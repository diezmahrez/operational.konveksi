<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::orderBy('nik')->get();
        $data = [
            'menu' => 'Karyawan',
            'karyawan' => $karyawan
        ];
        return view('karyawan.index', $data);
    }
    public function post_karyawan(Request $post_data)
    {
        $validator = Validator::make($post_data->all(), [
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|max:1|string',
            'posisi' => 'required|string',
        ]);


        if ($validator->fails()) {
            return redirect('/karyawan')
                ->withErrors($validator)
                ->withInput();
        }

        $nama = ucwords(strtolower($post_data->nama));
        $jenis_kelamin = $post_data->jenis_kelamin;
        $tanggal_lahir = $post_data->tanggal_lahir;

        if (is_null($tanggal_lahir)) {
            $tanggal_lahir = '1970-01-01';
        }

        $posisi = $post_data->posisi;
        $tanggal_masuk = $post_data->tanggal_masuk;

        $check_last_kd = Karyawan::select('nik')->orderByDesc('nik')->first();

        if (empty($check_last_kd)) {
            $nik = '00001';
        } else {
            $last_nik = $check_last_kd->nik;
            $sum_nik = $last_nik + 1;
            $nik = str_pad($sum_nik, 5, "0", STR_PAD_LEFT);
        }

        // dd($nik);

        $data = [
            'nik' => $nik,
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'tanggal_lahir' => $tanggal_lahir,
            'posisi' => $posisi,
            'tanggal_masuk' => $tanggal_masuk,
            'aktif' => 'Y',
            'user_input' => session()->get('nik'),
            'user_update' => session()->get('nik')
        ];

        // dd($data);
        $post_order = Karyawan::create($data);

        return redirect('/karyawan')->with('primary', 'Berhasil Input Data!');
    }

    public function lihat_detail_data(Request $request)
    {
        $nik = $request->input('id');

        $data = Karyawan::Where('nik', $nik)->first();

        return response()->json(['data' => $data]);
    }
    public function change_karyawan(Request $post_data)
    {
        $nik = $post_data->nik;
        $nama = ucwords(strtolower($post_data->nama));
        $jenis_kelamin = $post_data->jenis_kelamin;
        $tanggal_lahir = $post_data->tanggal_lahir;
        $posisi = $post_data->posisi;
        $tanggal_masuk = $post_data->tanggal_masuk;
        $aktif = $post_data->aktif;

        // dd($nama_model);

        $data = [
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'tanggal_lahir' => $tanggal_lahir,
            'posisi' => $posisi,
            'tanggal_masuk' => $tanggal_masuk,
            'aktif' => $aktif,
            'user_update' => session()->get('nik'),
            'updated_at' => date('Y-m-d H:i:s')

        ];

        $update_data = Karyawan::where('nik', '=', $nik)
            ->update($data);
        if ($update_data) {
            return redirect('/karyawan')->with('success', 'Berhasil Update Data!');
        } else {
            return redirect('/karyawan')->with('danger', 'Gagal Update Data!');
        }
    }
}
