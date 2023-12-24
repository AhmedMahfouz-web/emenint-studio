@extends('layouts.front')

@section('content')
    <div id="page">
        <section class="page-header">
            <div id="header-animation" class="bh">
                <div class="js-parallaxheader singleimage cover-image"
                    style="background-image:url('{{ asset('images/oracal/1.jpg') }}');"></div>
            </div>
        </section>
        <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up">
                    (oracal)
                </div>
                <div class="editor-content copy-l inview inview--up content-sml">
                    <p class="p1">The Oracal Studios logo is a sleek and modern representation of a film reel with the
                        company name elegantly integrated. The film reel, in a bold and dynamic red, symbolizes the vibrant
                        creativity and passion brought to every production. The black background signifies the depth,
                        sophistication, and professionalism of Oracal Studios. The logo captures the essence of storytelling
                        and film production with its minimalist yet impactful design.</p>
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
                            <img data-src="{{ asset('images/oracal/2.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/oracal/3.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/oracal/4.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/oracal/5.jpg') }}" alt="" class="lazyload" />
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
                            <img data-src="{{ asset('images/oracal/6.jpg') }}" alt="" class="lazyload" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
