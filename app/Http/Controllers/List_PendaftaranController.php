<?php

namespace App\Http\Controllers;
use DateTime;
use App\Models\Data_Pasien;
use App\Models\List_Pendaftaran;
use Illuminate\Http\Request;
use ILLuminate\Pagination\Paginator;
use PDF;

class List_PendaftaranController extends Controller
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
          $list = List_Pendaftaran::all()->sortByDesc('Tanggal');
          $dtpasien = Data_Pasien::all();
        //   $cari = $request->get('cari');
          Paginator::useBootstrap();

            if ($_GET) {
    
                if ($_GET['from'] and $_GET['to']) {
                    $from = date('Y-m-d', strtotime($_GET['from']));
                    $to = date('Y-m-d', strtotime($_GET['to']));
    
                    $list = List_Pendaftaran::whereBetween('Tanggal', [$from, $to])->get();
                } else {
                    $list = List_Pendaftaran::whereBetween('Tanggal', [date('Y-m-1'), date('Y-m-t')])->get();
                } 
    
            } else {
                $list = List_Pendaftaran::whereBetween('Tanggal', [date('Y-m-1'), date('Y-m-t')])->get();
            }

          return view('Pasien.List_Pendaftaran', compact('list','dtpasien'));
      }
      public function tambah()
      {
          $list = List_Pendaftaran::all();
          $dtpasien = Data_Pasien::all();
          return view('/Pasien/Pendaftaran_Pasien', compact('list','dtpasien'));
      }

      public function cetaklist($tglawal, $tglakhir)
      {
  
          $list = List_Pendaftaran::all()->whereBetween('Tanggal',[$tglawal, $tglakhir])->sortBy('id');
          return view('/Pasien/Cetak_pertanggal',compact('list'));
      }
      
      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
        /*
     
            /*
      Pendaftaran Pasien Umum
      */
      public function Umum(Request $request)
      {
  

          
        $request->validate([
  
              'No_Rekam_Medis' => 'required',
              'Tanggal' => 'required',
              'Jenis_Layanan' => 'required',
             
          ], [
  
              'No_Rekam_Medis' => 'Tidak boleh kosong',
              'Tanggal' => 'Tidak boleh Kosong',
              'Jenis_Layanan' => 'Tidak Boleh Kosong',
  
       
          ]);
          


          $check = false;
          $count = 1;
          $awal = 'No';
          $tgl = $request->Tanggal;
  
          $new_id = $awal.'/'.str_pad($count, 2, 0, STR_PAD_LEFT).$tgl;
  
  
          while ($check == false) {
            
            
              $No_Antrian = List_Pendaftaran::where('No_Antrian', $new_id)->get();
  
              if ($No_Antrian ->count()) {
  
                  $count++;
                  $new_id = $awal.'/'.str_pad($count, 2, 0, STR_PAD_LEFT).$tgl;

                  if ($count==31){
                    $check = true;

                    return redirect('/Pasien/Pendaftaran_Pasien_Umum')->withFail('Maaf Nomor Antrian Hari Tanggal Ini Sudah Penuh!! Silahkan Pilih Tanggal Lain ');
                  }

              } else {
  
                  $check = true;
              }
          }


          


          $list = new List_Pendaftaran();
          $list->No_Rekam_Medis = $request->No_Rekam_Medis;
          $list->Status_Antrian = $request->Status_Antrian;
          $list->No_Antrian = $new_id;
          $list->Tanggal = $request->Tanggal;
          $list->Jenis_Layanan = $request->Jenis_Layanan;

          $date = new DateTime();
          $match_date = new DateTime($list->Tanggal);
          $interval = $date->diff($match_date);

        if ($interval->days == 0) 

             $list->Status_Antrian = 'Aktif';

        elseif ($interval->days == 1)

        if($interval->invert == 0)
             $list->Status_Antrian = 'Menunggu';
         else
            $list->Status_Antrian = 'Tidak Aktif';
        else
            $list->Status_Antrian = 'Tidak Aktif';

          if($list->save())
          {
              return redirect('/Pasien/Pendaftaran_Pasien_Umum')->withSuccess('Anda Berhasil Mendaftar Anda Mendapatkan Antrian '.$new_id);
          }
          else{
              return back()->withfailed('Gagal Mendaftar');
          }
         
         
      }
     
      public function hapus($id)
      {
          $list = List_Pendaftaran::find($id);
          $list->delete();
          return redirect()->route('List_Pendaftaran.index')->withSuccess('Data Berhasil DIhapus');
      }
  
      /**
       * Show the form for editing the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function tindakan($id)
      {
          
          $list = List_Pendaftaran::find($id);
          $dtpasien = Data_Pasien::all();
          return view('Pasien.Tindakan', compact('list','dtpasien'));
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
  
            // 'No_Rekam_Medis' => 'required',
            //   'No_BPJS' => 'required',
            //   'Nama' => 'required',
            //   'Umur' => 'required',
            //   'Jenis_Kelamin' => 'required',
            //   'Alamat' => 'required',
            //   'No_Telepon' => 'required',
            //   'Pemeriksaan' => 'required',
            //   'Diagnosa' => 'required',
            //   'Status_Antrian' => 'required',
            //   'Terapi' => 'required',
            //   'Tanggal_Berobat' => 'required',
            
             
          ], [

            //   'No_Rekam_Medis.required' => 'Tidak boleh kosong',
            //   'No_BPJS.required' => 'Tidak boleh kosong',
            //   'Nama.required' => 'Tidak boleh kosong',
            //   'Umur.required' => 'Tidak boleh kosong',
            //   'Jenis_Kelamin.required' => 'Tidak boleh kosong',
            //   'Alamat.required' => 'Tidak boleh kosong',
            //   'No_Telepon.required' => 'Tidak boleh kosong',
            //   'Pemeriksaan.required' => 'Tidak boleh kosong',
            //   'Diagnosa.required' => 'Tidak boleh kosong',
            //   'Status_Antrian.required' => 'Tidak Boleh Kosong',
            //   'Terapi.required' => 'Tidak boleh kosong',
            //   'Tanggal_Berobat.required' => 'Tidak boleh kosong',
        

       
          ]);
  
          List_Pendaftaran::where('id', $request->id)->update([
            //   'No_Rekam_Medis' => $request->No_Rekam_Medis,
            //   'No_BPJS' => $request->No_BPJS,
            //   'Nama' => $request->Nama,
            //   'Umur' => $request->Umur,
            //   'Jenis_Kelamin' => $request->Jenis_Kelamin,
            //   'Alamat' => $request->Alamat,
            //   'No_Telepon' => $request->No_Telepon,
            //   'Pemeriksaan' => $request->Pemeriksaan,
            //   'Diagnosa' => $request->Diagnosa,
              'Status_Antrian' => $request->Status_Antrian,
            //   'Terapi' => $request->Terapi,
            //   'Tanggal_Berobat' => $request->Tanggal_Berobat,
            

          ]);
              return redirect('/Pasien/List_Pendaftaran')->withSuccess('Data Berhasil DiRubah');
      
         
      }
  
      public function lihat($id)
      {
          $list = List_Pendaftaran::find($id);
          return view('Pasien.View_List', compact('list'));
      }
  
      public function laporan($id)
      {
          $laporan = List_Pendaftaran::find($id);
          $list['No_Rekam_Medis'] = $laporan->No_Rekam_Medis;
          $list['No_BPJS'] = $laporan->dtpasien->No_BPJS;
          $list['Nama'] = $laporan->dtpasien->Nama;
          $list['Umur'] = $laporan->dtpasien->Umur;
          $list['Jenis_Kelamin'] = $laporan->dtpasien->Jenis_Kelamin;
          $list['Alamat'] = $laporan->dtpasien->Alamat;
          $list['No_Telepon'] = $laporan->dtpasien->No_Telepon;
          $list['Status_Antrian'] = $laporan->Status_Antrian;
          $list['No_Antrian'] = $laporan->No_Antrian;
          $list['Tanggal'] = $laporan->Tanggal;
          $list['Jenis_Layanan'] = $laporan->Jenis_Layanan;
          $list['Jenis_Pasien'] = $laporan->dtpasien->Jenis_Pasien;
          $list['Status_BPJS'] = $laporan->dtpasien->Status_BPJS;
          $pdf = PDF::loadView('Pasien.Laporan_pdf', $list);
          return $pdf->download('List Pendaftaran Pasien.pdf');
      }
  
}
