<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register'); // Tidak perlu mengambil data perusahaan di sini
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input pengguna
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => 'required|string|max:255', // Validasi untuk nama perusahaan
        ]);

        // Mencari perusahaan berdasarkan nama
        $company = Company::firstOrCreate([
            'name' => $request->company_name, // Cari perusahaan berdasarkan nama
        ], [
            // Jika perusahaan belum ada, buat dengan data tambahan lainnya (optional)
            'address' => $request->address ?? null, // Jika ada alamat
            'phone' => $request->phone ?? null,     // Jika ada nomor telepon
        ]);

        // Membuat pengguna dan menghubungkannya dengan perusahaan
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $company->id, // Menghubungkan dengan ID perusahaan
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Arahkan ke halaman login setelah registrasi berhasil
        return redirect()->route('login'); // Halaman login setelah registrasi
    }
}
