<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Charts\EmployeeGrowthChart;
use App\Charts\AttendanceTrendChart;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $company = Auth::user()->company;

        if (!$company) {
            abort(403, 'Akses ditolak');
        }

        // Mengambil bulan dan tahun yang dipilih dari request
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        // Mendapatkan tanggal mulai dan akhir bulan yang dipilih
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Query untuk data dashboard dengan cache
        $data = Cache::remember("dashboard_{$company->id}_{$month}_{$year}", now()->addMinutes(10), function () use ($company, $startDate, $endDate, $month, $year) {
            return [
                // Total pegawai yang bergabung pada atau sebelum bulan yang dipilih
                'totalEmployees' => Employee::where('company_id', $company->id)
                    ->where('created_at', '<=', $endDate) // Menghitung karyawan yang bergabung pada atau sebelum akhir bulan
                    ->count(),

                // Total pegawai yang bergabung pada bulan yang dipilih
                'totalEmployeesThisMonth' => Employee::where('company_id', $company->id)
                    ->whereMonth('created_at', $month) // Menghitung karyawan yang bergabung pada bulan yang dipilih
                    ->whereYear('created_at', $year)   // Pastikan tahun sesuai
                    ->count(),

                // Mengambil total kehadiran (hanya yang hadir) pada bulan yang dipilih
                'totalAttendance' => Attendance::where('company_id', $company->id)
                    ->where('status', 'present')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count(),

                // Mengambil total gaji yang dibayarkan pada bulan yang dipilih
                'totalSalary' => Salary::whereHas('employee', function ($query) use ($company) {
                    $query->where('company_id', $company->id);
                })->whereBetween('payment_date', [$startDate, $endDate])->sum('amount'),

                // Grafik pertumbuhan pegawai berdasarkan tanggal bergabung
                'employeeGrowth' => Employee::where('company_id', $company->id)
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->pluck('count', 'date')
                    ->toArray(),

                // Grafik tren kehadiran berdasarkan tanggal
                'attendanceTrend' => Attendance::where('company_id', $company->id)
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->pluck('count', 'date')
                    ->toArray(),
            ];
        });

        // Menangani data default jika kosong
        $data = array_merge([
            'totalEmployees' => 0,
            'totalEmployeesThisMonth' => 0,
            'totalAttendance' => 0,
            'totalSalary' => 0,
            'employeeGrowth' => [],
            'attendanceTrend' => [],
        ], $data);

        // Menghitung persentase kehadiran
        $totalWorkingDays = $this->getWorkingDays($startDate, $endDate);
        $attendancePercentage = ($data['totalEmployees'] > 0 && $totalWorkingDays > 0)
            ? round(($data['totalAttendance'] / ($data['totalEmployees'] * $totalWorkingDays)) * 100, 2)
            : 0;

        // Menghitung gaji rata-rata
        $averageSalary = ($data['totalEmployees'] > 0)
            ? round($data['totalSalary'] / $data['totalEmployees'], 2)
            : 0;

        // Membuat grafik pertumbuhan pegawai
        $employeeGrowthChart = new EmployeeGrowthChart();
        $employeeGrowthChart->labels(array_keys($data['employeeGrowth']));
        $employeeGrowthChart->dataset('Employee Growth', 'line', array_values($data['employeeGrowth']))
            ->color('#4BC0C0')
            ->backgroundColor('rgba(75, 192, 192, 0.2)');

        // Membuat grafik tren kehadiran
        $attendanceTrendChart = new AttendanceTrendChart();
        $attendanceTrendChart->labels(array_keys($data['attendanceTrend']));
        $attendanceTrendChart->dataset('Attendance Trend', 'bar', array_values($data['attendanceTrend']))
            ->color('#36A2EB')
            ->backgroundColor('rgba(54, 162, 235, 0.2)');

        return view('dashboard', array_merge($data, [
            'attendancePercentage' => $attendancePercentage,
            'averageSalary' => $averageSalary,
            'employeeGrowthChart' => $employeeGrowthChart,
            'attendanceTrendChart' => $attendanceTrendChart,
        ]));
    }

    // Fungsi untuk menghitung hari kerja dalam rentang waktu tertentu
    private function getWorkingDays(Carbon $startDate, Carbon $endDate)
    {
        $totalWorkingDays = 0;
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            if (!$currentDate->isWeekend()) {
                $totalWorkingDays++;
            }
            $currentDate->addDay();
        }

        return $totalWorkingDays;
    }
}
