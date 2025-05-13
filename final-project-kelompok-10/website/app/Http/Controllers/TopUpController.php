<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    public function index()
    {
        $user_id = session()->get('id');
        $saldo = DB::table('balance')->select(['saldo'])->where(['id_user' => $user_id, 'id_currency' => 1])->first();
        return view('top_up', compact('saldo'));
    }

    public function submit_top_up(Request $request)
    {
        $saldo_topup = $request->input('jumlah_top_up');
        if(empty($saldo_topup) || $saldo_topup <= 0){
            return redirect()->back()->with('error', 'Maaf, jumlah top up harus angka positif!');
        }
        $user_id = session()->get('id');
        $currency_mode = session()->get('currency_mode');

        $res = DB::table('balance')->select(['saldo'])->where(['id_user' => $user_id, 'id_currency' => 1])->first();

        $saldo = $res->saldo;

        $saldo += $saldo_topup;

        DB::table('balance')->where(['id_user' => $user_id, 'id_currency' => 1])->update(['saldo' => $saldo]);
        DB::table('transaction')->insert([
            'id_user' => $user_id,
            'tanggal' => date('Y-m-d'),
            'jml_mata_uang_digital' => $saldo_topup,
            'metode_pembayaran' => 'top up',
            'status_transaksi' => 'success'
        ]);


        return view('top_up_success');
    }
}


