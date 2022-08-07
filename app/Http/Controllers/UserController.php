<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use ILLuminate\Pagination\Paginator;

class UserController extends Controller
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
          $user = User::all()->sortByDesc('name');
        //   $cari = $request->get('cari');
          Paginator::useBootstrap();
          return view('User.User', compact('user'));
      }
      public function tambah()
      {
          $user = User::all();
          return view('User.Tambah_User',['user'=>$user]);
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
  
              'name' =>  'required',
              'level' =>  'required',
              // 'status' =>  'required',
              'no_rekam_medis' => '',
              'username' => 'required|unique:users,username',
              'password' => 'required',
             
          ], [
            
            'name.required' => 'Tidak boleh kosong',
            'level.required' => 'Tidak boleh kosong',
            // 'status.required' => 'Tidak boleh kosong',
            // 'no_rekam_medis.required.unique' => 'No_Rekam_Medis Sudah Digunakan',
            'username.required' => 'Tidak boleh kosong',
            'username.unique' => 'username Sudah Digunakan',
            'password.required' => 'Tidak boleh kosong',
  
       
          ]);
  
          $user = new User;
          $user->name = $request->name;
          $user->level = $request->level;
          $user->status = 0;
          $user->no_rekam_medis = $request->no_rekam_medis;
          $user->username = $request->username;
          $user->password = bcrypt($request->password);
          if($user->save())
          {
              return redirect('/User')->withSuccess('Data Berhasil Ditambahkan');
          }
          else{
              return back()->withfailed('Gagal');
          }
         
  
      }
     
      public function hapus($id)
      {
          $user = User::find($id);
          $user->delete();
          return redirect()->route('User.index')->withSuccess('Data Berhasil DIhapus');
      }



       /**
       * Show the form for editing the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function edit($id)
      {
          $user = User::find($id);
          return view('User.Edit', compact('user'));
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
              
              'name' =>  'required',
              'level' =>  'required',
              'status' =>  'required',
              // 'no_rekam_medis' => '',
              // 'username' => 'required',
              // 'password' => 'required',
             
          ], [
  
            'name.required' => 'Tidak boleh kosong',
            'level.required' => 'Tidak boleh kosong',
            // 'no_rekam_medis.required.unique' => 'No_Rekam_Medis Sudah Digunakan',
            // 'status.required' => 'Tidak boleh kosong',
          ]);
  
          User::where('id', $request->id)->update([
              'name' => $request->name,
              'level' => $request->level,
              'status' => $request->status,
              // 'no_rekam_medis' => $request->no_rekam_medis,

          ]);
              return redirect('/User')->withSuccess('Data Berhasil Dirubah');
      
         
      }
      public function gantiPassword()
      {
          return view('user.gantipassword');
      }

      public function updatepassword()
      {
        request()->validate([

            // 'username' => 'unique:users,username',
            // 'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password_lama' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ], [

          'password_lama.required' => 'Password lama harus diisi!',
          // 'username.unique' => 'Username Sudah Digunakan!',
          'password.required' => 'Password baru tidak boleh kosong!',
          'password.min' => 'Password minimal 8 huruf/angka!',
          'password.confirmed' => 'Konfirmasi password salah!',


        ]);

        $password_baru = auth()->user()->password;
        $password_lama = request('password_lama');

        if (Hash::check($password_lama, $password_baru)) {
          auth()->user()->update([
            'password' => bcrypt(request('password')),
          ]);
          return redirect()->route('Home.index')->withSuccess('Passsword berhasil diganti');
          // return back()->withSuccess('Akun berhasil diupdate');
        } else {
          return back()->withErrors(['password_lama' => 'Pastikan password lama diisi secara benar!']);
        }
      }
  
      // public function search(Request $request)
      // {
      // $cari = $request->get('cari');
      // $umum = Pasien_Umum::where('Nama','like',"%".$cari."%")->paginate(10);
      // Paginator::useBootstrap();
      // return view('LaporanMedis.Pasien_Umum', compact('umum','cari'));
      // }
  
  }
  
