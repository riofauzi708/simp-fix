<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckCompanyAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Tambahkan logika untuk memeriksa akses ke perusahaan
        $resource = $request->route()->parameter('employee') ??
            $request->route()->parameter('attendance') ??
            $request->route()->parameter('salary') ??
            $request->route()->parameter('position');

        if ($resource && $resource->company_id != $user->company_id) {
            return response()->json(['error' => 'Unauthorized access to this company data'], 403);
        }

        return $next($request);
    }
}
