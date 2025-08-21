<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('user-register');
    }

    public function register(Request $request)
    {
        // Form verilerini doğrula
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', //confirmed kuralı, password_confirmation alanının varlığını ve eşleşmesini kontrol eder
            'gender' => 'required|string',
            'city' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Kullanıcıyı oluştur
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'city' => $request->city,
        ]);

        // Otomatik giriş yap
        Auth::login($user);

        return redirect('/')->with('success', 'Hesabınız başarıyla oluşturuldu!');
    }
}
