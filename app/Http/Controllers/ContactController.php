<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMessageLanding;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::to('minozajohnvincent2000@gmail.com')->send(new SendMessageLanding(
            $validated['email'],
            $validated['subject'],
            $validated['message']
        ));

        return back()->with('success', 'Message sent successfully!');
    }
}
