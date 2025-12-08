<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SettingsController extends Controller
{
    public function index()
    {
        $dependents = auth()->user()->dependents()->get() ?? [];
        return view('resident.my-profile', compact('dependents'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'surname' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'nick_name' => ['nullable', 'string', 'max:255'],
            'birth_month' => ['required', 'string', 'max:2'],
            'birth_day' => ['required', 'integer', 'min:1', 'max:31'],
            'birth_year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'birth_province' => ['required', 'string', 'max:255'],
            'birth_city' => ['required', 'string', 'max:255'],
            'citizenship' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'civil_status' => ['required', 'in:Single,Married,Widowed,Separated'],
            'religion' => ['required', 'string', 'max:255'],
            'education_occupation' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'spouse_name' => ['nullable', 'string', 'max:255'],
            'father_name' => ['required', 'string', 'max:255'],
            'mother_name' => ['required', 'string', 'max:255'],
            'complete_address' => ['required', 'string', 'max:1000'],
            'residency_type' => ['required', 'in:Owner,Renter,Living with Family'],
            'residency_years' => ['required', 'integer', 'min:0'],
            'id_picture' => ['nullable', 'file', 'mimes:jpeg,png', 'max:5120'],
            'digital_signature' => ['nullable', 'file', 'mimes:jpeg,png', 'max:5120'],
        ]);

        $updateData = $request->only([
            'surname',
            'first_name',
            'middle_name',
            'nick_name',
            'birth_month',
            'birth_day',
            'birth_year',
            'birth_province',
            'birth_city',
            'citizenship',
            'gender',
            'civil_status',
            'religion',
            'education_occupation',
            'phone_number',
            'email',
            'spouse_name',
            'father_name',
            'mother_name',
            'complete_address',
            'residency_type',
            'residency_years',
        ]);

        // Handle file uploads
        if ($request->hasFile('id_picture')) {
            if ($user->id_picture) {
                \Storage::delete($user->id_picture);
            }
            $updateData['id_picture'] = $request->file('id_picture')->store('public/uploads/id_pictures');
        }

        if ($request->hasFile('digital_signature')) {
            if ($user->digital_signature) {
                \Storage::delete($user->digital_signature);
            }
            $updateData['digital_signature'] = $request->file('digital_signature')->store('public/uploads/digital_signatures');
        }

        // Update last_name for backward compatibility
        $updateData['last_name'] = $request->input('surname');

        $user->update($updateData);

        return back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully');
    }
}