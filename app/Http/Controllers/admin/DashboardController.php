<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index(Request $request)
    {
        // Build a safe stats array. Check schema for the 'status' column to avoid SQL errors
        $totalUsers = User::count();
        $totalRequests = DocumentRequest::count();

        $pending = 0;
        $completed = 0;

        if (\Illuminate\Support\Facades\Schema::hasColumn((new DocumentRequest)->getTable(), 'status')) {
            $pending = DocumentRequest::where('status', 'pending')->count();
            $completed = DocumentRequest::where('status', 'completed')->count();
        }

        // Estimate active barangay staffs: admins + users with role 'staff' (if present)
        $activeStaffs = User::admins()->count();
        try {
            // Avoid calling the instance relation `role()` statically. Use whereHas to count users
            // that belong to a role named 'staff'. This is safe even if 'staff' role is missing.
            $activeStaffs += User::whereHas('role', function ($q) {
                $q->where('name', 'staff');
            })->count();
        } catch (\Exception $e) {
            // role 'staff' may not exist or DB may not be available; ignore
        }

        // Average processing time in hours (from submitted_at -> completed_at)
        $avgSeconds = DocumentRequest::whereNotNull('completed_at')
            ->avg(DB::raw('TIMESTAMPDIFF(SECOND, submitted_at, completed_at)'));
        $avgHours = $avgSeconds ? round($avgSeconds / 3600, 1) : null;

        // Get most requested documents
        $mostRequestedDocuments = DocumentRequest::with('documentType')
            ->select('document_type_id', DB::raw('COUNT(*) as count'))
            ->groupBy('document_type_id')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->pluck('count', 'documentType.name')
            ->toArray();

        $stats = [
            'total_users' => $totalUsers,
            'total_requests' => $totalRequests,
            'pending_requests' => $pending,
            'completed_requests' => $completed,
            'active_staffs' => $activeStaffs,
            'avg_processing_hours' => $avgHours,
            'most_requested_documents' => $mostRequestedDocuments,
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Return monthly request counts for the current year as JSON.
     */
    public function monthlyRequests(Request $request)
    {
        $year = date('Y');

        $rows = DocumentRequest::selectRaw("MONTH(submitted_at) as month, COUNT(*) as total")
            ->whereYear('submitted_at', $year)
            ->groupByRaw('MONTH(submitted_at)')
            ->orderByRaw('MONTH(submitted_at)')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Build an array with 12 months (1..12)
        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $data[] = isset($rows[$m]) ? (int)$rows[$m] : 0;
        }

        return response()->json([
            'year' => (int)$year,
            'monthly' => $data,
        ]);
    }
}



