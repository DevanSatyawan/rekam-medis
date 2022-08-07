<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Features;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function loginsubmit(Request $request)
    {
        // dd('');
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required|min:3',
            ],
            [
                'username.required' => 'Tidak boleh kosong!',
                'password.required' => 'Tidak boleh kosong!',
            ]
        );

        // $credentials = $request->only('username', 'password');

        // if (Auth::attempt($credentials)) {
        //     // Authentication passed...
        //     // return redirect()->intended('dashboard');
        //     return redirect()->route('Home.index')->withSuccess('Selamat Datang '.Auth::user()->username );
        // } else {
        //     return redirect()->route('login')->withFail('Username atau Password Salah');
        // }
        $username = $request->username;
        $password = $request->password;

        if (Auth::attempt(['username' => $username, 'password' => $password, 'status' => 0])){
            return redirect('/home')->withSuccess('Selamat Datang '.Auth::user()->username );

        // } elseif (Auth::attempt(['username' => $username, 'password' => $password, 'status' => 1])){
        //     return redirect('/login')->withFail('Username atau Password Anda Tidak Aktif');
        } else {
            return redirect('/login')->withFail('Username atau Password Salah');
        }
    }

    public function username()
    {
        return 'username';
    }
}
