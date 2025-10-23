<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('status', 'open')
            ->latest()
            ->get();

        return view('front.pages.career', compact('jobs'));
    }

    public function show(Job $job)
    {
        return view('front.jobs.show', compact('job'));
    }

    public function apply(Request $request)
    {
        try {
            $validated = $request->validate([
                'job_id' => 'required|exists:jobs,id',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'portfolio_link' => 'nullable|url|max:255',
                'cover_letter' => 'required|string',
                'resume' => 'required|file|mimes:pdf,doc,docx|max:20480',
            ]);

            $resumePath = $request->file('resume')->store('resumes', 'public');

            JobApplication::create([
                'job_id' => $request->job_id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'portfolio_link' => $request->portfolio_link,
                'cover_letter' => $request->cover_letter,
                'resume_path' => $resumePath,
                'status' => 'pending',
            ]);

            // Return JSON response for AJAX requests
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your application has been submitted successfully! We will review it and get back to you soon.'
                ]);
            }

            return back()->with('success', 'Your application has been submitted successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return JSON response for AJAX validation errors
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            // Return JSON response for AJAX general errors
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting your application. Please try again.'
                ], 500);
            }
            return back()->with('error', 'An error occurred. Please try again.');
        }
    }
}
