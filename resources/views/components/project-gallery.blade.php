@props(['project', 'layout' => 'grid'])

{{-- Project Image Gallery Component - Grid Layout Only --}}
<div class="project-gallery-grid">
    @if ($project->projectImages && $project->projectImages->count() > 0)
        {{-- Use new sortable project images --}}
        @foreach ($project->projectImages as $projectImage)
            <div class="gallery-item">
                <img data-src="{{ $projectImage->image_url }}"
                    alt="{{ $project->title }} Gallery" class="lazyload gallery-image" />
            </div>
        @endforeach
    @elseif($project->gallery_images && count($project->gallery_images) > 0)
        {{-- Legacy fallback --}}
        @foreach ($project->gallery_images as $galleryImage)
            <div class="gallery-item">
                <img data-src="{{ asset('storage/' . $galleryImage) }}" alt="{{ $project->title }} Gallery"
                    class="lazyload gallery-image" />
            </div>
        @endforeach
    @endif
</div>
