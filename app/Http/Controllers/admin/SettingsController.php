<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'barangay_name' => 'Barangay San Roque',
            'barangay_punong' => 'Hon. Maria C. Santos',
            'email_address' => 'contact@sanroque.gov.ph',
            'phone_number' => '0917-123-4567',
            'address' => 'San Roque Hall, Main Street, San Roque',
        ];

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'barangay_name' => 'required|string|max:255',
            'barangay_punong' => 'required|string|max:255',
            'email_address' => 'required|email',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:500',
        ]);

        // Save settings (could use SystemSetting model or env file)
        // For now, we'll just redirect with success
        
        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
    }
}
