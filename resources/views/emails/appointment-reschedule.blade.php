<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reschedule Appointment Confirmation</title>
</head>
<body>
    <h2>Hello {{ $appointment->user->full_name }}</h2>
    <p>
        This is to remind you of your appointment is rescheduled with Atty. Ruth Restauro on
    </p>
    <ul>
        <li>Date: {{ \Carbon\Carbon::parse($appointment->scheduledDay)->format('F d, Y') }}</li>
        <li>Time: {{ \Carbon\Carbon::parse($appointment->scheduledTime)->format('h:i A') }}</li>
    </ul>
    <p>Thank you,</p>
    <p>Restauro Legal Services</p>
</body>
</html>
