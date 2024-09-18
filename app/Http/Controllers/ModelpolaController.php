<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Modelpola;
use App\Models\JenisModel;
use App\Models\JenisBahan;
use App\Models\JenisUkuran;
use App\Models\JenisKategori;
use App\Models\JenisAksesoris;
use App\Models\Customer;
use Illuminate\Support\Facades\Redis;

class ModelpolaController extends Controller
{
    public function index()
    {
        $modelpola = Modelpola::join('dt_customer', 'dt_modelpola.kode_customer', '=', 'dt_customer.kode_customer')
        ->select('dt_modelpola.*','dt_customer.nama_brand')->get();
        $jenismodel = JenisModel::all()->where('aktif', 'Y');
        $jenisbahan = JenisBahan::all()->where('aktif', 'Y');
        $jenisukuran = JenisUkuran::all()->where('aktif', 'Y');
        $jeniskategori = JenisKategori::all()->where('aktif', 'Y');
        $jenisaksesoris = JenisAksesoris::all()->where('aktif', 'Y');
        $customer = Customer::all()->where('aktif', 'Y');
        $data = [
            'menu' => 'Modelpola',
            'modelpola' => $modelpola,
            'jenismodel' => $jenismodel,
            'jenisbahan' => $jenisbahan,
            'jenisukuran' => $jenisukuran,
            'jeniskategori' => $jeniskategori,
            'jenisaksesoris' => $jenisaksesoris,
            'customer' => $customer
        ];
        return view('model_pola.index', $data);
    }

    public function post_modelpola(Request $post_data)
    {
        // dd($post_data);


        // echo $post_data->_token;

        $check_last_kd = Modelpola::select('kode_model')->orderByDesc('kode_model')->first();

        if (empty($check_last_kd)) {
            $kode_model = 'M001';
        } else {
            $last_kode_cs = $check_last_kd->kode_model;
            $sum_kode = substr($last_kode_cs, -3) + 1;
            $final_sum_kode = str_pad($sum_kode, 3, "0", STR_PAD_LEFT);
            $kode_model = 'M' . $final_sum_kode;
        }


        $jenis_model = trim(strtoupper($post_data->jenis_model));
        $jenis_bahan = trim(strtoupper($post_data->jenis_bahan));
        $jenis_ukuran = trim(strtoupper($post_data->jenis_ukuran));
        $jenis_kategori = trim(strtoupper($post_data->jenis_kategori));
        $jenis_aksesoris = trim(strtoupper($post_data->jenis_aksesoris));
        $keterangan = strtoupper($post_data->keterangan);
        $harga_produksi = intval(str_replace(".", "", $post_data->harga_produksi,));
        $harga_penjahit = intval(str_replace(".", "", $post_data->harga_penjahit,));
        $harga_pemotongbahan = intval(str_replace(".", "", $post_data->harga_pemotongbahan,));
        $kode_customer = strtoupper($post_data->kode_customer);

        $nama_model = trim($jenis_model . " " . $jenis_bahan . " " . $jenis_ukuran . " " . $jenis_kategori . " " . $jenis_aksesoris);

        // dd($nama_model);
        $check_nama_model = Modelpola::Where([
            ['nama_model', '=', $nama_model],
            ['kode_customer', '=', $kode_customer]
        ])->get()->count();

        if ($check_nama_model > 0) {
            $get_nama_customer = Customer::select('nama_brand')->Where('kode_customer', '=', $kode_customer)->first()->nama_brand;
            return redirect('/Model_pola')->with('error', 'Model ' . $nama_model . ' untuk ' . $get_nama_customer . ' Sudah Ada!')->withInput();
        } else {

            $data = [
                'kode_model' => $kode_model,
                'nama_model' => $nama_model,
                'jenis_model' => $jenis_model,
                'jenis_bahan' => $jenis_bahan,
                'ukuran' => $jenis_ukuran,
                'kategori' => $jenis_kategori,
                'aksesoris' => $jenis_aksesoris,
                'keterangan' => $keterangan,
                'harga_produksi' => $harga_produksi,
                'harga_penjahit' => $harga_penjahit,
                'harga_pemotongbahan' => $harga_pemotongbahan,
                'kode_customer' => $kode_customer,
                'aktif' => 'Y',
                'user_input' => session()->get('nik'),
                'user_update' => session()->get('nik')
            ];

            $customer = Modelpola::create($data);

            return redirect('/Model_pola')->with('primary', 'Berhasil Input Data!');
        }
    }

    public function lihat_detail_data(Request $request)
    {
        $kode_model = $request->input('id');

        $data = Modelpola::Where('kode_model', $kode_model)->first();

        return response()->json(['data' => $data]);
    }

    public function change_model(Request $post_data)
    {
        $keterangan = strtoupper($post_data->keterangan);
        $harga_produksi = intval(str_replace(".", "", $post_data->harga_produksi,));
        $harga_penjahit = intval(str_replace(".", "", $post_data->harga_penjahit,));
        $harga_pemotongbahan = intval(str_replace(".", "", $post_data->harga_pemotongbahan,));
        $kode_customer = strtoupper($post_data->kode_customer);
        $kode_model = $post_data->kode_model;
        $aktif = $post_data->aktif;

        // dd($nama_model);

            $data = [
                'keterangan' => $keterangan,
                'harga_produksi' => $harga_produksi,
                'harga_penjahit' => $harga_penjahit,
                'harga_pemotongbahan' => $harga_pemotongbahan,
                'aktif' => $aktif,
                'user_update' => session()->get('nik')
            ];

            Modelpola::where('kode_model','=', $kode_model)
            ->update($data);
            return redirect('/Model_pola')->with('primary', 'Berhasil Update Data!');
    }
}
