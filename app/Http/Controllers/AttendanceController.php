<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Menampilkan daftar absensi
    public function index(Request $request)
    {
        $company = Auth::user()->company;

        if (!$company) {
            abort(403, 'Akses ditolak.');
        }

        $date = $request->input('date', now()->format('Y-m-d')); // Default ke hari ini jika tidak dipilih
        $attendances = Attendance::where('company_id', $company->id)
            ->whereDate('date', $date)
            ->orderBy('date')
            ->paginate(10); // Tambahkan paginasi untuk data absensi

        return view('attendances.index', compact('attendances', 'company', 'date'));
    }

    // Menampilkan detail absensi per pegawai
    public function show(Employee $employee, Request $request)
    {
        $company = Auth::user()->company;

        if ($employee->company_id !== $company->id) {
            abort(403, 'Akses ditolak.');
        }

        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $attendances = $employee->attendances()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $attendanceCount = $attendances->count();

        return view('attendances.show', compact('employee', 'attendances', 'attendanceCount', 'month', 'year'));
    }

    // Menampilkan form untuk membuat absensi baru
    // Menampilkan form untuk membuat absensi baru
    public function create(Request $request)
    {
        $company = Auth::user()->company;

        if (!$company) {
            abort(403, 'Akses ditolak');
        }

        $date = $request->input('date', now()->format('Y-m-d'));

        $employees = Employee::where('company_id', $company->id)->get();

        $existingAttendances = Attendance::where('company_id', $company->id)
            ->whereDate('date', $date)
            ->pluck('employee_id')
            ->toArray();

        foreach ($employees as $employee) {
            if (!in_array($employee->id, $existingAttendances)) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'company_id' => $company->id,
                    'date' => $date,
                    'status' => 'hadir', // Default status: hadir
                ]);
            }
        }

        $attendances = Attendance::where('company_id', $company->id)
            ->whereDate('date', $date)
            ->with('employee')
            ->get();

        return view('attendances.create', compact('attendances', 'date', 'company'));
    }

    // Menyimpan data absensi baru
    public function store(Request $request)
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*.employee_id' => 'required|exists:employees,id',
            'attendance.*.status' => 'required|in:hadir,izin,sakit,tanpa_keterangan',
            'date' => 'required|date',
        ]);

        $date = $request->input('date');
        $attendanceData = $request->input('attendance');

        foreach ($attendanceData as $data) {
            Attendance::updateOrCreate(
                [
                    'employee_id' => $data['employee_id'],
                    'date' => $date,
                ],
                [
                    'company_id' => Auth::user()->company->id,
                    'status' => $data['status'],
                ]
            );
        }

        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil disimpan.');
    }

    // Menampilkan form untuk mengedit absensi
    public function edit(Attendance $attendance)
    {
        $company = Auth::user()->company;

        if ($attendance->company_id !== $company->id) {
            abort(403, 'Akses ditolak.');
        }

        $employees = Employee::where('company_id', $company->id)->get();

        return view('attendances.edit', compact('attendance', 'employees', 'company'));
    }

    // Memperbarui absensi
    public function update(Request $request, Attendance $attendance)
    {
        $company = Auth::user()->company;

        if ($attendance->company_id !== $company->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,tanpa_keterangan',
        ]);

        $attendance->update($request->only('employee_id', 'date', 'status'));

        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil diperbarui.');
    }

    // Menghapus absensi
    public function destroy(Attendance $attendance)
    {
        $company = Auth::user()->company;

        if ($attendance->company_id !== $company->id) {
            abort(403, 'Akses ditolak.');
        }

        $attendance->delete();

        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil dihapus.');
    }

    public function report(Request $request)
    {
        $company = Auth::user()->company;

        // Validasi input tanggal
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ambil data kehadiran berdasarkan periode dan perusahaan
        $attendances = Attendance::where('company_id', $company->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->with('employee')
            ->get();

        // Rekap kehadiran per pegawai
        $summary = $attendances->groupBy('employee_id')->map(function ($attendanceGroup) {
            return [
                'employee' => $attendanceGroup->first()->employee->name,
                'hadir' => $attendanceGroup->where('status', 'hadir')->count(),
                'izin' => $attendanceGroup->where('status', 'izin')->count(),
                'sakit' => $attendanceGroup->where('status', 'sakit')->count(),
                'tanpa_keterangan' => $attendanceGroup->where('status', 'tanpa_keterangan')->count(),
            ];
        });

        return view('attendances.report', compact('summary', 'startDate', 'endDate'));
    }
}
