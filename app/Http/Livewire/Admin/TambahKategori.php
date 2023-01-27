<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class TambahKategori extends Component
{
    public $nama, $slug, $submit;

    public function generateSlug()
    {
        $this->slug = SlugService::createSlug(Category::class, 'slug', $this->nama);
    }
    


    public function submit()
    {
        $validatedData = $this->validate([
            'nama' => 'required|max:255|unique:categories,nama,except,id',
        ], [
            'required' => 'Harap Jawab Pertanyaan Ini',
            'max' => 'Jumlah Karakter Maksimal Adalah 255 Karaker (Termasuk Spasi)',   
            'unique' => 'Kategori Telah Tersedia'   
            ]);
 
        Category::create([
            'nama' => $this->nama,
            'slug'  => $this->slug
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Berhasil',
            'text' => 'Terimakasih Telah Menambahkan Kategori',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);

        $this->clearForm();
        $this->emit('updatecategory');
    }

    public function clearForm()
    {
        $this->nama = "";
    }

    public function render()
    {
        return view('livewire.admin.tambah-kategori');
    }


}
