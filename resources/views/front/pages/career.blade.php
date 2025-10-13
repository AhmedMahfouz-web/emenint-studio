@extends('layouts.front')

@section('css')
    <style>
        #map {
            height: 500px;
            width: 70%;
            margin: auto;
        }

        form {
            width: 50%;
            margin: 40px auto 80px;
            max-width: 400px;
        }

        @media(max-width: 480px) {
            form {
                width: 80%;
            }

            #map {
                height: 300px;
                width: 95%;
                margin: auto;
            }
        }

        .input-group {
            width: 100%;
            font-size: 16px;
            max-width: 400px;
            position: relative;
            margin: auto;
            margin-bottom: 20px;

            input,
            textarea,
            select {
                width: 100%;
                color: #010101;
                border: none;
                outline: none;
                line-height: 1;
                padding: 5px 0;
                padding-left: 20px;
                font-size: 16px;
                border-bottom: solid 1px #010101;
                background-color: transparent;
                transition: all 0.2s ease-in;
                font-weight: 400;

                option {
                    height: fit-content;
                }

                +label {
                    left: 10px;
                    top: -5px;
                    position: absolute;
                    pointer-events: none;
                    transition: all 0.2s ease-in;
                }

                &:focus {
                    box-shadow: 0 1px 0 0 #010101;
                }

                &:focus,
                &.active,
                &.has-value {
                    +label {
                        font-size: 12px;
                        transform: translate(-10px, -12px);
                    }
                }

            }

            #resume-label {
                margin-bottom: 15px;
                margin-left: 10px;
            }

            textarea {

                &:focus {
                    box-shadow: 0px 0px 0px 1px #010101;
                }

                &:focus,
                &.active {
                    height: 100px;
                    margin-top: 10px;
                    padding-left: 10px;
                    border: solid 1px #010101;
                }
            }
        }

        .message-send {
            border: none;
            font-size: 18px;
            color: #010101;
            cursor: pointer;
            display: flex;
            font-weight: 500;
            float: right;
            padding: 0;
            transition: all 0.2s ease-in;
            background: unset;
        }

        .message-send svg {
            transition: all 0.2s ease-in;
            transform: translateX(-2px);
        }

        .message-send:hover svg {
            transform: translateX(2px);
        }

        .cls-1 {
            stroke: unset;
        }
    </style>
@endsection

@section('content')
    <div id="page">
        <section class="svg-header contact-header">
            <div class="svgh-bh">
                <div id="svg-animaiotn" class="inview flex flex--bottom">
                    <div class="js-parallaxheader">
                        <svg class="deaw studio contact" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 383.19 391.63">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: none;
                                    }
                                </style>
                            </defs>
                            <path class="cls-1"
                                d="m336.44,233.26c-15.09-1.71-64.12-21.03-101.51-31.75-8.64-2.46-16.62-4.47-23.45-5.7,6.83-1.23,14.82-3.24,23.45-5.7,37.42-10.65,86.45-29.97,101.51-31.75,17.26-2.15,32.54-6.03,45.56-11.66-1.99-8.11-4.63-16.1-7.82-23.96-5.7-7.22-10.86-14.93-15.57-23.08-4.63-8.02-8.61-16.32-11.87-24.77-5.37-6.96-11.16-13.41-17.3-19.39-11.42,8.39-22.38,19.75-32.98,33.59-9.03,12.22-50.28,45.02-78.25,72.04-6.45,6.25-12.18,12.16-16.67,17.46,2.35-6.53,4.6-14.45,6.79-23.16,9.49-37.73,17.27-89.86,23.26-103.78,6.77-16.03,11.05-31.2,12.68-45.28-8.01-2.33-16.26-4.05-24.66-5.21-9.1,1.32-18.36,1.94-27.77,1.94s-18.44-.7-27.38-2.1c-8.71,1.17-17.19,2.96-25.44,5.29,1.56,14.08,5.91,29.25,12.6,45.36,6.07,13.93,13.85,66.05,23.26,103.78,2.19,8.71,4.44,16.63,6.79,23.16-4.49-5.3-10.22-11.21-16.67-17.46-27.93-27.09-69.18-59.88-78.25-72.04-10.49-13.88-21.49-25.17-32.87-33.62-6.03,5.77-11.63,12.06-16.84,18.75-3.41,8.54-7.5,16.87-12.2,25.02-4.63,8.02-9.82,15.62-15.51,22.67-3.35,8.13-6.04,16.37-8.14,24.68,12.97,5.69,28.29,9.5,45.58,11.76,15.09,1.71,64.12,21.03,101.51,31.74,8.64,2.46,16.62,4.47,23.46,5.7-6.83,1.23-14.82,3.24-23.45,5.7-37.42,10.65-86.45,29.97-101.51,31.75-17.26,2.15-32.54,6.03-45.56,11.66,1.99,8.11,4.63,16.11,7.82,23.96,5.7,7.22,10.86,14.93,15.57,23.08,4.63,8.02,8.61,16.32,11.87,24.77,5.37,6.96,11.16,13.41,17.3,19.39,11.42-8.39,22.37-19.75,32.98-33.59,9.03-12.22,50.28-45.02,78.25-72.04,6.45-6.25,12.18-12.16,16.67-17.46-2.35,6.53-4.6,14.45-6.79,23.16-9.49,37.73-17.27,89.85-23.26,103.78-6.77,16.03-11.05,31.2-12.68,45.28,8.01,2.33,16.26,4.05,24.66,5.21,9.1-1.32,18.36-1.95,27.77-1.95s18.44.7,27.39,2.1c8.71-1.17,17.19-2.95,25.44-5.29-1.56-14.08-5.91-29.25-12.6-45.36-6.07-13.93-13.85-66.05-23.26-103.78-2.19-8.71-4.44-16.63-6.79-23.16,4.49,5.3,10.22,11.21,16.67,17.46,27.93,27.09,69.18,59.88,78.25,72.04,10.49,13.88,21.5,25.17,32.87,33.62,6.03-5.77,11.63-12.06,16.84-18.75,3.41-8.54,7.5-16.87,12.2-25.02,4.63-8.02,9.82-15.62,15.51-22.67,3.35-8.13,6.04-16.37,8.14-24.68-12.97-5.69-28.29-9.5-45.58-11.76Z" />
                        </svg>
                    </div>
                </div>
                <div class="grid-width svgh-bh flex text-center">
                    <div class="js-parallaxheader-text">
                        <div class="subline inview inview--up">(Apply)</div>
                        <h2 class="inview inview--up">Eminent Studio</h2>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-form">
            <form action="{{ route('jobs apply') }}" method="POST">
                @csrf
                <div class="input-group">
                    <select name="job_id" id="job_id" onchange="this.classList.toggle('has-value', this.value !== '')">
                        <option value=""></option>
                        @foreach ($jobs as $job)
                            <option value="{{ $job->id }}">{{ $job->title }}</option>
                        @endforeach
                    </select>
                    <label for="job_id">Job</label>
                </div>
                <div class="input-group">
                    <input type="text" id="name" name="full_name" onblur="checkInput(this)">
                    <label for="name">Name</label>
                </div>
                <div class="input-group">
                    <input type="mobile" name="phone" id="text" onblur="checkInput(this)">
                    <label for="mobile">Phone</label>
                </div>
                <div class="input-group">
                    <input type="email" name="email" id="email" onblur="checkInput(this)">
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <textarea name="cover_letter" id="cover_letter" onblur="checkInput(this)"></textarea>
                    <label for="cover_letter">Cover Letter</label>
                </div>
                <div class="input-group">
                    <label id="resume-label" for="resume">Resume</label>
                    <input type="file" name="resume" id="resume" onblur="checkInput(this)">
                </div>
                <button type="submit" class="message-send">Send Message <svg style="margin-top: -3px; margin-left:5px"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                        <path d="M7.293 4.707 14.586 12l-7.293 7.293 1.414 1.414L17.414 12 8.707 3.293 7.293 4.707z" />
                    </svg></button>
            </form>

        </section>
    </div>
@endsection

<script>
    // Initialize has-value class on page load
    document.addEventListener('DOMContentLoaded', function() {
        const jobSelect = document.getElementById('job_id');
        if (jobSelect) {
            jobSelect.classList.toggle('has-value', jobSelect.value !== '');
        }
    });
</script>
