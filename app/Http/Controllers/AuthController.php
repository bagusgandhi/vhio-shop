<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // Login
    public function login(){
        return view('pages.public.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
        	'password' => 'required|min:8',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];


        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->guest(route('products'));
        }

        return back()->with('loginError','Login Failed!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
