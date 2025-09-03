<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        
        // Profil fotoğrafı güncellemesi
        if ($request->hasFile('profile_photo')) {
            // Eski fotoğrafı sil
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            // Yeni fotoğrafı kaydet
            $photoPath = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo = $photoPath;
        }
        
        // Bio güncellemesi
        if ($request->has('bio')) {
            $user->bio = $request->bio;
        }
        
        $user->save();
        
        return redirect()->back()->with('success', 'Profil başarıyla güncellendi!');
    }
}