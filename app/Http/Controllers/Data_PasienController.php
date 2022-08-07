<?php

namespace App\Http\Controllers;

use App\Models\Data_Pasien;
use App\Models\Laporan_Medis;
use Illuminate\Http\Request;
use ILLuminate\Pagination\Paginator;
use Symfony\Component\Mime\Part\DataPart;

class Data_PasienController extends Controller
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
        $dtpasien = Data_Pasien::all()->sortByDesc('created_at');
        $cari = $request->get('cari');
        Paginator::useBootstrap();

        if ($_GET) {
            // $bpjs = Pasien_BPJS::whereBetween('Tanggal_Berobat', [date('Y-01-01', strtotime($_GET['Tanggal_Berobat'] . '-01-01')), date('Y-12-31', strtotime($_GET['Tanggal_Berobat'] . '-12-31'))])->get();
            $dtpasien = Data_Pasien::whereBetween('created_at', [date('Y-01-01', strtotime($_GET['created_at'] . '-01-01')), date('Y-12-31', strtotime($_GET['created_at'] . '-12-31'))])->get();
           
        } else {
            // $bpjs = Pasien_BPJS::whereBetween('Tanggal_Berobat', [date('Y-01-01'), date('Y-12-31')])->get();
            $dtpasien = Data_Pasien::whereBetween('created_at', [date('Y-01-01'), date('Y-12-31')])->get();

        }

        return view('Data_Pasien.Data_Pasien', compact('dtpasien','cari'));
    }
    public function tambah()
    {
        $dtpasien = Data_Pasien::all();
        return view('/Data_Pasien/Tambah_Data',['dtpasien'=>$dtpasien]);
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

            // 'No_Medis' =>  'numeric|required|unique:data_pasien,No_Medis',
            'No_BPJS' => '',
            'Nama' => 'required',
            'Umur' => 'required',
            'Jenis_Kelamin' => 'required',
            'Alamat' => 'required',
            'No_Telepon' => 'required',
            'Jenis_Pasien' => 'required',
            'Status_BPJS' => 'required',

        ], [

            // 'No_Medis.required' => 'Tidak boleh kosong',
            'No_Medis.unique' => 'No Rekam Medis Sudah Digunakan',
            'No_BPJS' => '',
            'Nama' => 'Tidak boleh kosong',
            'Umur' => 'Tidak boleh kosong',
            'Jenis_Kelamin' => 'Tidak boleh kosong',
            'Alamat' => 'Tidak boleh kosong',
            'No_Telepon' => 'Tidak boleh kosong',
            'Jenis_Pasien' => 'Tidak boleh kosong',
            'Status_BPJS' => 'Tidak boleh kosong',
     
        ]);

        $check = false;
        $count = 1;

     
        $new_id = date('Ymd') . str_pad($count, 4, 0, STR_PAD_LEFT);

  
        while ($check == false) {

          
            $No_Medis = Data_Pasien::where('No_Medis', $new_id)->get();
      
            if ($No_Medis->count()) {

                $count++;
                $new_id = date('Ymd') . str_pad($count, 4, 0, STR_PAD_LEFT);
            } else {

                $check = true;
            }
        }

        // $check = false;
        // $count = 1;
        // $tgl = $request->Tanggal_Berobat;

        // $new_id =str_pad($count, 4, 0, STR_PAD_LEFT).$tgl;


        // while ($check == false) {
          
          
        //     $No_Medis = Data_Pasien::where('No_Medis', $new_id)->get();

        //     if ($No_Medis ->count()) {

        //         $count++;
        //         $new_id =str_pad($count, 4, 0, STR_PAD_LEFT).$tgl;

        //      } else {

        //      $check = true;
        //      }
        //  }

        $dtpasien = new Data_Pasien();
        $dtpasien->No_Medis = $new_id;
        $dtpasien->No_BPJS = $request->No_BPJS;
        $dtpasien->Nama = $request->Nama;
        $dtpasien->Umur = $request->Umur;
        $dtpasien->Jenis_Kelamin = $request->Jenis_Kelamin;
        $dtpasien->Alamat = $request->Alamat;
        $dtpasien->No_Telepon = $request->No_Telepon;
        $dtpasien->Jenis_Pasien = $request->Jenis_Pasien;
        $dtpasien->Status_BPJS= $request->Status_BPJS;
        if($dtpasien->save())
        {
            return redirect('/Data_Pasien')->withSuccess('Data Berhasil DItambahkan');
        }
        else{
            return back()->withfailed('Gagal');
        }
       

    }
   
    public function hapus($id)
    {
        $dtpasien = Data_Pasien::find($id);
        $dtpasien->delete();
        return redirect()->route('Data_Pasien.index')->withSuccess('Data Berhasil DIhapus');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $dtpasien= Data_Pasien::find($id);
        return view('Data_Pasien.Edit_Data', compact('dtpasien'));
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

            // 'No_Medis' =>  'numeric|required',
            'No_BPJS' => '',
            'Nama' => 'required',
            'Umur' => 'required',
            'Jenis_Kelamin' => 'required',
            'Alamat' => 'required',
            'No_Telepon' => 'required',
            'Jenis_Pasien' => 'required',
            'Status_BPJS' => 'required',
           
        ], [

            // 'No_Medis.required' => 'Tidak boleh kosong',
            'No_Rekam_Medis.unique' => 'No Rekam Medis Sudah Digunakan',
            'No_BPJS' => '',
            'Nama' => 'Tidak boleh kosong',
            'Umur' => 'Tidak boleh kosong',
            'Jenis_Kelamin' => 'Tidak boleh kosong',
            'Alamat' => 'Tidak boleh kosong',
            'No_Telepon' => 'Tidak boleh kosong',
            'Jenis_Pasien' => 'Tidak boleh kosong',
        ]);

        Data_Pasien::where('No_Medis', $request->id)->update([

            'No_BPJS' => $request->No_BPJS,
            'Nama' => $request->Nama,
            'Umur' => $request->Umur,
            'Jenis_Kelamin' => $request->Jenis_Kelamin,
            'Alamat' => $request->Alamat,
            'No_Telepon' => $request->No_Telepon,
            'Jenis_Pasien' => $request->Jenis_Pasien,
            'Status_BPJS' => $request->Status_BPJS,
        ]);
            return redirect('/Data_Pasien')->withSuccess('Data Berhasil Dirubah');
    
       
    }


    public function lihat($id)
    {
        $umum = Laporan_Medis::where("No_Rekam_Medis", $id)->get();
        $dtpasien = Data_Pasien::find($id);
        return view('Data_Pasien.View_Data', compact('dtpasien','umum'));
    }

    // public function search(Request $request)
    // {
    // $cari = $request->get('cari');
    // $umum = Pasien_Umum::where('Nama','like',"%".$cari."%")->paginate(10);
    // Paginator::useBootstrap();
    // return view('LaporanMedis.Pasien_Umum', compact('umum','cari'));
    // }
}
