@extends('layouts.front')

@section('css')
    <style>
        .swiper {
            overflow: show;
            position: relative;
            width: 45%;
            margin: 20px 0;
            height: 100%;
            z-index: 1;
            margin-left: unset !important;
            margin-right: unset !important;
        }

        .swiper-wrapper {
            display: flex;
            position: relative;
            align-content: flex-start;
            top: 0;
            width: 100%;
            transition: 1s;
        }

        .swiper-wrapper .swiper-slide {
            width: 100%;
            max-height: 100%;
            cursor: pointer;
            display: flex;
            flex-direction: row;
            justify-content: center;
            transition: all 1s;
            position: relative;
            border-radius: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="page">
        <section class="svg-header svg-header--project">
            <div class="svgh-bh">
                <div id="svg-animaiotn" class="inview flex flex--bottom">
                    <div class="js-parallaxheader">
                        <svg class="deaw studio" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 383.19 391.63">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: none;
                                        stroke: #2c2a2a;
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
                <div class="grid-width svgh-bh flex flex--bottom text-center">
                    <div>
                        <div class="subline inview inview--up">(Welcome to the show)</div>
                        <h1 class="inview inview--up">Advertising</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="adv-container">
            <section class="flex flex-top advertising">
                <div class=" swiper">
                    <div class=" swiper-wrapper">
                        <img class=" swiper-slide lazyload" src="{{ asset('images/visual_identity/1.jpg') }}"
                            alt="">
                        <img class=" swiper-slide lazyload" src="{{ asset('images/visual_identity/2.jpg') }}"
                            alt="">
                        <img class=" swiper-slide lazyload" src="{{ asset('images/visual_identity/3.jpg') }}"
                            alt="">
                    </div>

                </div>
                <div class="text-adv">
                    <div class="adv-header h2 output inview inview--up">Visual Identity</div>
                    <div class="copy-m"> Our creative team develops visually stunning
                        and impactful advertising visuals that effectively communicate your brand
                        message.</div>
                </div>
            </section>

            <section class="flex flex-top advertising">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <img class="swiper-slide lazyload" src="{{ asset('images/printing_solution/1.jpg') }}"
                            alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/printing_solution/2.jpg') }}"
                            alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/printing_solution/3.jpg') }}"
                            alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/printing_solution/4.jpg') }}"
                            alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/printing_solution/5.jpg') }}"
                            alt="">
                    </div>
                </div>
                <div class="text-adv">
                    <div class="adv-header h2 output inview inview--up">Printing Solutions</div>
                    <div class="copy-m">We provide printing services for various advertising
                        materials, including brochures, flyers, banners, and promotional
                        merchandise.</div>
                </div>
            </section>

            <section class="flex flex-top advertising">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <img class="swiper-slide lazyload" src="{{ asset('images/2d/1.jpg') }}" alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/2d/2.jpg') }}" alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/2d/3.jpg') }}" alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/2d/3.jpg') }}" alt="">
                    </div>
                </div>
                <div class="text-adv">
                    <div class="adv-header h2 output inview inview--up">3D Designs</div>
                    <div class="copy-m">We specialize in creating eye-catching 2D and 3D
                        designs for advertisements, ensuring your brand stands out in the
                        competitive market.
                    </div>
                </div>
            </section>

            <section class="flex flex-top advertising">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <img class="swiper-slide lazyload" src="{{ asset('images/campaign/1.jpg') }}" alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/campaign/2.jpg') }}" alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/campaign/3.jpg') }}" alt="">
                    </div>
                </div>
                <div class="text-adv">
                    <div class="adv-header h2 output inview inview--up">Campaign Visualizing</div>
                    <div class="copy-m">We bring your advertising campaigns to life
                        through captivating visual concepts that resonate with your target
                        audience and achieve campaign objectives.
                    </div>
                </div>
            </section>

            <section class="flex flex-top advertising">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <img class="swiper-slide lazyload" src="{{ asset('images/billboard/1.jpg') }}" alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/billboard/2.jpg') }}" alt="">
                    </div>
                </div>
                <div class="text-adv">
                    <div class="adv-header h2 output inview inview--up">Billboards</div>
                    <div class="copy-m">We offer strategic billboard advertising solutions, designing
                        attention-grabbing layouts to maximize visibility and impact.
                    </div>
                </div>
            </section>

            <section class="flex flex-top advertising mb-6">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <img class="swiper-slide lazyload" src="{{ asset('images/commercial/1.jpg') }}" alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/commercial/2.jpg') }}" alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/commercial/3.jpg') }}" alt="">
                        <img class="swiper-slide lazyload" src="{{ asset('images/commercial/4.jpg') }}" alt="">
                    </div>
                </div>
                <div class="text-adv ">
                    <div class="adv-header h2 output inview inview--up">Commercial Designs</div>
                    <div class="copy-m">Our team creates visually appealing commercial
                        designs for TV, radio, and online platforms, ensuring your brand message
                        reaches your desired audience effectively.
                    </div>
                </div>
            </section>
        </section>
    </div>
@endsection
