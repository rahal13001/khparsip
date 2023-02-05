<?php

namespace App\Http\Livewire\Superadmin;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\User;
use Livewire\Component;

use function PHPUnit\Framework\isNull;

class Tambahkategori extends Component
{
    public $nama, $taut, $user_id, $clearform;
    public $category_id = [];
   
  
    public function render()
    {
        return view('livewire.superadmin.tambahkategori',[
            "users" => User::get(),
            "categories" => Category::get()
        ]);
    }


    public function taut(){

        $validatedData = $this->validate([
            'user_id' => 'required',
            'category_id' => 'required'
        ], [
            'user_id.required' => 'Harap Isi Kolom User',
            'category_id.required' => 'Harap Isi Kolom Kategori',
             
            ]);


        foreach ($this->category_id as $kategori ) {
         
            $cek = CategoryUser::where('user_id', $this->user_id)->where('category_id', $kategori)->get();

            if (count($cek)<1) {
                
                    $userinput= User::find($this->user_id);
                    $userinput->category()->attach($kategori);
              
            }
        }

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
        $this->user_id = Null;
        $this->category_id = Null;
    }
}
