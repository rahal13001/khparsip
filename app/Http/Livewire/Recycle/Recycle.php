<?php

namespace App\Http\Livewire\Recycle;
use App\Exports\ReportsExport;
use App\Models\Category;
use App\Models\Report;
use App\Models\Report_User;
use App\Models\Subcategory;
use App\Models\Subcategory_Report;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;




class Recycle extends Component
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
    public $selectedSubkategori = Null;
    public $subkategori = [];
    public $kategori = [];

    public function mulai(){
        $validatedData = $this->validate([
            'mulai' => 'nullable'
        ]);
    }

    public function notif(){
        return $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'success',
                'title' => 'Tambah Data Berhasil',
                'text' => '',
                'timer' => 5000,
                'timerProgressBar' => true,
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
       
        return view('livewire.recycle.recycle',[
            "datas" => $this->datas,
                      
            "categories" => Category::all(),
        ]);
    }

    public function updatedKategori($kategori_id){
 
        $this->selectedSubkategori = Category::with('subcategories')->whereKey($kategori_id)->get();
        
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
       return Report::onlyTrashed()->with('user', 'categories', 'subcategories')
                        ->when($this->mulai && $this->akhir, function($query){
                            $query->whereBetween('when', [trim($this->mulai), trim($this->akhir)]);})
                        ->when($this->kategori, function($query){
                                $query->whereHas('categories', function($categoryId){
                                $categoryId->whereIn('category_id', $this->kategori);
                            });
                        })
                        ->when($this->subkategori, function($query){
                            $query->whereHas('subcategories', function($subcategoryId){
                            $subcategoryId->whereIn('subcategory_id', $this->subkategori);
                        });
                        })->cari(trim($this->cari))
                        ->orderBy($this->orderby, $this->asc);
    }


    public function deleteDatas(){

        $gambar = Report::with('dokumentasi')->withTrashed()->whereIn('id', $this->checked)->get();

        foreach($gambar as $g){
            Storage::disk('public')->delete(['dokumentasi/' . $g->dokumentasi->dokumentasi1]);

            if($g->dokumentasi->dokumentasi2 != null){
                Storage::disk('public')->delete(['dokumentasi/' . $g->dokumentasi->dokumentasi2]);
            }
            if($g->dokumentasi->dokumentasi3 != null){
                Storage::disk('public')->delete(['dokumentasi/' . $g->dokumentasi->dokumentasi3]);
            }
            if($g->dokumentasi->st != null){
                Storage::disk('public')->delete(['dokumentasi/' . $g->dokumentasi->st]);
            }
            if($g->dokumentasi->lainnya != null){
                Storage::disk('public')->delete(['dokumentasi/' . $g->dokumentasi->lainnya]);
            }
        }
        
        Report::whereKey($this->checked)->forcedelete();
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

    public function restoreDatas(){
        
        Report::whereKey($this->checked)->restore();
        $this->checked = [];
        $this->selectAll=false;
        $this->selectPage=false;
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Di Kembalikan',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }



    public function deleteSatuData($data_id){

        $gambar = Report::with('dokumentasi')->withTrashed()->where('id', $data_id)->first();

        Storage::disk('public')->delete(['dokumentasi/' . $gambar->dokumentasi->dokumentasi1]);

        if($gambar->dokumentasi->dokumentasi2 != null){
            Storage::disk('public')->delete(['dokumentasi/' . $gambar->dokumentasi->dokumentasi2]);
        }
        if($gambar->dokumentasi->dokumentasi3 != null){
            Storage::disk('public')->delete(['dokumentasi/' . $gambar->dokumentasi->dokumentasi3]);
        }
        if($gambar->dokumentasi->st != null){
            Storage::disk('public')->delete(['dokumentasi/' . $gambar->dokumentasi->st]);
        }
        if($gambar->dokumentasi->lainnya != null){
            Storage::disk('public')->delete(['dokumentasi/' . $gambar->dokumentasi->lainnya]);
        }
        
        Report::where('id', $data_id)->forcedelete();

        $this->checked = array_diff($this->checked, [$data_id]);
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Terhapus',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }

    public function restoreSatuData($data_id){
        
        Report::where('id', $data_id)->restore();

        $this->checked = array_diff($this->checked, [$data_id]);
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Dikembalikan',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }

    public function eksporexcel(){
        
        // return (new ReportsExport($this->checked))->download('laporan.xlsx');
        return Excel::download(new ReportsExport($this->checked), 'laporan_di_hapus_sementara.xlsx');
    }
}
