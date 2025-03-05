<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    // Show all agents
    public function index()
    {
        $agents = Agent::all();
        return view('admin.agents.index', compact('agents'));
    }

    // Show the create agent form
    public function create()
    {
        return view('admin.agents.create');
    }

    // Store new agent
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:agents',
            'email' => 'required|email|unique:agents',
            'pan_card' => 'required|string|max:20|unique:agents',
            'password' => 'required|string|min:6',
        ]);

        Agent::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'pan_card' => $request->pan_card,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.agents')->with('success', 'Agent added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        return view('admin.agents.edit', compact('agent'));
    }

    // Update agent
    public function update(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:agents,phone,' . $id,
            'email' => 'required|email|unique:agents,email,' . $id,
            'pan_card' => 'required|string|max:20|unique:agents,pan_card,' . $id,
        ]);

        $agent->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'pan_card' => $request->pan_card,
        ]);

        return redirect()->route('admin.agents')->with('success', 'Agent updated successfully.');
    }

    // Delete agent
    public function destroy($id)
    {
        Agent::findOrFail($id)->delete();
        return redirect()->route('admin.agents')->with('success', 'Agent deleted successfully.');
    }
}
