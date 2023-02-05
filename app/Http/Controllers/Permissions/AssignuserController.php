<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
class AssignuserController extends Controller
{
    // public function store()
    // {
    //     request()->validate([
    //         'user' => 'required',
    //         'roles' => 'array|required',
    //     ]);


    //     $user = User::where('id', request('user'))->first();

    //     $user->assignRole(request('roles'));

    //     return back()->with('status', "Pemberian Role Berhasil");

        
    // }


       public function edit(User $user){
        // $tes = User::with('category')->orderBy('name')->get();
      
        //dibuat array mengikuti untuk mengirimkan data sebenernya sama saja seperti variabel namun lebih praktis
        return view('superadmin.permissions.edituser', [
            'user' => $user,
            'users' => User::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
            'categories' => Category::orderBy('nama')->get()
        ]);


        
    }

    public function update(User $user, Request $request){
        request()->validate([
            'roles' => 'array|nullable',
            'categories' => 'array|nullable'
        ]);
        
        $user->category()->sync($request->categories);
        $user->syncRoles(request('roles'));

        Alert::success('Berhasil', 'Data Telah Tersinkronisasi');

        return redirect()->route('superadmin_tambah')->with('status', "Hak Akses Berhasil Diubah");

    }
}
