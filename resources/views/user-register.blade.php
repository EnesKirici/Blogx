@extends('layouts.app')

@section('title', 'Hesap Oluştur - Blog Sitesi')

@section('content')
<style>
    /* Ana container - tam ekranı kapla ve ortala */
    .register-wrapper {
        background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
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
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        color: white;
    }

    /* Header */
    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .register-header h2 {
        color: white;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .register-header p {
        color: #bbb;
        font-size: 14px;
        margin: 0;
    }

    /* Google Button */
    .google-btn {
        width: 100%;
        background: #4285f4;
        border: none;
        color: white;
        padding: 12px;
        border-radius: 10px;
        font-size: 14px;
        margin-bottom: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .google-btn:hover {
        background: #357ae8;
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
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
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
        width: 100%;
        background: #4a4a4a;
        border: 1px solid #555;
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #4285f4;
    }

    /* Submit button */
    .submit-btn {
        width: 100%;
        background: #4285f4;
        border: none;
        color: white;
        padding: 14px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 10px;
    }

    .submit-btn:hover {
        background: #357ae8;
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
            <h2>Hesap Oluştur</h2>
            <p>Bilet satın almak için hesap oluşturun</p>
        </div>


        <!-- Form -->
        <form method="POST" action="/register">
            @csrf
            
            <!-- Ad Soyad -->
            <div class="input-row">
                <div class="input-group">
                    <label class="input-label">Ad</label>
                    <input type="text" class="form-input" name="first_name" placeholder="Adınızı girin" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Soyad</label>
                    <input type="text" class="form-input" name="last_name" placeholder="Soyadınızı girin" required>
                </div>
            </div>

            <!-- E-mail -->
            <div class="input-group">
                <label class="input-label">E-Mail</label>
                <input type="email" class="form-input" name="email" placeholder="E-mail adresinizi girin" required>
            </div>

            <!-- GSM -->
           
            <!-- Cinsiyet -->
            <div class="input-group">
                <label class="input-label">Cinsiyet</label>
                <select class="form-select" name="gender" required>
                    <option value="">Cinsiyet seçin</option>
                    <option value="male">Erkek</option>
                    <option value="female">Kadın</option>
                    <option value="other">Diğer</option>
                </select>
            </div>

            <!-- Şehir -->
            <div class="input-group">
                <label class="input-label">Şehir</label>
                <select class="form-select" name="city" required>
                    <option value="">Şehir seçin</option>
                    <option value="istanbul">İstanbul</option>
                    <option value="ankara">Ankara</option>
                    <option value="izmir">İzmir</option>
                    <option value="bursa">Bursa</option>
                    <option value="antalya">Antalya</option>
                </select>
            </div>

            <!-- Şifre -->
            <div class="input-group">
                <label class="input-label">Şifre</label>
                <input type="password" class="form-input" name="password" placeholder="Şifrenizi girin" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                Hesap Oluştur
            </button>
        </form>
    </div>
</div>

@endsection

