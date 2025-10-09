@extends('layouts.front')

@section('content')
    <div id="page">
        <section class="page-header">
            <div id="header-animation" class="bh">
                <div class="js-parallaxheader singleimage cover-image"
                    style="background-image:url('{{ $project->featured_image_url }}');"></div>
            </div>
        </section>
        <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up">
                    ({{ $project->title }})
                </div>
                <div class="editor-content copy-l inview inview--up content-sml">
                    <p class="p1">{!! $project->project_summary !!}</p>
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
        {{-- Project Gallery Component --}}
        <x-project-gallery :project="$project" />

    </div>
@endsection
