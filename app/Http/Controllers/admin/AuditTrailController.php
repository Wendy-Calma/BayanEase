<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index()
    {
        $auditLogs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.audit-trail', compact('auditLogs'));
    }
}
