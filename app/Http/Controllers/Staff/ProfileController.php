<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('staff.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('first_name','last_name','email','phone_number'));

        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return back()->with('success','Profile updated');
    }
}
