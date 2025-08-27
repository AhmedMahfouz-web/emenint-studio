@extends('layouts.front')

@section('title', $project->seo_title)
@section('description', $project->seo_description)
@section('keywords', $project->seo_keywords)

@section('content')
<div id="page">
    <div class="project-container" style="--primary-color: {{ $project->serviceCategory->color_scheme['primary'] ?? '#003bf4' }}">
        @foreach($blocks as $blockContent)
            <div class="block-wrapper block-{{ $blockContent->templateBlock->block_type }}" 
                 data-block-id="{{ $blockContent->id }}">
                {!! $blockContent->render() !!}
            </div>
            
            @if($blockContent->custom_css)
                <style>
                    [data-block-id="{{ $blockContent->id }}"] {
                        {!! $blockContent->custom_css !!}
                    }
                </style>
            @endif
        @endforeach
    </div>
</div>
@endsection
