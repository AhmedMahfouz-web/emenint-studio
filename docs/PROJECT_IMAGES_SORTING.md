# Project Images Sorting Feature

## Overview
This feature allows you to manage and sort project images with a drag-and-drop interface in the Filament admin panel.

## Features
- **Sortable Images**: Drag and drop images to reorder them
- **Featured Images**: Mark specific images as featured
- **Alt Text & Captions**: Add accessibility and descriptive text
- **Image Optimization**: Automatic WebP conversion and optimization
- **Legacy Support**: Maintains compatibility with existing gallery_images field

## Database Structure

### ProjectImage Model
- `id`: Primary key
- `project_id`: Foreign key to projects table
- `image_path`: Path to the optimized image file
- `alt_text`: Alternative text for accessibility
- `caption`: Optional image caption
- `sort_order`: Integer for sorting (lower numbers appear first)
- `is_featured`: Boolean flag for featured images

## Usage

### Admin Panel
1. **Project Images Resource**: Manage all project images in `/admin/project-images`
2. **Project Form**: Use the "Project Images (Sortable)" repeater in the project edit form
3. **Drag & Drop**: Reorder images by dragging them in the repeater
4. **Featured Images**: Toggle the "Featured" switch for important images

### Frontend Integration
```php
// Get sorted project images
$project = Project::find(1);
$sortedImages = $project->sorted_project_images;

// Get image URLs as array
$imageUrls = $project->project_image_urls;

// Get only featured images
$featuredImage = $project->featuredProjectImage;
```

### Model Methods
- `projectImages()`: HasMany relationship to ProjectImage
- `featuredProjectImage()`: HasOne relationship to featured ProjectImage
- `getSortedProjectImagesAttribute()`: Get images ordered by sort_order
- `getProjectImageUrlsAttribute()`: Get array of image URLs

## Migration
Run the following commands to set up the feature:

```bash
# Create the project_images table
php artisan migrate

# Optional: Migrate existing gallery_images to new structure
# This will automatically run with the migration
```

## Legacy Support
The existing `gallery_images` field is preserved and marked as "Legacy" in the admin interface. You can gradually migrate to the new sortable system while maintaining backward compatibility.

## Technical Notes
- Images are automatically optimized and converted to WebP format
- Sort order is managed automatically when reordering in the admin panel
- Foreign key constraints ensure data integrity
- Indexes are added for optimal query performance
