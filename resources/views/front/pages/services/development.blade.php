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
                        <div class="subline inview inview--up color-white">(Hello world)</div>
                        <h1 class="inview inview--up color-white">Development</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up" style="text-transform: lowercase">
                    (&#10094;div&#10095; <span style="text-transform: uppercase"> We develop</span>
                    &#10094;/div&#10095;)
                </div>
                <div class="editor-content copy-xl inview inview--up">
                    <p class="p1">Crafting exquisite websites, bespoke mobile applications, and refined UI/UX designs.
                        Elevate your digital presence with our technical support, seamless admin dashboards, and opulent
                        interactive training systems for a truly distinguished experience.</p>
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
                            <span class="top">Development</span>
                            <span class="bottom">Website Development</span>
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
                            Website <br />
                            Development </h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">Elevate your online presence with our website development expertise. We
                                    meticulously craft visually stunning and user-friendly websites, excelling in both
                                    front-end and back-end development. Utilizing the latest technologies and industry best
                                    practices, we ensure your digital platform not only meets but exceeds expectations.

                                </p>
                                <p class="p1">Our commitment to excellence guarantees a seamless and engaging user
                                    experience, setting your website apart in today's competitive landscape.</p>

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
                            <span class="top">Website Development</span>
                            <span class="bottom">App Development</span>
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
                            App <br />
                            Development</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">Delivering tailored excellence in app development, we create bespoke
                                    mobile applications for iOS and Android. Our commitment extends beyond aesthetics,
                                    focusing on seamless user experiences and robust functionalities.</p>
                                <p class="p1">Trust us to bring your vision to life with precision and innovation.</p>
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
                            <span class="top">App Development</span>
                            <span class="bottom">UI & UX Design</span>
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
                            UI & UX <br />
                            Design</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">Immerse your audience in a world of intuitive design with our UI & UX
                                    expertise. Our talented designers craft not just interfaces, but experiences that
                                    captivate. From seamless navigation to engaging visuals, we prioritize usability,
                                    ensuring every interaction enhances customer satisfaction. With a keen eye for detail
                                    and innovation, we go beyond aesthetics, creating designs that resonate and elevate your
                                    brand's digital journey.</p>
                                <p class="p1">Trust us to transform your vision into a captivating user experience,
                                    setting your platform apart in the competitive digital landscape.</p>
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
                            <span class="top">UI & UX Design</span>
                            <span class="bottom">Technical Support</span>
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
                            Technical <br>
                            Support</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">Rely on our dedicated technical support for sustained digital excellence.
                                    We offer comprehensive ongoing services, ensuring your website or application runs
                                    seamlessly. Our expert team is committed to proactive maintenance, swiftly addressing
                                    any issues to uphold optimal performance. With a focus on efficiency, we provide a
                                    reliable support system, allowing you to navigate the digital realm confidently.
                                </p>
                                <p class="p1">Partner with us for continuous, hassle-free operation and a steadfast
                                    commitment to the smooth functioning of your digital assets.</p>
                                <p>&nbsp;</p>
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
                            <span class="top">echnical Support</span>
                            <span class="bottom">Admin Dashboard</span>
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
                            Admin <br>
                            Dashboard</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">Empower your digital command center with our bespoke admin dashboards. We
                                    specialize in designing and developing intuitive platforms that put you in control.
                                    Effortlessly manage and monitor your website or application's performance, content, and
                                    user data. Our meticulously crafted dashboards provide real-time insights, enabling
                                    informed decision-making and streamlined operations.
                                </p>
                                <p class="p1">Experience the ease of navigating complex data landscapes with
                                    user-friendly interfaces tailored to your unique needs. Elevate your administrative
                                    capabilities and amplify efficiency with our cutting-edge solutions.
                                </p>
                                <p>&nbsp;</p>
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
                            <span class="top">Admin Dashboard</span>
                            <span class="bottom">Training System</span>
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
                            Training <br>
                            System</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">Transform learning into a captivating journey with our interactive
                                    training systems and e-learning platforms. Tailored for both employees and customers,
                                    our solutions redefine education. Immerse your audience in engaging experiences designed
                                    for optimal comprehension and skill retention. Our commitment to effectiveness blends
                                    seamlessly with innovation, ensuring your training initiatives are not only informative
                                    but also enjoyable.
                                </p>
                                <p class="p1">Experience the future of education with our advanced platforms, fostering
                                    continuous growth and expertise among your team or clientele.
                                </p>
                                <p>&nbsp;</p>
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
                            <span class="top">Digital Marketing</span>
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
                                <a class="btn" href="{{ route('branding') }}">
                                    <span>learn more</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="page-teaser-wrapper--link inview flex hbh text-center">
                        <div class="page-teaser-wrapper--link--inner inview inview--up">
                            <div class="subline">
                                (We're Together)
                            </div>
                            <div class="h3">
                                Consultant</div>
                            <div class="text-wrapper">
                                Our team offers expert guidance and strategic insights to streamline your marketing
                                endeavors, enhance brand visibility, and attain your business goals effectively.
                            </div>
                            <div class="magnet">
                                <a class="btn" href="{{ route('consultant') }}">
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
