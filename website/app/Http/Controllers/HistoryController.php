<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index()
    {
        $user_id = session()->get('id');
        $currency_mode = session()->get('currency_mode');

        $transaction_history = DB::table('transaction')
            ->where(['id_user' => $user_id])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('history', compact('transaction_history'));
    }
}


