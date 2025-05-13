<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\APIExchange;

class ConvertController extends Controller
{
    public function index()
    {
        $user_id = session()->get('id');
        $saldo = DB::table('balance')->select(['saldo'])->where(['id_user' => $user_id, 'id_currency' => 1])->first();

        $currency_mode = session()->get('currency_mode');
        
        $currencies = DB::table('currency')->where('id', '!=', 1)->get();

        $currencies_exchange_rates = [];
        foreach($currencies as $currency){
            $kode_mata_uang_convert = $currency->kode_mata_uang;
            $currencies_exchange_rates[$currency->kode_mata_uang] = $this->_get_conversion_rate_idr($kode_mata_uang_convert);
        }

        return view('convert', compact('currency_mode','currencies', 'saldo', 'currencies_exchange_rates'));
    }

    public function submit_convert(Request $request)
    {
        $jumlah_convert = $request->input('jumlah_convert');
        $selected_kode_mata_uang = $request->input('selected_kode_mata_uang');

        $jumlah_convert = $jumlah_convert ?? 0;
        $user_id = session()->get('id');
        $currency_mode = session()->get('currency_mode');

        $currency_convert = DB::table('currency')->select(['id', 'nama_mata_uang', 'kode_mata_uang'])->where(['kode_mata_uang' => $selected_kode_mata_uang])->first();
        if(empty($currency_convert)){
            return redirect()->back()->with('error', "Maaf, kode mata uang yang dipilih tidak ada di daftar!");
        }
        
        if($currency_convert->id != $currency_mode){
            session()->put('currency_mode', $currency_convert->id);
        }


        $kode_mata_uang_convert = $currency_convert->kode_mata_uang;
        
        $convert_rate_idr = $this->_get_conversion_rate_idr($kode_mata_uang_convert);

        $jumlah_idr = $convert_rate_idr * $jumlah_convert;

        $res_saldo = DB::table('balance')->select(['saldo'])->where(['id_user' => $user_id, 'id_currency' => 1])->first();
        $saldo_user_idr = $res_saldo->saldo;

        if($jumlah_idr > $saldo_user_idr){
            return redirect()->back()->with('error', 'Maaf, uang yang di convert melebihi saldo IDR mu');
        }

        $res_saldo_convert = DB::table('balance')->select(['saldo'])->where(['id_user' => $user_id, 'id_currency' => $currency_convert->id])->first();
        if($res_saldo_convert){
            $saldo_convert = $res_saldo_convert->saldo;
            $saldo_convert += $jumlah_convert;
            DB::table('balance')->where(['id_user' => $user_id, 'id_currency' => $currency_convert->id])->update(['saldo' => $saldo_convert]);
        }else{
            $saldo_convert = $jumlah_convert;
            DB::table('balance')->insert([
                'id_user' => $user_id,
                'id_currency' => $currency_convert->id,
                'saldo' => $saldo_convert
            ]);
        }

        $saldo_idr_after_conversion = $saldo_user_idr - $jumlah_idr;
        DB::table('balance')->where(['id_user' => $user_id, 'id_currency' => 1])->update(['saldo' => $saldo_idr_after_conversion]);
        DB::table('transaction')->insert([
            'id_user' => $user_id,
            'tanggal' => date('Y-m-d'),
            'jml_mata_uang_digital' => $jumlah_convert,
            'metode_pembayaran' => 'convert',
            'nama_mata_uang' => $currency_convert->nama_mata_uang,
            'status_transaksi' => 'success'
        ]);

        return view('convert_success');
    }

    private function _get_conversion_rate_idr($kode_mata_uang_convert)
    {
        $base_eur_in_idr = APIExchange::get('latest', ['symbols' => 'IDR'])['rates']['IDR'];
        $base_eur_in_convert = APIExchange::get('latest', ['symbols' => $kode_mata_uang_convert])['rates'][$kode_mata_uang_convert];
        $convert_rate_idr = $base_eur_in_idr / $base_eur_in_convert;
        return $convert_rate_idr;
    }
}


