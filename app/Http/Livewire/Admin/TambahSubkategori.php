<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Category;
use App\Models\Subcategory;

class TambahSubkategori extends Component
{

    public $nama, $category_id, $slug, $submit;
    public $selected = '';

    public $categories;

    public function mount($categories){
        $this->categories = $categories;
    }

    public function generateSlug()
    {
        $this->slug = SlugService::createSlug(Subcategory::class, 'slug', $this->nama);
    }
    


    public function submit()
    {
       
        $validatedData = $this->validate([
            'nama' => 'required|max:255|unique:categories,nama,except,id',
            'category_id' => 'required'
        ], [
            'required' => 'Harap Isikan Nama Sub Kategori',
            'max' => 'Jumlah Karakter Maksimal Adalah 255 Karaker (Termasuk Spasi)',   
            'unique' => 'Sub Kategori Telah Tersedia'   
            ]);
 
        Subcategory::create([
            'nama' => $this->nama,
            'slug'  => $this->slug,
            'category_id' => $this->category_id
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Berhasil',
            'text' => 'Terimakasih Telah Menambahkan Sub Kategori',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);

        $this->clearForm();
        $this->emit('updateSubcategory');
    }

    public function clearForm()
    {
        $this->nama = "";
        $this->category_id = "";
    }

    public function render()
    {
        return view('livewire.admin.tambah-subkategori');
    }
}
