@extends('layouts.front')

@section('content')
    <div id="page">
        <section class="page-header">
            <div id="header-animation" class="bh">
                <div class="js-parallaxheader singleimage cover-image"
                    style="background-image:url('{{ asset('images/loja/1.jpg') }}');"></div>
            </div>
        </section>
        <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up">
                    (Loja)
                </div>
                <div class="editor-content copy-l inview inview--up content-sml">
                    <p class="p1">The Loja Fabrics logo is a representation of precision and creativity. The word "Loja"
                        is elegantly written in a clean and modern font. The icon incorporates intertwining threads forming
                        an abstract fabric pattern, symbolizing the intricate and high-quality textiles produced by the
                        factory. The color palette features a soothing Light Baby Blue and a classic, versatile
                        Black.</p>
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
                            <img data-src="{{ asset('images/loja/2.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/loja/3.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/loja/4.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/loja/5.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/loja/6.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/loja/7.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/loja/8.jpg') }}" alt="" class="lazyload" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up">
                    (Brand Story + Design)
                </div>
                <div class="editor-content copy-xl inview inview--up">
                    <p class="p1">The Monvest team sees itself as the gentlemen and women of the Munich real estate
                        industry: openness, transparency, and making<span class="Apple-converted-space">  </span>real
                        estate transactions as easy as possible are the values of the company and the core of their <a
                            href="../service.html#brand-story">brand story</a>.</p>
                </div>
                <div class="editor-content copy-l inview inview--up content-sml">
                    <p class="p1">The pinstripe &#8211; the insignia of the modern gentleman &#8211; is translated into
                        the design grid on which all implementations are based.</p>
                </div>


            </div>
        </section> --}}
    </div>
@endsection
