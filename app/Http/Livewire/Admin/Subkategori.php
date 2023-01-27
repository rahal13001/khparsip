<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Subkategori extends Component
{

    protected $listeners = ['updateSubcategory' => 'render'];


    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $cari ="";
    public $checked = [];
    public $selectPage= false;
    public $selectAll=false;
    public $paginate = 10;
    public $orderby = "created_at";
    public $asc = "DESC";
    public $editedSubcategoryIndex = Null;
    public $setsubcategories = [];


    
    public function updatedChecked(){
        $this->selectPage =false;
    }

    
    public function isChecked($subcategory_id)
    {
        return in_array($subcategory_id, $this->checked);
    }

    public function deleteDatas(){
        
        $subcategories = Subcategory::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll=false;
        $this->selectPage=false;
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Terhapus',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }


    public function deleteSatuData($subcategory_id){
        
        Subcategory::where('id', $subcategory_id)->delete();

        $this->checked = array_diff($this->checked, [$subcategory_id]);
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Terhapus',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }

    public function render() : View
    {
        $this->setsubcategories = Subcategory::all()->toArray();

        return view('livewire.admin.subkategori', [
        "subcategories" => $this->subcategories,
        "categories" => Category::all(),
        "setsubcategories" => $this->setsubcategories
        ]);
    }


    public function selectAll(){
        $this->selectAll=true;
        $this->checked = $this->subcategoriesQuery->pluck('id')->toArray();
    }

    public function selectPart(){
        $this->selectAll=false;
        $this->checked = $this->subcategories->pluck('id')->toArray();
    }

    public function updatedSelectPage($value){
        if ($value) {
            $this->checked = $this->subcategories->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
        
    }

    public function getSubcategoriesProperty(){
        return $this->subcategoriesQuery->paginate($this->paginate);
    }

    public function getSubcategoriesQueryProperty(){
       return Subcategory::with('categories')
                ->cari(trim($this->cari))
                ->orderBy($this->orderby, $this->asc);
    }


    public function editSubcategory($subcategoryIndex){
        $this->editedSubcategoryIndex = $subcategoryIndex;
    }


    public function saveSubcategory($subcategoryIndex){
        $subcategory = $this->setsubcategories[$subcategoryIndex] ?? NULL;
      
        if (!is_null($subcategory)) {
            $editedSubcategory = Subcategory::where('id', $this->editedSubcategoryIndex);
            if ($editedSubcategory) {
                $editedSubcategory->update($subcategory);
            }

        }

        $this->editedSubcategoryIndex = null;
    }

}
