<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    //
    public function index()
    {
        // $klijenti = DB::table('clients')->get();
        // $klijenti = Client::all()->get();
        $klijenti = Auth::user()->clients;

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

        return Inertia::render('Clients/Detail', [
            'klijent' => $klijent,
            'appointments' => $klijent->appointments,
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

    public function aisummary($id)
    {
        $klijent = Client::where('id', $id)->first();

        // Call to AI service to generate summary would go here


        // extract notes from appointments
        $notes = array();
        foreach ($klijent->appointments as $appointment) {
            if ($appointment->note) {
                $app = array();
                $app["date"] = $appointment->date;
                $app["note"] = $appointment->note;
                array_push($notes, $app);
            }
        }

        $prompt = "Ti si psihoterapeut i sa svojim klijentima prakticiras teoriju izbora prema William Glasseru\n\n U nastavku ti saljem biljeske sa terapija koje si vodio sa svojim klijentom.Na osnovu tih biljeski napravi kratak pregledni sazetak o klijentu, njegovim problemima i napretku tokom terapija.Sazetak treba biti koncizan i informativan.\n\n Struktura biljeski je u JSON formatu. Odgovor napisi na hrvatskom jeziku do 500 rijeci. Ne koristi termine iz teorije izbora.\n\n Provjeri zadnje dvije bilješke prema datumu i istaki dogovorene radnje ili zadatke. \n\n Biljeske:\n". json_encode($notes);

        $ai_response = Gemini::generativeModel(model: 'gemini-2.0-flash')->generateContent($prompt);;

        //dd($ai_response->text());
        $summary = $ai_response->text();

        //dd($summary);
        //sleep(15); // to avoid rate limits during testing

        $klijent->summary = Str::markdown($summary);
        $klijent->save();

        //$klijent->update(['summary' => $summary]);

        //json_encode($notes)
 

        // For now, we'll just simulate it
        //$summary = "This is a simulated AI-generated summary for " . $klijent->first_name . " " . $klijent->last_name . ".";

        return redirect()->route('clients.detail', ['id' => $id])->with('ai_summary', $summary);
    }


}
