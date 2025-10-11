<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function weekly(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : Carbon::now();

        // Start of week (Monday)
        $startOfWeek = $date->copy()->startOfWeek();
        $endOfWeek = $date->copy()->endOfWeek();

        $weekDays = [];
        $currentDay = $startOfWeek->copy();

        while ($currentDay <= $endOfWeek) {
            $weekDays[] = $currentDay->copy();
            $currentDay->addDay();
        }

        $appointments = Appointment::whereBetween('datetime', [
            $startOfWeek->startOfDay(),
            $endOfWeek->endOfDay()
        ])->get()->groupBy(function ($appointment) {
            return $appointment->datetime->format('Y-m-d');
        });

        $previousWeek = $startOfWeek->copy()->subWeek();
        $nextWeek = $startOfWeek->copy()->addWeek();

        return view('calendar.weekly', compact(
            'weekDays',
            'appointments',
            'startOfWeek',
            'endOfWeek',
            'previousWeek',
            'nextWeek'
        ));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
