<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $appointments = Appointment::when($search, function ($query, $search) {
            return $query->where('patient_name', 'like', "%{$search}%");
        })
            ->orderBy('datetime', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('appointments.index', compact('appointments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'datetime' => 'required|date|unique:appointments,datetime',
            'notes' => 'sometimes|nullable|string',
        ]);

        Appointment::create($request->all());

        return redirect()->route('calendar.weekly')
            ->with('success', 'Consulta agendada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'datetime' => 'required|date|unique:appointments,datetime,' . $appointment->id,
            'notes' => 'sometimes|nullable|string',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')
            ->with('success', 'Consulta atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Consulta cancelada com sucesso!');
    }
}
