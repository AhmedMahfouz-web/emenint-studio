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
                        <div class="subline inview inview--up color-white">(Help is here)</div>
                        <h1 class="inview inview--up color-white">Marketing</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up">
                    (From now)
                </div>
                <div class="editor-content copy-xl inview inview--up">
                    <p class="p1">Transform your brand with our strategic marketing services. Our holistic approach
                        ensures maximum impact in today's dynamic business world. Elevate your brand with us.</p>
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
                            <span class="top">Marketing</span>
                            <span class="bottom">Marketing Strategy</span>
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
                            Marketing <br />
                            Strategy </h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">At our innovative and forward-thinking marketing agency, we take pride in
                                    our ability to develop comprehensive marketing strategies that are meticulously tailored
                                    to align seamlessly with your unique business goals, target audience, and the
                                    ever-evolving landscape of your industry. Our approach is not just about creating
                                    campaigns; it's about crafting a dynamic roadmap that propels your brand towards
                                    sustainable growth and success.
                                </p>
                                <p class="p1">Understanding that every business is distinctive, we embark on a detailed
                                    journey to
                                    comprehend the intricacies of your organization. We delve into the core of your
                                    objectives, identifying the essence of your brand identity and values. By immersing
                                    ourselves in your business culture, we ensure that our strategies not only resonate with
                                    your vision but also encapsulate the spirit of your brand, making them
                                    authentic and resonant.</p>

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
                            <span class="top">Marketing Strategy</span>
                            <span class="bottom">Marketing Story</span>
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
                            Marketing <br />
                            Plan</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">At our forefront in the realm of marketing excellence, we take pride in
                                    not only conceptualizing comprehensive marketing strategies but also in translating
                                    these visionary plans into actionable and result-driven initiatives. Our commitment to
                                    your success extends beyond the ideation phase as we meticulously craft detailed
                                    marketing plans that serve as the blueprint for the effective implementation of your
                                    overarching strategy.</p>
                                <p class="p1">Our approach to creating these intricate marketing plans is grounded in
                                    precision and foresight. We understand that successful execution is contingent on a
                                    granular understanding of tactics, timelines, and budgets. To that end, our seasoned
                                    team of strategists and planners collaborate to create a roadmap that not only
                                    encapsulates the strategic vision but also outlines specific, measurable, and achievable
                                    steps to bring that vision to life.</p>
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
                            <span class="top">Marketing Plan</span>
                            <span class="bottom">Content Creation</span>
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
                            Content <br />
                            Creation</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">Within the fabric of our dynamic and innovative marketing agency, we
                                    boast a team of seasoned content creators whose collective expertise is devoted to the
                                    art and science of crafting compelling, resonant, and engaging content. This dedicated
                                    cadre of professionals forms the backbone of our commitment to not only attract but also
                                    retain your target audience across a multitude of platforms.</p>
                                <p class="p1">In a world inundated with information, standing out requires more than
                                    just words—it demands a strategic blend of creativity, insight, and a profound
                                    understanding of your brand and audience. Our content creators are not merely writers;
                                    they are storytellers, weaving narratives that captivate, educate, and inspire. Each
                                    piece of content is meticulously crafted to not only communicate your brand's message
                                    but to do so in a way that establishes a meaningful connection with your audience.</p>
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
                            <span class="top">Content Cration</span>
                            <span class="bottom">Storytelling</span>
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
                            Storytelling</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">In the ever-evolving landscape of contemporary business, the ability to
                                    tell a compelling and resonant brand story is not just a marketing strategy; it is the
                                    essence of forging meaningful connections with your audience. At our forefront as a
                                    dynamic and innovative marketing agency, we take pride in not only acknowledging the
                                    power of storytelling but in mastering the craft to help you narrate your brand's unique
                                    story with authenticity, depth, and impact.</p>
                                <p class="p1">Our team of dedicated storytellers doesn't just create content; they
                                    sculpt narratives that breathe life into your brand, infusing it with personality,
                                    purpose, and a distinctive identity. Every brand has a story to tell, and our mission is
                                    to uncover and articulate that narrative in a way that not only captures attention but
                                    leaves an indelible mark on the hearts and minds of your audience.</p>
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
                            <span class="top">Storytelling</span>
                            <span class="bottom">Digital Marketing</span>
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
                            Digital <br>
                            Marketing</h3>
                    </div>
                    <div class="leistungen--text flex--strech flex">
                        <div class="leistungen--text--inner">
                            <div class="copy-l editor-content inview inview--up">
                                <p class="p1">In the rapidly evolving digital landscape, establishing and maintaining a
                                    robust online presence is not just a necessity; it's a strategic imperative. At the
                                    forefront of digital innovation, our comprehensive suite of digital marketing services
                                    is meticulously designed to propel your brand to new heights in the digital realm. From
                                    social media management to cutting-edge design, content creation, media buying, and
                                    campaign ideation, our holistic approach ensures that every facet of your online
                                    presence is optimized for maximum impact and reach.</p>
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
                                <a class="btn" href="{{ route('services.category', 'services.category', 'branding') }}">
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
