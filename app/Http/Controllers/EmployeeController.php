<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Models\Position;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Menampilkan daftar pegawai perusahaan yang terkait dengan pengguna.
     */
    public function index(Request $request)
    {
        $company = Auth::user()->company;

        if (!$company) {
            abort(403, 'Akses ditolak');
        }

        // Ambil nilai pencarian dari request
        $search = $request->get('search');

        $employees = Employee::with('position')
            ->where('company_id', $company->id)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhereHas('position', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->get();

        return view('employees.index', compact('employees', 'company'));
    }

    /**
     * Menampilkan form untuk menambahkan pegawai baru.
     */
    public function create()
    {
        $company = Auth::user()->company;

        if (!$company) {
            abort(403, 'Akses ditolak');
        }

        $positions = Position::where('company_id', $company->id)->get();

        return view('employees.create', compact('company', 'positions'));
    }

    /**
     * Menyimpan data pegawai baru.
     */
    public function store(Request $request)
    {
        $company = Auth::user()->company;

        if (!$company) {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'salary' => 'required|numeric|min:0',
            'join_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        // Menyimpan foto jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employees', 'public');
        }

        $employee = Employee::create(array_merge($request->only([
            'name',
            'email',
            'phone',
            'address',
            'position_id',
            'join_date',
            'is_active',
        ]), [
            'company_id' => $company->id,
            'photo' => $photoPath,
        ]));

        Salary::create([
            'employee_id' => $employee->id,
            'company_id' => $company->id,
            'payment_date' => now(),
            'amount' => $request->salary,
            'note' => 'Gaji pertama',
        ]);

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit data pegawai.
     */
    public function edit(Employee $employee)
    {
        $company = Auth::user()->company;

        if ($employee->company_id !== $company->id) {
            abort(403, 'Akses ditolak');
        }

        $positions = Position::where('company_id', $company->id)->get();

        return view('employees.edit', compact('employee', 'positions', 'company'));
    }

    /**
     * Memperbarui data pegawai.
     */
    public function update(Request $request, Employee $employee)
    {
        $company = Auth::user()->company;

        if ($employee->company_id !== $company->id) {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'salary' => 'required|numeric|min:0',
            'join_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $photoPath = $employee->photo;

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($photoPath && Storage::exists($photoPath)) {
                Storage::delete($photoPath);
            }

            // Simpan foto baru
            $photoPath = $request->file('photo')->store('employees', 'public');
        }

        $employee->update(array_merge($request->only(['name', 'email', 'phone', 'address', 'position_id', 'join_date', 'is_active']), [
            'photo' => $photoPath,
        ]));

        // Perbarui gaji pegawai
        $employee->salary()->updateOrCreate(
            ['employee_id' => $employee->id],
            ['amount' => $request->salary, 'note' => 'Gaji diperbarui']
        );

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    /**
     * Menghapus data pegawai.
     */
    public function destroy(Employee $employee)
    {
        $company = Auth::user()->company;

        if ($employee->company_id !== $company->id) {
            abort(403, 'Akses ditolak');
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus.');
    }

    public function show(Employee $employee)
    {
        $company = Auth::user()->company;

        // Pastikan pegawai terkait dengan perusahaan pengguna yang sedang login
        if ($employee->company_id !== $company->id) {
            abort(403, 'Akses ditolak');
        }

        // Ambil data kehadiran pegawai dalam bulan ini
        $attendances = $employee->attendances()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get();

        // Hapus query yang tidak diperlukan
        // $attendances = $employee->attendances()->orderBy('date')->get(); 

        // Ambil gaji pegawai
        $salary = $employee->salary;

        return view('employees.show', compact('employee', 'attendances', 'salary'));
    }
}
