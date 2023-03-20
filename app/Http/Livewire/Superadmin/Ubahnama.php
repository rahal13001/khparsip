<?php

namespace App\Http\Livewire\Superadmin;

use App\Models\User;
use Livewire\Component;

class Ubahnama extends Component
{

    public $name;
    public $user;
    public $nama;
    public $ubah;

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function ubah(){
        $this->ubah = true;
    }

    public function batal(){
        $this->ubah = false;
    }

    public function mount($user)
    {
        $this->name = $user->name;
        $this->user = $user;
    }

    public function update()
    {
        $this->validate();       
        User::whereKey($this->user->id)->update(['name' => $this->name]);


        $this->ubah = false;
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Edit Nama Berhasil',
            'text' => '',
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.superadmin.ubahnama');
    }
}
