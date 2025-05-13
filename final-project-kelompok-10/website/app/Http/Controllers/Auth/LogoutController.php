<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        $error = session('error');
        session()->flush();
        return redirect()->route('login')->with("error", $error);
    }
}


