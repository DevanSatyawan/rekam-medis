<?php

namespace App\Http\Controllers;
use DateTime;
use App\Models\Jadwal_Kerja;
use Illuminate\Http\Request;
use ILLuminate\Pagination\Paginator;
class Jadwal_KerjaController extends Controller
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
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index(Request $request)
      {
          $jadwal = Jadwal_Kerja::all()->sortBy('Tanggal');
        //   $cari = $request->get('cari');
          Paginator::useBootstrap();
          return view('Jadwal_Kerja.Jadwal_Kerja', compact('jadwal'));
      }
      public function tambah()
      {
          $jadwal = Jadwal_Kerja::all();
          return view('/Jadwal_Kerja/Tambah_Jadwal',['jadwal'=>$jadwal]);
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
  
              'Tanggal' =>  'required',
            //   'Jenis_Layanan' => 'required',
              'Status' => 'required',
              'Jam_Mulai' => 'required',
              'Jam_Selesai' => 'required',
             
          ], [
  
              'Tanggal' => 'Tidak boleh kosong',
            //   'Jenis_Layanan' => 'Tidak boleh Kosong',
              'Status' => 'Tidak Boleh Kosong',
              'Jam_Mulai' => 'Tidak boleh kosong',
              'Jam_Selesai' => 'Tidak boleh kosong',
  
       
          ]);
  
          $jadwal = new Jadwal_Kerja();
          $jadwal->Tanggal = $request->Tanggal;
        //   $jadwal->Jenis_Layanan = $request->Jenis_Layanan;
          $jadwal->Status = $request->Status;
          $jadwal->Jam_Mulai = $request->Jam_Mulai;
          $jadwal->Jam_Selesai = $request->Jam_Selesai;
          $date = new DateTime();
          $match_date = new DateTime($jadwal->Tanggal);
          if($jadwal->save())
          {
              return redirect('/Jadwal_Kerja')->withSuccess('Data Berhasil Ditambahkan');
          }
          else{
              return back()->withfailed('Gagal');
          }
         
  
      }
     
      public function hapus($id)
      {
          $jadwal = Jadwal_Kerja::find($id);
          $jadwal->delete();
          return redirect()->route('Jadwal_Kerja.index')->withSuccess('Data Berhasil DIhapus');
      }
  
      /**
       * Show the form for editing the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function edit($id)
      {
          $jadwal = Jadwal_Kerja::find($id);
          return view('Jadwal_Kerja.Edit_Jadwal', compact('jadwal'));
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
  
            'Tanggal' =>  'required',
            // 'Jenis_Layanan' => 'required',
            'Status' => 'required',
            'Jam_Mulai' => 'required',
            'Jam_Selesai' => 'required',
             
          ], [
  
            'Tanggal' => 'Tidak boleh kosong',
            // 'Jenis_Layanan' => 'Tidak boleh Kosong',
            'Status' => 'Tidak Boleh Kosong',
            'Jam_Mulai' => 'Tidak boleh kosong',
            'Jam_Selesai' => 'Tidak boleh kosong',
          ]);
  
          Jadwal_Kerja::where('id', $request->id)->update([
  
            'Tanggal' => $request->Tanggal,
            // 'Jenis_Layanan' => $request->Jenis_Layanan,
            'Status' => $request->Status,
            'Jam_Mulai' => $request->Jam_Mulai,
            'Jam_Selesai' => $request->Jam_Selesai,
          ]);
              return redirect('/Jadwal_Kerja')->withSuccess('Data Berhasil Dirubah');
      
         
      }
  
    //   public function lihat($id)
    //   {
    //       $bpjs = Pasien_BPJS::find($id);
    //       return view('LaporanMedis.View_Data_BPJS', compact('bpjs'));
    //   }
  
  }
  