<?php

namespace App\Http\Controllers;

use App\Models\Clients\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index()
    {
        // List view
        $clients = Client::withCount('managementProjects')->latest()->get();
        
        return view('clients.manage', [
            'action' => 'list',
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        // Create Form view
        return view('clients.manage', [
            'action' => 'add',
            'client_to_edit' => null // Pass null to avoid undefined variable error
        ]);
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client added successfully.');
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit($id)
    {
        // Edit Form view
        $client = Client::findOrFail($id);
        
        return view('clients.manage', [
            'action' => 'edit',
            'client_to_edit' => $client,
        ]);
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        
        // Prevent deletion if client has active projects
        if ($client->managementProjects()->count() > 0) {
            return back()->with('error', 'Cannot delete client because they have active projects.');
        }

        $client->delete();
        
        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}