<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Throwable;

class ManajemenReimbursementController extends Controller
{
    public function index()
    {
        return view('direktur.manajemenreimbursement');
    }

    public function listDataReimbursementUser(Request $request)
    {
        try {
            $subQuery = DB::table('reimbursements')
            ->join('users', 'reimbursements.user_id', '=', 'users.id')
            ->select('reimbursements.id as id', 'reimbursements.nama as nama', 'nominal', 'status', 'tanggal', 'users.nip as nip');

            if ($request->has('search') && !empty($request->search['value'])) {
                $searchReimbursement = $request->search['value'];
                $subQuery->where(function ($a) use ($searchReimbursement) {
                    $a
                        ->where(DB::raw('LOWER(reimbursements.nama)'), 'LIKE', '%' . strtolower($searchReimbursement) . '%')
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

    public function Verifikasi(Request $request)
    {
        try {
            DB::table('reimbursements')
            ->where('id', $request->id)
                ->update([
                    'status' => "VERIFIKASI-DIREKTUR",
                    'direktur_agreement' => Auth::user()->nama,
                    'updated_at' => Carbon::parse(now())->timezone('Asia/Jakarta'),
                ]);
            return response()->json(['success' => true, 'message' => 'Berhasil memverifikasi']);
        } catch (Throwable $e) {
            DB::rollback();

            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan pada sisi server']);
        }
    }

    public function Tolak(Request $request)
    {
        try {
            DB::table('reimbursements')
            ->where('id', $request->id)
                ->update([
                    'status' => "TOLAK-DIREKTUR",
                    'direktur_agreement' => Auth::user()->nama,
                    'updated_at' => Carbon::parse(now())->timezone('Asia/Jakarta'),
                ]);
            return response()->json(['success' => true, 'message' => 'Berhasil memverifikasi']);
        } catch (Throwable $e) {
            DB::rollback();

            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan pada sisi server']);
        }
    }

    public function findDataReimbursementUserByID(Request $request)
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
}
