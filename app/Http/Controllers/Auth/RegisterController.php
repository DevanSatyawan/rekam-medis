<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Features;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    // public function register()
    // {
    //    return view('V_Login');
    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'no_rekam_medis' => ['numeric','required','exists:data_pasien,No_Medis', 'string', 'digits:12', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [    
                'name.required' => 'Tidak boleh kosong!',
                'no_rekam_medis.unique' => 'No_Rekam_Medis Sudah Digunakan',
                'no_rekam_medis.exists' => 'No Rekam Medis tidak terdaftar',
                'no_rekam_medis.required' => 'Tidak boleh kosong!',
                'username.unique' => 'Username Sudah Digunakan',
                'username.required' => 'Tidak boleh kosong!',
                'password.required' => 'Tidak boleh kosong!',
        ]
    );
    return redirect()->route('register')->withSuccess('Anda Berhasil Melakukan Pembuatan Akun Baru');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'level' => $data['level'],
            'status' => $data['status'],
            'no_rekam_medis' => $data['no_rekam_medis'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
        // return redirect()->route('register')->withSuccess('Register Berhasil');
    }
}
