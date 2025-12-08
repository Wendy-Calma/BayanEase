<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;

class ResidentSearchController extends Controller
{
    public function index(Request $request)
    {
        $residents = [];
        $searchQuery = $request->input('q');

        if ($searchQuery) {
            // Search by resident name or reference number
            $residents = User::where('role_id', function($q) {
                    $q->select('id')
                      ->from('roles')
                      ->where('name', 'resident');
                })
                ->where(function($q) use ($searchQuery) {
                    // Search by first name
                    $q->where('first_name', 'like', '%' . $searchQuery . '%')
                      // Search by surname/last name
                      ->orWhere('surname', 'like', '%' . $searchQuery . '%')
                      ->orWhere('last_name', 'like', '%' . $searchQuery . '%')
                      // Search by phone number
                      ->orWhere('phone_number', 'like', '%' . $searchQuery . '%')
                      // Search by first name + surname combination
                      ->orWhereRaw("CONCAT(first_name, ' ', surname) like ?", ['%' . $searchQuery . '%'])
                      ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $searchQuery . '%']);
                })
                ->orWhereHas('documentRequests', function($q) use ($searchQuery) {
                    $q->where('reference_number', 'like', '%' . $searchQuery . '%');
                })
                ->with(['documentRequests' => function($q) {
                    $q->orderBy('created_at', 'desc');
                }])
                ->distinct()
                ->paginate(10);
        }

        return view('staff.resident-search', compact('residents', 'searchQuery'));
    }
}
