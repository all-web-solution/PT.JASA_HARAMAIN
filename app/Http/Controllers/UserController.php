<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }

    public function show($id)
    {
        // Logic to show a specific user
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the request data


        // Update the user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function store(Request $request)
    {

        // Create the user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
}
