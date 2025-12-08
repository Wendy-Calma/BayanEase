<?php

namespace App\Http\Controllers;

use App\Models\Dependent;
use Illuminate\Http\Request;

class DependentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'civil_status' => 'required|string|in:single,married,widowed,separated',
        ]);

        Dependent::create([
            'user_id' => auth()->id(),
            ...$validated,
        ]);

        return back()->with('success', 'Dependent added successfully!');
    }

    public function destroy(Dependent $dependent)
    {
        if ($dependent->user_id !== auth()->id()) {
            abort(403);
        }

        $dependent->delete();

        return back()->with('success', 'Dependent removed successfully!');
    }
}

