<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClientController extends Controller
{
    //
    public function index()
    {
        // $klijenti = DB::table('clients')->get();
        // $klijenti = Client::all()->get();
        $klijenti = Client::all();

        return Inertia::render('Clients/Index', [
            'klijenti' => $klijenti,
        ]);

        // return Inertia::render('Clients/Index', compact('klijenti'));
    }

    public function create()
    {
        return Inertia::render('Clients/Create', []);
    }

    public function detail($id)
    {
        // $klijent = Client::find($id);
        $klijent = Client::where('id', $id)->first();

        // dd($klijent);

        return Inertia::render('Clients/Detail', [
            'klijent' => $klijent,
        ]);
    }

    public function edit($id)
    {
        // $klijent = Client::find($id);
        $klijent = Client::where('id', $id)->first();

        // dd($klijent);

        return Inertia::render('Clients/Edit', [
            'klijent' => $klijent,
        ]);
    }

    public function store(Request $request)
    {

        $request['auth_user_id'] = Auth::id();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'auth_user_id' => 'required|integer|exists:users,id',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }


    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'supervisor' => 'nullable|string|max:255',
            'association' => 'nullable|string|max:255',

        ]);

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

}
