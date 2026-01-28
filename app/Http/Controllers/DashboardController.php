<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function index(DashboardService $dashboardService)
    {
        abort_unless(auth()->user()->esSuperAdmin(), 403);

        $stats = $dashboardService->getStats();

        return view('super_admin.dashboard', compact('stats'));
    }
}
