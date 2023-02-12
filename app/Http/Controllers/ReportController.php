<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Report;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cek = Auth::user()->category;
         
        if(count($cek) > 0){
      
            return view('user.userpercategory');
        }else{
            Alert::warning('Anda Belum Memiliki Kategori', 'Hubungi Admin Untuk Berikan Kategori');
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::whereNotNull('email_verified_at')->get();
        $categories = Category::get();
        $subcategories = Subcategory::get();

        return view('form.tambah', compact('users', 'categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        $report = Report::withTrashed()->where('slug', $report->slug)->first();
        return view('admin.detail', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pdf(Report $report){

        $q_report = base64_encode(QrCode::size(100)->generate('http://arsip.timurbersinar.com/pdf/'.$report->slug));
        $q_lainnya = base64_encode(QrCode::size(100)->generate('http://arsip.timurbersinar.com/lihat_lainnya/'.$report->slug));
        $q_st = base64_encode(QrCode::size(100)->generate('http://arsip.timurbersinar.com/lihat_st/'.$report->slug));
 
        $pdf = PDF::loadView('pdf.pdf', compact('report', 'q_report', 'q_lainnya', 'q_st'));
        return $pdf->stream('laporan_'.$report->slug.'.pdf');
    }

    public function viewpdf(Report $report){
        $lainnya = $report->dokumentasi->lainnya;  
        return view('lihat.lihatlainnya', compact('lainnya'));
    }

     public function viewst(Report $report){
        $lainnya = $report->dokumentasi->st;  
        return view('lihat.lihatst', compact('lainnya'));
    }
}
