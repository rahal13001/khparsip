<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\CategoryReport;
use App\Models\Documentation;
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
    public $listeners = ['refreshNotes' => '$refresh'];
    use WithFileUploads;
    
    public
            $pengikut = [], $slug,
            $how, $who, $what, $where, $when, $why, $user_id, $no_st,
            $tanggal_selesai, $penyelenggara, $dokumentasi1_upload, $dokumentasi2_upload, $dokumentasi3_upload,
            $lainnya_upload, $gender_wanita, $st_upload, $total_peserta, $kategori, $dasar_pelaksanaan,
            $kategoriTerpilih, $subkategoriTerpilih, $report_id, $penyusun, $pengikutTerpilih, $gender_wanita_terpilih;
    public  $edit_toggle;
    public  $selectedSubkategori,
            $subkategori = [];

    public  $dokumentasi1, $dokumentasi2, $dokumentasi3, $lainnya, $st;
   

    public function mount ($report){
        $this->report_id = $report->id;
        $this->slug = $report->slug;
        $this->pengikutTerpilih = $report->pengikut;
        $this->how = $report->how;
        $this->who = $report->who;
        $this->what = $report->what;
        $this->where = $report->where;
        $this->when = $report->when;
        $this->why = $report->why;
        $this->user_id = $report->user_id;
        $this->dasar_pelaksanaan = $report->dasar_pelaksanaan;
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
        $users = User::whereNotNull('email_verified_at')->get();
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
        $this->validate([
            'what' => 'required|unique:reports,what,' . $this->report_id,
            'where' => 'required',
            'when' => 'required',
            'tanggal_selesai' => 'required|after_or_equal:when',
            'why' => 'required',
            'dasar_pelaksanaan' => 'required',
            'who' => 'required',
            'penyelenggara' => 'required',
            'total_peserta' => 'required',
            'how' => 'required',
            'gender_wanita' => 'required',
            'no_st' => 'nullable',
            'user_id' => 'required',
            'pengikut' => 'nullable',
            'kategori' => $this->kategori ? 'required' : 'nullable',
            'subkategori' => 'nullable',
            'dokumentasi1' => $this->dokumentasi1 ? 'required|image|max:1024' : 'nullable',
            'dokumentasi2' => 'nullable|image|max:1024',
            'dokumentasi3' => 'nullable|image|max:1024',
            'lainnya' => 'nullable|max:3072',
            'st' => 'nullable|max:30720',
        ],[
            'what.required' => 'Harap Isi Kolom What',
            'where.required' => 'Harap Isi Kolom Where',
            'when.required' => 'Harap Isi Kolom When',
            'why.required' => 'Harap Isi Kolom Why',
            'tanggal_selesai.required' => 'Harap Isi Kolom Tanggal Selesai',
            'where.required' => 'Harap Isi Kolom Where',
            'who.required' => 'Harap Isi Kolom Who',
            'how.required' => 'Harap Isi Kolom How',
            'penyelenggara.required' => 'Harap Isi Kolom Penyelenggara',
            'total_peserta.required' => 'Harap Isi Kolom Total Peserta',
            'gender_wanita.required' => 'Harap Isi Kolom Persentase Wanita Yang Hadir',
            'user_id.required' => 'Harap Isi Kolom Penyusun',
            'kategori.required' => 'Harap Isi Kolom Kategori',
            'dokumentasi1.required' => 'Harap Isi Kolom Dokumentasi 1',
            'max:1024' => 'Ukuran Maksimal File Adalah 1 MB',
            'max:3072' => 'Ukuran Maksimal File Adalah 3 MB',
            'max:30720' => 'Ukuran Maksimal File Adalah 30 MB',
            'after_or_equal' => 'Tanggal Harus Sama Dengan Atau Lebih Dari Tanggal When',
            'image' => 'File Harus Bertipe Gambar',
            'what.unique' => 'Nama Kegiatan Ini Telah Digunakan, Mohon Gunakan Nama Lain',
            'dasar_pelaksanaan.unique' => 'Harap Isi Kolom Dasar Pelaksanaan Kegiatan'

        ]);


        Report::whereKey($this->report_id)->update([
                'user_id' => $this->user_id,
                'no_st' => $this->no_st,
                'what' => $this->what,
                'when' => $this->when,
                'why' => $this->why,
                'where' => $this->where,
                'who' => $this->who,
                'dasar_pelaksanaan' => $this->dasar_pelaksanaan,
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

        $documentation = Documentation::where('report_id', $this->report_id);
        $documentation->update([
            'dokumentasi1'=>$dokumentasi1_2,
            'dokumentasi2'=>$dokumentasi2_2,
            'dokumentasi3'=>$dokumentasi3_2,
            'lainnya'=>$lainnya_2,
            'st'=>$st_2
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Edit Data Berhasil',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);

        $this->edit_toggle = false;
        $this->dokumentasi1 = null;
        $this->dokumentasi2 = null;
        $this->dokumentasi3 = null;
        $this->lainnya = null;
        $this->st = null;

       return redirect()->route('report_detail', $this->slug);

    }   
   
}
