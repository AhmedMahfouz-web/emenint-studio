<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>Eminent - Login</title>
    <link rel="icon" href="{{ asset('icon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/rt-plugins.css') }}">
    <link href="https://unpkg.com/aos@2.3.0/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- START : Theme Config js-->
    <script src="{{ asset('js/settings.js') }}" sync></script>
    <!-- END : Theme Config js-->

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="font-inter skin-default">
    <div class="loginwrapper">
        <div class="lg-inner-column">
            <div class="right-column relative">
                <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                    <div class="auth-box h-full flex flex-col justify-center">
                        <div class="mobile-logo text-center mb-6 lg:hidden block">
                            <a href="#">
                                <svg style="height: 10vh; margin: auto" id="Layer_2" data-name="Layer 2"
                                    class="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 139.96 143.18">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: #003bf4;
                                            }
                                        </style>
                                    </defs>
                                    <g id="Layer_1-2" data-name="Layer 1">
                                        <path class="cls-1"
                                            d="M123.21,85.35c-5.55-.63-23.57-7.73-37.3-11.67-3.17-.9-6.11-1.64-8.62-2.1,2.51-.45,5.44-1.19,8.62-2.1,13.75-3.91,31.77-11.01,37.3-11.67,6.34-.79,11.96-2.22,16.74-4.28-.73-2.98-1.7-5.92-2.87-8.81-2.09-2.65-3.99-5.49-5.72-8.48-1.7-2.95-3.17-6-4.36-9.1-1.97-2.56-4.1-4.93-6.36-7.12-4.2,3.08-8.22,7.26-12.12,12.35-3.32,4.49-18.48,16.54-28.76,26.47-2.37,2.3-4.48,4.47-6.13,6.42,.86-2.4,1.69-5.31,2.49-8.51,3.49-13.87,6.35-33.02,8.55-38.14,2.49-5.89,4.06-11.47,4.66-16.64-2.95-.86-5.98-1.49-9.06-1.92-3.35,.49-6.75,.71-10.21,.71s-6.78-.26-10.06-.77c-3.2,.43-6.32,1.09-9.35,1.95,.57,5.17,2.17,10.75,4.63,16.67,2.23,5.12,5.09,24.27,8.55,38.14,.8,3.2,1.63,6.11,2.49,8.51-1.65-1.95-3.75-4.12-6.13-6.42-10.27-9.95-25.42-22.01-28.76-26.47-3.86-5.1-7.9-9.25-12.08-12.36-2.21,2.12-4.28,4.43-6.19,6.89-1.25,3.14-2.75,6.2-4.48,9.2-1.7,2.95-3.61,5.74-5.7,8.33-1.23,2.99-2.22,6.02-2.99,9.07,4.77,2.09,10.4,3.49,16.75,4.32,5.55,.63,23.57,7.73,37.3,11.67,3.17,.9,6.11,1.64,8.62,2.1-2.51,.45-5.44,1.19-8.62,2.1-13.75,3.91-31.77,11.01-37.3,11.67-6.34,.79-11.96,2.22-16.74,4.28,.73,2.98,1.7,5.92,2.87,8.81,2.09,2.65,3.99,5.49,5.72,8.48,1.7,2.95,3.17,6,4.36,9.1,1.97,2.56,4.1,4.93,6.36,7.12,4.2-3.08,8.22-7.26,12.12-12.35,3.32-4.49,18.48-16.54,28.76-26.47,2.37-2.3,4.48-4.47,6.13-6.42-.86,2.4-1.69,5.31-2.49,8.51-3.49,13.87-6.35,33.02-8.55,38.14-2.49,5.89-4.06,11.47-4.66,16.64,2.94,.86,5.98,1.49,9.06,1.92,3.35-.49,6.75-.72,10.21-.72s6.78,.26,10.06,.77c3.2-.43,6.32-1.09,9.35-1.94-.57-5.17-2.17-10.75-4.63-16.67-2.23-5.12-5.09-24.27-8.55-38.14-.8-3.2-1.63-6.11-2.49-8.51,1.65,1.95,3.75,4.12,6.12,6.42,10.27,9.95,25.42,22.01,28.76,26.47,3.86,5.1,7.9,9.25,12.08,12.36,2.21-2.12,4.28-4.43,6.19-6.89,1.25-3.14,2.75-6.2,4.48-9.2,1.7-2.95,3.61-5.74,5.7-8.33,1.23-2.99,2.22-6.02,2.99-9.07-4.77-2.09-10.4-3.49-16.75-4.32Z" />
                                    </g>
                                </svg>
                            </a>
                        </div>
                        <div class="text-center 2xl:mb-10 mb-4">
                            <h4 class="font-medium">Sign in</h4>
                        </div>
                        <!-- BEGIN: Login Form -->
                        <form class="space-y-4" wire:submit="authenticate">
                            <div class="fromGroup">
                                <label class="block capitalize form-label">email</label>
                                <div class="relative">
                                    <input type="email" wire:model.defer="data.email" name="data.email"
                                        class="form-control py-2" placeholder="example@example.com" required>
                                </div>
                                @error('data.email')
                                    <p class="text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="fromGroup">
                                <label class="block capitalize form-label">password</label>
                                <div class="relative">
                                    <input type="password" wire:model.defer="data.password" name="data.password"
                                        class="form-control py-2" placeholder="************" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary block w-full text-center">Sign in</button>
                        </form>
                        <!-- END: Login Form -->

                    </div>
                    <div class="auth-footer text-center">
                        Copyright 2024, Eminent Studio All Rights Reserved.
                    </div>
                </div>
            </div>
            <div class="left-column bg-cover bg-no-repeat bg-center " style="background: #003bf4;">
                <div class="flex flex-col h-full justify-center">
                    <div class="flex-1 flex flex-col justify-center items-center">
                        <a href="/">
                            <svg style="height: 10vh; margin: auto" id="Layer_2" data-name="Layer 2" class="logo"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 139.96 143.18">
                                <defs>
                                    <style>
                                        .cls-1 {
                                            fill: #fff;
                                        }
                                    </style>
                                </defs>
                                <g id="Layer_1-2" data-name="Layer 1">
                                    <path class="cls-1"
                                        d="M123.21,85.35c-5.55-.63-23.57-7.73-37.3-11.67-3.17-.9-6.11-1.64-8.62-2.1,2.51-.45,5.44-1.19,8.62-2.1,13.75-3.91,31.77-11.01,37.3-11.67,6.34-.79,11.96-2.22,16.74-4.28-.73-2.98-1.7-5.92-2.87-8.81-2.09-2.65-3.99-5.49-5.72-8.48-1.7-2.95-3.17-6-4.36-9.1-1.97-2.56-4.1-4.93-6.36-7.12-4.2,3.08-8.22,7.26-12.12,12.35-3.32,4.49-18.48,16.54-28.76,26.47-2.37,2.3-4.48,4.47-6.13,6.42,.86-2.4,1.69-5.31,2.49-8.51,3.49-13.87,6.35-33.02,8.55-38.14,2.49-5.89,4.06-11.47,4.66-16.64-2.95-.86-5.98-1.49-9.06-1.92-3.35,.49-6.75,.71-10.21,.71s-6.78-.26-10.06-.77c-3.2,.43-6.32,1.09-9.35,1.95,.57,5.17,2.17,10.75,4.63,16.67,2.23,5.12,5.09,24.27,8.55,38.14,.8,3.2,1.63,6.11,2.49,8.51-1.65-1.95-3.75-4.12-6.13-6.42-10.27-9.95-25.42-22.01-28.76-26.47-3.86-5.1-7.9-9.25-12.08-12.36-2.21,2.12-4.28,4.43-6.19,6.89-1.25,3.14-2.75,6.2-4.48,9.2-1.7,2.95-3.61,5.74-5.7,8.33-1.23,2.99-2.22,6.02-2.99,9.07,4.77,2.09,10.4,3.49,16.75,4.32,5.55,.63,23.57,7.73,37.3,11.67,3.17,.9,6.11,1.64,8.62,2.1-2.51,.45-5.44,1.19-8.62,2.1-13.75,3.91-31.77,11.01-37.3,11.67-6.34,.79-11.96,2.22-16.74,4.28,.73,2.98,1.7,5.92,2.87,8.81,2.09,2.65,3.99,5.49,5.72,8.48,1.7,2.95,3.17,6,4.36,9.1,1.97,2.56,4.1,4.93,6.36,7.12,4.2-3.08,8.22-7.26,12.12-12.35,3.32-4.49,18.48-16.54,28.76-26.47,2.37-2.3,4.48-4.47,6.13-6.42-.86,2.4-1.69,5.31-2.49,8.51-3.49,13.87-6.35,33.02-8.55,38.14-2.49,5.89-4.06,11.47-4.66,16.64,2.94,.86,5.98,1.49,9.06,1.92,3.35-.49,6.75-.72,10.21-.72s6.78,.26,10.06,.77c3.2-.43,6.32-1.09,9.35-1.94-.57-5.17-2.17-10.75-4.63-16.67-2.23-5.12-5.09-24.27-8.55-38.14-.8-3.2-1.63-6.11-2.49-8.51,1.65,1.95,3.75,4.12,6.12,6.42,10.27,9.95,25.42,22.01,28.76,26.47,3.86,5.1,7.9,9.25,12.08,12.36,2.21-2.12,4.28-4.43,6.19-6.89,1.25-3.14,2.75-6.2,4.48-9.2,1.7-2.95,3.61-5.74,5.7-8.33,1.23-2.99,2.22-6.02,2.99-9.07-4.77-2.09-10.4-3.49-16.75-4.32Z" />
                                </g>
                            </svg>
                            <div class="black-500-title max-w-[525px] mx-auto mt-5 text-center">
                                Eminent Studio
                            </div>
                        </a>
                    </div>
                    <div>
                        <div class="black-500-title max-w-[525px] mx-auto pb-20 text-center">
                            Embark on
                            <span class="text-white font-bold">
                                the Journey to Glory...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/rt-plugins.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>
