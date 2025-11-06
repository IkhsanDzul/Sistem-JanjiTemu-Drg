<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateRole extends Controller
{
    public function index(Request $request) {
        return view('create-role');
    }

    public function store(Request $request) {
        // Validate the request data
        $validated = $request->validate([
            'nama_role' => 'required|string',
            'permissions' => 'required|array',
        ]);

        // Logic to create a new role with the given permissions
        // This is a placeholder; actual implementation will depend on your role management system
        // Role::create([...]);

        return redirect()->back()->with('success', 'Role created successfully!');
    }
}
