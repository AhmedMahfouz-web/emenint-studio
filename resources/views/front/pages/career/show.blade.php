@extends('front.layouts.master')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>{{ $job->title }}</h1>
        <p>{{ $job->location }} - <span class="job-type">{{ ucfirst($job->type) }}</span></p>
    </div>
</section>

<section class="job-details">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Job Description</h2>
                {!! $job->description !!}
            </div>
            <div class="col-md-4">
                <div class="apply-form">
                    <h3>Apply for this position</h3>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('jobs.apply', $job) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" name="full_name" id="full_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="cover_letter">Cover Letter</label>
                            <textarea name="cover_letter" id="cover_letter" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="resume">Resume (PDF, DOC, DOCX)</label>
                            <input type="file" name="resume" id="resume" class="form-control-file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
