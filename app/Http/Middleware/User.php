<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->status == 1) {

            // return redirect('/login')->withfail('Status User Tidak Aktif');
            return redirect('/login')->withwarning('AKun Anda Tidak AKtif Mohon Untuk Menghubungi Staf Tempat Praktik');
        }
        return $next($request);
    }
    
}
