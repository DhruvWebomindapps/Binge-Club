<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function inquiry(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'comment' => $request->comment,
        ];
        Mail::send('mail.inquiry', $data, function ($message) {
            $message->from('no-reply@bingeclub.in', 'Binge Club');
            $message->to('dhruba@webomindapps.com');
            $message->replyTo('no-reply@bingeclub.in', 'Binge Club');
            $message->subject('Binge Club | Enquiry');
            $message->priority(3);
        });
        return back()->with('success', 'Message sent successfully');
    }
}
