<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $user_id = session()->get('id');

        $account_user = DB::table('account')
            ->where('id_user', $user_id)
            ->first();

        if(empty($account_user)){
            return redirect()->back()->with("error", "Maaf tidak bisa menemukan data akun!");
        }

        $fullname = $account_user->fullname;
        list($firstName, $lastName) = explode(' ', $fullname, 2);
        return view('profil', compact('account_user', 'firstName', 'lastName'));
    }

    public function save_profile(Request $request)
    {
        $request->validate([
            'first-name' => 'required|string',
            'last-name' => 'string',
            'username' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('user', 'email')->ignore(session()->get('id'), 'id_user'),
            ],
            'no-hp' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
        ], [
            'email.unique' => 'Email yang diinput sudah ada.',
        ]);

        $user_id = session()->get('id');
        
        $first_name = $request->input('first-name');
        $last_name = $request->input('last-name');
        $nama = trim($first_name . " " . $last_name);

        $update_user = [
            'nama' => $request->input('username'),
            'email' => $request->input('email'),
        ];
        DB::table('user')
            ->where('id_user', $user_id)
            ->update($update_user);

        $update_data_perbankan = [
            'fullname' => $nama,
            'phone_number' => $request->input('no-hp'),
            'city' => $request->input('city'),
            'address' => $request->input('address'),
        ];
        DB::table('account')
            ->where('id_user', $user_id)
            ->update($update_data_perbankan);

        return redirect()->back()->with("success", "Profil berhasil diganti!");
    }


    public function security_account(Request $request)
    {
        return view('security_account');
    }

    public function ganti_password(Request $request)
    {
        // Validate the request
        $request->validate([
            'confirm-password' => 'required',
            'current-password' => 'required',
            'new-password' => 'required',
        ]);

        $current_password = $request->input('current-password');
        $confirm_password = $request->input('confirm-password');
        $new_password = $request->input('new-password');

        if($new_password !== $confirm_password){
            return redirect()->back()->with('error', "Maaf password konfirmasi tidak sama");
        }

        $user_id = session()->get('id');

        // Retrieve the current hash_password from the database
        $user = DB::table('user')
            ->select('password')
            ->where('id_user', $user_id)
            ->first();

        if (!$user) {
            return redirect()->back()->with("error", "User not found");
        }

        $hash_password = $user->password;

        // Verify the current password
        if (!Hash::check($current_password, $hash_password)) {
            return redirect()->back()->with("error", "Password salah!");
        }

        // Hash and update the new password
        $new_hash_password = Hash::make($new_password);

        // Update the password in the database
        DB::table('user')
            ->where('id_user', $user_id)
            ->update(['password' => $new_hash_password]);

        return redirect()->back()->with("success", 'Password berhasil diubah!');
    }
}


