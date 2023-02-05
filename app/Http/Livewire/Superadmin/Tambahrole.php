<?php

namespace App\Http\Livewire\Superadmin;

use Livewire\Component;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Spatie\Permission\Models\Role;

class Tambahrole extends Component
{
    public $name, $submit;

    public function submit()
    {
        $validatedData = $this->validate([
            'name' => 'required|max:255|unique:roles,name,except,id',
        ], [
            'required' => 'Harap Jawab Pertanyaan Ini',
            'max' => 'Jumlah Karakter Maksimal Adalah 255 Karaker (Termasuk Spasi)',   
            'unique' => 'Kategori Telah Tersedia'   
            ]);
 
        Role::create([
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
        $this->emit('updaterole');
    }

    public function clearForm()
    {
        $this->name = "";
    }

    public function render()
    {
        return view('livewire.superadmin.tambahrole');
    }


}
