<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $posts = \App\Models\Appointment::with(['services'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts);
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
}
