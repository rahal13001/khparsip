<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;


class AssignController extends Controller
{
     public function edit(Role $role){

        //dibuat array mengikuti untuk mengirimkan data sebenernya sama saja seperti variabel namun lebih praktis
        return view('superadmin.permissions.edit', [
            'role' => $role,
            'roles' => Role::get(),
            'permissions' => Permission::get()
            
        ]);
    }

    public function update(Role $role){
        request()->validate([
            'name' => 'required',
            'permission' => 'array|nullable',
        ]);

        $role->syncPermissions(request('permission'));

        Alert::success('Berhasil', 'Role Telah Memiliki Permission');

        return redirect()->route('assignrole')->with('status', "Hak Akses Berhasil Diubah");
    }

}