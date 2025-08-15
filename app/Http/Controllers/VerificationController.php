<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        
        $code = rand(100000, 999999);

        VerificationCode::updateOrCreate(
            ['user_id' => $user->id],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]
        );

        // Send via email
        Mail::to($user->email)->send(new VerificationCodeMail($code));

        return response()->json(['message' => 'Verification code sent successfully.']);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();
        $verification = VerificationCode::where('user_id', $user->id)
            ->where('code', $request->code)
            ->first();

        if (!$verification) {
            return response()->json(['message' => 'Invalid code.'], 422);
        }

        if (Carbon::now()->greaterThan($verification->expires_at)) {
            return response()->json(['message' => 'Code has expired.'], 422);
        }

        // Mark user as verified
        $user->email_verified_at = now();
        $user->save();

        // Delete code after use
        $verification->delete();

        return response()->json(['message' => 'Email verified successfully.']);
    }
}
