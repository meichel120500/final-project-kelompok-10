<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = session()->get('id');
        $currency_mode = session()->get('currency_mode');

        $saldo_rupiah = DB::table('balance')
            ->select('saldo')
            ->where(['id_user' => $user_id, 'id_currency' => 1])
            ->first();

        $saldo_exchange = DB::table('balance')
            ->select('saldo')
            ->where(['id_user' => $user_id, 'id_currency' => $currency_mode])
            ->first();

        $res = DB::table('currency')->select('nama_mata_uang')->where(['id' => $currency_mode])->first();
        $nama_mata_uang_convert = "Rp.";

        if($res){
            $nama_mata_uang_convert = $res->nama_mata_uang;
        }

        return view('dashboard', compact('saldo_rupiah', 'saldo_exchange', 'nama_mata_uang_convert'));
    }
}


