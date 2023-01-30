<?php

namespace App\Http\Livewire\Admin;
use App\Models\Category;
use App\Models\Report;
use App\Models\Report_User;
use App\Models\Subcategory;
use App\Models\Subcategory_Report;

use Livewire\WithPagination;

use Livewire\Component;

class Dashboardkategori extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['sendnotifTambah' => 'notif'];

    public $paginate = 10;
    public $orderby = "created_at";
    public $asc = "DESC";
    public $checked = [];
    public $cari = "";
    public $mulai = "";
    public $akhir = "";
    public $selectPage= false;
    public $selectAll=false;
    public $subkategori = [];
    public $kategori = [];
    public $kiriman_id;

    public function mount($categories_kiriman){
        $this->kiriman_id = $categories_kiriman->id;
    }
    
    public function mulai(){
        $validatedData = $this->validate([
            'mulai' => 'nullable'
        ]);
    }

    public function akhir(){
        $validatedData = $this->validate([
            'akhir' => 'after_or_equal:mulai_',
        ], [
            'after_or_equal' => 'Tanggal Harus Sama Dengan Atau Lebih Dari Tanggal Awal',
            ]);
    }


    public function render()
    {
       
        return view('livewire.admin.dashboardkategori',[
            "datas" => $this->datas,
            "subcategories" => Subcategory::all(),
        ]);
    }

    public function updatedSelectPage($value){
        if ($value) {
            $this->checked = $this->datas->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
        
    }

    public function updatedChecked(){
        $this->selectPage =false;
    }

    
    public function isChecked($data_id)
    {
        return in_array($data_id, $this->checked);
    }

    public function selectAll(){
        $this->selectAll=true;
        $this->checked = $this->datasQuery->pluck('id')->toArray();
    }

    public function selectPart(){
        $this->selectAll=false;
        $this->checked = $this->datas->pluck('id')->toArray();
    }

    public function getDatasProperty(){
        return $this->datasQuery->paginate($this->paginate);
    }

    public function getDatasQueryProperty(){
          
        return Report::with('user')
                        ->whereHas('categories', function($categories_id){
                            $categories_id->where('id', $this->kiriman_id);
                        })->when($this->mulai && $this->akhir, function($query){
                            $query->whereBetween('when', [trim($this->mulai), trim($this->akhir)]);})
                        ->when($this->subkategori, function($query){
                                $query->whereHas('subcategories', function($categoryId){
                                $categoryId->whereKey('subcategory_id', $this->subkategori);
                            });
                        })->cari(trim($this->cari))
                        ->orderBy($this->orderby, $this->asc);
    }


    public function deleteDatas(){
        
        $reports = Report::whereKey($this->checked)->delete();
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


    public function deleteSatuData($data_id){
        
        Report::where('id', $data_id)->delete();

        $this->checked = array_diff($this->checked, [$data_id]);
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Terhapus',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }
}
