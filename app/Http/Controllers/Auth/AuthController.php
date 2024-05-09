<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request) {

        $credential = $request->validate([
            'nip'       => 'required',
            'password'  => 'required',
        ]);

        if(Auth::attempt($credential)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->jabatan == "DIREKTUR") {
                return response()->json(['success' => true, 'redirectUrl' => '/manajemen-user', 'message' => 'Berhasil Login']);
            } else if($user->jabatan == "FINANCE") {
                return response()->json(['success' => true, 'redirectUrl' => '/manajemen-reimbursement-finance', 'message' => 'Berhasil Login']);
            } else {
                return response()->json(['success' => true, 'redirectUrl' => '/data-pengajuan-reimbursement', 'message' => 'Berhasil Login']);
            }

            return redirect()->back();
        } else {
            return response()->json(['failed' => false, 'message' => 'Email atau password salah']);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        return redirect('/');
    }
}
