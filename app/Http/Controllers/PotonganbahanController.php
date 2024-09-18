<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Exception;

require __DIR__ . '/../../../vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

use App\Models\PotonganBahan;
use App\Models\Customer;
use App\Models\Modelpola;
use App\Models\OrdersDetail;
use App\Models\PotonganBahanDetail;
use App\Models\OrdersM;
use App\Models\User;
use function PHPUnit\Framework\isNull;

class PotonganbahanController extends Controller
{
    public function potonganbahan()
    {
        $orders = OrdersM::join('dt_customer', 'dt_orders.kode_customer', '=', 'dt_customer.kode_customer')
            ->join('dt_modelpola', 'dt_orders.kode_model', '=', 'dt_modelpola.kode_model')
            ->select('dt_orders.*', 'dt_customer.nama_brand', 'dt_modelpola.nama_model')
            ->where('dt_orders.status', '=', 'PROCESS')
            ->where('dt_orders.detail_status', '=', 'ORDER DITERIMA')
            ->orderBy('dt_orders.id', 'ASC')
            ->get();
        $potonganbahan = PotonganBahan::join('dt_customer', 'dt_potonganbahan.kode_customer', '=', 'dt_customer.kode_customer')
            ->join('dt_modelpola', 'dt_potonganbahan.kode_model', '=', 'dt_modelpola.kode_model')
            ->select('dt_potonganbahan.*', 'dt_customer.nama_brand', 'dt_modelpola.nama_model')
            ->where('dt_potonganbahan.status', '=', 'PROCESS')
            ->orderBy('dt_potonganbahan.id', 'ASC')
            ->get();
        $customer = Customer::select('kode_customer', 'nama_customer', 'nama_brand')
            ->where('aktif', '=', 'Y')->get();
        $modelpola = Modelpola::select('kode_model', 'nama_model')->where('aktif', '=', 'Y')->get();
        $data = [
            'menu' => 'PotonganBahan',
            'submenu' => 'inputdatapotonganbahan',
            'potonganbahan' => $potonganbahan,
            'customer' => $customer,
            'modelpola' => $modelpola,
            'orders' => $orders
        ];
        return view('potongan_bahan.index', $data);
    }

    public function historypotonganbahan()
    {
        $potonganbahan = PotonganBahan::join('dt_customer', 'dt_potonganbahan.kode_customer', '=', 'dt_customer.kode_customer')
            ->join('dt_modelpola', 'dt_potonganbahan.kode_model', '=', 'dt_modelpola.kode_model')
            ->select('dt_potonganbahan.*', 'dt_customer.nama_brand', 'dt_modelpola.nama_model')
            ->where('dt_potonganbahan.status', '=', 'CLOSED')
            ->orderBy('dt_potonganbahan.id', 'ASC')
            ->get();
        $data = [
            'menu' => 'PotonganBahan',
            'submenu' => 'historypotonganbahan',
            'potonganbahan' => $potonganbahan
        ];
        return view('potongan_bahan.history', $data);
    }
    public function getkodemodel(Request $request)
    {
        $kode_customer = $request->input('kode_customer');

        $data = Modelpola::select('kode_model', 'nama_model')->Where('kode_customer', $kode_customer)->get();

        return response()->json(['data' => $data]);
    }

    public function post_potonganbahan(Request $post_data)
    {

        $validator = Validator::make($post_data->all(), [
            'kode_order' => 'required|min:19|string',
            'kode_customer' => 'required|min:5|string',
            'kode_model' => 'required|min:4|string',
            'judul' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect('/potonganbahan')
                ->withErrors($validator)
                ->withInput();
        }

        $kode_order = $post_data->kode_order;
        $kode_customer = $post_data->kode_customer;
        $kode_model = $post_data->kode_model;
        $judul = $post_data->judul;
        $tanggal = $post_data->tanggal;
        $temp_tgl_convert = strtotime($post_data->tanggal);
        $tanggal_convert_forcheck = date("Y-m", $temp_tgl_convert);
        $tanggal_convert = date("ym", $temp_tgl_convert);

        $check_last_kd = PotonganBahan::select('tanggal', 'kode_potonganbahan')
            ->where('tanggal', 'like', $tanggal_convert_forcheck . '%')->orderByDesc('kode_potonganbahan')->first();

        if (empty($check_last_kd)) {
            $prefix = '001';
        } else {
            $last_kode = $check_last_kd->kode_potonganbahan;
            $sum_kode = substr($last_kode, -3) + 1;
            $prefix = str_pad($sum_kode, 3, "0", STR_PAD_LEFT);
        }


        $kode_potonganbahan = $kode_customer . $kode_model . 'X' . $tanggal_convert .  $prefix;
        // echo $kode_potonganbahan;

        $data = [
            'kode_potonganbahan' => $kode_potonganbahan,
            'kode_customer' => $kode_customer,
            'kode_model' => $kode_model,
            'judul' => $judul,
            'tanggal' => $tanggal,
            'aktif' => 'Y',
            'user_input' => session()->get('nik'),
            'user_update' => session()->get('nik')
        ];

        $post_potonganbahan = PotonganBahan::create($data);

        $update_orders_detail = OrdersDetail::where('kode_order', '=', $kode_order)->update(
            [
                'potongan_bahan_input' => 'Y',
                'potongan_bahan_input_timestamp' => date('Y-m-d H:i:s'),
                'user_update' => session()->get('nik'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );

        return redirect('/potonganbahan')->with('primary', 'Berhasil Input Data!');
    }
    public function detail_potonganbahan($kode_potonganbahan)
    {
        $header = PotonganBahan::where('kode_potonganbahan', '=', $kode_potonganbahan)
            ->join('dt_customer', 'dt_potonganbahan.kode_customer', '=', 'dt_customer.kode_customer')
            ->join('dt_modelpola', 'dt_potonganbahan.kode_model', '=', 'dt_modelpola.kode_model')
            ->select('dt_potonganbahan.*', 'dt_customer.nama_brand', 'dt_modelpola.nama_model')->first();
        $detail = PotonganBahanDetail::Where('kode_potonganbahan', '=', $kode_potonganbahan)->get();

        $data = [
            'menu' => 'PotonganBahan',
            'submenu' => 'inputdatapotonganbahan',
            'header' => $header,
            'detail' => $detail
        ];
        return view('potongan_bahan.detail_potonganbahan', $data);
    }

    public function historydetail_potonganbahan($kode_potonganbahan)
    {
        $header = PotonganBahan::where('kode_potonganbahan', '=', $kode_potonganbahan)
            ->join('dt_customer', 'dt_potonganbahan.kode_customer', '=', 'dt_customer.kode_customer')
            ->join('dt_modelpola', 'dt_potonganbahan.kode_model', '=', 'dt_modelpola.kode_model')
            ->select('dt_potonganbahan.*', 'dt_customer.nama_brand', 'dt_modelpola.nama_model')->first();
        $detail = PotonganBahanDetail::Where('kode_potonganbahan', '=', $kode_potonganbahan)->get();

        $data = [
            'menu' => 'PotonganBahan',
            'submenu' => 'historypotonganbahan',
            'header' => $header,
            'detail' => $detail
        ];
        return view('potongan_bahan.historydetail_potonganbahan', $data);
    }

    public function post_potonganbahandetail(Request $post_data)
    {
        // dd($post_data);
        $kode_potonganbahan = $post_data->kode_potonganbahan;
        $validator = Validator::make($post_data->all(), [
            'kode_potonganbahan' => 'required|min:17|string',
            'warna' => 'required|string',
            'yards' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/potonganbahan/' . $kode_potonganbahan)
                ->withErrors($validator)
                ->withInput();
        }

        $check_last_kd = PotonganBahanDetail::select('kode_potonganbahan_detail')->where('kode_potonganbahan', '=', $kode_potonganbahan)->orderByDesc('id')->first();

        if (empty($check_last_kd)) {
            $prefix = '001';
        } else {
            $last_kode = $check_last_kd->kode_potonganbahan_detail;
            $sum_kode = substr($last_kode, -3) + 1;
            $prefix = str_pad($sum_kode, 3, "0", STR_PAD_LEFT);
        }

        $kode_potonganbahan_detail = $kode_potonganbahan . $prefix;
        $yards = $post_data->yards;
        $warna = $post_data->warna;
        $qty = $post_data->qty;

        $data = [
            'kode_potonganbahan_detail' => $kode_potonganbahan_detail,
            'warna' => $warna,
            'yards' => $yards,
            'qty' => $qty,
            'aktif' => 'Y',
            'kode_potonganbahan' => $kode_potonganbahan,
            'user_input' => session()->get('nik'),
            'user_update' => session()->get('nik')
        ];
        // dd($data);

        $get_last_qty = PotonganBahan::select('total_qty')->where('kode_potonganbahan', '=', $kode_potonganbahan)->first()->total_qty;
        $update_total_qty = $qty + $get_last_qty;

        $post_potonganbahan_detail = PotonganBahanDetail::create($data);
        $q_update_total_qty = PotonganBahan::where('kode_potonganbahan', '=', $kode_potonganbahan)->update([
            'total_qty' => $update_total_qty,
            'user_update' => session()->get('nik'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('/potonganbahan' . '/' . $kode_potonganbahan)->with('primary', 'Berhasil Input Data!');
    }
    public function qrcode_print(Request $post_data)
    {
        include '../public/Library/phpqrcode/qrlib.php';
        // dd($post_data);
        $validator = Validator::make($post_data->all(), [
            'kode_potonganbahan_detail' => 'required|min:20|string',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/');
        }

        $nik = session()->get('nik');
        $kode_potonganbahan_detail = $post_data->kode_potonganbahan_detail;
        $kode_potonganbahan = substr($kode_potonganbahan_detail, 0, 17);
        $pass = $post_data->password;
        if (Auth::attempt(['nik' => $nik, 'password' => $pass])) {
            $get_data_print =  PotonganBahanDetail::select(DB::raw('substr(dt_potonganbahan_detail.kode_potonganbahan_detail,-3,3) AS prefix'),  'dt_potonganbahan_detail.qty', 'dt_customer.nama_brand', 'dt_modelpola.nama_model')
                ->join('dt_customer', DB::raw('SUBSTR(dt_potonganbahan_detail.kode_potonganbahan,1,5)'), '=', 'dt_customer.kode_customer')
                ->join('dt_modelpola', DB::raw('SUBSTR(dt_potonganbahan_detail.`kode_potonganbahan`,6,4)'), '=', 'dt_modelpola.kode_model')
                ->where('kode_potonganbahan_detail', '=', $kode_potonganbahan_detail)->first();
            // dd($get_data_print);
            $namebrand = $get_data_print->nama_brand;
            $namemodel = $get_data_print->nama_model;
            $qty = $get_data_print->qty;
            $prefix = $get_data_print->prefix;

            try {
                $connector = new WindowsPrintConnector("smb://10.10.0.150/pos58");

                $printer = new Printer($connector);

                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("$namebrand" . "\n");
                $printer->text("--------------------------\n");
                $printer->text("$namemodel" . "\n");
                $printer->text("--------------------------\n");
                $printer->text("No. " . "$prefix" . "    " . "Qty. " . "$qty" . "\n");
                $printer->text("--------------------------\n");
                $printer->qrCode($kode_potonganbahan_detail, Printer::QR_ECLEVEL_L, 16);
                $printer->text("--------------------------\n");
                $printer->text("$kode_potonganbahan_detail" . "\n");
                $printer->cut();

                // Close the printer connection
                $printer->close();
                return redirect('/potonganbahan' . '/' . $kode_potonganbahan)->with('success', 'Print QR Berhasil!');
            } catch (Exception $e) {
                echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
            }
        } else {
            return redirect('/potonganbahan' . '/' . $kode_potonganbahan)->with('error', 'Password Salah!');
        }
    }
    public function delete_detaildata(Request $post_data)
    {
        $validator = Validator::make($post_data->all(), [
            'kode_potonganbahan_detail' => 'required|min:20|string',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/');
        }
        $nik = session()->get('nik');
        $kode_potonganbahan_detail = $post_data->kode_potonganbahan_detail;
        $kode_potonganbahan = substr($kode_potonganbahan_detail, 0, 17);
        $pass = $post_data->password;
        // echo $pass;
        if (Auth::attempt(['nik' => $nik, 'password' => $pass])) {
            $qty = PotonganBahanDetail::select('qty')->where('kode_potonganbahan_detail', '=', $kode_potonganbahan_detail)->first()->qty;
            $get_last_qty = PotonganBahan::select('total_qty')->where('kode_potonganbahan', '=', $kode_potonganbahan)->first()->total_qty;
            $update_total_qty = $get_last_qty - $qty;

            $q_update_total_qty = PotonganBahan::where('kode_potonganbahan', '=', $kode_potonganbahan)->update([
                'total_qty' => $update_total_qty,
                'user_update' => session()->get('nik'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $delete = PotonganBahanDetail::where('kode_potonganbahan_detail', '=', $kode_potonganbahan_detail)->delete();

            return redirect('/potonganbahan' . '/' . $kode_potonganbahan)->with('success', 'Berhasil Hapus Data!');
        } else {
            return redirect('/potonganbahan' . '/' . $kode_potonganbahan)->with('error', 'Password Salah!');
        }
    }
    public function edit_detaildata(Request $post_data)
    {
        $validator = Validator::make($post_data->all(), [
            'kode_potonganbahan_detail' => 'required|min:20|string',
            'qty' => 'required|integer',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/');
        }
        $nik = session()->get('nik');
        $kode_potonganbahan_detail = $post_data->kode_potonganbahan_detail;
        $kode_potonganbahan = substr($kode_potonganbahan_detail, 0, 17);
        $qty = $post_data->qty;
        $pass = $post_data->password;

        // echo $pass;
        if (Auth::attempt(['nik' => $nik, 'password' => $pass])) {
            $get_total_qty = PotonganBahanDetail::select(DB::raw("SUM(qty) as qty"))->where('kode_potonganbahan_detail', '!=', $kode_potonganbahan_detail)
                ->first()->qty;
            $updt_qty = $get_total_qty + $qty;
            $q_update_total_qty = PotonganBahan::where('kode_potonganbahan', '=', $kode_potonganbahan)->update([
                'total_qty' => $updt_qty,
                'user_update' => session()->get('nik'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $edit = PotonganBahanDetail::where('kode_potonganbahan_detail', '=', $kode_potonganbahan_detail)
                ->update(['qty' => $qty]);
            return redirect('/potonganbahan' . '/' . $kode_potonganbahan)->with('success', 'Berhasil Update Data!');
        } else {
            return redirect('/potonganbahan' . '/' . $kode_potonganbahan)->with('error', 'Password Salah!');
        }
    }
    public function close_potonganbahan($post_data)
    {
        // dd($post_data);
        $kode_potonganbahan = $post_data;
        $nik = session()->get('nik');

        if (is_null($kode_potonganbahan)) {
            return redirect('/');
        } else {
            $check_count_detaildata = PotonganBahanDetail::where('kode_potonganbahan', '=', $kode_potonganbahan)->count();

            if ($check_count_detaildata > 0) {

                $close_potonganbahan = PotonganBahan::where('kode_potonganbahan', '=', $kode_potonganbahan)
                    ->update([
                        'status' => 'CLOSED',
                        'user_update' => $nik,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                $update_orders_detail = OrdersDetail::where('kode_order', '=', 'TR'.$kode_potonganbahan)->update(
                    [
                        'potongan_bahan_closed' => 'Y',
                        'potongan_bahan_closed_timestamp' => date('Y-m-d H:i:s'),
                        'user_update' => session()->get('nik'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );
                return redirect('/potonganbahan' . '/' . $kode_potonganbahan)->with('success', 'Berhasil Closed Potongan Bahan!');
            } else {
                return redirect('/potonganbahan' . '/' . $kode_potonganbahan)->with('error', 'Tidak bisa di Close karena tidak ada detail data!');
            }
        }
    }

    public function print_potonganbahan($post_data)
    {
        $kode_potonganbahan = $post_data;

        if (is_null($kode_potonganbahan)) {
            return redirect('/');
        } else {
            $header = PotonganBahan::join('dt_customer', 'dt_potonganbahan.kode_customer', '=', 'dt_customer.kode_customer')
                ->join('dt_modelpola', 'dt_potonganbahan.kode_model', '=', 'dt_modelpola.kode_model')
                ->select('dt_potonganbahan.*', 'dt_customer.nama_brand', 'dt_modelpola.nama_model')
                ->where('dt_potonganbahan.kode_potonganbahan', '=', $kode_potonganbahan)
                ->first();
            $detail = PotonganBahanDetail::where('kode_potonganbahan', '=', $kode_potonganbahan)->get();

            $data = [
                'menu' => 'PotonganBahan',
                'header' => $header,
                'detail' => $detail
            ];

            return view('potongan_bahan.print', $data);
        }
    }
}
