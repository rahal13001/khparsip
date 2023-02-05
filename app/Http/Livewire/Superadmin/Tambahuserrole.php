<?php

namespace App\Http\Livewire\Superadmin;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Tambahuserrole extends Component
{

    public $nama, $taut, $user_idrole, $clearform;
    public $role_id = [];
   
  
    public function render()
    {
        return view('livewire.superadmin.tambahuserrole',[
            "usersrole" => User::get(),
            "roles" => Role::get(),
        ]);
    }


    public function taut(){

        $validatedData = $this->validate([
            'user_idrole' => 'required',
            'role_id' => 'required'
        ], [
            'user_id.required' => 'Harap Isi Kolom User',
            'role_id.required' => 'Harap Isi Kolom Kategori',
             
            ]);

            
        $user = User::where('id', $this->user_idrole)->first();

        $user->assignRole($this->role_id);

            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'success',
                'title' => 'Berhasil',
                'text' => 'User dan Kategori Berhasil Tertaut',
                'timer' => 5000,
                'timerProgressBar' => true,
            ]);
        
        $this->clearForm();
        $this->emit('updateUserKategori');
        $this->emit('reloadform');
        
    }

    public function clearForm()
    {
        $this->user_idrole = Null;
        $this->role_id = Null;
    }
}
