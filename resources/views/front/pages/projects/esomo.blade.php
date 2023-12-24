@extends('layouts.front')

@section('content')
    <div id="page">
        <section class="page-header">
            <div id="header-animation" class="bh">
                <div class="js-parallaxheader singleimage cover-image"
                    style="background-image:url('{{ asset('images/esomo/1.jpg') }}');"></div>
            </div>
        </section>
        <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up">
                    (esomo)
                </div>
                <h2 class="inview inview--up">
                    Built to the point. </h2>
                <div class="editor-content copy-l inview inview--up content-sml">
                    <p class="p1">With their <a href="../service.html#brand-story">brand story</a>, they simply get to
                        the point: Monvest are young guns with old values in the Munich real estate market. They proudly
                        show this in the new <a href="../service.html#brand-design">brand design</a>, proving that real
                        gentlemen and women never go out of fashion.</p>
                </div>


            </div>
        </section>

        <section class="separator inview inview--up">
            <div class="grid-width copy-s">
                <div class="js-seperator">
                    <div class="separator--text flex">
                        <div class="flex--strech">
                            <span class="top"><span>Sec.</span>(01)</span>
                            <span class="bottom"><span>Sec.</span>(02)</span>
                        </div>
                        <div>
                            <span class="top">Project Info</span>
                            <span class="bottom">Sample</span>
                        </div>
                    </div>
                    <div class="separator--line inview inview--line"></div>
                </div>
            </div>
        </section>
        <section class="bilder">
            <div class="grid-width">
                <div class="flex bilder-wrap-1 flex--nom">
                    <div class="bilder-wrap-image">
                        <div class="inview inview--up">
                            <img data-src="{{ asset('images/esomo/2.jpg') }}" alt="" class="lazyload" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bilder">
            <div class="grid-width">
                <div class="flex bilder-wrap-1 flex--nom">
                    <div class="bilder-wrap-image">
                        <div class="inview inview--up">
                            <img data-src="{{ asset('images/esomo/3.jpg') }}" alt="" class="lazyload" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bilder">
            <div class="grid-width">
                <div class="flex bilder-wrap-1 flex--nom">
                    <div class="bilder-wrap-image">
                        <div class="inview inview--up">
                            <img data-src="{{ asset('images/esomo/4.jpg') }}" alt="" class="lazyload" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
