<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pengguna (hanya user login).
     */
    public function show()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Menampilkan form edit profil.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit_profile', compact('user'));
    }

    /**
     * Memperbarui data profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru di folder storage/app/public/profiles
            $path = $request->file('photo')->store('profiles', 'public');
            $validated['photo'] = $path;
        }

        // Update data user
        $user->update($validated);

        // Redirect ke profil dengan notifikasi sukses
        return redirect()
            ->route('user.profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menghapus akun pengguna dengan konfirmasi SweetAlert.
     */
        public function destroy()
    {
        $user = Auth::user();

        // Hapus foto profil jika ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Hapus akun
        $user->delete();

        // Logout pengguna dulu
        Auth::logout();

        // Regenerasi session agar session lama (termasuk flash lama) hilang
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Buat session baru dan flash pesan sukses ke situ
        session()->flash('account_deleted', true);

        // Redirect ke login
        return redirect()->route('login');
    }

}
