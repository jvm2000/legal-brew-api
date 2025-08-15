<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Appointment::with(['services', 'user'])
            ->orderBy('created_at', 'asc');

        if ($request->has('scheduledDay')) {
            $query->where('scheduledDay', $request->scheduledDay);
        }

        return response()->json($query->get());
    }

    public function getAll()
    {
        $query = \App\Models\Appointment::with(['services', 'user'])
            ->orderBy('created_at', 'asc');

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'setup' => 'required|string|in:office,online',
            'scheduledDay' => 'required|date',
            'scheduledTime' => 'required|date_format:H:i',
            'services' => 'required|array',
            'services.*' => 'integer',
        ]);

        DB::beginTransaction();

        $appointment = Appointment::create([
            ...$data,
            'user_id' => Auth::id(),
        ]);

        $serviceIds = $data['services'];
        Service::whereIn('id', $serviceIds)->update(['appointment_id' => $appointment->id]);

        DB::commit();

        return response()->json([
            'message' => 'Appointment created and services attached.',
            'appointment' => $appointment->load('services'),
        ], 201);
    }

    public function update(Request $request, Appointment $appointment) {
        $data = $request->validate([
            'scheduledDay' => 'required|date',
            'scheduledTime' => 'required|date_format:H:i',
        ]);

        $appointment->update($data);

        return response()->json([
            'message'    => 'Appointment updated successfully',
            'appointment'=> $appointment
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(null, 204);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'scheduledDay' => 'required|date',
            'scheduledTime' => 'required|date_format:H:i',
        ]);

        $exists = Appointment::whereDate('scheduledDay', $request->scheduledDay)
            ->whereTime('scheduledTime', $request->scheduledTime)
            ->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }
}
