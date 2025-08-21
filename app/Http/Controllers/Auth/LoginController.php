<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function show()
    {
        return view('user-login');
    }

    public function login(Request $request)
    {
        // Form verilerini doğrula
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Giriş bilgilerini hazırla
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Veritabanından kullanıcı kontrolü ve giriş
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // Başarılı giriş
            $request->session()->regenerate();
            
            return redirect()->intended('/')
                ->with('success',Auth::user()->name . '! Başarıyla giriş yaptınız.');
        }

        // Hatalı giriş
        return redirect()->back()
            ->withErrors(['email' => 'Email veya şifre hatalı!'])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('info', 'Başarıyla çıkış yaptınız!');
    }
}
