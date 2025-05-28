<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    public function showSendMailForm()
    {
        return view('emails.send');
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'recipients' => 'required|array',
            'recipients.*' => 'email'
        ]);

        $data = [
            'subject' => $request->subject,
            'message' => $request->message
        ];

        foreach ($request->recipients as $email) {
            Mail::to($email)->send(new SendEmail($data));
        }

        return redirect()->back()->with('success', 'Emails envoyés avec succès !');
    }
}
