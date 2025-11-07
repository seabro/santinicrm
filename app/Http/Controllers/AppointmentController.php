<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class AppointmentController extends Controller
{
    public function index()
    {
        // $klijenti = DB::table('clients')->get();
        $appointments = Appointment::all();
        $klijenti = Auth::user()->clients;


        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments,
            'klijenti' => $klijenti,
        ]);
    }


    public function store(Request $request)
    {
        $request['auth_user_id'] = Auth::id();
        //$request['client_id'] = 1;

        $request['date'] = Date::createFromFormat('Y-m-d', $request['day']);
        $request['time'] = $request['hour'] . ':' . $request['min'];

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'auth_user_id' => 'required|integer|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        //dd($request->all());
        //dd($validated);

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
    }
}
