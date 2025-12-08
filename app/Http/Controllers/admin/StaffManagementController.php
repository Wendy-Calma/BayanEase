<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;

class StaffManagementController extends Controller
{
    public function index()
    {
        $staff = User::whereHas('role', function ($query) {
            $query->whereIn('name', ['staff', 'admin']);
        })->get();

        return view('admin.manage-staff', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|min:8|confirmed',
        ]);

        $staff = User::create([
            'role_id' => 2, // staff role
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'complete_address' => 'N/A', // Default value for staff members
            'password' => bcrypt($request->password),
            'is_active' => true,
        ]);

        // Log the action
        AuditService::logStaffCreated($staff);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member added successfully');
    }

    public function edit($id)
    {
        $staff = User::findOrFail($id);
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required|string|max:15',
            'is_active' => 'boolean',
        ]);

        // Store old data for audit log
        $oldData = $staff->only('first_name', 'last_name', 'email', 'phone_number', 'is_active');

        $staff->update($request->only('first_name', 'last_name', 'email', 'phone_number', 'is_active'));

        // Log the action
        AuditService::logStaffUpdated($staff, $oldData);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully');
    }

    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staffName = "{$staff->first_name} {$staff->last_name}";
        $staffId = $staff->id;

        $staff->delete();

        // Log the action
        AuditService::logStaffDeleted($staffName, $staffId);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully');
    }
}

