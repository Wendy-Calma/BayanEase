<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        // Minimal stub: list users could be implemented here
        return view('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Implement storing user
        return redirect()->route('admin.users.index');
    }

    public function show($id)
    {
        return view('admin.users.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('admin.users.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.users.index');
    }
}
