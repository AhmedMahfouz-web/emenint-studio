@extends('layouts.front')

@section('seo')
    <title>{{ $project->meta_title ?? $project->title }}</title>
    <meta name="description" content="{{ $project->meta_description ?? $project->short_description }}">
@endsection

@section('content')
    <div id="page">
        <section class="page-header">
            <div id="header-animation" class="bh">
                @if(!empty($project->featured_image) && is_array($project->featured_image))
                    <picture>
                        @if(isset($project->featured_image['webp']['large']))
                            <source media="(min-width: 1200px)" srcset="{{ $project->featured_image['webp']['large'] }}" type="image/webp">
                        @endif
                        @if(isset($project->featured_image['jpeg']['large']))
                            <source media="(min-width: 1200px)" srcset="{{ $project->featured_image['jpeg']['large'] }}" type="image/jpeg">
                        @endif
                        @if(isset($project->featured_image['webp']['medium']))
                            <source media="(min-width: 768px)" srcset="{{ $project->featured_image['webp']['medium'] }}" type="image/webp">
                        @endif
                        @if(isset($project->featured_image['jpeg']['medium']))
                            <source media="(min-width: 768px)" srcset="{{ $project->featured_image['jpeg']['medium'] }}" type="image/jpeg">
                        @endif
                        @if(isset($project->featured_image['webp']['thumbnail']))
                            <source srcset="{{ $project->featured_image['webp']['thumbnail'] }}" type="image/webp">
                        @endif
                        @if(isset($project->featured_image['jpeg']['thumbnail']))
                            <source srcset="{{ $project->featured_image['jpeg']['thumbnail'] }}" type="image/jpeg">
                        @endif

                        <img src="{{ $project->featured_image['jpeg']['large'] ?? $project->featured_image['original'] }}" 
                             alt="{{ $project->title }} featured image"
                             class="js-parallaxheader singleimage cover-image"/>
                    </picture>
                @endif
            </div>
        </section>

        <section class="introtext">
            <div class="grid-width text-center">
                <div class="subline inview inview--up">
                    ({{ $project->serviceCategory->name }})
                </div>
                <div class="editor-content copy-l inview inview--up content-sml">
                    <h1>{{ $project->title }}</h1>
                    <p>{{ $project->short_description }}</p>
                </div>
            </div>
        </section>

        <section class="separator inview inview--up">
            <div class="grid-width copy-s">
                <div class="js-seperator">
                    <div class="separator--text flex">
                        <div class="flex--strech">
                            <span class="top"><span>Client</span></span>
                            <span class="bottom"><span>Date</span></span>
                        </div>
                        <div>
                            <span class="top">{{ $project->client_name }}</span>
                            <span class="bottom">{{ $project->project_date->format('F Y') }}</span>
                        </div>
                    </div>
                    <div class="separator--line inview inview--line"></div>
                </div>
            </div>
        </section>

        @if($project->project_summary)
        <section class="introtext">
            <div class="grid-width text-center">
                <div class="editor-content copy-m inview inview--up">
                    {!! $project->project_summary !!}
                </div>
            </div>
        </section>
        @endif

        {{-- Render Dynamic Blocks --}}
        @if($blocks && $blocks->count() > 0)
            @foreach($blocks as $block)
                {!! $block->render() !!}
            @endforeach
        @endif

        {{-- Legacy Project Details (Tags) --}}
        <section class="project-details-section">
             <div class="grid-width">

                <div class="tags-section inview inview--up">
                    @if($project->services_provided && count($project->services_provided) > 0)
                        <div class="tags-group">
                            <h4>Services Provided</h4>
                            @foreach($project->services_provided as $service)
                                <span class="tag">{{ $service }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($project->technologies_used && count($project->technologies_used) > 0)
                        <div class="tags-group">
                            <h4>Technologies Used</h4>
                            @foreach($project->technologies_used as $tech)
                                <span class="tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </div>
@endsection

@push('styles')
<style>
    .project-details-section {
        padding: 60px 0;
    }
    .detail-block {
        margin-bottom: 40px;
    }
    .detail-block h3 {
        font-size: 24px;
        margin-bottom: 15px;
    }
    .tags-section {
        margin-top: 40px;
        display: flex;
        gap: 40px;
    }
    .tags-group h4 {
        font-size: 18px;
        margin-bottom: 15px;
    }
    .tag {
        display: inline-block;
        background-color: #f0f0f0;
        padding: 5px 15px;
        border-radius: 15px;
        margin-right: 10px;
        margin-bottom: 10px;
        font-size: 14px;
    }
</style>
@endpush
