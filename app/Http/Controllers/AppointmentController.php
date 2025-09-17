<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\AppointmentCreatedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentRescheduleMail;

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
            'services.*' => 'string',
        ]);

        DB::beginTransaction();

        $appointment = Appointment::create([
            ...$data,
            'user_id' => Auth::id(),
        ]);

        Service::whereIn('id', $data['services'])
            ->update(['appointment_id' => $appointment->id]);

        $appointment->load('services', 'user');
        
        DB::commit();

        Mail::to([Auth::user()->email, 'ruth.restauro2018@gmail.com'])
            ->send(new AppointmentCreatedMail(
                $appointment->load('services', 'user')
            ));

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

        if ($appointment->user && $appointment->user->email) {
            Mail::to($appointment->user->email)->send(new AppointmentRescheduleMail($appointment));
        }

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
