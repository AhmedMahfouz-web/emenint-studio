@extends('layouts.front')

@section('content')
    <div id="page">
        {{-- <section class="index-intro">
            <div class="grid-width">
                <div class="intro inview inview--up inview-home">
                    <p>Embark on <br />
                        the Journey to Glory...</p>
                </div>
            </div>
        </section> --}}

        <section class="index-page-teaser">
            <div class="grid-width">
                <a href="{{ route('about') }}" class="page-teaser">
                    <div class="page-teaser--video inview inview--up">
                        <video autoplay muted loop playsinline preload="none">
                            <source src="{{ asset('uploads/promo_eminent.mp4') }}" type="video/mp4" />
                        </video>
                    </div>
                    <div class="page-teaser--text inview">
                        <div class="subline color-white">
                            (About)
                        </div>
                        <div class="h2 color-white">
                            Embark on <br />
                            the Journey to Glory...</div>
                        <div class="magnet">
                            <div class="btn color-white">
                                <span>Get to know us</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up">
                    (About)
                </div>
                <div class="editor-content copy-xl inview inview--up">
                    <p class="p1">Welcome to Eminent Studio, a trailblazing marketing and advertising agency, we are not
                        just a service provider, we are a dedicated partner on your journey.</p>
                </div>
            </div>
        </section>

        <section class="brand-links">
            <div class="grid-width grid-width--fullwidth">
                <div class="subline inview inview--up text-center">
                    (Services)
                </div>
                <div id="js-brandslider" class="brandslider antonia">
                    <div class="flex brandslid">
                        @foreach ($data['services'] as $key => $service)
                            <a class="inview" href="{{ route('services.category', $service->slug) }}">
                                {{ $service->name }} <span class="book">[{{ $key + 1 }}]</span>
                            </a>
                        @endforeach
                        @foreach ($data['services'] as $key => $service)
                            <a class="inview" href="{{ route('services.category', $service->slug) }}">
                                {{ $service->name }} <span class="book">[{{ $key + 1 }}]</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="separator inview inview--up">
            <div class="grid-width copy-s">
                <div class="js-seperator">
                    <div class="separator--line inview inview--line"></div>
                </div>
            </div>
        </section>


        <section class="latest">
            <div class="grid-width">
                <div class="flex flex--top flex--nom">
                    @foreach ($data['projects'] as $key => $project)
                        @if ($key == 0)
                            <div class="sticky">
                                <a
                                    href="{{ route('project.show', $project->slug) }}"class="latest--big-one bh inview inview--up is-100">
                                    <div class="latest--big-one--image cover-image lazyload"
                                        data-bg="{{ Storage::url($project->featured_image) }}">
                                    </div>
                                    <div class="latest--big-one--text">
                                        <div class="subline color-white">
                                            ({{ $project->serviceCategory->name }})
                                        </div>
                                        <div class="h2 color-white">
                                            {{ $project->title }} </div>
                                        <div class="magnet">
                                            <div class="btn color-white">
                                                <span>learn more</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="latest--items flex">
                                <div class="latest--items--inner inview-section">
                                @elseif($key == 1)
                                    <div class="latest--items--heading inview inview--up">
                                        <div class="subline">
                                            (Idea, Thinking &amp; Projects)
                                        </div>
                                        <div class="h2">
                                            Show Time </div>
                                    </div>
                                    <div class="latest--items--mobile-scroll">
                                        <a href="{{ route('project.show', $project->slug) }}">
                                            <div class="inview inview--up overflow-hidden">
                                                <div class="parallax-section inview2">
                                                    <div class="parallax-section--image cover-image lazyload"
                                                        data-bg="{{ Storage::url($project->featured_image) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="inview inview--up">
                                                <div class="subline copy-m">
                                                    (Branding)
                                                </div>
                                                <div class="headline">
                                                    <span class="underline">{{ $project->title }}</span>
                                                </div>
                                                <div class="copy-m">
                                                    {{ $project->short_description }}
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('project.show', $project->slug) }}">
                                            <div class="inview inview--up overflow-hidden">
                                                <div class="parallax-section inview2">
                                                    <div class="parallax-section--image cover-image lazyload"
                                                        data-bg="{{ Storage::url($project->featured_image) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="inview inview--up">
                                                <div class="subline copy-m">
                                                    ({{ $project->serviceCategory->name }})
                                                </div>
                                                <div class="headline">
                                                    <span class="underline">{{ $project->title }}</span>
                                                </div>
                                                <div class="copy-m">{{ $project->short_description }}</div>
                                            </div>
                                        </a>
                        @endif
                    @endforeach

                </div>
            </div>
    </div>
    </div>
    </div>
    <div class="grid-width mt-0 link-box flex flex--nom text-center">
        <div class="inview inview--up">
            <div class="magnet">
                <a class="btn" href="{{ route('services.category', 'branding') }}">
                    <span> All Projects</span>
                </a>
            </div>
        </div>
    </div>
    </section>

    <section class="introtext">
        <div class="grid-width  text-center">
            <div class="subline inview inview--up">
                (Let&#8217;s be in touch)
            </div>
            <div class="editor-content copy-xl inview inview--up">
                <p class="p1">You have business. We make growth.<br />
                    It&#8217;s time to eminent your brand. Let&#8217;s talk!</p>
            </div>

            <div class="flex quicklinks">
                <div class="inview inview--up">
                    <div class="magnet">
                        <a class="btn nopagechange" href="mailto:hello@eminent-studio.com">
                            <span class="flex">
                                E-Mail </span>
                        </a>
                    </div>
                </div>
                <div class="inview inview--up">
                    <div class="magnet">
                        <a class="btn nopagechange" target="_blank" href="https://wa.me/201031375777">
                            <span class="flex">
                                WhatsApp </span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    </div>
    <!-- /page -->
@endsection
