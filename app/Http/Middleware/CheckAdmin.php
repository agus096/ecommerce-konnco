<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
    
    if (Auth::check()) {
        Log::info('otentikasi user:', ['user' => Auth::user()]);
        if (Auth::user()->role === 'admin') {
            return $next($request); 
        }

        Log::warning('User Tidak ada:', ['user' => Auth::user()]);
        return redirect('/');
    }

    Log::warning('User Tidak ada');
    return redirect()->route('login');
}

}
