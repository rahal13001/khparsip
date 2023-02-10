<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromQuery, WithMapping, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
        protected $checked;

        public function __construct($checked)
        {
            $this->checked = $checked;
        }
        public function query()
        {
            return Report::with('tescategory','dokumentasi','tessubcategory', 'pengikutreport', 'user')->whereKey($this->checked);
        }
        public function map($query): array
        {

       
        foreach($query->tescategory as $tescategory){
            $tescateg[] = $tescategory->nama;
        }
        $teskategori = implode(', ', $tescateg);


  
        foreach($query->tessubcategory as $tessubcategory){
            $tessubcateg[] = $tessubcategory->nama;
            }
            $tessubkategori = implode(', ', $tessubcateg);


            $pengikut = [];
            foreach($query->pengikutreport as $pengikutreport)
            {
                $pengikut[] = $pengikutreport->name;
            }
      
            $pengikutnya =  implode(', ', $pengikut);
     



        if ($query->dokumentasi->dokumentasi2 === NULL) {
            $dokumentasi2 = '';
        }else {
            $dokumentasi2 = 'http://arsip.timurbersinar.com/dokumentasi/'.$query->dokumentasi->dokumentasi2;
        }

          if ($query->dokumentasi->dokumentasi3 === NULL) {
            $dokumentasi3 = '';
        }else {
            $dokumentasi3 = 'http://arsip.timurbersinar.com/dokumentasi/'.$query->dokumentasi->dokumentasi3;
        }

          if ($query->dokumentasi->lainnya === NULL) {
            $lainnya = '';
        }else {
            $lainnya = 'http://arsip.timurbersinar.com/lihat_lainnya/'.$query->dokumentasi->lainnya;
        }

          if ($query->dokumentasi->st === NULL) {
            $st = '';
        }else {
            $st = 'http://arsip.timurbersinar.com/lihat_st/'.$query->dokumentasi->st;
        }



        $isi = [
            $query->when,
            $query->tanggal_selesai,
            $query->user->name,
            $pengikutnya,
            $query->what,
            $query->no_st,
            $query->dasar_pelaksanaan,
            $query->why,
            $query->where,
            $query->penyelenggara,
            $query->who,
            $query->total_peserta,
            $query->gender_wanita,
            $teskategori,
            $tessubkategori,
            strip_tags($query->how),
            'http://arsip.timurbersinar.com/dokumentasi/'.$query->dokumentasi->dokumentasi1,
            $dokumentasi2,
            $dokumentasi3,
            $lainnya,
            $st,
        ];
        return $isi;
    }

    public function headings(): array
    {
        return [
            'Waktu',
            'Tanggal Selesai',
            'Nama Pelaksana',
            'Nama Pengikut',
            'What',
            'No ST',
            'Dasar Pelaksanaan',
            'Why',
            'Where',
            'Penyelenggara',
            'Who',
            'Total Peserta',
            'Jumlah Wanita Yang Hadir',
            'Kategori',
            'Sub Kategori',
            'How',
            'Dokumentasi 1',
            'Dokumentasi 2',
            'Dokumentasi 3',
            'Dokumentasi Lainnya',
            'ST',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 20,
            'M' => 20,
            'N' => 20,
            'O' => 20,
            'P' => 60,
            'Q' => 60,
            'R' => 60,
            'S' => 60,
            'T' => 60,
            'U' => 60,
        ];
    }

}
