<?php

namespace App\Http\Controllers;
use App\Models\Laporan_Medis;
use App\Models\Data_Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ILLuminate\Pagination\Paginator;
use PDF;

class Laporan_MedisController extends Controller
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
        $umum = Laporan_Medis::all()->sortByDesc('Tanggal_Berobat');
        $dtpasien = Data_Pasien::all();
        $cari = $request->get('cari');
        Paginator::useBootstrap();


        if ($_GET) {
    
            if ($_GET['from'] and $_GET['to']) {
                $from = date('Y-m-d', strtotime($_GET['from']));
                $to = date('Y-m-d', strtotime($_GET['to']));

                $umum =Laporan_Medis::whereBetween('Tanggal_Berobat', [$from, $to])->get();
            } else {
                $umum =Laporan_Medis::whereBetween('Tanggal_Berobat', [date('Y-m-1'), date('Y-m-t')])->get();
            } 

        } else {
            $umum =Laporan_Medis::whereBetween('Tanggal_Berobat', [date('Y-m-1'), date('Y-m-t')])->get();
        }

        return view('LaporanMedis.Pasien_Umum', compact('umum','cari','dtpasien'));
    }
    public function tambah()
    {
        $umum = Laporan_Medis::all();
        $dtpasien = Data_Pasien::all();
        return view('/LaporanMedis/Tambah_Umum',compact('umum','dtpasien'));
    }

    public function cetakumum($tglawal, $tglakhir)
    {

        $umum = Laporan_Medis::all()->whereBetween('Tanggal_Berobat',[$tglawal, $tglakhir])->sortBy('id');
        return view('/LaporanMedis/Cetak_Umum',compact('umum'));
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

            'No_Rekam_Medis' =>  'numeric|required',
            'Pemeriksaan' => 'required',
            'Diagnosa' => 'required',
            'Terapi' => 'required',
            'Tanggal_Berobat' => 'required',
           
        ], [

            'No_Rekam_Medis.required' => 'Tidak boleh kosong',
            'Pemeriksaan' => 'Tidak boleh Kosong',
            'Diagnosa' => 'Tidak boleh Kosong',
            'Terapi' => 'Tidak boleh Kosong',
            'Tanggal_Berobat' => 'Tidak boleh Kosong',

     
        ]);

        $umum = new Laporan_Medis();
        $umum->No_Rekam_Medis = $request->No_Rekam_Medis;
        $umum->Nama = $request->Nama;
        $umum->Umur = $request->Umur;
        $umum->Jenis_Kelamin = $request->Jenis_Kelamin;
        $umum->Alamat = $request->Alamat;
        $umum->No_Telepon = $request->No_Telepon;
        $umum->Pemeriksaan = $request->Pemeriksaan;
        $umum->Diagnosa = $request->Diagnosa;
        $umum->Terapi = $request->Terapi;
        $umum->Tanggal_Berobat = $request->Tanggal_Berobat;
        if($umum->save())
        {
            return redirect('/LaporanMedis/Pasien_Umum')->withSuccess('Data Berhasil DItambahkan');
        }
        else{
            return back()->withfailed('Gagal');
        }
       

    }
   
    public function hapus($id)
    {
        $umum = Laporan_Medis::find($id);
        $umum->delete();
        return redirect()->route('Pasien_Umum.index')->withSuccess('Data Berhasil DIhapus');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $umum = Laporan_Medis::find($id);
        $dtpasien = Data_Pasien::all();
        return view('LaporanMedis.Edit_Umum', compact('umum','dtpasien'));
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


            'Pemeriksaan' => 'required',
            'Diagnosa' => 'required',
            'Terapi' => 'required',
            'Tanggal_Berobat' => 'required',
           
        ], [


            'Pemeriksaan' => 'Tidak boleh Kosong',
            'Diagnosa' => 'Tidak boleh Kosong',
            'Terapi' => 'Tidak boleh Kosong',
            'Tanggal_Berobat' => 'Tidak boleh Kosong',
     
        ]);

        Laporan_Medis::where('id', $request->id)->update([

            'Pemeriksaan' => $request->Pemeriksaan,
            'Diagnosa' => $request->Diagnosa,
            'Terapi' => $request->Terapi,
            'Tanggal_Berobat' => $request->Tanggal_Berobat,
        ]);
            return redirect('/LaporanMedis/Pasien_Umum')->withSuccess('Data Berhasil Dirubah');
    
       
    }

    public function lihat($id)
    {
        $umum = Laporan_Medis::find($id);
        return view('LaporanMedis.View_Data_Umum', compact('umum'));
    }


    public function laporan($id)
    {
        $laporan = Laporan_Medis::find($id);
        $umum['No_Rekam_Medis'] = $laporan->No_Rekam_Medis;
        $umum['No_BPJS'] = $laporan->dtpasien->No_BPJS;
        $umum['Nama'] = $laporan->dtpasien->Nama;
        $umum['Umur'] = $laporan->dtpasien->Umur;
        $umum['Jenis_Kelamin'] = $laporan->dtpasien->Jenis_Kelamin;
        $umum['Alamat'] = $laporan->dtpasien->Alamat;
        $umum['No_Telepon'] = $laporan->dtpasien->No_Telepon;
        $umum['Pemeriksaan'] = $laporan->Pemeriksaan;
        $umum['Diagnosa'] = $laporan->Diagnosa;
        $umum['Terapi'] = $laporan->Terapi;
        $umum['Tanggal_Berobat'] = $laporan->Tanggal_Berobat;
        $umum['Jenis_Pasien'] = $laporan->dtpasien->Jenis_Pasien;
        $umum['Status_BPJS'] = $laporan->dtpasien->Status_BPJS;
        $pdf = PDF::loadView('LaporanMedis.Laporan_PDF', $umum);
        return $pdf->download('Laporan Medis.pdf');
    }

}
