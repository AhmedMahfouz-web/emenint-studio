@extends('layouts.front')

@section('content')
    <div id="page">
        <section class="page-header">
            <div id="header-animation">
                <div class="js-parallaxheader singleimage cover-image"
                    style="background-image:url({{ asset('/uploads/2022/07/eminent_image.jpg') }});">
                </div>
                <div class="grid-width bh flex text-center black-bg">
                    <div class="js-parallaxheader-text">
                        <div class="subline inview inview--up color-white">(No product without)</div>
                        <h1 class="inview inview--up color-white">E-Commerce</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up">
                    (It's time to sell !)
                </div>
                <div class="editor-content copy-xl inview inview--up">
                    <p class="p1">Transform your online presence with our e-commerce expertise! Specializing in Shopify,
                        Salla, ZId, and Fathershops platforms, we craft seamless, secure, and visually stunning online
                        stores. Elevate your brand with our tailored solutions, ensuring optimal functionality and a
                        delightful shopping experience for your customers.</p>
                </div>


            </div>
        </section>

        <section id="brand-strategy" class="separator inview inview--up">
            <div class="grid-width copy-s">
                <div class="js-seperator">
                    <div class="separator--text flex">
                        <div class="flex--strech">
                            <span class="top"><span>Sec.</span>(01)</span>
                            <span class="bottom"><span>Sec.</span>(02)</span>
                        </div>
                        <div>
                            <span class="top">E-commerce</span>
                            <span class="bottom">Shopify</span>
                        </div>
                    </div>
                    <div class="separator--line inview inview--line"></div>
                </div>
            </div>
        </section>

        <section class="leistungen">
            <div class="grid-width">
                <div class="flex flex--left flex--nom">
                    <div class="sticky">
                        <div class="subline inview inview--up">
                            (01)
                        </div>
                        <h3 class="h2 inview inview--up">
                            Shopify </h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">We specialize in building and customizing Shopify e-commerce stores,
                                    ensuring seamless functionality, attractive designs, and secure payment gateways.
                                </p>

                            </div>
                            {{-- <div class="subline inview inview--up">
                                (Performance Pillars)
                            </div>
                            <div class="leistungsbausteine">
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#">
                                            <span>
                                                Overview </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#brand-audit">
                                            <span>
                                                Brand Audit </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#brand-audience">
                                            <span>
                                                Audience </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#marken-kern">
                                            <span>
                                                Brandcore </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#brand-essence">
                                            <span>
                                                Brand Essence </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#brand-purpose">
                                            <span>
                                                Purpose </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#vision_mission">
                                            <span>
                                                Vision &amp; Mission </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#brand-values">
                                            <span>
                                                Values </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#markenversprechen">
                                            <span>
                                                Brand Promise </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#brand-research">
                                            <span>
                                                Research &amp; Trends </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-strategy.html#brand-positioning">
                                            <span>
                                                Positioning </span>
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
        </section>

        <section id="brand-story" class="separator inview inview--up">
            <div class="grid-width copy-s">
                <div class="js-seperator">
                    <div class="separator--text flex">
                        <div class="flex--strech">
                            <span class="top"><span>Sec.</span>(02)</span>
                            <span class="bottom"><span>Sec.</span>(03)</span>
                        </div>
                        <div>
                            <span class="top">Shopify</span>
                            <span class="bottom">Salla</span>
                        </div>
                    </div>
                    <div class="separator--line inview inview--line"></div>
                </div>
            </div>
        </section>

        <section class="leistungen">
            <div class="grid-width">
                <div class="flex flex--left flex--nom">
                    <div class="sticky">
                        <div class="subline inview inview--up">
                            (02)
                        </div>
                        <h3 class="h2 inview inview--up">
                            Salla</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">Our team creates professional and user-friendly e-commerce shops using the
                                    Salla platform, providing a seamless online shopping experience for your customers.</p>
                            </div>
                            {{-- <div class="subline inview inview--up">
                                (Performance Pillars)
                            </div>
                            <div class="leistungsbausteine">
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#">
                                            <span>
                                                Overview </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#brand-narrative">
                                            <span>
                                                Brand Narrative </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#finale-brand-story">
                                            <span>
                                                Brand Story </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#schluesselthemen">
                                            <span>
                                                Key Themes </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#unterthemen">
                                            <span>
                                                Sub Themes </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#themen-story">
                                            <span>
                                                Theme Story </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#mitbewerberstory-analyse">
                                            <span>
                                                Competitor Story Analysis </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#brand-szenario">
                                            <span>
                                                Scenario </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#tone-of-voice">
                                            <span>
                                                Tone of Voice </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#brand-name">
                                            <span>
                                                Naming </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="__trashed.html#claim-slogan">
                                            <span>
                                                Slogan &amp; Claim </span>
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
        </section>

        <section id="brand-design" class="separator inview inview--up">
            <div class="grid-width copy-s">
                <div class="js-seperator">
                    <div class="separator--text flex">
                        <div class="flex--strech">
                            <span class="top"><span>Sec.</span>(03)</span>
                            <span class="bottom"><span>Sec.</span>(04)</span>
                        </div>
                        <div>
                            <span class="top">Salla</span>
                            <span class="bottom">Zid</span>
                        </div>
                    </div>
                    <div class="separator--line inview inview--line"></div>
                </div>
            </div>
        </section>

        <section class="leistungen">
            <div class="grid-width">
                <div class="flex flex--left flex--nom">
                    <div class="sticky">
                        <div class="subline inview inview--up">
                            (03)
                        </div>
                        <h3 class="h2 inview inview--up">
                            Zid</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">We leverage the Zed platform to build robust and customized e-commerce
                                    shops, offering scalability, flexibility, and extensive customization options.</p>
                            </div>
                            {{-- <div class="subline inview inview--up">
                                (Performance Pillars)
                            </div>
                            <div class="leistungsbausteine">
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#">
                                            <span>
                                                Overview </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#brand-design-audit">
                                            <span>
                                                Brand Design Audit </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#creative-idea">
                                            <span>
                                                Creative Guiding Principle </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#brand-logo">
                                            <span>
                                                Logo </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#brand-typography">
                                            <span>
                                                Typography </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#brand-imagery">
                                            <span>
                                                Imagery </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#brand-illustration">
                                            <span>
                                                Illustration </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#brand-colors">
                                            <span>
                                                Color Palette </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#brand-iconography">
                                            <span>
                                                Design Language </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#brand-materials">
                                            <span>
                                                Material Concept </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-design.html#motion-branding">
                                            <span>
                                                Motion Branding </span>
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
        </section>

        <section id="brand-experience" class="separator inview inview--up">
            <div class="grid-width copy-s">
                <div class="js-seperator">
                    <div class="separator--text flex">
                        <div class="flex--strech">
                            <span class="top"><span>Sec.</span>(04)</span>
                            <span class="bottom"><span>Sec.</span>(05)</span>
                        </div>
                        <div>
                            <span class="top">Zid</span>
                            <span class="bottom">Fathershops</span>
                        </div>
                    </div>
                    <div class="separator--line inview inview--line"></div>
                </div>
            </div>
        </section>

        <section class="leistungen">
            <div class="grid-width">
                <div class="flex flex--left flex--nom">
                    <div class="sticky">
                        <div class="subline inview inview--up">
                            (04)
                        </div>
                        <h3 class="h2 inview inview--up">
                            Fathershops</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">We utilize the Fathershops platform to develop feature-rich and visually
                                    appealing e-commerce stores, optimizing them for conversions and customer satisfaction.
                                </p>
                            </div>
                            {{-- <div class="subline inview inview--up">
                                (Performance Pillars)
                            </div>
                            <div class="leistungsbausteine">
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-experience.html#">
                                            <span>
                                                Overview </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-experience.html#website">
                                            <span>
                                                Website </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-experience.html#content-redaktion">
                                            <span>
                                                Content &amp; Editing </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-experience.html#packaging-design">
                                            <span>
                                                Packaging </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-experience.html#editorial-design">
                                            <span>
                                                Editorial Design </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-experience.html#signage">
                                            <span>
                                                Signage </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-experience.html#fotoshooting">
                                            <span>
                                                Photo Shoot </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="inview inview--up">
                                    <div class="magnet">
                                        <a class="btn btn-s" href="brand-experience.html#imagefilme">
                                            <span>
                                                Image Film </span>
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
        </section>

        <section class="separator inview inview--up">
            <div class="grid-width copy-s">
                <div class="js-seperator">
                    <div class="separator--text flex">
                        <div class="flex--strech">
                            <span class="top"><span>Sec.</span>(05)</span>
                            <span class="bottom"><span>Sec.</span>(06)</span>
                        </div>
                        <div>
                            <span class="top">Fathershops</span>
                            <span class="bottom">Services</span>
                        </div>
                    </div>
                    <div class="separator--line inview inview--line"></div>
                </div>
            </div>
        </section>

        <section class="page-teaser-wrapper">
            <div class="grid-width grid-width--fullwidth">
                <div class="flex flex--nom">
                    <div class="page-teaser-wrapper--link inview inview--line-down flex hbh text-center">
                        <div class="page-teaser-wrapper--link--inner inview inview--up">
                            <div class="subline">
                                (Welcome to the show)
                            </div>
                            <div class="h3">
                                Branding </div>
                            <div class="text-wrapper">Elevate your brand with our services: unique name selection,
                                strategic positioning, captivating logo design, cohesive identity, and comprehensive
                                guidelines for consistent, memorable, and impactful brand presence. </div>
                            <div class="magnet">
                                <a class="btn" href="{{ route('services.category', 'branding') }}">
                                    <span>learn more</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="page-teaser-wrapper--link inview flex hbh text-center">
                        <div class="page-teaser-wrapper--link--inner inview inview--up">
                            <div class="subline">
                                (Hello world)
                            </div>
                            <div class="h3">
                                Development</div>
                            <div class="text-wrapper">
                                Comprehensive web & app solutions: user-friendly websites, custom mobile apps, UI/UX design,
                                tech support, admin dashboards, and interactive training systems.</div>
                            <div class="magnet">
                                <a class="btn" href="{{ route('services.category', 'development') }}">
                                    <span>learn more</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
