@props(['project', 'showCaptions' => true, 'layout' => 'default'])

{{-- Project Image Gallery Component --}}
@if($project->projectImages && $project->projectImages->count() > 0)
    {{-- Use new sortable project images --}}
    @foreach ($project->projectImages as $projectImage)
        @if($layout === 'grid')
            <div class="gallery-item">
                <img data-src="{{ $projectImage->image_url }}" 
                     alt="{{ $projectImage->alt_text ?: $project->title . ' Gallery' }}"
                     class="lazyload gallery-image" />
                @if($showCaptions && $projectImage->caption)
                    <div class="image-caption">{{ $projectImage->caption }}</div>
                @endif
            </div>
        @else
            {{-- Default layout (sections) --}}
            <section class="bilder">
                <div class="grid-width">
                    <div class="flex bilder-wrap-1 flex--nom">
                        <div class="bilder-wrap-image">
                            <div class="inview inview--up">
                                <img data-src="{{ $projectImage->image_url }}" 
                                     alt="{{ $projectImage->alt_text ?: $project->title . ' Gallery' }}"
                                     class="lazyload" />
                                @if($showCaptions && $projectImage->caption)
                                    <div class="image-caption">{{ $projectImage->caption }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@elseif($project->gallery_images && count($project->gallery_images) > 0)
    {{-- Legacy fallback --}}
    @foreach ($project->gallery_images as $galleryImage)
        @if($layout === 'grid')
            <div class="gallery-item">
                <img data-src="{{ asset('storage/' . $galleryImage) }}" 
                     alt="{{ $project->title }} Gallery"
                     class="lazyload gallery-image" />
            </div>
        @else
            <section class="bilder">
                <div class="grid-width">
                    <div class="flex bilder-wrap-1 flex--nom">
                        <div class="bilder-wrap-image">
                            <div class="inview inview--up">
                                <img data-src="{{ asset('storage/' . $galleryImage) }}" 
                                     alt="{{ $project->title }} Gallery"
                                     class="lazyload" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@endif
