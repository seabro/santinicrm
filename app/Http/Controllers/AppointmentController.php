<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index()
    {
        // $klijenti = DB::table('clients')->get();
        // $klijenti = Client::all()->get();
        $appointments = Appointment::all();

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments,
        ]);

        // return Inertia::render('Clients/Index', compact('klijenti'));
    }
}
