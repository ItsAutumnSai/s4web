<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Arr;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('pages.account.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi umum untuk profil
        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'current_password' => 'nullable|required_with:password|string',
        'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Memperbarui informasi profil TANPA menyertakan field password
        $user->fill(Arr::except($validatedData, ['password', 'current_password', 'password_confirmation']));

        // Memeriksa apakah email diubah dan mengatur ulang verifikasi jika perlu
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Menangani unggahan gambar profil jika ada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
        // Menghapus gambar lama jika ada
        if ($user->image !== 'default.jpg' && file_exists(public_path('img/profile/' . $user->image))) {
            unlink(public_path('img/profile/' . $user->image));
        }

        // Menyimpan gambar baru di direktori publik
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('img/profile/'), $imageName);
        $user->image = $imageName;
        }

        // Menangani perubahan kata sandi jika diberikan
        if ($request->filled('password')) {
        // Memastikan kata sandi lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => __('label.current_password')
            ]);
        }

        // Update password
        $user->password = Hash::make($request->password);
        }

        // Menyimpan perubahan pada pengguna
        $user->save();

        // Mengalihkan kembali ke halaman edit profil dengan notifikasi sukses
        return Redirect::route('account.profile.edit')->with('notification', $this->successNotification('notification.success_update', 'menu.profile'));    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
