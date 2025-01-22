<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalaryController extends Controller
{
    // Menampilkan daftar gaji berdasarkan bulan dan tahun
    public function index(Request $request)
    {
        $company = Auth::user()->company;

        // Pastikan pengguna memiliki perusahaan yang terhubung
        if (!$company) {
            abort(403, 'Akses ditolak');
        }

        // Ambil bulan dan tahun yang dipilih, default ke bulan dan tahun sekarang
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Mengambil gaji yang terkait dengan perusahaan pengguna dan bulan/tahun yang dipilih
        $salaries = Salary::with('employee', 'company')
            ->where('company_id', $company->id)
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->get();

        // Hitung total gaji yang dibayarkan pada bulan tersebut
        $totalSalary = $salaries->sum('amount');

        return view('salaries.index', compact('salaries', 'company', 'month', 'year', 'totalSalary'));
    }

    // Menampilkan form untuk membuat gaji baru
    public function create()
    {
        $company = Auth::user()->company;

        // Pastikan pengguna memiliki perusahaan yang terhubung
        if (!$company) {
            abort(403, 'Akses ditolak');
        }

        // Mengambil pegawai yang terkait dengan perusahaan pengguna
        $employees = Employee::where('company_id', $company->id)->get();

        return view('salaries.create', compact('employees', 'company'));
    }

    // Menyimpan data gaji baru
    public function store(Request $request)
    {
        $request->merge(['company_id' => Auth::user()->company_id]); // Tambahkan company_id dari pengguna yang login

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
        ]);

        Salary::create($request->all()); // Menyimpan semua data
        return redirect()->route('salaries.index');
    }


    // Menampilkan form untuk mengedit data gaji
    public function edit(Salary $salary)
    {
        $company = Auth::user()->company;

        // Pastikan gaji terkait dengan perusahaan pengguna yang sedang login
        if ($salary->company_id !== $company->id) {
            abort(403, 'Akses ditolak');
        }

        $employees = Employee::where('company_id', $company->id)->get();

        return view('salaries.edit', compact('salary', 'employees', 'company'));
    }

    // Memperbarui data gaji
    public function update(Request $request, Salary $salary)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
        ]);

        // Pastikan gaji terkait dengan perusahaan pengguna yang sedang login
        if ($salary->company_id !== Auth::user()->company_id) {
            abort(403, 'Akses ditolak');
        }

        $salary->update($request->all());

        return redirect()->route('salaries.index');
    }

    // Menghapus gaji
    public function destroy(Salary $salary)
    {
        // Pastikan gaji terkait dengan perusahaan pengguna yang sedang login
        if ($salary->company_id !== Auth::user()->company_id) {
            abort(403, 'Akses ditolak');
        }

        $salary->delete();

        return redirect()->route('salaries.index');
    }
}
