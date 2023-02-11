<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit(){
        $password = Auth::user()->id;
        return view('account.editpassword', compact('password'));
    }

    public function update(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $passwordsekarang = Auth::user()->password;
        $old_password = $request->old_password;

            if (Hash::check($old_password, $passwordsekarang)) {
            Auth::user()->update([
                'password' => bcrypt($request->password),
            ]);

            return redirect()->back()->with('status', 'Ubah Password Berhasil');
        }
        else {
            return redirect()->back()->with('error', 'Ubah Password Gagal, Silahkan Isi Dengan Tepat');
        }

    }
}
