<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\CategoryReport;
use App\Models\Report;
use App\Models\Report_User;
use App\Models\Subcategory;
use App\Models\Subcategory_Report;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use SebastianBergmann\Type\NullType;
use function PHPUnit\Framework\isNull;

class Detail extends Component
{
    use WithFileUploads;
    
    public
            $pengikut = [],
            $how, $who, $what, $where, $when, $why, $user_id, $no_st,
            $tanggal_selesai, $penyelenggara, $dokumentasi1_upload, $dokumentasi2_upload, $dokumentasi3_upload,
            $lainnya_upload, $gender_wanita, $st_upload, $total_peserta, $kategori,
            $kategoriTerpilih, $subkategoriTerpilih, $report_id, $penyusun, $pengikutTerpilih, $gender_wanita_terpilih;
    public  $edit_toggle;
    public  $selectedSubkategori,
            $subkategori = [];

    public  $dokumentasi1, $dokumentasi2, $dokumentasi3, $lainnya, $st;
   

    public function mount ($report){
        $this->report_id = $report->id;
        $this->pengikutTerpilih = $report->pengikut;
        $this->how = $report->how;
        $this->who = $report->who;
        $this->what = $report->what;
        $this->where = $report->where;
        $this->when = $report->when;
        $this->why = $report->why;
        $this->user_id = $report->user_id;
        $this->no_st = $report->no_st;
        $this->tanggal_selesai = $report->tanggal_selesai;
        $this->penyelenggara = $report->penyelenggara;
        $this->total_peserta = $report->total_peserta;
        $this->dokumentasi1_upload = $report->dokumentasi->dokumentasi1;
        $this->dokumentasi2_upload = $report->dokumentasi->dokumentasi2;
        $this->dokumentasi3_upload = $report->dokumentasi->dokumentasi3;
        $this->lainnya_upload = $report->dokumentasi->lainnya;
        $this->st_upload = $report->dokumentasi->st;
        $this->kategoriTerpilih = $report->categories;
        $this->subkategoriTerpilih = $report->subcategories;
        $this->penyusun = $report->user->nama;
        $this->gender_wanita = $report->gender_wanita;
    }
    
    public function render()
    {
        // $reports = Report::with('pengikut', 'user', 'subcategories', 'categories')->get();
        $users = User::all();
        $categories = Category::all();
        $subkategoriYangada = Category::with('subcategories')->whereHas('report', function($query){
            $query->where('report_id', $this->report_id);
        })->get();

        // dd($subkategoriYangada);
        return view('livewire.admin.detail', compact('users', 'categories', 'subkategoriYangada'));
    }

    public function updatedKategori($kategori_id){
 
        $this->selectedSubkategori = Category::with('subcategories')->whereKey($kategori_id)->get();
       
    }

    public function edit_toggle(){
        return $this->edit_toggle;
    }

    public function submit()
    {   
        Report::whereKey($this->report_id)->update([
                'user_id' => $this->user_id,
                'no_st' => $this->no_st,
                'what' => $this->what,
                'when' => $this->when,
                'why' => $this->why,
                'where' => $this->where,
                'who' => $this->who,
                'total_peserta' => $this->total_peserta,
                'gender_wanita' => $this->gender_wanita,
                'penyelenggara' => $this->penyelenggara,
                'tanggal_selesai' => $this->tanggal_selesai,
        ]);

        if ($this->subkategori) {
           Subcategory_Report::where('report_id', $this->report_id)->delete();
                foreach ($this->subkategori as $newSubkategori) {
                    $datasubkategori = array(
                        'report_id' => $this->report_id,
                        'subcategory_id' => $newSubkategori
                    ) ;
                    Subcategory_Report::create($datasubkategori);
                }
           }

        if ($this->kategori) {
            CategoryReport::where('report_id', $this->report_id)->delete();
                foreach ($this->kategori as $newKategori) {
                    $datakategori = array(
                        'report_id' => $this->report_id,
                        'category_id' => $newKategori
                    );
                    CategoryReport::create($datakategori);
                }
         
        }

        if ($this->pengikut) {
            Report_User::where('report_id', $this->report_id)->delete();
                    foreach ($this->pengikut as $item2) {
                            $data3 = array(
                                'report_id' => $this->report_id,
                                'user_id' => $item2
                            );
                        Report_User::create($data3);
                    }
        }

        if ($this->dokumentasi1) {
                $dokumentasi1_1 = $this->dokumentasi1;
                $dokumentasi1_2 = date('Y-m-d') ."_". $dokumentasi1_1->getClientOriginalName();
                $dokumentasi1_1->storeAs('dokumentasi', $dokumentasi1_2, 'public');

            Storage::disk('public')->delete(['dokumentasi/' . $this->dokumentasi1_upload]);
        } else {
            $dokumentasi1_2 = $this->dokumentasi1_upload;
        }

        if ($this->dokumentasi2) {
            $dokumentasi2_1 = $this->dokumentasi2;
            $dokumentasi2_2 = date('Y-m-d') ."_". $dokumentasi2_1->getClientOriginalName();
            $dokumentasi2_1->storeAs('dokumentasi', $dokumentasi2_2, 'public');

        Storage::disk('public')->delete(['dokumentasi/' . $this->dokumentasi2_upload]);
        } else {
            $dokumentasi2_2 = $this->dokumentasi2_upload;
        }

        if ($this->dokumentasi3) {
            $dokumentasi3_1 = $this->dokumentasi3;
            $dokumentasi3_2 = date('Y-m-d') ."_". $dokumentasi3_1->getClientOriginalName();
            $dokumentasi3_1->storeAs('dokumentasi', $dokumentasi3_2, 'public');

        Storage::disk('public')->delete(['dokumentasi/' . $this->dokumentasi3_upload]);
        } else {
            $dokumentasi3_2 = $this->dokumentasi3_upload;
        }

        if ($this->lainnya) {
            $lainnya_1 = $this->lainnya;
            $lainnya_2 = date('Y-m-d') ."_". $lainnya_1->getClientOriginalName();
            $lainnya_1->storeAs('lainnya', $lainnya_2, 'public');

        Storage::disk('public')->delete(['lainnya/' . $this->lainnya_upload]);
        } else {
            $lainnya_2 = $this->lainnya_upload;
        }

        if ($this->st) {
            $st_1 = $this->st;
            $st_2 = date('Y-m-d') ."_". $st_1->getClientOriginalName();
            $st_1->storeAs('st', $st_2, 'public');

        Storage::disk('public')->delete(['st/' . $this->st_upload]);
        } else {
            $st_2 = $this->lainnya_upload;
        }

        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Edit Data Berhasil',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);

        $this->edit_toggle = false;


    }   
   
}
