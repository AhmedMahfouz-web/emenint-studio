<!DOCTYPE html>
<html lang="en-GB" class=" ">



<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Eminent Studio</title>

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

    <link rel="icon" href="{{ asset('icon.svg') }}">
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
    {{-- <svg id="Layer_2" data-name="Layer 2" class="text" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 303.76 217.96">
            <defs>
                <style>
                    .cls-1 {
                        fill: #003bf4;
                    }

                    .cls-2 {
                        fill: #212121;
                    }
                </style>
            </defs>

            <g id="Layer_1-2" data-name="Layer 1">

                <g>

                    <g>
                        <path class="cls-2"
                            d="M290.76,83.29h5.34v.95h-1.2c-.22,0-.39-.02-.53-.07-.13-.05-.24-.11-.33-.17l-.2,.13c.05,.09,.09,.22,.1,.39,.01,.17,.02,.3,.02,.39v4.44h-1.05v-4.44c0-.09,0-.22,.02-.39,.01-.17,.04-.3,.08-.39l-.18-.13c-.1,.08-.22,.14-.35,.18-.14,.04-.31,.07-.53,.07h-1.18v-.95Zm8.09,0l1.08,3.55c.05,.19,.11,.41,.16,.66,.05,.25,.1,.5,.13,.74h.23c.03-.24,.08-.49,.13-.74,.05-.25,.11-.47,.16-.66l1.09-3.55h1.92v6.05h-1.05v-3.76c0-.22,0-.43,.02-.64s.05-.47,.12-.77l-.26-.07c-.02,.09-.06,.21-.1,.38-.04,.16-.11,.37-.2,.62l-1.33,4.24h-1.22l-1.33-4.24c-.09-.25-.15-.46-.2-.62-.04-.16-.08-.29-.1-.38l-.28,.07c.08,.31,.12,.56,.13,.77s.02,.42,.02,.64v3.76h-1.05v-6.05h1.92Z" />
                        <g>
                            <g>
                                <path class="cls-2"
                                    d="M94.18,109.13c0-1.76,.28-3.44,.85-5.05,.57-1.6,1.4-3.02,2.48-4.24,1.09-1.22,2.42-2.2,4.01-2.92,1.59-.72,3.4-1.09,5.43-1.09,2.14,0,3.99,.38,5.56,1.14,1.57,.76,2.85,1.8,3.83,3.13,.98,1.33,1.66,2.86,2.04,4.61,.38,1.74,.43,3.6,.15,5.56h-18.94c.31,2.1,1.2,3.8,2.66,5.07,1.47,1.28,3.35,1.91,5.67,1.91,.97,0,1.87-.12,2.72-.36,.84-.24,1.61-.53,2.3-.88,.69-.34,1.29-.73,1.81-1.16,.52-.43,.93-.82,1.24-1.16l2.64,4.09c-.35,.31-.82,.72-1.42,1.22-.6,.5-1.34,.98-2.23,1.45-.88,.47-1.92,.86-3.13,1.19-1.21,.33-2.62,.49-4.24,.49-2.1,0-3.98-.32-5.64-.96s-3.06-1.53-4.22-2.66c-1.16-1.14-2.04-2.51-2.66-4.11-.62-1.6-.93-3.35-.93-5.25Zm5.54-2.07l.72,.31c.24-.17,.94-.39,2.1-.65,1.16-.26,2.54-.39,4.17-.39,1,0,1.85,.03,2.56,.1,.71,.07,1.29,.16,1.73,.26,.45,.1,.8,.21,1.06,.31,.26,.1,.44,.21,.54,.31l.72-.26c0-1.1-.17-2.08-.52-2.92-.35-.85-.81-1.55-1.4-2.12-.59-.57-1.28-1-2.07-1.29-.79-.29-1.64-.44-2.54-.44-.72,0-1.49,.14-2.3,.41-.81,.28-1.55,.69-2.23,1.24-.67,.55-1.24,1.25-1.71,2.1-.47,.85-.75,1.85-.85,3.03Z" />
                                <path class="cls-2"
                                    d="M129.42,96.46l-.26,4.61h1.29c.17-.59,.45-1.19,.83-1.81,.38-.62,.89-1.18,1.53-1.68,.64-.5,1.4-.91,2.3-1.24,.9-.33,1.95-.49,3.16-.49,2.07,0,3.78,.51,5.12,1.53,1.35,1.02,2.35,2.37,3,4.06h1.14c.17-.59,.49-1.21,.96-1.86,.47-.65,1.08-1.26,1.84-1.81,.76-.55,1.63-1.01,2.61-1.37,.98-.36,2.08-.54,3.29-.54,2.9,0,5.14,.89,6.73,2.66,1.59,1.78,2.38,4.22,2.38,7.32v15.68h-5.43v-12.99c0-2.83-.47-4.85-1.42-6.05-.95-1.21-2.58-1.81-4.89-1.81-2.04,0-3.58,.73-4.63,2.2-1.05,1.47-1.58,3.39-1.58,5.77v12.88h-5.43v-12.99c0-2.83-.47-4.85-1.42-6.05-.95-1.21-2.58-1.81-4.89-1.81-2.04,0-3.58,.73-4.63,2.2-1.05,1.47-1.58,3.39-1.58,5.77v12.88h-5.43v-25.04h5.43Z" />
                                <path class="cls-2" d="M171.9,121.5l.05-25.04h5.38v25.04h-5.43Z" />
                                <path class="cls-2"
                                    d="M183.96,96.46h5.43l-.26,4.61h1.29c.17-.59,.45-1.19,.83-1.81,.38-.62,.89-1.18,1.53-1.68,.64-.5,1.41-.91,2.33-1.24,.91-.33,1.97-.49,3.18-.49,2.79,0,5,.92,6.62,2.77,1.62,1.85,2.43,4.44,2.43,7.79v15.11h-5.43v-13.4c0-2.55-.49-4.44-1.47-5.67-.98-1.22-2.54-1.84-4.68-1.84s-3.86,.75-4.86,2.25c-1,1.5-1.5,3.42-1.5,5.77v12.88h-5.43v-25.04Z" />
                                <path class="cls-2"
                                    d="M212.68,109.13c0-1.76,.28-3.44,.85-5.05,.57-1.6,1.4-3.02,2.48-4.24,1.09-1.22,2.42-2.2,4.01-2.92,1.59-.72,3.4-1.09,5.43-1.09,2.14,0,3.99,.38,5.56,1.14,1.57,.76,2.85,1.8,3.83,3.13,.98,1.33,1.66,2.86,2.04,4.61,.38,1.74,.43,3.6,.15,5.56h-18.94c.31,2.1,1.2,3.8,2.66,5.07,1.47,1.28,3.35,1.91,5.67,1.91,.97,0,1.87-.12,2.72-.36,.84-.24,1.61-.53,2.3-.88,.69-.34,1.29-.73,1.81-1.16,.52-.43,.93-.82,1.24-1.16l2.64,4.09c-.35,.31-.82,.72-1.42,1.22-.6,.5-1.34,.98-2.23,1.45-.88,.47-1.92,.86-3.13,1.19-1.21,.33-2.62,.49-4.24,.49-2.1,0-3.98-.32-5.64-.96s-3.06-1.53-4.22-2.66c-1.16-1.14-2.04-2.51-2.66-4.11-.62-1.6-.93-3.35-.93-5.25Zm5.54-2.07l.72,.31c.24-.17,.94-.39,2.1-.65,1.16-.26,2.54-.39,4.17-.39,1,0,1.85,.03,2.56,.1,.71,.07,1.29,.16,1.73,.26,.45,.1,.8,.21,1.06,.31,.26,.1,.44,.21,.54,.31l.72-.26c0-1.1-.17-2.08-.52-2.92-.35-.85-.81-1.55-1.4-2.12-.59-.57-1.28-1-2.07-1.29-.79-.29-1.64-.44-2.54-.44-.72,0-1.49,.14-2.3,.41-.81,.28-1.55,.69-2.23,1.24-.67,.55-1.24,1.25-1.71,2.1-.47,.85-.75,1.85-.85,3.03Z" />
                                <path class="cls-2"
                                    d="M242.48,96.46h5.43l-.26,4.61h1.29c.17-.59,.45-1.19,.83-1.81,.38-.62,.89-1.18,1.53-1.68,.64-.5,1.41-.91,2.33-1.24,.91-.33,1.97-.49,3.18-.49,2.79,0,5,.92,6.62,2.77,1.62,1.85,2.43,4.44,2.43,7.79v15.11h-5.43v-13.4c0-2.55-.49-4.44-1.47-5.67-.98-1.22-2.54-1.84-4.68-1.84s-3.86,.75-4.86,2.25c-1,1.5-1.5,3.42-1.5,5.77v12.88h-5.43v-25.04Z" />
                                <path class="cls-2"
                                    d="M274.51,96.46v-10.14h5.43v6.52c0,.62-.15,1.29-.47,2.02-.31,.72-.76,1.28-1.34,1.66l.88,.98c.41-.28,.85-.52,1.32-.72,.47-.21,1.04-.31,1.73-.31h8.38v4.66h-10.5v10.87c0,1.9,.35,3.27,1.06,4.11,.71,.85,1.7,1.27,2.98,1.27,1.07,0,2.23-.31,3.49-.93,1.26-.62,2.35-1.41,3.29-2.38l2.02,4.35c-1.38,1.21-2.89,2.13-4.53,2.77-1.64,.64-3.32,.96-5.04,.96-2.66,0-4.77-.75-6.34-2.25-1.57-1.5-2.35-3.82-2.35-6.96v-11.8h-5.54v-4.66h5.54Z" />
                                <rect class="cls-2" x="172" y="89.39" width="5.34" height="4.71" />
                            </g>
                            <g>
                                <path class="cls-2"
                                    d="M212.68,142.66l1.67-2.36c.24,.27,.53,.57,.88,.88,.35,.32,.76,.61,1.24,.88,.48,.27,1.02,.5,1.63,.67,.61,.17,1.29,.26,2.06,.26,.68,0,1.28-.07,1.78-.22,.5-.14,.92-.34,1.26-.58,.33-.24,.59-.52,.76-.83,.17-.32,.26-.65,.26-1.01,0-.43-.1-.79-.31-1.09-.21-.3-.48-.56-.83-.77-.35-.21-.76-.39-1.23-.53-.47-.14-.97-.26-1.5-.38-.77-.17-1.56-.36-2.37-.56-.81-.21-1.55-.49-2.22-.86-.67-.37-1.21-.85-1.64-1.46-.43-.61-.64-1.4-.64-2.37,0-.85,.17-1.62,.51-2.31,.34-.68,.82-1.26,1.44-1.73s1.34-.83,2.18-1.09c.84-.26,1.75-.38,2.74-.38,1.42,0,2.7,.25,3.85,.74,1.15,.5,2.04,1.19,2.69,2.08l-1.95,2.08c-.15-.24-.35-.49-.59-.74-.24-.26-.54-.5-.91-.73-.37-.23-.8-.42-1.31-.56-.5-.14-1.11-.22-1.81-.22-1.28,0-2.28,.25-2.99,.74-.71,.5-1.06,1.13-1.06,1.9,0,.48,.13,.88,.4,1.19,.26,.32,.62,.58,1.08,.78,.45,.21,.97,.38,1.54,.53,.57,.15,1.17,.29,1.78,.42,.72,.17,1.43,.36,2.14,.58,.71,.21,1.35,.5,1.91,.87s1.02,.84,1.37,1.41c.35,.57,.53,1.3,.53,2.19s-.18,1.62-.53,2.31c-.35,.68-.83,1.27-1.45,1.76-.62,.49-1.36,.86-2.22,1.12-.86,.26-1.81,.38-2.83,.38-.82,0-1.61-.08-2.36-.24-.75-.16-1.44-.38-2.06-.65-.62-.27-1.18-.59-1.68-.95-.5-.36-.9-.73-1.21-1.13Z" />
                                <path class="cls-2"
                                    d="M230.58,132.91v-5.03h2.69v3.23c0,.31-.08,.64-.23,1s-.38,.63-.67,.82l.44,.49c.21-.14,.42-.26,.65-.36s.52-.15,.86-.15h4.15v2.31h-5.2v5.38c0,.94,.18,1.62,.53,2.04,.35,.42,.84,.63,1.47,.63,.53,0,1.11-.15,1.73-.46,.62-.31,1.17-.7,1.63-1.18l1,2.15c-.68,.6-1.43,1.06-2.24,1.37-.81,.32-1.65,.47-2.5,.47-1.32,0-2.36-.37-3.14-1.12-.78-.74-1.17-1.89-1.17-3.45v-5.85h-2.74v-2.31h2.74Z" />
                                <path class="cls-2"
                                    d="M241.55,140.53v-7.62h2.69v6.9c0,2.26,1.02,3.38,3.05,3.38s3.15-1.13,3.15-3.38v-6.9h2.69v12.41h-2.69l.13-2.28h-.64c-.09,.29-.22,.59-.41,.9-.19,.31-.44,.59-.76,.83-.32,.25-.7,.45-1.15,.62-.45,.16-.98,.24-1.58,.24-1.42,0-2.52-.45-3.31-1.35-.79-.9-1.18-2.15-1.18-3.76Z" />
                                <path class="cls-2"
                                    d="M255.81,139.12c0-1.03,.16-1.94,.47-2.76,.32-.81,.74-1.5,1.28-2.05s1.17-.98,1.88-1.27c.72-.29,1.48-.44,2.28-.44,1.01,0,1.85,.25,2.53,.74,.68,.5,1.14,1.1,1.4,1.82h.64l-.26-2.33v-5.72h2.69v18.2h-2.69l.26-2.26h-.64c-.26,.72-.72,1.32-1.4,1.82-.68,.5-1.52,.74-2.53,.74-.8,0-1.56-.15-2.28-.44-.72-.29-1.35-.71-1.88-1.27s-.97-1.24-1.28-2.05c-.32-.81-.47-1.73-.47-2.76Zm2.69,0c0,.58,.09,1.12,.27,1.62,.18,.5,.44,.92,.77,1.28s.73,.64,1.19,.83,.97,.29,1.54,.29,1.08-.1,1.55-.29,.87-.47,1.21-.83,.59-.79,.77-1.28c.18-.5,.27-1.03,.27-1.62s-.09-1.12-.27-1.62c-.18-.5-.44-.92-.77-1.28s-.74-.64-1.21-.83-.99-.29-1.55-.29-1.08,.1-1.54,.29-.86,.47-1.19,.83-.59,.79-.77,1.28c-.18,.5-.27,1.03-.27,1.62Z" />
                                <path class="cls-2"
                                    d="M271.88,130.86v-2.56h2.97v2.56h-2.97Zm.13,14.46l.03-12.41h2.67v12.41h-2.69Z" />
                                <path class="cls-2"
                                    d="M277.37,139.12c0-.96,.16-1.83,.47-2.63,.32-.79,.77-1.48,1.35-2.05,.58-.57,1.27-1.02,2.08-1.35,.8-.32,1.69-.49,2.67-.49s1.86,.16,2.67,.49c.8,.32,1.5,.77,2.08,1.35,.58,.57,1.03,1.26,1.35,2.05,.32,.79,.47,1.67,.47,2.63s-.16,1.81-.47,2.62c-.32,.8-.77,1.49-1.35,2.06-.58,.57-1.27,1.02-2.08,1.35-.8,.32-1.69,.49-2.67,.49s-1.86-.16-2.67-.49c-.8-.32-1.5-.77-2.08-1.35-.58-.57-1.03-1.26-1.35-2.06-.32-.8-.47-1.68-.47-2.62Zm2.64,0c0,.6,.1,1.15,.29,1.65,.2,.5,.47,.94,.81,1.29,.34,.36,.75,.64,1.23,.85,.48,.21,1.01,.31,1.59,.31s1.11-.1,1.59-.31c.48-.21,.89-.49,1.24-.85,.35-.36,.62-.79,.81-1.29,.19-.5,.28-1.06,.28-1.65s-.09-1.15-.28-1.65c-.19-.5-.46-.94-.81-1.29-.35-.36-.77-.64-1.24-.85-.48-.21-1.01-.31-1.59-.31s-1.11,.1-1.59,.31c-.48,.21-.89,.49-1.23,.85-.34,.36-.61,.79-.81,1.29-.2,.5-.29,1.06-.29,1.65Z" />
                            </g>
                        </g>
                    </g>
                </g>
            </g>
        </svg> --}}

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
{{-- <script type="text/javascript" src="{{ asset('blocks/brand-links/brand-links3781.js?ver=6.2.2') }}" --}}
{{-- id="block-acf-brand-links-js"></script> --}}
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
<script>
    $(window).on('load', function() {
        $('.loader-wrapper').fadeOut('slow');
    });
</script>

</body>

</html>
