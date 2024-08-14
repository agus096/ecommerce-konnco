<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = Account::where('email', $request->input('email'))->first();

    if ($user && password_verify($request->input('password'), $user->password)) {
    
        Auth::login($user, $request->has('remember'));

        if (Auth::check()) {
            return redirect('/');
        } else {
            return redirect()->back();
        }

    }
    return redirect()->back();
   }
   
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
