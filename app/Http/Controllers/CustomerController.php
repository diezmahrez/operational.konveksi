<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Customer;
use App\Models\Bank;

class CustomerController extends Controller
{
    public function customer()
    {
        $customer = Customer::all();
        $bank = Bank::all()->where('aktif','Y');
        $data = [
            'menu' => 'Customer',
            'customer' => $customer,
            'bank' => $bank
        ];
        return view('customer.index', $data);
    }
    public function post_customer(Request $post_data)
    {
        // var_dump($post_data);


        // echo $post_data->_token;

        $check_last_kd = Customer::select('kode_customer')->orderByDesc('kode_customer')->first();

        if (empty($check_last_kd)) {
            $kode_customer = 'CS001';
        } else {
            $last_kode_cs = $check_last_kd->kode_customer;
            $sum_kode = substr($last_kode_cs, -3) + 1;
            $final_sum_kode = str_pad($sum_kode, 3, "0", STR_PAD_LEFT);
            $kode_customer = 'CS' . $final_sum_kode;
        }

        $nama_customer = strtoupper($post_data->nama_customer);
        $nama_brand = strtoupper($post_data->nama_perusahaan);
        $alamatdetail = ucfirst($post_data->alamat_detail);
        $kabupaten = ucfirst($post_data->kabupaten);
        $provinsi = ucfirst($post_data->provinsi);
        $kode_pos = $post_data->kode_pos;
        $email = strtolower($post_data->email_customer);
        $no_hp = $post_data->hp_customer;
        $jenis_rekening = $post_data->jenis_rekening;
        $rekening_customer = strtoupper($post_data->rekening_customer);



        $data = [
            'kode_customer' => $kode_customer,
            'nama_customer' => $nama_customer,
            'nama_brand' => $nama_brand,
            'alamatdetail' => $alamatdetail,
            'kabupaten' => $kabupaten,
            'provinsi' => $provinsi,
            'kode_pos' => $kode_pos,
            'email' => $email,
            'no_hp' => $no_hp,
            'jenis_rekening' => $jenis_rekening,
            'rekening_customer' => $rekening_customer,
            'user_input' => session()->get('nik'),
            'user_update' => session()->get('nik')
        ];

        $customer = Customer::create($data);

        return redirect('/customer')->with('primary', 'Berhasil Input Data!');
    }
    public function lihat_detail_data(Request $request)
    {
        $kode_customer = $request->input('id');

        $data = Customer::Where('kode_customer', $kode_customer)->first();

        return response()->json(['data' => $data]);
    }

    public function change_customer(Request $post_data)
    {
        $kode_customer = $post_data->kode_customer;
        $nama_customer = strtoupper($post_data->nama_customer);
        $nama_brand = strtoupper($post_data->nama_perusahaan);
        $alamatdetail = ucfirst($post_data->alamat_detail);
        $kabupaten = ucfirst($post_data->kabupaten);
        $provinsi = ucfirst($post_data->provinsi);
        $kode_pos = $post_data->kode_pos;
        $email = strtolower($post_data->email_customer);
        $no_hp = $post_data->hp_customer;
        $jenis_rekening = $post_data->jenis_rekening;
        $rekening_customer = strtoupper($post_data->rekening_customer);
        $status = strtoupper($post_data->aktif);

        $data = [
            'nama_customer' => $nama_customer,
            'nama_brand' => $nama_brand,
            'alamatdetail' => $alamatdetail,
            'kabupaten' => $kabupaten,
            'provinsi' => $provinsi,
            'kode_pos' => $kode_pos,
            'email' => $email,
            'no_hp' => $no_hp,
            'jenis_rekening' => $jenis_rekening,
            'rekening_customer' => $rekening_customer,
            'aktif' => $status,
            'user_update' => session()->get('nik')
        ];

        // var_dump($data);
        Customer::where('kode_customer','=', $kode_customer)
            ->update($data);
        return redirect('/customer')->with('primary', 'Berhasil Update Data!');
    }
}
