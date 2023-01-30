<?php

namespace App\Http\Livewire\Form;

use App\Models\Category;
use App\Models\Documentation;
use App\Models\Report;
use App\Models\Report_User;
use App\Models\Subcategory;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use SebastianBergmann\Type\NullType;

class Tambah extends Component
{
    //mengambil data dari database
    public $users, $categories, $subcategories;

    //deklarasi variabel pada form sekaligus penangkap data
    public
    $pengikut = [],
    $how, $who, $what, $where, $when, $why, $user_id, $no_st,$dasar_pelaksanaan,
    $tanggal_selesai, $penyelenggara, $dokumentasi1, $dokumentasi2, $dokumentasi3,
    $lainnya, $gender_wanita, $st, $total_peserta;

    public $kategori = Null,
    $selectedSubkategori = Null,
    $subkategori = [];

    use WithFileUploads;

    public function submit(){
             
        $this->validate([
            'what' => 'required|unique:reports,what,except,id',
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
            'kategori' => 'required',
            'subkategori' => 'nullable',
            'dokumentasi1' => 'required|image|max:1024',
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

         //mengambil bulan dan tahun
        $date = Carbon::createFromFormat('Y-m-d', $this->when);
       
        $report = new Report();
        $report->user_id = $this->user_id;
        $report->no_st = $this->no_st;
        $report->what = $this->what;
        $report->why = $this->why;
        $report->where = $this->where;
        $report->when = $this->when;
        $report->tanggal_selesai = $this->tanggal_selesai;
        $report->who = $this->who;
        $report->penyelenggara = $this->penyelenggara;
        $report->gender_wanita = $this->gender_wanita;
        $report->how = $this->how;
        $report->total_peserta = $this->total_peserta;
        $report->dasar_pelaksanaan = $this->dasar_pelaksanaan;
        $report->save();

        if ($this->subkategori) {
            foreach ($this->subkategori as $item) {
                $reports = Report::find($report->id);
                $reports->subcategory()->attach($item);
          }
        }

        if ($this->kategori) {
            foreach ($this->kategori as $item3) {
                $reports = Report::find($report->id);
                $reports->category()->attach($item3);
          }
        }

        if ($this->pengikut) {
            foreach ($this->pengikut as $item2) {
                $data3 = array(
                    'report_id' => $report->id,
                    'user_id' => $item2
                );
             Report_User::create($data3);
                }
            }

            
            if ($this->dokumentasi1) {
                $dokumentasi1_1 = $this->dokumentasi1;
                $dokumentasi1_2 = date('Y-m-d') ."_". $dokumentasi1_1->getClientOriginalName();
                $dokumentasi1_1->storeAs('dokumentasi', $dokumentasi1_2, 'public');
                
            } else {
                $dokumentasi1_2 = null;
            }

            if ($this->dokumentasi2) {
                $dokumentasi2_1 = $this->dokumentasi2;
                $dokumentasi2_2 = date('Y-m-d') ."_". $dokumentasi2_1->getClientOriginalName();
                $dokumentasi2_1->storeAs('dokumentasi', $dokumentasi2_2, 'public');
                
            } else {
                $dokumentasi2_2 = null;
            }

            if ($this->dokumentasi3) {
                $dokumentasi3_1 = $this->dokumentasi3;
                $dokumentasi3_2 = date('Y-m-d') ."_". $dokumentasi3_1->getClientOriginalName();
                $dokumentasi3_1->storeAs('dokumentasi', $dokumentasi3_2, 'public');
                
            } else {
                $dokumentasi3_2 = null;
            }

            if ($this->lainnya) {
                $lainnya = $this->lainnya;
                $lainnya2 = date('Y-m-d') ."_". $lainnya->getClientOriginalName();
                $lainnya->storeAs('lainnya', $lainnya2, 'public');
                
            } else {
                $lainnya2 = null;
            }

            if ($this->st) {
                $st = $this->st;
                $st2 = date('Y-m-d') ."_". $st->getClientOriginalName();
                $st->storeAs('st', $st2, 'public');
                
            } else {
                $st2 = null;
            }

            $documentation = New Documentation();
            $documentation->report_id = $report->id;
            $documentation->dokumentasi1 = $dokumentasi1_2;
            $documentation->dokumentasi2 = $dokumentasi2_2;
            $documentation->dokumentasi3 = $dokumentasi3_2;
            $documentation->lainnya = $lainnya2;
            $documentation->st = $st2;
            $documentation->save();

            
          session()->flash('message', 'Data Berhasil Ditambah');

        return redirect()->route('home');

        
    }

    public function render()
    {
        return view('livewire.form.tambah',[
            "categories" => Category::all(),
            "users" => User::all()
        ]);
    }

    public function updatedKategori($kategori_id){
 
        $this->selectedSubkategori = Category::with('subcategories')->whereKey($kategori_id)->get();
        
    }
}
