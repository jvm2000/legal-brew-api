<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Appointment Confirmation</title>
</head>
<body>
    <h2>Appointment Confirmation</h2>
    <p>Hi {{ $appointment->user->full_name }},</p>
    <p>Your appointment has been scheduled:</p>
    <ul>
        <li>Setup: {{ ucfirst($appointment->setup) }}</li>
        <li>Date: {{ \Carbon\Carbon::parse($appointment->scheduledDay)->format('F d, Y') }}</li>
        <li>Time: {{ \Carbon\Carbon::parse($appointment->scheduledTime)->format('h:i A') }}</li>
    </ul>
    <p>Services included:</p>
    <ul>
        @foreach($appointment->services as $service)
            <li>{{ $service->name }}</li>
        @endforeach
    </ul>
    <p>Thank you for booking with us!</p>
</body>
</html>
