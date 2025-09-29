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

    public function send_data(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'email',
                'mobile' => 'required|string',
                'message' => 'required|string'
            ]);

            $data = array('name' => $request->name, 'email' => $request->email, 'mobile' => $request->mobile, 'body' => $request->message);
            Mail::send('mail', $data, function ($message) {
                $message->to('support@eminent-studio.com', 'سجل بياناتك')->subject('سجل بياناتك');
                $message->from('info@eminent-studio.com', 'Eminent-Studio');
            });

            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'سيتم التواصل معكم خلال 24 ساعة'
                ]);
            }

            return redirect()->route('data-form')->with('success', 'سيتم التواصل معكم خلال 24 ساعة');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.'
                ], 500);
            }

            return redirect()->back()->with('error', 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.');
        }
    }
}
