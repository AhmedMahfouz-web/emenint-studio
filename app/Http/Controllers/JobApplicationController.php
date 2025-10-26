<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function getModalContent($id)
    {
        $application = JobApplication::with('job')->findOrFail($id);
        $allApplicationIds = JobApplication::orderBy('created_at', 'desc')->pluck('id')->toArray();

        return view('filament.modals.job-application-details', [
            'record' => $application,
            'allApplicationIds' => $allApplicationIds
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,pending,accepted,rejected'
        ]);

        $application = JobApplication::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $application->status
        ]);
    }
}
