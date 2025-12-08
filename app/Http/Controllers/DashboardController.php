<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Redirect staff users to their dashboard
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if ($user && $user->role && $user->role->name === 'staff') {
                return redirect()->route('staff.dashboard');
            }
            if ($user && $user->role && $user->role->name === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $user = auth()->user();
        
        $activeRequests = \App\Models\DocumentRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->count();

        // Status field uses 'ready_for_pickup' in migrations
        $readyForPickup = \App\Models\DocumentRequest::where('user_id', $user->id)
            ->where('status', 'ready_for_pickup')
            ->count();

        $latestRequest = \App\Models\DocumentRequest::where('user_id', $user->id)
            ->with('documentType')
            ->latest()
            ->first();

        return view('dashboard', compact('activeRequests', 'readyForPickup', 'latestRequest'));
    }

    /**
     * Return monthly request counts for the current year for the authenticated user.
     */
    public function monthlyRequests(Request $request)
    {
        $user = auth()->user();
        $year = date('Y');

        $query = \App\Models\DocumentRequest::selectRaw("MONTH(submitted_at) as month, COUNT(*) as total")
            ->whereYear('submitted_at', $year)
            ->groupByRaw('MONTH(submitted_at)')
            ->orderByRaw('MONTH(submitted_at)');

        // If the user is not admin, limit to their requests
        if (!($user && method_exists($user, 'isAdmin') && $user->isAdmin())) {
            $query->where('user_id', $user->id);
        }

        $rows = $query->get()->pluck('total', 'month')->toArray();

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