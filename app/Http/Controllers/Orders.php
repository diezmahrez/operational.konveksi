<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// use App\Models\PotonganBahan;
use App\Models\Customer;
use App\Models\Modelpola;
use App\Models\OrdersDetail;
use App\Models\OrdersM;

// use App\Models\PotonganBahanDetail;

class Orders extends Controller
{

    public function Orders()
    {
        $orders = OrdersM::join('dt_customer', 'dt_orders.kode_customer', '=', 'dt_customer.kode_customer')
            ->join('dt_modelpola', 'dt_orders.kode_model', '=', 'dt_modelpola.kode_model')
            ->select('dt_orders.*', 'dt_customer.nama_brand', 'dt_modelpola.nama_model')
            // ->where('dt_orders.status', '=', 'PROCESS')
            ->orderBy('dt_orders.id', 'ASC')
            ->get();
        $customer = Customer::select('kode_customer', 'nama_customer', 'nama_brand')
            ->where('aktif', '=', 'Y')->get();
        $modelpola = Modelpola::select('kode_model', 'nama_model')->where('aktif', '=', 'Y')->get();
        $data = [
            'menu' => 'Orders',
            // 'submenu' => 'inputdatapotonganbahan',
            'orders' => $orders,
            'customer' => $customer,
            'modelpola' => $modelpola
        ];
        return view('orders.index', $data);
    }
    public function getkodemodel(Request $request)
    {
        $kode_customer = $request->input('kode_customer');

        $data = Modelpola::select('kode_model', 'nama_model')->Where('kode_customer', $kode_customer)->get();

        return response()->json(['data' => $data]);
    }
    public function getdataharga(Request $request)
    {
        $kode_model = $request->input('kode_model');

        $data = Modelpola::select('harga_penjahit', 'harga_produksi', 'harga_pemotongbahan')->Where('kode_model', $kode_model)->first();

        return response()->json(['data' => $data]);
    }
    public function post_orders(Request $post_data)
    {
        $validator = Validator::make($post_data->all(), [
            'kode_customer' => 'required|min:5|string',
            'kode_model' => 'required|min:4|string',
            'judul' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect('/orders')
                ->withErrors($validator)
                ->withInput();
        }

        $kode_customer = $post_data->kode_customer;
        $kode_model = $post_data->kode_model;
        $judul = $post_data->judul;
        $tanggal = $post_data->tanggal;
        $temp_tgl_convert = strtotime($post_data->tanggal);
        $tanggal_convert_forcheck = date("Y-m", $temp_tgl_convert);
        $tanggal_convert = date("ym", $temp_tgl_convert);

        $check_last_kd = OrdersM::select('tanggal', 'kode_order')
            ->where('tanggal', 'like', $tanggal_convert_forcheck . '%')->orderByDesc('kode_order')->first();

        if (empty($check_last_kd)) {
            $prefix = '001';
        } else {
            $last_kode = $check_last_kd->kode_order;
            $sum_kode = substr($last_kode, -3) + 1;
            $prefix = str_pad($sum_kode, 3, "0", STR_PAD_LEFT);
        }


        $kode_order = 'TR' . $kode_customer . $kode_model . 'X' . $tanggal_convert .  $prefix;
        // echo $kode_order;

        $data = [
            'kode_order' => $kode_order,
            'kode_customer' => $kode_customer,
            'kode_model' => $kode_model,
            'judul' => $judul,
            'tanggal' => $tanggal,
            'status' => 'PROCESS',
            'detail_status' => 'ORDER DITERIMA',
            'aktif' => 'Y',
            'user_input' => session()->get('nik'),
            'user_update' => session()->get('nik'),
        ];

        $datadetail = [
            'kode_order' => $kode_order,
            'user_input' => session()->get('nik'),
            'user_update' => session()->get('nik'),
        ];

        $post_order = OrdersM::create($data);
        $post_order_detail = OrdersDetail::create($datadetail);

        return redirect('/orders')->with('primary', 'Berhasil Input Data!');
    }
}
