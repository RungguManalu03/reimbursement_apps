<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Throwable;

class ManajemenUserController extends Controller
{
    public function index()
    {
        return view('direktur.manajemen-user');
    }

    public function listDataUser(Request $request)
    {
        try {
            $subQuery = DB::table('users')->select('id', 'nip', 'nama', 'jabatan');

            if ($request->has('search') && !empty($request->search['value'])) {
                $searchUser = $request->search['value'];
                $subQuery->where(function ($a) use ($searchUser) {
                    $a
                    ->where(DB::raw('LOWER(nama)'), 'LIKE', '%' . strtolower($searchUser) . '%')
                    ->orWhere('nip', 'LIKE', '%' . $searchUser . '%')
                    ->orWhere(DB::raw('LOWER(jabatan)'), 'LIKE', '%' . strtolower($searchUser) . '%');
                });
            }

            $queryUser = DB::table(DB::raw("({$subQuery->toSql()}) as tmp"))
            ->mergeBindings($subQuery)
                ->select('*')
                ->get();

            if ($request->ajax()) {
                return DataTables::of($queryUser)
                    ->addIndexColumn()
                    ->addColumn('nip', function ($row) {
                        return $row->nip;
                    })
                    ->addColumn('nama', function ($row) {
                        return $row->nama;
                    })
                    ->addColumn('jabatan', function ($row) {
                        return $row->jabatan;
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
                    '" id="btn-detail-user" class="dropdown-item detail-item-btn"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>Detail</button></li>
                        <li class="delete"><button data-id="' . $row->id . '" id="btn-delete-user" class="dropdown-item remove-item-btn text-danger"><i class="ri-delete-bin-fill align-bottom me-2"></i> Hapus</button></li>
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

    public function findDataUserByID(Request $request)
    {
        try {
            $data = DB::table('users')
            ->select('users.id', 'users.nama', 'users.jabatan', 'users.nip')
            ->where('users.id', $request->id)
            ->first();

            if ($data) {
                return response()->json([
                    $data->id,
                    $data->nip,
                    $data->nama,
                    $data->jabatan,

                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan']);
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function storeUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nip' => 'required|unique:users',
                'nama' => 'required',
                'jabatan' => 'required',
                'password' => 'required'
            ], [
                'nip.required' => 'NIP harus diisi.',
                'nip.unique' => 'NIP sudah digunakan.',
                'nama.required' => 'Nama lengkap harus diisi.',
                'jabatan.required' => 'Jabatan harus diisi.',
                'password.required' => 'Password harus diisi.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'data' => [],
                    'message' => $validator->errors()
                ]);
            }

            $uuid = Uuid::uuid4();
            DB::table('users')->insert([
                [
                    'id' => $uuid->toString(),
                    'nip' => $request->nip,
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'password' => Hash::make($request->password),
                    'created_at' => Carbon::parse(now())->timezone('Asia/Jakarta'),
                    'updated_at' => Carbon::parse(now())->timezone('Asia/Jakarta'),
                ]
            ]);

            return response()->json([
                'error' => false,
                'data' => [],
                'message' => 'Berhasil menambahkan user'
            ]);
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    public function editUser(Request $request)
    {
        try {
            $updateData = [
                'nip' => $request->nip_detail,
                'nama' => $request->nama_detail,
                'jabatan' => $request->jabatan_detail,
                'updated_at' => now()->timezone('Asia/Jakarta'),
            ];

            if ($request->has('password_detail')) {
                $updateData['password'] = Hash::make($request->password_detail);
            }

            DB::table('users')
            ->where('id', $request->id_data)
                ->update($updateData);

            return response()->json(['success' => true, 'message' => 'Berhasil memverifikasi']);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan pada sisi server']);
        }
    }

    public function deleteUser($id)
    {
        try {
            $data = DB::table('users')->where('id', $id)->delete();
            if ($data) {
                return response()->json(['success' => true, 'message' => 'Berhasil menghapus data users', 'data' => $data]);
            } else {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus data users']);
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi Kesalahan pada sisi server']);
        }
    }
}
