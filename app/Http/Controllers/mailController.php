<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
    public function send_mail(Request $request)
    {
        $data = array('name' => $request->name, 'email' => $request->email, 'mobile' => $request->mobile, 'body' => $request->message);
        Mail::send('mail', $data, function ($message) {
            $message->to('jobs@eminent-studio.com', 'New Job Request')->subject('New Job Request');
            $message->from('info@eminent-studio.com', 'Eminent-Studio');
        });

        return redirect()->route('contact');
    }
}
