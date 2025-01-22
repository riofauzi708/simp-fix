<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pengguna dan perusahaan yang terkait.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        $company = $user->company;

        return view('profile.show', [
            'user' => $user,
            'company' => $company,
        ]);
    }

    /**
     * Menampilkan form untuk mengedit profil pengguna berdasarkan perusahaan yang terkait.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $company = $user->company;

        return view('profile.edit', [
            'user' => $user,
            'company' => $company,
        ]);
    }

    /**
     * Memperbarui profil pengguna berdasarkan data yang diterima dan perusahaan yang terkait.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Memperbarui data pengguna
        $user->fill($request->validated());

        // Jika email berubah, maka perlu memverifikasi ulang
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun pengguna dan profil perusahaan terkait.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus perusahaan terkait jika perlu
        $company = $user->company;
        if ($company) {
            // Logika untuk menghapus data perusahaan jika diperlukan
            // $company->delete();
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
