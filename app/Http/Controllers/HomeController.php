<?php

namespace App\Http\Controllers;

use App\Models\List_Pendaftaran;
use App\Models\Data_Pasien;
use App\Models\Laporan_Medis;
use App\Models\Pengumuman;
use ILLuminate\Pagination\Paginator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pengumuman = Pengumuman::all()->sortBy('id');
        Paginator::useBootstrap();
        $dtpasien = Data_Pasien::all()->count();
        $umum = Laporan_Medis::all()->count();
        $list = List_Pendaftaran::all()->count();
        $laki = Data_Pasien::where('Jenis_Kelamin','Laki-Laki')->get()->count();
        $perempuan = Data_Pasien::where('Jenis_Kelamin','Perempuan')->get()->count();
        $aktif = List_Pendaftaran::where('Status_Antrian','Aktif')->get()->count();
        $proses = List_Pendaftaran::where('Status_Antrian','Proses')->get()->count();
        $selesai = List_Pendaftaran::where('Status_Antrian','Selesai')->get()->count();
        $tdkaktif = List_Pendaftaran::where('Status_Antrian','Tidak Aktif')->get()->count();
        $menunggu = List_Pendaftaran::where('Status_Antrian','Menunggu')->get()->count();
        return view('Home.Home', compact('umum','list','laki','perempuan','aktif','proses','selesai','tdkaktif','menunggu','pengumuman','dtpasien'));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function tambah()
      {
          $pengumuman = Pengumuman::all();
          return view('/Home/tambah_pengumuman',['pengumuman'=>$pengumuman]);
      }
  
      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(Request $request)
      {
          $request->validate([
            
              'judul' =>  'required',
              'isi' =>  'required',
             
          ], [
            
              'judul' =>  'Tidak Boleh Kosong',
              'isi' => 'Tidak boleh kosong',
  
       
          ]);
  
          $pengumuman = new Pengumuman();
          $pengumuman->judul = $request->judul;
          $pengumuman->isi = $request->isi;
          if($pengumuman->save())
          {
              return redirect('/Home')->withSuccess('Data Berhasil Ditambahkan');
          }
          else{
              return back()->withfailed('Gagal');
          }
         
  
      }
     
      public function hapus($id)
      {
          $pengumuman = Pengumuman::find($id);
          $pengumuman->delete();
          return redirect()->route('Home.index')->withSuccess('Data Berhasil DIhapus');
      }
  
      /**
       * Show the form for editing the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function edit($id)
      {
          $pengumuman = Pengumuman::find($id);
          return view('Home.edit_pengumuman', compact('pengumuman'));
      // ['bpjs'=>$bpjs]);
      }
  
      /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request)
      {
          $request->validate([
            'judul' =>  'required',
            'isi' =>  'required',
             
          ], [
            'judul' =>  'Tidak Boleh Kosong',
            'isi' => 'Tidak boleh kosong',
          ]);
  
          Pengumuman::where('id', $request->id)->update([

            'judul' => $request->judul,
            'isi' => $request->isi,
          ]);
              return redirect('/Home')->withSuccess('Data Berhasil Dirubah');
      
         
      }
}
