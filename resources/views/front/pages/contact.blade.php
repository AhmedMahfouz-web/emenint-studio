@extends('layouts.front')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
            textarea {
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
                &.active {
                    +label {
                        font-size: 12px;
                        transform: translate(-10px, -12px);
                    }
                }

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

        }

        .message-send svg {
            transition: all 0.2s ease-in;
            transform: translateX(-2px);
        }

        .message-send:hover svg {
            transform: translateX(2px);
        }
    </style>
@endsection

@section('content')
    <div id="page">
        <section class="svg-header contact-header">
            <div class="svgh-bh">
                <div id="svg-animaiotn" class="inview flex flex--bottom">
                    <div class="js-parallaxheader">
                        <svg class="deaw studio contact" id="Layer_1" data-name="Layer 1"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 383.19 391.63">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: none;
                                        stroke: #212120;
                                        stroke-miterlimit: 10;
                                        stroke-width: 2px;
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
                        <div class="subline inview inview--up">(Contact)</div>
                        <h2 class="inview inview--up">Eminent Studio</h2>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-form">
            <form action="{{ route('send mail') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" id="name" name="name" onblur="checkInput(this)">
                    <label for="name">Name</label>
                </div>
                <div class="input-group">
                    <input type="mobile" name="mobile" id="text" onblur="checkInput(this)">
                    <label for="mobile">Mobile</label>
                </div>
                <div class="input-group">
                    <input type="email" name="email" id="email" onblur="checkInput(this)">
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <textarea name="message" id="message" onblur="checkInput(this)"></textarea>
                    <label for="message">Message</label>
                </div>
                <button type="submit" class="message-send">Send Message <svg style="margin-top: -3px; margin-left:5px"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                        <path d="M7.293 4.707 14.586 12l-7.293 7.293 1.414 1.414L17.414 12 8.707 3.293 7.293 4.707z" />
                    </svg></button>
            </form>

        </section>

        <section class="kontakt-wrapper">
            <div class="grid-width text-center">
                <div class="flex flex--top flex--nom copy-m flex-kontakt">
                    <div class="kontakt-wrapper--text">
                        <div class="subline inview inview--up">
                            (Inquire)
                        </div>
                        <div class="inview inview--up">
                            <a class="nopagechange"
                                href="mailto:hello@eminent-studio.com">hello(at)eminent-studio(dot)com</a><br />
                            <a class="nopagechange" href="tel:+20 103 373 9707">+20 103 373 9707</a><br />
                            <a class="nopagechange" target="_blank" href="https://wa.me/201031375777">WhatsApp</a>
                        </div>
                    </div>
                    <div class="kontakt-wrapper--text">
                        <div class="subline inview inview--up">
                            <a href="{{ route('jobs apply') }}">(Apply)</a>
                        </div>
                        <div class="inview inview--up">
                            <a class="nopagechange" href="mailto:jobs@eminent-studio.com">jobs(at)eminent-studio(dot)com</a>
                        </div>
                    </div>
                    <div class="kontakt-wrapper--text">
                        <div class="subline inview inview--up">
                            (Follow)
                        </div>
                        <div class="inview inview--up">
                            <a class="nopagechange" target="_blank"
                                href="https://www.facebook.com/eminentstudiosa">Facebook</a><br>
                            <a class="nopagechange" target="_blank"
                                href="https://www.instagram.com/eminent.studio/">Instagram</a><br />
                            <a class="nopagechange" target="_blank"
                                href="https://www.linkedin.com/company/eminentstudiosa/">Linkedin</a><br>
                            <a class="nopagechange" target="_blank"
                                href="https://www.behance.net/eminentstudiosa">Behance</a>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <div id="map">
        </div>
        <section class="awards">
            <div class="grid-width text-center">
                <div class="h3 inview inview--up">
                    Synergetic Partners </div>
                <div class="flex flex--nom awards-wrap">
                    <div class="awards-wrap--image">
                        <div class="inview inview--up">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                xml:space="preserve" style="enable-background:new 0 0 1651.8 464.36"
                                viewBox="0 0 1651.8 464.4">
                                <circle cx="3200.5" cy="2001.6" r="406.1" class="st0" />
                                <text class="st2"
                                    style="font-family:&quot;PoliteType-Regular&quot;;font-size:51.2811px"
                                    transform="translate(5404 5485)">
                                    ™</text>
                                <text class="st2"
                                    style="font-family:&quot;PoliteType-Regular&quot;;font-size:51.2811px"
                                    transform="translate(-1427 4890)">
                                    ™</text>
                                <text class="st2"
                                    style="font-family:&quot;PoliteType-Regular&quot;;font-size:60.1264px"
                                    transform="translate(-920 6563)">
                                    ™</text>
                                <text class="st1"
                                    style="font-family:&quot;PoliteType-Regular&quot;;font-size:51.2811px"
                                    transform="translate(552 4890)">
                                    ™</text>

                                <circle cx="1603.7" cy="1886.9" r="45.9" class="st1" />
                                <circle cx="1166.4" cy="2557.8" r="56.3" class="st0" />
                                <path
                                    d="M933 3v164h-32V61l-47 76h-3l-46-76v106h-32V3h33l47 78 46-78h34zm128 149a60 60 0 0 1-44 18c-17 0-32-6-44-18s-18-26-18-43 6-32 18-44 27-18 44-18 32 6 44 18 18 26 18 44-6 31-18 43zm-66-20c6 6 13 9 22 9s17-3 23-9 9-14 9-23a31 31 0 0 0-32-33c-9 0-16 3-22 9-6 7-9 14-9 24 0 9 3 17 9 23zm131-49c0 3 2 6 6 8l15 5 18 6c5 2 10 6 15 11 4 5 6 12 6 20 0 12-5 21-14 28-9 6-20 9-33 9-24 0-40-9-49-28l26-14c3 10 11 15 23 15 11 0 16-3 16-10 0-3-2-6-6-8l-15-5-18-6c-6-2-11-6-15-11s-6-11-6-19c0-11 4-21 12-27 9-7 19-10 32-10 10 0 18 2 26 6 8 5 14 11 18 19l-25 14c-4-8-10-12-19-12l-10 2c-2 2-3 4-3 7zm142-4h-26v49c0 4 1 7 3 9 2 1 5 3 9 3h14v27c-20 2-35 0-43-6-9-6-13-17-13-33V79h-20V50h20V27l30-10v33h26v29zm107-29h30v117h-30v-14c-9 12-22 17-38 17s-29-6-40-18-17-26-17-43 6-32 17-44 24-18 40-18 29 6 38 17V50zm-56 82c6 6 14 10 24 10a31 31 0 0 0 32-33c0-10-3-18-9-24s-14-9-23-9a31 31 0 0 0-33 33c0 9 3 17 9 23zm176-103c-16-1-24 6-24 20v1h24v29h-24v88h-31V79h-16V50h16v-1c0-17 5-29 14-38 9-8 23-12 41-11v29zm98 21h31v117h-31v-14c-9 12-21 17-38 17-15 0-29-6-40-18s-16-26-16-43 5-32 16-44 25-18 40-18c17 0 29 6 38 17V50zm-55 82c6 6 14 10 23 10a31 31 0 0 0 32-33c0-10-3-18-9-24s-14-9-23-9a31 31 0 0 0-32 33c0 9 3 17 9 23zM792 402h80v16h-96V254h95v15h-79v58h73v16h-73v59zm106 16V247h15v171h-15zm148-117h16v117h-16v-23a52 52 0 0 1-47 25 59 59 0 0 1-60-61c0-17 6-31 17-43 12-12 26-18 43-18 21 0 36 9 47 26v-23zm-79 91c9 9 20 13 33 13a44 44 0 0 0 46-46 44 44 0 0 0-46-46 44 44 0 0 0-46 46c0 13 5 24 13 33zm182-94c14 0 25 4 33 13 9 9 13 20 13 35v72h-16v-72c0-11-3-19-8-24-6-6-13-9-24-9s-20 3-27 11c-7 7-10 18-10 32v62h-16V301h16v18c8-14 21-21 39-21zm88 33c0 5 2 9 7 12s10 6 17 8l20 6c7 2 12 5 17 10s7 12 7 20c0 10-4 18-12 24s-18 9-30 9-21-2-29-7-13-12-16-20l13-7c2 6 6 11 11 14 6 4 13 5 21 5 7 0 14-1 19-4s7-8 7-14-2-10-7-13c-4-3-10-6-17-7l-20-6c-6-2-12-6-17-10-4-5-7-12-7-20 0-9 4-17 12-24 7-6 17-9 28-9 10 0 18 2 25 6 7 5 13 10 16 18l-13 7c-4-11-14-16-28-16-6 0-12 1-17 5-5 3-7 7-7 13zm191-30h15v117h-15v-23a52 52 0 0 1-48 25 59 59 0 0 1-60-61c0-17 6-31 18-43 11-12 26-18 42-18 21 0 37 9 48 26v-23zm-79 91c9 9 20 13 33 13s23-4 32-13 14-20 14-33-5-24-14-33-20-13-32-13a46 46 0 0 0-46 46c0 13 4 24 13 33zm142-72c7-14 20-21 37-21v15c-11 0-19 3-26 9s-11 16-11 30v65h-15V301h15v19zm144-19h17l-50 127c-5 12-11 21-19 27-9 7-18 10-28 9v-14c14 1 24-7 32-25l3-7-53-117h17l43 97 38-97zM251 118l-40 67-71-119C119 30 80 8 39 8H0v413h106V199l97 161c1 3 4 5 8 5 3 0 6-2 8-5l106-175c29-49 82-78 138-78h174V8H445c-80 0-154 42-194 110z"
                                    class="st14" />
                                <path d="M372 261v160h265v-99H469v-61h164v-97H453c-45 0-81 36-81 81v16z" class="st14" />
                            </svg>


                        </div>
                    </div>
                    <div class="awards-wrap--image">
                        <div class="inview inview--up">

                            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve"
                                style="enable-background:new 0 0 1276.62 124.71" viewBox="0 0 1276.6 124.7">
                                <path
                                    d="M71 27v98H40V27H0V0h111v27H71zm140 98V75h-51v50h-31V0h31v48h51V0h31v125h-31zm57 0V0h32v125h-32zm90 0h-32V0h51c33 0 50 15 50 40 0 16-9 29-26 35l32 50h-35l-25-42-15 1v41zm16-65c13-1 20-7 20-18s-7-17-23-17h-13v35h16zm133-33v98h-32V27h-40V0h112v27h-40zm123 50v48h-31V77L555 0h34l26 49 25-49h33l-43 77zm123-50v98h-32V27h-40V0h112v27h-40zm139 98V75h-50v50h-32V0h32v48h50V0h32v125h-32zm89 0h-31V0h50c33 0 50 15 50 40 0 16-9 29-25 35l32 50h-36l-25-42-15 1v41zm16-65c13-1 21-7 21-18s-8-17-24-17h-13v35h16zm76 65V0h91v26h-60v23h48v26h-48v24h60v26h-91zm112 0V0h92v26h-60v23h48v26h-48v24h60v26h-92z"
                                    class="st0" />
                            </svg>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div><!-- /page -->
@endsection

@section('js')
    {{-- Commented out Google Maps --}}
    {{-- <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', 'AIzaSyB36QcSLhdeV8gPQoK7Wv1nOghjKq4WkSY') }}&callback=initMap"></script>
    <script>
        function initMap() {
            // Google Maps implementation commented out
        }
    </script> --}}

    {{-- Commented out Leaflet Map --}}
    {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = new L.Map('map').setView([30.1004118, 31.3404542], 15);

        // Use OpenStreetMap for better detail, then apply custom styling
        const tiles = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Apply sophisticated black/white/gray filter with good contrast
        map.getContainer().style.filter = 'grayscale(100%) contrast(130%) brightness(90%) invert(0%) sepia(0%)';

        // Add custom CSS for additional styling
        const mapContainer = map.getContainer();
        mapContainer.style.borderRadius = '12px';
        mapContainer.style.overflow = 'hidden';
        mapContainer.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';

        // Create a more sophisticated custom marker with lighter blacks
        var customIcon = L.divIcon({
            className: 'custom-marker',
            html: `
                <div style="
                    position: relative;
                    width: 30px;
                    height: 30px;
                ">
                    <div style="
                        background: linear-gradient(135deg, #4a4a4a 0%, #333333 100%);
                        width: 24px;
                        height: 24px;
                        border-radius: 50%;
                        border: 4px solid white;
                        box-shadow: 0 3px 12px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.2);
                        position: absolute;
                        top: 3px;
                        left: 3px;
                    "></div>
                    <div style="
                        width: 8px;
                        height: 8px;
                        background: white;
                        border-radius: 50%;
                        position: absolute;
                        top: 11px;
                        left: 11px;
                        box-shadow: 0 1px 2px rgba(0,0,0,0.3);
                    "></div>
                </div>
            `,
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });

        var marker = L.marker([30.1004118, 31.3404542], {
            title: 'Eminent Studio',
            icon: customIcon
        }).addTo(map);

        // Enhanced popup with better styling
        marker.bindPopup(`
            <div style="
                padding: 20px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                max-width: 280px;
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            ">
                <h3 style="
                    margin: 0 0 12px 0;
                    color: #333333;
                    font-size: 18px;
                    font-weight: 600;
                    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
                ">Eminent Studio</h3>
                <p style="
                    margin: 0;
                    color: #555555;
                    line-height: 1.5;
                    font-size: 14px;
                    text-shadow: 0 1px 1px rgba(255,255,255,0.8);
                ">33 Mohamed Bek Ramzy Street – Triumph Square – Heliopolis, Cairo Governorate 11757</p>
            </div>
        `).openPopup();

        // Add a subtle overlay to enhance the black/white/gray effect
        setTimeout(() => {
            const mapPane = map.getPane('mapPane');
            if (mapPane) {
                mapPane.style.mixBlendMode = 'luminosity';
            }
        }, 1000);
    </script> --}}

    {{-- Google Maps with Black and White Style --}}
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>
    <script>
        function initMap() {
            // Eminent Studio location coordinates
            const eminentStudio = {
                lat: 30.1004118,
                lng: 31.3404542
            };

            // Dark/Black map style for Google Maps JavaScript API
            const mapStyles = [{
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#212121"
                    }]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#757575"
                    }]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [{
                        "color": "#212121"
                    }]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#757575"
                    }]
                },
                {
                    "featureType": "administrative.country",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#9e9e9e"
                    }]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#bdbdbd"
                    }]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#757575"
                    }]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#181818"
                    }]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#616161"
                    }]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.stroke",
                    "stylers": [{
                        "color": "#1b1b1b"
                    }]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#2c2c2c"
                    }]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#8a8a8a"
                    }]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#373737"
                    }]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#3c3c3c"
                    }]
                },
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#4e4e4e"
                    }]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#616161"
                    }]
                },
                {
                    "featureType": "transit",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#757575"
                    }]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#000000"
                    }]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#3d3d3d"
                    }]
                }
            ];

            // Create map with JSON styles (force custom styling)
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: eminentStudio,
                styles: mapStyles, // Apply custom dark styling
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true,
                zoomControl: true,
                disableDefaultUI: false
            });

            // Add custom styling to map container
            const mapContainer = document.getElementById('map');
            mapContainer.style.borderRadius = '12px';
            mapContainer.style.overflow = 'hidden';
            mapContainer.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';

            // Create custom marker
            const marker = new google.maps.Marker({
                position: eminentStudio,
                map: map,
                title: 'Eminent Studio',
                animation: google.maps.Animation.DROP
            });

            // Create info window with styled content
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="
                        padding: 20px;
                        font-family: 'IBMPlexSans-Regular', sans-serif;
                        max-width: 280px;
                        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    ">
                        <h3 style="
                            margin: 0 0 12px 0;
                            color: #333333;
                            font-size: 18px;
                            font-weight: 600;
                            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
                        ">Eminent Studio</h3>
                        <p style="
                            margin: 0;
                            color: #555555;
                            line-height: 1.5;
                            font-size: 14px;
                            text-shadow: 0 1px 1px rgba(255,255,255,0.8);
                        ">33 Mohamed Bek Ramzy Street – Triumph Square – Heliopolis, Cairo Governorate 11757</p>
                        <div style="margin-top: 15px;">
                            <a href="https://www.google.com/maps/dir/?api=1&destination=30.1004118,31.3404542" 
                               target="_blank" 
                               style="
                                   display: inline-block;
                                   padding: 8px 16px;
                                   background: #030cfc;
                                   color: white;
                                   text-decoration: none;
                                   border-radius: 4px;
                                   font-size: 14px;
                                   font-weight: 500;
                               ">Get Directions</a>
                        </div>
                    </div>
                `
            });

            // Open info window on marker click
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });

            // Open info window by default
            infoWindow.open(map, marker);
        }
    </script>
    <script>
        let checkInput = function(input) {
            if (input.value.length > 0) {
                input.className = 'active';
            } else {
                input.className = '';
            }
        };
    </script>
@endsection
