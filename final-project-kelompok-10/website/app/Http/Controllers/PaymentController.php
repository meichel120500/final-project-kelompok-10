<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\APIExchange;

class PaymentController extends Controller
{
    public function index()
    {
        $user_id = session()->get('id');
        $saldo = DB::table('balance')->select(['saldo'])->where(['id_user' => $user_id, 'id_currency' => 1])->first();
        return view('payment', compact('saldo'));
    }

    public function submit_payment(Request $request)
    {
        $jumlah_payment = $request->input('jumlah_payment');
        if(empty($jumlah_payment) || $jumlah_payment <= 0){
            return redirect()->back()->with('error', "Maaf, jumlah payment harus angka positif!");
        }

        $user_id = session()->get('id');

        $res_saldo = DB::table('balance')->select(['saldo'])->where(['id_user' => $user_id, 'id_currency' => 1])->first();
        $saldo_user_idr = $res_saldo->saldo;

        if($jumlah_payment > $saldo_user_idr){
            return response()->json(['error' => "Maaf, uang yang di payment melebihi saldo IDR mu"], 422);
        }

        $saldo_idr_after_payment = $saldo_user_idr - $jumlah_payment;
        DB::table('balance')->where(['id_user' => $user_id, 'id_currency' => 1])->update(['saldo' => $saldo_idr_after_payment]);
        DB::table('transaction')->insert([
            'id_user' => $user_id,
            'tanggal' => date('Y-m-d'),
            'jml_mata_uang_digital' => $jumlah_payment,
            'metode_pembayaran' => 'payment',
            'status_transaksi' => 'success'
        ]);

        return view('payment_success');
    }
}


