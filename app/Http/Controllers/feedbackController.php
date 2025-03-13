<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;
//use Illuminate\Contracts\Mail\Mailable;

class feedbackController extends Controller
{
    //
    public function showForm()
    {
        return view('supportPage');
    }

    public function sendFeedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        $feedbackData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new FeedbackMail($feedbackData));

        return redirect()->back()->with('success', 'Your feedback has been sent successfully!');
    }
}



