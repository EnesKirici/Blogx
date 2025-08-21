@extends('layouts.app')

@section('title', 'Hesap Oluştur - Blog Sitesi')

@section('content')
<style>

    body{
        background: #313131ff !important;
    }
    /* Ana container - tam ekranı kapla ve ortala */
    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        margin: -20px; /* app.blade.php container padding'ini iptal et */
    }

    /* Ana form kartı */
    .register-card {
        background: #3a3a3a;
        border-radius: 20px;
        padding: 40px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 20px 40px rgba(71, 71, 71, 0.4);
        color: white;
    }

    /* Header */
    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }

    /* Input grupları */
    .input-group {
        margin-bottom: 15px;
    }

    .input-row {
        display: flex;
        gap: 10px;
    }

    
    /* Input stilleri */
    .form-input {
        width: 100%;
        background: #4a4a4a;
        border: 1px solid #555;
        color: #bbb;
        padding: 12px 16px;
        border-radius: 12px !important;
        font-size: 14px;
        outline: none;
    }

    .form-input::placeholder {
        color: #bbb;
    }

    .form-input:focus {
        border-color: #4285f4;
        box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
    }

    /* Select dropdown */
    .form-select {
        background: #4a4a4a;
        border: 1px solid #555;
        padding: 12px 16px;
        font-size: 14px;
        border-radius: 8px !important;
        color: white;
    }

    .form-select:focus {
        border-color: #4285f4;
    }

    /* Select için özel styling */
    select.form-input {
        -webkit-appearance: none; 
        -moz-appearance: none; 
        appearance: none;
    }

    /* Submit button */
    .submit-btn {
        width: 100%;
        background: #0e0d0dff;
        border: none;
        color: white;
        padding: 14px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.5s ease;
    }

    .submit-btn:hover {
        background: #3f3f3fff;
    }

    /* Labels */
    .input-label {
        color: #ddd;
        font-size: 13px;
        margin-bottom: 6px;
        display: block;
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <!-- Header -->
        <div class="register-header">
            <h2>Giriş Yap</h2>
            <h8>Hesabınıza giriş yapın</h5>
        </div>


        <!-- Form -->
        <form method="POST" action="{{ route('user.login') }}">
            @csrf
            
            <!-- Hata mesajları göster -->
            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Success mesajı göster -->
            @if (session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <!-- E-mail -->
            <div class="input-group">
                <label class="input-label">E-Mail</label>
                <input type="email" class="form-input" name="email" placeholder="E-mail adresinizi girin" value="{{ old('email') }}" required>
            </div>

            <!-- Şifre -->
            <div class="input-group">
                <label class="input-label">Şifre</label>
                <input type="password" class="form-input" name="password" placeholder="Şifrenizi girin" required>
            </div>

            <!-- Beni Hatırla -->
            <div class="input-group">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 
                    Beni Hatırla
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                Giriş Yap
            </button>
        </form>
    </div>
</div>

@endsection

