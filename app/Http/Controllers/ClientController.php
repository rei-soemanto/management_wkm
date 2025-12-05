<?php

namespace App\Http\Controllers;

use App\Models\Clients\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Display list of clients.
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Client::withCount('managementProjects')->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('pic_name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $clients = $query->paginate(5);

        return view('clients.manage', [
            'action' => 'list',
            'clients' => $clients,
            'search' => $search
        ]);
    }

    // Show form to create new client.
    public function create()
    {
        // Create Form view
        return view('clients.manage', [
            'action' => 'add',
            'client_to_edit' => null
        ]);
    }

    // Store newly created client.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:14'
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client added successfully.');
    }

    // Show form to edit specified client.
    public function edit($id)
    {
        // Edit Form view
        $client = Client::findOrFail($id);
        
        return view('clients.manage', [
            'action' => 'edit',
            'client_to_edit' => $client,
        ]);
    }

    // Update client in storage.
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:14'
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    // Remove client from storage.
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