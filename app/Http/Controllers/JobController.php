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

        return view('front.pages.career.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        return view('front.jobs.show', compact('job'));
    }

    public function apply(Request $request, Job $job)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'cover_letter' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        JobApplication::create([
            'job_id' => $job->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cover_letter' => $request->cover_letter,
            'resume_path' => $resumePath,
            'status' => 'new',
        ]);

        return back()->with('success', 'Your application has been submitted successfully!');
    }
}
