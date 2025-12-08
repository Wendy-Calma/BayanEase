<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Overall queue statistics for all staff to see
        $stats = [
            'pending_requests' => DocumentRequest::where('status', 'pending')->count(),
            'processing_requests' => DocumentRequest::where('status', 'processing')->count(),
            'assigned_requests' => DocumentRequest::where('assigned_to', $userId)->count(),
            'completed_requests' => DocumentRequest::where('status', 'completed')->count(),
        ];

        // Recent requests assigned to current staff member
        $recent_requests = DocumentRequest::where('assigned_to', $userId)
                                        ->with(['user', 'documentType'])
                                        ->orderBy('created_at', 'desc')
                                        ->take(5)
                                        ->get();

        return view('staff.dashboard', compact('stats', 'recent_requests'));
    }
}