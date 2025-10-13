<!DOCTYPE html>
<html lang="en-GB" class=" ">



<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'Professional design and development studio creating exceptional digital experiences.')">
    <title>@yield('title', 'Eminent Studio')</title>

    <link rel='stylesheet' id='styles-normalize-css' href='{{ asset('css/normalizea149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-colors-css' href='{{ asset('css/colorsa149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-webfonts-css' href='{{ asset('css/webfontsa149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-typo-css' href='{{ asset('css/typoa149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-btn-css' href='{{ asset('css/btna149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-swiper-css' href='{{ asset('css/swiper.mina149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-swiper-custom-css' href='{{ asset('css/swiper-customa149.css?ver=6.4') }}'
        type='text/css' media='all' />
    <link rel='stylesheet' id='styles-custom-cursor-css' href='{{ asset('css/custom-cursora149.css?ver=6.4') }}'
        type='text/css' media='all' />
    <link rel='stylesheet' id='styles-cookiebot-css' href='{{ asset('css/cookiebota149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-css' href='{{ asset('css/stylea149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-header-css' href='{{ asset('css/headera149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-burger-css' href='{{ asset('css/burgera149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id='styles-default-menu-css' href='{{ asset('css/default-menua149.css?ver=6.4') }}'
        type='text/css' media='all' />
    <link rel='stylesheet' id='styles-sharetext-css' href='{{ asset('css/selection-sharera149.css?ver=6.4') }}'
        type='text/css' media='all' />
    <link rel='stylesheet' id='styles-footer-css' href='{{ asset('css/footera149.css?ver=6.4') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' href='{{ asset('css/swiper.css') }}' type='text/css' media='all' />
    <link rel='stylesheet' id='styles-editor-content-css' href='{{ asset('css/editor-contenta149.css?ver=6.4') }}'
        type='text/css' media='all' />
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('icon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icon.svg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icon.svg') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Eminent Studio')">
    <meta property="og:description" content="@yield('description', 'Professional design and development studio creating exceptional digital experiences.')">
    <meta property="og:image" content="{{ asset('icon.svg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Eminent Studio">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Eminent Studio')">
    <meta property="twitter:description" content="@yield('description', 'Professional design and development studio creating exceptional digital experiences.')">
    <meta property="twitter:image" content="{{ asset('icon.svg') }}">

    <!-- Theme Color -->
    <meta name="theme-color" content="#003bf4">
    <meta name="msapplication-TileColor" content="#003bf4">

    @yield('css')
    <style>
        body #page {
            opacity: 0;
        }
    </style>
</head>

@if (Request::is('studio'))

    <body class="studio">
    @else

        <body class="home">
@endif

<div class="loader-wrapper flex-center">

    <svg id="Layer_2" data-name="Layer 2" class="logo" xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 139.96 143.18">
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

</div>
@if (Request::is('studio'))
    <div id="alphawrapper" class=" bg-black">
    @else
        <div id="alphawrapper">
@endif
@include('front.includes.header')

@yield('content')

@include('front.includes.footer')
</div>
<!-- /alpawrapper -->
<div class="cursor"></div>
<link rel='stylesheet' id='block-acf-index-page-teaser-css'
    href='{{ asset('blocks/index-page-teaser/index-page-teaser3781.css?ver=6.2.2') }}' type='text/css'
    media='all' />

<link rel='stylesheet' id='block-acf-leistungen-css'
    href='{{ asset('blocks/leistungen/leistungen3781.css?ver=6.2.2') }}' type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-introtext-css'
    href='{{ asset('blocks/introtext/introtext3781.css?ver=6.2.2') }}' type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-brand-links-css'
    href='{{ asset('blocks/brand-links/brand-links3781.css?ver=6.2.2') }}' type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-latest-css' href='{{ asset('blocks/latest/latest3781.css?ver=6.2.2') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-bilder-css' href='{{ asset('blocks/bilder/bilder3781.css?ver=6.2.2') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-svg-header-css'
    href='{{ asset('blocks/svg-header/svg-header3781.css?ver=6.2.2') }}' type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-video-css' href='{{ asset('blocks/video/video3781.css?ver=6.2.2') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-introtext-css'
    href='{{ asset('blocks/introtext/introtext3781.css?ver=6.2.2') }}' type='text/css' me dia='all' />
<link rel='stylesheet' id='block-acf-keynote-css' href='{{ asset('blocks/keynote/keynote3781.css?ver=6.2.2') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-slider-css' href='{{ asset('blocks/slider/slider3781.css?ver=6.2.2') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-text-css' href='{{ asset('blocks/text/text3781.css?ver=6.2.2') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-info-slider-css'
    href='{{ asset('blocks/info-slider/info-slider3781.css?ver=6.2.2') }}' type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-team-css' href='{{ asset('blocks/team/team3781.css?ver=6.2.2') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-awards-css' href='{{ asset('blocks/awards/awards3781.css?ver=6.2.2') }}'
    type='text/css' media='all' />
<link rel='stylesheet' id='block-acf-page-teaser-big-css'
    href='{{ asset('blocks/page-teaser-big/page-teaser-big3781.css?ver=6.2.2') }}' type='text/css' media='all' />
<script type="text/javascript" src="{{ asset('js/jquery.minf43b.js?ver=3.7.1') }}" id="jquery-core-js"></script>
<script type="text/javascript" src="{{ asset('js/jquery-migrate.min5589.js?ver=3.4.1') }}" id="jquery-migrate-js">
</script>
<script type="text/javascript" src="{{ asset('js/inview.js') }}" id="script-inview-js"></script>
<script type="text/javascript" src="{{ asset('js/parallax.js') }}" id="script-parallax-js"></script>
<script type="text/javascript" src="{{ asset('js/lazysizes.min.js') }}" id="script-lazysizes-js"></script>
<script type="text/javascript" src="{{ asset('js/swiper.min.js') }}" id="script-swiper-js"></script>
<script type="text/javascript" src="{{ asset('js/jquery.zpath.js') }}" id="script-zpath-js"></script>
<script type="text/javascript" src="{{ asset('js/selection-sharer.js') }}" id="script-sharetext-js"></script>
<script type="text/javascript" src="{{ asset('js/imageComparison.js') }}" id="script-imageComparison-js"></script>
<script type="text/javascript" src="{{ asset('js/infiniteslid.min.js') }}" id="script-infiniteslid-js"></script>
<script type="text/javascript" src="{{ asset('js/alpha.js') }}" id="script-alpha-js"></script>
<script type="text/javascript" src="{{ asset('blocks/index-intro/index-intro3781.js?ver=6.2.2') }}"
    id="block-acf-index-intro-js"></script>
<script type="text/javascript" src="{{ asset('blocks/latest/latest3781.js?ver=6.2.2') }}" id="block-acf-latest-js">
    < script type = "text/javascript"
    src = "{{ asset('blocks/keynote/keynote3781.js?ver=6.2.2') }}"
    id = "block-acf-keynote-js" >
</script>
<script type="text/javascript" src="{{ asset('blocks/slider/slider3781.js?ver=6.2.2') }}" id="block-acf-slider-js">
</script>
<script type="text/javascript" src="{{ asset('blocks/info-slider/info-slider3781.js?ver=6.2.2') }}"
    id="block-acf-info-slider-js"></script>
<script type="text/javascript" src="{{ asset('blocks/team/team3781.js?ver=6.2.2') }}" id="block-acf-team-js"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/adaptive-header.js') }}"></script>
<script>
    $(window).on('load', function() {
        $('.loader-wrapper').fadeOut('slow');
    });

    let services_ul = document.getElementById('services_links');
    let services_btn = document.getElementById('services_link');

    services_btn.addEventListener('click', function(e) {
        e.preventDefault();
        services_ul.classList.remove('close');
    });
</script>

@yield('js')

</body>

</html>
