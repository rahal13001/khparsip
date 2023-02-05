<?php

namespace App\Http\Livewire\Superadmin;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;

class Tambahpermission extends Component
{
    public $name, $submit;

    public function submit()
    {
        $validatedData = $this->validate([
            'name' => 'required|max:255|unique:permissions,name,except,id',
        ], [
            'required' => 'Harap Jawab Pertanyaan Ini',
            'max' => 'Jumlah Karakter Maksimal Adalah 255 Karaker (Termasuk Spasi)',   
            'unique' => 'Kategori Telah Tersedia'   
            ]);
 
        Permission::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Berhasil',
            'text' => 'Terimakasih Telah Menambahkan Kategori',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);

        $this->clearForm();
        $this->emit('updatepermission');
    }

    public function clearForm()
    {
        $this->name = "";
    }

    public function render()
    {
        return view('livewire.superadmin.tambahpermission');
    }
}
