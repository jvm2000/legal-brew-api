<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Appointment Confirmation</title>
</head>
<body>
    <h2>Hello {{ $appointment->user->full_name }}</h2>
    <p>
        This is to remind you of your appointment with Atty. Attorney’s Full Name on
    </p>
    <ul>
        <li>Date: {{ \Carbon\Carbon::parse($appointment->scheduledDay)->format('F d, Y') }}</li>
        <li>Time: {{ \Carbon\Carbon::parse($appointment->scheduledTime)->format('h:i A') }}</li>
        <li>Setup: {{ ucfirst($appointment->setup) }}</li>
    </ul>
    <p>Thank you,</p>
    <p>The Legal Brew</p>
</body>
</html>
