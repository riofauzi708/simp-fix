<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    /**
     * Menampilkan daftar posisi untuk company tertentu.
     */
    public function index(Company $company)
    {
        // Validasi akses
        if ($company->id !== Auth::user()->company_id) {
            abort(403, 'Akses ditolak');
        }

        $positions = $company->positions; // Asumsi ada relasi `positions` di model Company
        return view('positions.index', compact('positions', 'company'));
    }

    /**
     * Menampilkan form untuk membuat posisi baru.
     */
    public function create(Company $company)
    {
        // Menampilkan form pembuatan posisi untuk perusahaan tertentu
        return view('positions.create', compact('company'));
    }

    /**
     * Menyimpan data posisi baru.
     */
    public function store(Request $request, Company $company)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'base_salary' => 'required|numeric|min:0',
        ]);

        // Menghubungkan posisi ke company yang sedang diakses
        $company->positions()->create($request->only(['name', 'base_salary']));

        // Redirect ke halaman daftar posisi perusahaan
        return redirect()->route('companies.positions.index', $company)
            ->with('success', 'Posisi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit posisi.
     */
    public function edit(Company $company, Position $position)
    {
        // Menampilkan form pengeditan posisi untuk perusahaan tertentu
        return view('positions.edit', compact('company', 'position'));
    }

    /**
     * Memperbarui data posisi.
     */
    public function update(Request $request, Company $company, Position $position)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'base_salary' => 'required|numeric|min:0',
        ]);

        // Memperbarui posisi
        $position->update($request->only(['name', 'base_salary']));

        // Redirect kembali ke daftar posisi perusahaan
        return redirect()->route('companies.positions.index', $company)
            ->with('success', 'Posisi berhasil diperbarui.');
    }

    /**
     * Menghapus posisi.
     */
    public function destroy(Company $company, Position $position)
    {
        // Menonaktifkan posisi pada pegawai yang terhubung dengan posisi yang akan dihapus
        $position->employees()->update(['position_id' => null]);

        // Menghapus posisi
        $position->delete();

        // Redirect kembali ke daftar posisi perusahaan
        return redirect()->route('companies.positions.index', $company)
            ->with('success', 'Posisi berhasil dihapus, pegawai tidak terpengaruh.');
    }
}
