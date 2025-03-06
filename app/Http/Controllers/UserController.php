<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // Display all users
    public function index()
    {
        $users = User::all(); // Fetch all users without agent_id
        return view('admin.agents.dashboard', compact('users'));
    }    


    // Show form to create a new user
    public function create()
    {
        return view('admin.agents.users.create');
    }

    // Store a new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        $users = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // return json_encode('User Created');
        return redirect()->route('agent.users.index')->with('success', 'User added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.agents.users.edit', compact('user'));
    }

    // Update user details
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
        ]);

        $user->update($request->only('name', 'email', 'phone'));

        return redirect()->route('agent.users.index')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('agent.users.index')->with('success', 'User deleted successfully.');
    }
}
