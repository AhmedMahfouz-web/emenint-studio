@extends('layouts.front')

@section('content')
    <div id="page">
        <section class="index-intro">
            <div class="grid-width">
                <div class="intro inview inview--up inview-home">
                    <p>Embark on <br />
                        the Journey to Glory...</p>
                </div>
            </div>
        </section>

        <section class="index-page-teaser">
            <div class="grid-width">
                <a href="studio.html" class="page-teaser">
                    <div class="page-teaser--video inview inview--up">
                        <video autoplay muted loop playsinline preload="none">
                            <source
                                src="https://solidbold.at/wp-content/uploads/2022/08/STUDIO_Rec709A-1080p-3800kbs-v06B.mp4"
                                type="video/mp4" />
                        </video>
                    </div>
                    <div class="page-teaser--text inview">
                        <div class="subline color-white">
                            (About)
                        </div>
                        <div class="h2 color-white">
                            Brand Design <br />
                            Studio </div>
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
                    (An eminent on a mission)
                </div>
                <div class="editor-content copy-xl inview inview--up">
                    <p class="p1">to offer a transformative journey to our clients, helping them embark on a
                        new professional identity and brand. We are committed to sharing this journey with our
                        clients, fostering enduring relationships beyond project completion.</p>
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
                        <a class="inview" href="{{ route('branding') }}">
                            Branding <span class="book">[1]</span>
                        </a>
                        <a class="inview" href="{{ route('marketing') }}">
                            Marketing <span class="book">[2]</span>
                        </a>
                        <a class="inview" href="{{ route('advertising') }}">
                            Advertising <span class="book">[3]</span>
                        </a>
                        <a class="inview" href="{{ route('development') }}">
                            Development <span class="book">[4]</span>
                        </a>
                        <a class="inview" href="{{ route('ecommerce') }}">
                            E-Commerce <span class="book">[5]</span>
                        </a>
                        <a class="inview" href="{{ route('consultant') }}">
                            Connultant <span class="book">[6]</span>
                        </a>
                        <a class="inview" href="{{ route('branding') }}">
                            Branding <span class="book">[1]</span>
                        </a>
                        <a class="inview" href="{{ route('marketing') }}">
                            Marketing <span class="book">[2]</span>
                        </a>
                        <a class="inview" href="{{ route('advertising') }}">
                            Advertising <span class="book">[3]</span>
                        </a>
                        <a class="inview" href="{{ route('development') }}">
                            Development <span class="book">[4]</span>
                        </a>
                        <a class="inview" href="{{ route('ecommerce') }}">
                            E-Commerce <span class="book">[5]</span>
                        </a>
                        <a class="inview" href="{{ route('consultant') }}">
                            Connultant <span class="book">[6]</span>
                        </a>
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
                    <div class="sticky">
                        <a href="{{ route('plaza_gardens') }}"class="latest--big-one bh inview inview--up is-100">
                            <div class="latest--big-one--image cover-image lazyload"
                                data-bg="{{ asset('images/plaza_gardens/20.jpg') }}">
                            </div>
                            <div class="latest--big-one--text">
                                <div class="subline color-white">
                                    (Branding)
                                </div>
                                <div class="h2 color-white">
                                    Plaza Gardens. </div>
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
                            <div class="latest--items--heading inview inview--up">
                                <div class="subline">
                                    (Idea, Thinking &amp; Projects)
                                </div>
                                <div class="h2">
                                    Show Time </div>
                            </div>
                            <div class="latest--items--mobile-scroll">
                                <a href="{{ route('zenda') }}">
                                    <div class="inview inview--up overflow-hidden">
                                        <div class="parallax-section inview2">
                                            <div class="parallax-section--image cover-image lazyload"
                                                data-bg="{{ asset('images/zenda/1.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inview inview--up">
                                        <div class="subline copy-m">
                                            (Branding)
                                        </div>
                                        <div class="headline">
                                            <span class="underline">Zenda</span>
                                        </div>
                                        <div class="copy-m">
                                            The Zenda FinTech Solutions logo features a dynamic and modern trading mark,
                                            symbolizing innovation and financial transactions.
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('mountain_gate') }}">
                                    <div class="inview inview--up overflow-hidden">
                                        <div class="parallax-section inview2">
                                            <div class="parallax-section--image cover-image lazyload"
                                                data-bg="{{ asset('images/mountain_gate/1.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inview inview--up">
                                        <div class="subline copy-m">
                                            (Branding)
                                        </div>
                                        <div class="headline">
                                            <span class="underline">Mountaine Gate</span>
                                        </div>
                                        <div class="copy-m">The Mountain Gate Fountains logo artfully combines the
                                            silhouette of a majestic mountain peak forming a gate, with a cascading
                                            waterfall within.</div>
                                    </div>
                                </a>
                                <a href="{{ route('profit') }}">
                                    <div class="inview inview--up overflow-hidden">
                                        <div class="parallax-section inview2">
                                            <div class="parallax-section--image cover-image lazyload"
                                                data-bg="{{ asset('images/profit/1.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inview inview--up">
                                        <div class="subline copy-m">
                                            (Branding)
                                        </div>
                                        <div class="headline">
                                            <span class="underline">Profit</span>
                                        </div>
                                        <div class="copy-m">
                                            is a renowned sports company with a long and proud history. </div>
                                    </div>
                                </a>
                                <a href="{{ route('artal') }}">
                                    <div class="inview inview--up overflow-hidden">
                                        <div class="parallax-section inview2">
                                            <div class="parallax-section--image cover-image lazyload"
                                                data-bg="{{ asset('images/artal/1.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inview inview--up">
                                        <div class="subline copy-m">
                                            (Branding)
                                        </div>
                                        <div class="headline">
                                            <span class="underline">Artal</span>
                                        </div>
                                        <div class="copy-m">
                                            With their brand story, they simply get to the point: Monvest are young guns
                                            with old values in the Munich real estate market.
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('oracal') }}">
                                    <div class="inview inview--up overflow-hidden">
                                        <div class="parallax-section inview2">
                                            <div class="parallax-section--image cover-image lazyload"
                                                data-bg="{{ asset('images/oracal/3.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inview inview--up">
                                        <div class="subline copy-m">
                                            (Branding)
                                        </div>
                                        <div class="headline">
                                            <span class="underline">Oracal</span>
                                        </div>
                                        <div class="copy-m">
                                            The Oracal Studios logo is a sleek and modern representation of a film reel with
                                            the company name elegantly integrated. The film reel, in a bold and dynamic red,
                                            symbolizes the vibrant creativity and passion brought to every production.
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('loja') }}">
                                    <div class="inview inview--up overflow-hidden">
                                        <div class="parallax-section inview2">
                                            <div class="parallax-section--image cover-image lazyload"
                                                data-bg="{{ asset('images/loja/1.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="inview inview--up">
                                        <div class="subline copy-m">
                                            (Branding)
                                        </div>
                                        <div class="headline">
                                            <span class="underline">Loja
                                            </span>
                                        </div>
                                        <div class="copy-m">
                                            The Loja Fabrics logo is a representation of precision and creativity. The word
                                            "Loja" is elegantly written in a clean and modern font. </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-width link-box flex flex--nom text-center">
                <div class="inview inview--up">
                    <div class="magnet">
                        <a class="btn" href="{{ route('branding') }}">
                            <span> All Projects</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="introtext">
            <div class="grid-width text-center">
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
                            <a class="btn nopagechange" target="_blank" href="https://wa.me/201033739707">
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
