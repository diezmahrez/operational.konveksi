<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

use App\Models\OrdersM;
use App\Models\PotonganBahan;

class Databadge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $order_onprocess = OrdersM::where('status', '=', 'PROCESS')->count();
        $potonganbahan_onprocess = PotonganBahan::where('status','=','PROCESS')->count();

        $data = $order_onprocess;

        // Simpan data terbaru ke dalam session
        Session::put('badge',[
            'order' => $order_onprocess,
            'potongan_bahan' => $potonganbahan_onprocess

        ]);

        // Lanjutkan ke request berikutnya
        return $next($request);
    }
}
