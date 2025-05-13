<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\APIExchangeAsync;

class SaldoController extends Controller
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


        $money_transfer = collect(DB::select("SELECT SUM(jml_mata_uang_digital) as total FROM transaction WHERE status_transaksi = 'success' AND id_user = :ID_USER AND metode_pembayaran ='payment'", ["ID_USER" => $user_id]))->first();
        

        $money_income = collect(DB::select("SELECT SUM(jml_mata_uang_digital) as total FROM transaction WHERE status_transaksi = 'success' AND id_user = :ID_USER AND metode_pembayaran ='top up'", ["ID_USER" => $user_id]))->first();
        $res = DB::table('currency')->select('nama_mata_uang')->where(['id' => $currency_mode])->first();
        $nama_mata_uang_convert = "Rp.";

        if($res){
            $nama_mata_uang_convert = $res->nama_mata_uang;
        }

        $currency_mode = session()->get('currency_mode');
        $res_kode= DB::table('currency')->select('kode_mata_uang')->where(['id' => $currency_mode])->first();
        $convert_code = 'IDR';
        if($res_kode){
            $convert_code = $res_kode->kode_mata_uang;
        }

        // Ambil dates selama 15 hari
        $dates = array();
        $currentDate = new \DateTime();
        for ($i = 0; $i < 15; $i++) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->modify('-1 day');
        }
        sort($dates);
        $exchange_rates_in_1_month = $this->_get_exchange_rates($convert_code, $dates);

        return view('saldo', compact('money_income', 'money_transfer', 'saldo_exchange', 'saldo_rupiah', 'nama_mata_uang_convert', 'exchange_rates_in_1_month', 'convert_code', 'dates'));
    }

    private function _get_exchange_rates($convert_code, $dates)
    {
        $client = new APIExchangeAsync();

        // Rates IDR in EUR
        foreach($dates as $date){
            $client->add_get('idr'.$date, $date, ['symbols' => 'IDR']);
        }

        // Rates Convert in EUR
        foreach($dates as $date){
            $client->add_get($convert_code.$date, $date, ['symbols' => $convert_code]);
        }

        $result = $client->wait();

        $eur_rate_in_idr = [];
        $eur_rate_in_convert = [];

        foreach($dates as $date){
            $eur_rate_in_idr[] = $result['idr'.$date]['value']['rates']['IDR'];
        }

        foreach($dates as $date){
            $eur_rate_in_convert[] = $result[$convert_code.$date]['value']['rates'][$convert_code];
        }
        
        $exchange_rates = [];
        for($i = 0; $i < count($eur_rate_in_idr); $i++){
            $exchange_rates[] =  $eur_rate_in_idr[$i] / $eur_rate_in_convert[$i];
        }


        return $exchange_rates;
    }
}


