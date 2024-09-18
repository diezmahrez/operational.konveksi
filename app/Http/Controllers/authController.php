<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;


class authController extends Controller
{

   
    public function check_auth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nik' => 'required|min:5',
            'password' => 'required',
        ], [
            'nik.required' => 'Nik isi terlebih dahulu.',
            'nik.min' => 'Panjang nik hanya 5 digit.',
            'password.required' => 'Password harus diisi.',
        ]);

        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated = $validator->safe()->only(['nik', 'password']);


        $nik = $validated['nik'];
        $password = $validated['password'];

        $check_nik = User::join('dt_karyawan', 'dt_user.nik', '=', 'dt_karyawan.nik')
            ->where('dt_karyawan.nik', $nik)
            ->count();

        if ($check_nik < 1) {
            return redirect('/login')->with('status', 'Nik Tidak Terdaftar!')->withInput();
        }

        $check_active_nik = User::join('dt_karyawan', 'dt_user.nik', '=', 'dt_karyawan.nik')
            ->where('dt_karyawan.aktif', 'Y')
            ->count();

        if ($check_active_nik < 1) {
            return redirect('/login')->with('status', 'Nik tidak aktif!')->withInput();
        }

        if (Auth::attempt(['nik' => $nik, 'password' => $password])) {
            $role = User::select('role')->where('nik','=',$nik)->first()->role;

            $request->session()->put('nik', $nik);
            $request->session()->put('role', $role);
            $request->session()->put('status', 'login');
            return redirect('/dashboard')->with('info', 'Selamat Datang, ' . Auth::user()->nama);
        }

        return redirect('/login')->with('status', 'Nik atau Password salah!')->withInput();
    }
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        return redirect('/login');
    }
}
