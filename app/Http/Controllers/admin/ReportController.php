<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $logs = [
            '[ERROR] 2024-11-09 18:01 [ERROR] Database connection timeout (rebuild)',
            '[INFO] 2024-11-09 17:55 System integrity check completed',
            '[WARN] 2024-11-09 10:30 High CPU usage detected',
        ];

        return view('admin.reports-logs', compact('logs'));
    }
}
