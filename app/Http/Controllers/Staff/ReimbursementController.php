<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReimbursementController extends Controller
{
    public function index()
    {
        return view('staff.pengajuan-reimbursement');
    }

    public function listDataReimbursement(Request $request)
    {
        try {
            $subQuery = DB::table('reimbursements')
            ->join('users', 'reimbursements.user_id', '=', 'users.id')
            ->select('reimbursements.id as id','reimbursements.nama as nama', 'nominal', 'status', 'tanggal', 'users.nip as nip')
            ->where('reimbursements.user_id', '=', Auth::user()->id)
            ;

            if ($request->has('search') && !empty($request->search['value'])) {
                $searchReimbursement = $request->search['value'];
                $subQuery->orWhere(function ($a) use ($searchReimbursement) {
                    $a
                        ->orWhere(DB::raw('LOWER(reimbursements.nama)'), 'LIKE', '%' . strtolower($searchReimbursement) . '%')
                        ->orWhere('users.nip', 'LIKE', '%' . $searchReimbursement . '%');
                });
            }

            $queryUser = DB::table(DB::raw("({$subQuery->toSql()}) as tmp"))
            ->mergeBindings($subQuery)
                ->select('*')
                ->get();

            if ($request->ajax()) {
                return DataTables::of($queryUser)
                    ->addIndexColumn()
                    ->addColumn('nama', function ($row) {
                        return $row->nama;
                    })
                    ->addColumn('nip', function ($row) {
                        return $row->nip;
                    })
                    ->addColumn('nominal', function ($row) {
                        return $row->nominal;
                    })
                    ->addColumn('status', function ($row) {
                        return $row->status;
                    })
                    ->addColumn('tanggal', function ($row) {
                        return $row->tanggal;
                    })
                    ->addColumn('action', function ($row) {
                        $html_code =
                    '<div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown ps-2 pe-1 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; font-weight: 500; font-size: 14px;">
                        Action
                        <i class="ri-arrow-drop-down-fill" style="font-size: 20px;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                     <li class="detail"><button data-id="' .
                        $row->id .
                    '" id="btn-detail-reimbursement" class="dropdown-item detail-item-btn"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>Detail</button></li>
                ';
                if($row->status == "MENGAJUKAN") {
                    $html_code .= '
                        <li class="delete"><button data-id="' . $row->id . '" id="btn-delete-reimbursement" class="dropdown-item remove-item-btn text-danger"><i class="ri-delete-bin-fill align-bottom me-2"></i> Hapus</button></li>';
                }

                        $html_code .= '</ul></div>';
                        return $html_code;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    public function findDataReimbursementByID(Request $request)
    {
        try {
            $data = DB::table('reimbursements')
            ->join('users', 'reimbursements.user_id', '=', 'users.id')
            ->select('reimbursements.id as reimbursement_id','reimbursements.status', 'reimbursements.nominal', 'reimbursements.tanggal', 'reimbursements.deskripsi', 'users.nip', 'users.nama')
            ->where('reimbursements.id', $request->id)
            ->first();

            if ($data) {

                $files = DB::table('reimbursement_files')
                ->where('reimbursement_id', $request->id)
                ->get();

                $fileData = [];
                foreach ($files as $file) {
                    $fileData[] = [
                        $file->file_name,
                    ];
                }

                return response()->json([
                    $data->reimbursement_id,
                    $data->nip,
                    $data->nama,
                    $data->nominal,
                    $data->deskripsi,
                    $data->tanggal,
                    $fileData,
                    $data->status,

                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan']);
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function storeReimbursement(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'nominal' => 'required',
                'tanggal' => 'required',
                'deskripsi' => 'required',
            ], [
                'nominal.required' => 'Nominal harus diisi.',
                'tanggal.required' => 'Tanggal harus diisi.',
                'deskripsi.required' => 'Deskripsi harus diisi.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'data' => [],
                    'message' => $validator->errors()
                ]);
            }

            $uuid = Uuid::uuid4();
            $reimbursement = DB::table('reimbursements')->insertGetId([
                'id' => $uuid->toString(),
                'user_id' => Auth::user()->id,
                'nama' => Auth::user()->nama,
                'nominal' => $request->nominal,
                'status' => "MENGAJUKAN",
                'tanggal' => $request->tanggal,
                'deskripsi' => $request->deskripsi,
                'created_at' => Carbon::parse(now())->timezone('Asia/Jakarta'),
                'updated_at' => Carbon::parse(now())->timezone('Asia/Jakarta'),
            ]);

            foreach ($request->file('files') as $file) {
                $fileName = $file->getClientOriginalName();
                $file->move('reimbursement_files', $fileName);

                DB::table('reimbursement_files')->insert([
                    'id' => Uuid::uuid4()->toString(),
                    'reimbursement_id' => $reimbursement,
                    'file_name' => $fileName,
                    'created_at' => Carbon::parse(now())->timezone('Asia/Jakarta'),
                    'updated_at' => Carbon::parse(now())->timezone('Asia/Jakarta'),
                ]);
            }

            DB::commit();

            return response()->json([
                'error' => false,
                'data' => [],
                'message' => 'Berhasil menambahkan reimbursements'
            ]);
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    public function deleteReimbursement($id)
    {
        DB::beginTransaction();
        try {
            DB::table('reimbursement_files')->where('reimbursement_id', $id)->delete();

            $data = DB::table('reimbursements')->where('id', $id)->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Berhasil menghapus data reimbursements', 'data' => $data]);
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan pada sisi server']);
        }
    }
}
