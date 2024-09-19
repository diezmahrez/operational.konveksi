<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\OrdersDetail;
use App\Models\PotonganBahanDetail;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class PotonganBahanDetailController extends Controller
{
    public function inputprocess(Request  $post_data)
    {
        if ($post_data->input('kode_potonganbahan_detail')) {
            $checkHasProcess = PotonganBahanDetail::where('nik_process', '!=', '')
                ->where('kode_potonganbahan_detail', '=', $post_data->input('kode_potonganbahan_detail'))->count();

            // if ($checkHasProcess > 0) {
            //     return redirect('/potonganbahandetail/inputprocess')
            //         ->with('danger', 'Kode Tersebut sudah di input!!');
            // }

            $updatedata = [
                'nik_process' => $post_data->input('nik'),
                'status' => 'PROCESS',
                'nik_process_timestamp' => date('Y-m-d H:i:s'),
                'user_update' => session()->get('nik'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $updatePotonganBahanDetail = PotonganBahanDetail::where('kode_potonganbahan_detail', '=', $post_data->input('kode_potonganbahan_detail'))->update($updatedata);
            $kode_potonganbahan =  substr($post_data->input('kode_potonganbahan_detail'), 0, 17);
            $checkForUpdateOrderdetail = PotonganBahanDetail::where([
                ['kode_potonganbahan', '=', $kode_potonganbahan],
                ['nik_process', '!=', ''],
                ['status', '=', 'PROCESS']
            ])->count();
            // dd($checkForUpdateOrderdetail);
            if ($checkForUpdateOrderdetail == 1) {
                $kode_order = 'TR'.$kode_potonganbahan;
                $update_orders_detail = OrdersDetail::where('kode_order', '=', $kode_order)->update(
                    [
                        'penjahit_process' => 'Y',
                        'penjahit_process_timestamp' => date('Y-m-d H:i:s'),
                        'user_update' => session()->get('nik'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );
            }
            return redirect('/potonganbahandetail/inputprocess')->with('success', 'Berhasil Input Data!!');
        }


        $getNikKaryawan = Karyawan::where('aktif', '=', 'y')->get();
        $data = [
            'menu' => 'PotonganBahanDetail',
            'submenu' => 'inputprocess',
            'karyawan' => $getNikKaryawan
        ];
        return view('potongan_bahan_detail.inputprocess', $data);
    }


    public function getkode_potonganbahan_detail(Request $request)
    {
        $kode_potonganbahan_detail = $request->input('kode_potonganbahan_detail');
        // $kode_model = substr($kode_potonganbahan_detail,6,4);
        $data = PotonganBahanDetail::select('kode_potonganbahan_detail', 'nama_model', 'nama_brand', DB::raw('SUBSTR(kode_potonganbahan_detail,18,3) AS NO'), 'qty')
            ->join('dt_modelpola', DB::raw('SUBSTR(dt_potonganbahan_detail.kode_potonganbahan_detail,6,4)'), '=', 'dt_modelpola.kode_model')
            ->join('dt_customer', DB::raw('SUBSTR(dt_potonganbahan_detail.kode_potonganbahan_detail,1,5)'), '=', 'dt_customer.kode_customer')
            ->where('kode_potonganbahan_detail', '=', $kode_potonganbahan_detail)->first();

        return response()->json(['data' => $data]);
    }
}
