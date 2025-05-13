<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    public function index()
    {
        if(session()->has('id')){
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function submit_login(Request $request)
    {  
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Parameter email is required.',
            'email.email' => 'Parameter email must be a valid email address.',
            'password.required' => 'Parameter password is required.',
        ]);


        $email = $request->input('email');
        $password = $request->input('password');

        // Find the user by email
        $user = DB::table('user')
            ->select('id_user', 'nama', 'email', 'password')
            ->where('email', $email)
            ->first();

        if (!$user) {
            return redirect()->back()->with("error", 'Email atau Password salah!');
        }

        // Verify the password
        if (!Hash::check($password, $user->password)) {
            return redirect()->back()->with("error", 'Email atau Password salah!');
        }

        session()->put('id', $user->id_user);
        session()->put('username', $user->nama);
        session()->put('email', $user->email);
        session()->put('currency_mode', 2); // RM      

        return redirect()->route('dashboard');
    }

    public function sign_up(Request $request)
    {
        return view('sign_up');
    }

    public function submit_sign_up(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'fullname' => 'required|string',
            'username' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('user', 'email'),
            ],
            'password' => 'required|string',
        ], [
            'email.unique' => 'Email yang diinput sudah ada.',
        ]);

        $nama = $request->input('fullname');

        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');

        // Check if the username or email is already registered
        $userExists = DB::table('user')
            ->where('email', $email)
            ->exists();

        if ($userExists) {
            return redirect()->back()->with("error", "Email yang diinput sudah ada");
        }

        // Hash the password
        $hash_password = Hash::make($password);

        // Create a new user
        $userId = DB::table('user')->insertGetId([
            'nama' => $username,
            'email' => $email,
            'password' => $hash_password,
        ]);
        
        if (!$userId) {
            return redirect()->back()->with('error', "Ada masalah pada server");
        }

        $res_currencies = DB::table('currency')->select('id')->get();
        foreach($res_currencies as $currency){
            DB::table('balance')->insert([
                'id_user' => $userId,
                'id_currency' => $currency->id,
                'saldo' => 0,
            ]);
        }

        DB::table('account')->insert(['id_user' => $userId, 'fullname' => $nama]);        

        return redirect()->route('login')->with("success", "Akun berhasil dibuat!");
    }
}


