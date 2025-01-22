<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    // Menampilkan profil perusahaan yang dikelola oleh pengguna
    public function show(Company $company)
    {
        // Validasi akses
        if ($company->id !== Auth::user()->company_id) {
            abort(403, 'Akses ditolak');
        }

        return view('company.show', compact('company'));
    }

    // Menampilkan form untuk mengedit profil perusahaan
    public function edit(Company $company)
    {
        // Validasi akses
        if ($company->id !== Auth::user()->company_id) {
            abort(403, 'Akses ditolak');
        }

        return view('company.edit', compact('company'));
    }

    // Memperbarui profil perusahaan
    public function update(Request $request, Company $company)
    {
        // Validasi akses
        if ($company->id !== Auth::user()->company_id) {
            abort(403, 'Akses ditolak');
        }

        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi logo
        ]);

        // Memperbarui profil perusahaan
        $company->update($request->only(['name', 'address', 'phone']));

        // Memproses dan menyimpan logo jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo); // Menghapus logo lama
            }

            // Simpan logo baru
            $path = $request->file('logo')->store('logos', 'public'); // Menyimpan di direktori storage/app/public/logos
            $company->logo = $path;
            $company->save(); // Simpan path logo di database
        }

        return redirect()->route('company.show', $company)->with('success', 'Profil perusahaan berhasil diperbarui');
    }
}
