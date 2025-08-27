# Eminent Studio - Dynamic Project Management Plan

## Overview
Transform the static project showcase and job system into a dynamic, database-driven system manageable through the Filament admin dashboard. This is an agency website showcasing past work and services.

## Current Analysis
- **Static Portfolio**: 12 individual project routes showcasing past agency work
- **Service Categories**: Projects span different service types (branding, web development, marketing, ecommerce)
- **Static Structure**: Each project has its own route and view file with unique styling per category
- **No Database**: All portfolio content is hardcoded in templates

## Phase 1: Database Schema & Models

### 1.1 Service Categories System
**Migration: `create_service_categories_table`**
```sql
- id (primary key)
- name (string, required) // 'Branding', 'Web Development', 'Marketing', 'E-commerce'
- slug (string, unique, required) // 'branding', 'web-development', 'marketing', 'ecommerce'
- description (text, nullable)
- icon (string, nullable) // Icon class or SVG path
- color_scheme (json, nullable) // Primary colors for this category
- template_name (string, required) // 'branding', 'web_development', 'marketing', 'ecommerce'
- sort_order (integer, default: 0)
- is_active (boolean, default: true)
- created_at, updated_at
```

**Model: `App\Models\ServiceCategory`**
- Relationships: hasMany(Project)
- Scopes: active(), ordered()
- Casts: color_scheme as array
- Methods: getTemplateView(), getColorScheme()

### 1.2 Portfolio Projects System
**Migration: `create_projects_table`**
```sql
- id (primary key)
- service_category_id (foreign key to service_categories)
- title (string, required)
- slug (string, unique, required)
- description (text, nullable)
- short_description (string, nullable)
- client_name (string, required) // Agency past work client
- project_summary (text, nullable) // What was delivered
- challenge (text, nullable) // Client's challenge
- solution (text, nullable) // How agency solved it
- results (text, nullable) // Outcomes achieved
- status (enum: 'active', 'inactive', 'featured')
- featured_image (string, nullable)
- gallery_images (json, nullable)
- project_url (string, nullable) // Live site URL
- completion_date (date, nullable)
- duration (string, nullable) // "3 months", "6 weeks"
- technologies_used (json, nullable)
- services_provided (json, nullable) // What services were delivered
- sort_order (integer, default: 0)
- meta_title (string, nullable)
- meta_description (text, nullable)
- created_at, updated_at
```

**Model: `App\Models\Project`**
- Relationships: belongsTo(ServiceCategory)
- Scopes: active(), featured(), byCategory()
- Mutators: slug auto-generation
- Casts: gallery_images, technologies_used, services_provided as arrays

## Dynamic Frontend Styling Strategy

### Template-Based Category Rendering
Each service category will have its own template with unique styling:

**Template Structure:**
```
resources/views/front/categories/
├── branding.blade.php          // Branding projects template
├── web-development.blade.php   // Web dev projects template  
├── marketing.blade.php         // Marketing projects template
└── ecommerce.blade.php         // E-commerce projects template
```

**Controller Logic:**
```php
// In ProjectController
public function show($slug)
{
    $project = Project::with('serviceCategory')
        ->where('slug', $slug)
        ->where('status', 'active')
        ->firstOrFail();
    
    // Get the template name from the service category
    $template = 'front.categories.' . $project->serviceCategory->template_name;
    
    return view($template, compact('project'));
}
```

**Service Category Template Configuration:**
- **Branding**: Creative layouts, large imagery, color palettes showcase
- **Web Development**: Code snippets, tech stack display, responsive previews
- **Marketing**: Campaign metrics, before/after comparisons, ROI displays
- **E-commerce**: Product showcases, conversion metrics, sales data

**Dynamic Styling Approach:**
1. **CSS Variables**: Each category injects its color scheme as CSS variables
2. **Template Inheritance**: Base template with category-specific sections
3. **Component System**: Reusable components with category-aware styling

## Dynamic Template Editing System

### Template Builder Architecture
Allow agency to edit templates through dashboard without code changes:

### 1.4 Template Blocks System
**Migration: `create_template_blocks_table`**
```sql
- id (primary key)
- service_category_id (foreign key to service_categories)
- block_type (enum: 'hero', 'gallery', 'description', 'challenge_solution', 'results', 'tech_stack', 'testimonial', 'cta')
- block_name (string, required) // 'Hero Section', 'Project Gallery'
- content_schema (json) // Defines what fields this block has
- default_content (json) // Default values for the block
- html_template (text) // Blade template code for this block
- css_styles (text, nullable) // Custom CSS for this block
- sort_order (integer, default: 0)
- is_active (boolean, default: true)
- created_at, updated_at
```

**Model: `App\Models\TemplateBlock`**
- Relationships: belongsTo(ServiceCategory), hasMany(ProjectBlockContent)
- Casts: content_schema, default_content as arrays
- Methods: renderBlock($project), validateContent($data)

### 1.5 Project Block Content System
**Migration: `create_project_block_contents_table`**
```sql
- id (primary key)
- project_id (foreign key to projects)
- template_block_id (foreign key to template_blocks)
- content_data (json) // Actual content for this block on this project
- custom_css (text, nullable) // Project-specific CSS overrides
- is_visible (boolean, default: true)
- sort_order (integer, default: 0)
- created_at, updated_at
```

**Model: `App\Models\ProjectBlockContent`**
- Relationships: belongsTo(Project), belongsTo(TemplateBlock)
- Casts: content_data as array
- Methods: render(), getProcessedContent()

### Template Block Types & Schemas

**Hero Block Schema:**
```json
{
  "fields": {
    "title": {"type": "text", "required": true, "label": "Hero Title"},
    "subtitle": {"type": "text", "required": false, "label": "Subtitle"},
    "background_image": {"type": "image", "required": false, "label": "Background Image"},
    "overlay_opacity": {"type": "range", "min": 0, "max": 100, "default": 50, "label": "Overlay Opacity"}
  }
}
```

**Gallery Block Schema:**
```json
{
  "fields": {
    "layout": {"type": "select", "options": ["grid", "masonry", "carousel"], "default": "grid", "label": "Gallery Layout"},
    "columns": {"type": "select", "options": [2, 3, 4], "default": 3, "label": "Columns"},
    "show_captions": {"type": "boolean", "default": true, "label": "Show Image Captions"}
  }
}
```

**Challenge/Solution Block Schema:**
```json
{
  "fields": {
    "layout": {"type": "select", "options": ["side_by_side", "stacked"], "default": "side_by_side", "label": "Layout Style"},
    "challenge_icon": {"type": "icon_picker", "required": false, "label": "Challenge Icon"},
    "solution_icon": {"type": "icon_picker", "required": false, "label": "Solution Icon"},
    "background_color": {"type": "color", "default": "#f8f9fa", "label": "Background Color"}
  }
}
```

## Filament Dashboard Resources for Template Management

### 2.0 Template Block Resource (`App\Filament\Resources\TemplateBlockResource`)
**Features:**
- Visual template block builder
- Schema editor with field types
- HTML template editor with syntax highlighting
- CSS editor with live preview
- Block reordering with drag-and-drop

**Form Fields:**
- Select: service_category_id, block_type
- TextInput: block_name
- CodeEditor: html_template (Blade syntax)
- CodeEditor: css_styles (CSS syntax)
- KeyValue: content_schema (dynamic field builder)
- KeyValue: default_content
- Toggle: is_active
- TextInput: sort_order

**Table Columns:**
- TextColumn: block_name, serviceCategory.name, block_type
- BadgeColumn: is_active
- TextColumn: projects_using_count (computed)

### 2.1 Enhanced Project Resource with Block Builder
**Additional Features:**
- **Block Builder Tab**: Drag-and-drop interface for arranging blocks
- **Content Editor**: Dynamic forms based on block schemas
- **Live Preview**: Real-time preview of project page
- **Template Inheritance**: Choose base template then customize blocks

**Block Builder Interface:**
```
┌─────────────────────────────────────┐
│ Available Blocks        │ Page Layout │
├─────────────────────────┼─────────────┤
│ □ Hero Section         │ ┌─────────┐ │
│ □ Project Gallery      │ │ Hero    │ │
│ □ Challenge/Solution   │ └─────────┘ │
│ □ Results & Metrics    │ ┌─────────┐ │
│ □ Tech Stack          │ │ Gallery │ │
│ □ Testimonial         │ └─────────┘ │
│ □ Call to Action      │ ┌─────────┐ │
└─────────────────────────│ │ CTA     │ │
                         │ └─────────┘ │
                         └─────────────┘
```

## Template Rendering System

### Dynamic Template Engine
**Controller Logic:**
```php
public function show($slug)
{
    $project = Project::with(['serviceCategory', 'blockContents.templateBlock'])
        ->where('slug', $slug)
        ->where('status', 'active')
        ->firstOrFail();
    
    // Get ordered blocks for this project
    $blocks = $project->blockContents()
        ->where('is_visible', true)
        ->orderBy('sort_order')
        ->get();
    
    return view('front.project-detail', compact('project', 'blocks'));
}
```

**Universal Project Template:**
```blade
{{-- resources/views/front/project-detail.blade.php --}}
@extends('layouts.front')

@section('content')
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
@endsection
```

### Block Rendering System
**TemplateBlock Model Methods:**
```php
public function renderBlock($project, $content_data = [])
{
    // Merge default content with project-specific content
    $data = array_merge($this->default_content, $content_data);
    $data['project'] = $project;
    
    // Process the Blade template
    return Blade::render($this->html_template, $data);
}
```

**Example Hero Block Template:**
```blade
<section class="hero-section" style="background-image: url('{{ $background_image ?? '' }}')">
    <div class="hero-overlay" style="opacity: {{ ($overlay_opacity ?? 50) / 100 }}"></div>
    <div class="hero-content">
        <h1 class="hero-title">{{ $title ?? $project->title }}</h1>
        @if($subtitle)
            <p class="hero-subtitle">{{ $subtitle }}</p>
        @endif
    </div>
</section>
```

## Agency Template Management Workflow

### 1. Template Setup (One-time)
- Admin creates service categories (Branding, Web Dev, etc.)
- System creates default template blocks for each category
- Admin customizes block templates and styling

### 2. Project Creation
- Select service category
- System loads available blocks for that category
- Drag-and-drop blocks to arrange layout
- Fill in content for each block
- Preview and publish

### 3. Template Customization
- Edit block HTML templates through dashboard
- Modify CSS styling with live preview
- Create new block types as needed
- Reorder blocks across all projects in category

### Benefits of This System
1. **No Code Changes**: Agency can modify templates entirely through dashboard
2. **Consistent Branding**: Each category maintains its visual identity
3. **Flexible Layouts**: Mix and match blocks per project
4. **Content Management**: Easy content updates without touching design
5. **Scalable**: Add new block types and categories as needed

## Frontend Component Integration Guide

### Step 1: Analyze Existing Project Templates
**What You Need to Do:**
1. **Identify Common Sections** across your 12 static project pages:
   - Hero sections with different layouts
   - Project galleries/image showcases
   - Challenge/Solution blocks
   - Results/metrics sections
   - Technology stacks
   - Call-to-action sections

2. **Extract Reusable HTML Structures** from each section:
   ```html
   <!-- Example: Hero section from existing project -->
   <section class="hero-branding">
     <div class="hero-content">
       <h1>{{ TITLE_PLACEHOLDER }}</h1>
       <p>{{ SUBTITLE_PLACEHOLDER }}</p>
       <img src="{{ IMAGE_PLACEHOLDER }}" alt="{{ ALT_PLACEHOLDER }}">
     </div>
   </section>
   ```

3. **Identify Variable Content** in each section:
   - Text content (titles, descriptions)
   - Images and media
   - Colors and styling options
   - Layout variations

### Step 2: Create Component Templates
**For Each Identified Section:**

**A. Create Blade Template Fragments**
```blade
{{-- resources/views/components/blocks/hero-branding.blade.php --}}
<section class="hero-branding" style="background-color: {{ $background_color ?? '#ffffff' }}">
    <div class="hero-content">
        <h1 class="hero-title">{{ $title }}</h1>
        @if($subtitle)
            <p class="hero-subtitle">{{ $subtitle }}</p>
        @endif
        @if($hero_image)
            <img src="{{ $hero_image }}" alt="{{ $image_alt ?? $title }}" class="hero-image">
        @endif
        @if($cta_text && $cta_link)
            <a href="{{ $cta_link }}" class="btn btn-primary">{{ $cta_text }}</a>
        @endif
    </div>
</section>
```

**B. Define Content Schema for Dashboard**
```json
{
  "title": {
    "type": "text",
    "label": "Hero Title",
    "required": true,
    "placeholder": "Enter project title"
  },
  "subtitle": {
    "type": "textarea", 
    "label": "Hero Subtitle",
    "required": false,
    "rows": 3
  },
  "hero_image": {
    "type": "file_upload",
    "label": "Hero Image",
    "accept": "image/*",
    "required": false
  },
  "background_color": {
    "type": "color_picker",
    "label": "Background Color",
    "default": "#ffffff"
  },
  "cta_text": {
    "type": "text",
    "label": "Call to Action Text",
    "required": false
  },
  "cta_link": {
    "type": "url",
    "label": "Call to Action Link", 
    "required": false
  }
}
```

### Step 3: Component Categories by Project Type

**Branding Projects Components:**
- `hero-branding` - Brand-focused hero with logo showcase
- `brand-identity` - Logo variations and color palettes
- `brand-applications` - Business cards, letterheads, etc.
- `brand-guidelines` - Typography and usage rules

**Web Development Components:**
- `hero-website` - Website mockup hero
- `tech-stack` - Technologies used grid
- `features-showcase` - Website features list
- `responsive-demo` - Mobile/desktop previews

**Marketing Components:**
- `hero-campaign` - Campaign-focused hero
- `metrics-results` - Performance statistics
- `campaign-gallery` - Ad creatives showcase
- `roi-breakdown` - Return on investment charts

### Step 4: Dashboard Integration Workflow

**What the System Will Provide:**
1. **Template Block Manager** - Add/edit component templates
2. **Schema Builder** - Define form fields for each component
3. **Content Editor** - Fill component data per project
4. **Preview System** - See changes in real-time

**Your Workflow:**
1. **Extract** HTML sections from existing projects
2. **Convert** static content to Blade variables (`{{ $variable }}`)
3. **Define** content schema (what fields appear in dashboard)
4. **Upload** template and schema through dashboard
5. **Test** with sample content

### Step 5: Migration Strategy

**Phase 1: Create Base Components**
- Extract 5-6 most common section types
- Create templates for primary service category (e.g., Branding)
- Test with 1-2 existing projects

**Phase 2: Expand Component Library**
- Add variations for other service categories
- Create specialized components for unique sections
- Migrate remaining static projects

**Phase 3: Advanced Features**
- Add conditional logic to templates
- Create component variations and themes
- Implement advanced layout options

### Example: Converting Existing Hero Section

**Before (Static HTML):**
```html
<section class="hero-section bg-blue">
  <h1>Luxury Hotel Branding</h1>
  <p>Complete brand identity for premium hospitality</p>
  <img src="/images/hotel-logo.jpg" alt="Hotel Logo">
</section>
```

**After (Dynamic Template):**
```blade
<section class="hero-section" style="background-color: {{ $bg_color ?? '#003bf4' }}">
  <h1>{{ $title }}</h1>
  @if($description)
    <p>{{ $description }}</p>
  @endif
  @if($featured_image)
    <img src="{{ $featured_image }}" alt="{{ $image_alt ?? $title }}">
  @endif
</section>
```

**Dashboard Schema:**
```json
{
  "title": {"type": "text", "label": "Project Title", "required": true},
  "description": {"type": "textarea", "label": "Project Description"},
  "featured_image": {"type": "file_upload", "label": "Featured Image"},
  "bg_color": {"type": "color_picker", "label": "Background Color", "default": "#003bf4"}
}
```

### Component Development Tools

**Filament Form Components You'll Use:**
- `TextInput` - Single line text
- `Textarea` - Multi-line text  
- `RichEditor` - WYSIWYG editor
- `FileUpload` - Images/documents
- `ColorPicker` - Color selection
- `Select` - Dropdown options
- `Toggle` - On/off switches
- `Repeater` - Multiple items (gallery images)
- `KeyValue` - Custom data pairs

**Template Testing Process:**
1. Create component template in dashboard
2. Add sample content through form
3. Preview rendered output
4. Adjust template/schema as needed
5. Apply to actual projects

## Practical Component Extraction from Your Projects

### Analyzed Project Structure
Based on your existing projects (Artal, Mentor, etc.), here are the common components:

### Component 1: Hero Header
**Found in:** All projects
**Current Structure:**
```html
<section class="page-header">
    <div id="header-animation" class="bh">
        <div class="js-parallaxheader singleimage cover-image"
            style="background-image:url('{{ asset('images/PROJECT_NAME/1.jpg') }}');"></div>
    </div>
</section>
```

**Dynamic Template:**
```blade
<section class="page-header">
    <div id="header-animation" class="bh">
        <div class="js-parallaxheader singleimage cover-image"
            style="background-image:url('{{ $hero_image }}');"></div>
    </div>
</section>
```

**Dashboard Schema:**
```json
{
  "hero_image": {
    "type": "file_upload",
    "label": "Hero Background Image",
    "accept": "image/*",
    "required": true,
    "help": "Main project showcase image"
  }
}
```

### Component 2: Project Introduction
**Current Structure:**
```html
<section class="introtext">
    <div class="grid-width text-center">
        <div class="subline inview inview--up">
            (PROJECT_NAME)
        </div>
        <div class="editor-content copy-l inview inview--up content-sml">
            <p class="p1">PROJECT_DESCRIPTION_TEXT</p>
        </div>
    </div>
</section>
```

**Dynamic Template:**
```blade
<section class="introtext">
    <div class="grid-width text-center">
        <div class="subline inview inview--up">
            ({{ $project_name }})
        </div>
        <div class="editor-content copy-l inview inview--up content-sml">
            <p class="p1">{{ $description }}</p>
        </div>
    </div>
</section>
```

**Dashboard Schema:**
```json
{
  "project_name": {
    "type": "text",
    "label": "Project Name",
    "required": true,
    "placeholder": "e.g., artal, mentor"
  },
  "description": {
    "type": "rich_editor",
    "label": "Project Description",
    "required": true,
    "toolbar": ["bold", "italic", "link"]
  }
}
```

### Component 3: Section Separator
**Current Structure:**
```html
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
```

**Dynamic Template:**
```blade
<section class="separator inview inview--up">
    <div class="grid-width copy-s">
        <div class="js-seperator">
            <div class="separator--text flex">
                <div class="flex--strech">
                    <span class="top"><span>Sec.</span>({{ $section_from }})</span>
                    <span class="bottom"><span>Sec.</span>({{ $section_to }})</span>
                </div>
                <div>
                    <span class="top">{{ $top_text }}</span>
                    <span class="bottom">{{ $bottom_text }}</span>
                </div>
            </div>
            <div class="separator--line inview inview--line"></div>
        </div>
    </div>
</section>
```

**Dashboard Schema:**
```json
{
  "section_from": {
    "type": "text",
    "label": "From Section Number",
    "default": "01",
    "required": true
  },
  "section_to": {
    "type": "text", 
    "label": "To Section Number",
    "default": "02",
    "required": true
  },
  "top_text": {
    "type": "text",
    "label": "Top Text",
    "default": "Project Info",
    "required": true
  },
  "bottom_text": {
    "type": "text",
    "label": "Bottom Text", 
    "default": "Sample",
    "required": true
  }
}
```

### Component 4: Image Gallery Block
**Current Structure:**
```html
<section class="bilder">
    <div class="grid-width">
        <div class="flex bilder-wrap-1 flex--nom">
            <div class="bilder-wrap-image">
                <div class="inview inview--up">
                    <img data-src="{{ asset('images/PROJECT/2.jpg') }}" alt="" class="lazyload" />
                </div>
            </div>
        </div>
    </div>
</section>
```

**Dynamic Template:**
```blade
<section class="bilder">
    <div class="grid-width">
        <div class="flex bilder-wrap-1 flex--nom">
            <div class="bilder-wrap-image">
                <div class="inview inview--up">
                    <img data-src="{{ $image_url }}" alt="{{ $image_alt }}" class="lazyload" />
                </div>
            </div>
        </div>
    </div>
</section>
```

**Dashboard Schema:**
```json
{
  "image_url": {
    "type": "file_upload",
    "label": "Gallery Image",
    "accept": "image/*",
    "required": true
  },
  "image_alt": {
    "type": "text",
    "label": "Image Alt Text",
    "required": false,
    "help": "Describe the image for accessibility"
  }
}
```

### Component 5: Multi-Image Gallery
**For projects with multiple images like Mentor:**
```blade
<section class="multi-gallery">
    @foreach($gallery_images as $image)
    <section class="bilder">
        <div class="grid-width">
            <div class="flex bilder-wrap-1 flex--nom">
                <div class="bilder-wrap-image">
                    <div class="inview inview--up">
                        <img data-src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="lazyload" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
</section>
```

**Dashboard Schema:**
```json
{
  "gallery_images": {
    "type": "repeater",
    "label": "Gallery Images",
    "min_items": 1,
    "max_items": 10,
    "schema": {
      "url": {
        "type": "file_upload",
        "label": "Image",
        "accept": "image/*",
        "required": true
      },
      "alt": {
        "type": "text",
        "label": "Alt Text",
        "required": false
      }
    }
  }
}
```

## Your Implementation Steps

### Step 1: Start with One Project Type
1. **Choose Branding Projects** (like Artal, Mentor) as your starting point
2. **Extract 4-5 components** from one project template
3. **Test with existing content** to ensure styling remains intact

### Step 2: Create Component Templates in Dashboard
Once the system is built, you'll:
1. **Go to Template Blocks** in Filament dashboard
2. **Create new block** for each component type
3. **Paste the Blade template** code
4. **Define the schema** (form fields)
5. **Set default content** for testing

### Step 3: Convert Static Projects
1. **Create new dynamic project** in dashboard
2. **Select service category** (Branding)
3. **Add blocks** in order (Hero → Intro → Separator → Gallery)
4. **Fill in content** from existing static project
5. **Preview and adjust** as needed

### Step 4: Preserve Your Existing Styles
**Important:** All your existing CSS classes and animations will work exactly the same:
- `inview inview--up` animations
- `js-parallaxheader` functionality  
- `lazyload` image loading
- Grid and flex layouts

The only change is replacing static content with dynamic variables.

### Benefits for Your Workflow
1. **Keep all existing styling** - no CSS changes needed
2. **Reuse components** across similar projects
3. **Easy content updates** through dashboard forms
4. **Consistent structure** while allowing customization
5. **No code editing** for new projects

## Advanced Image Optimization System

### Automatic Image Processing Pipeline
**When images are uploaded through Filament dashboard:**

1. **Original Preservation** - Keep original file as backup
2. **Format Conversion** - Convert to WebP for web delivery
3. **Quality Optimization** - Maintain visual quality while reducing size
4. **Multiple Sizes** - Generate responsive image variants
5. **Fallback Support** - Provide JPEG fallback for older browsers

### Image Processing Configuration
**Laravel Image Processing Setup:**
```php
// config/image-optimization.php
return [
    'formats' => [
        'webp' => [
            'quality' => 85,
            'method' => 6, // WebP compression method (0-6)
        ],
        'jpeg' => [
            'quality' => 90,
            'progressive' => true,
        ],
    ],
    'sizes' => [
        'thumbnail' => ['width' => 300, 'height' => 300],
        'medium' => ['width' => 800, 'height' => 600],
        'large' => ['width' => 1920, 'height' => 1080],
        'original' => null, // Keep original dimensions
    ],
    'max_upload_size' => '50MB',
    'allowed_formats' => ['jpg', 'jpeg', 'png', 'webp'],
];
```

### Image Processing Service
**App\Services\ImageOptimizationService:**
```php
class ImageOptimizationService
{
    public function processUpload($uploadedFile, $options = [])
    {
        $results = [];
        
        // 1. Store original file
        $originalPath = $this->storeOriginal($uploadedFile);
        $results['original'] = $originalPath;
        
        // 2. Generate WebP versions
        $webpVersions = $this->generateWebPVersions($originalPath);
        $results['webp'] = $webpVersions;
        
        // 3. Generate JPEG fallbacks
        $jpegVersions = $this->generateJPEGVersions($originalPath);
        $results['jpeg'] = $jpegVersions;
        
        // 4. Generate responsive sizes
        foreach (config('image-optimization.sizes') as $size => $dimensions) {
            $results['sizes'][$size] = [
                'webp' => $this->resizeImage($originalPath, $dimensions, 'webp'),
                'jpeg' => $this->resizeImage($originalPath, $dimensions, 'jpeg'),
            ];
        }
        
        return $results;
    }
    
    private function generateWebPVersions($imagePath)
    {
        $webpPath = str_replace(['.jpg', '.jpeg', '.png'], '.webp', $imagePath);
        
        // Use Intervention Image or GD/Imagick
        $image = Image::make($imagePath);
        $image->encode('webp', config('image-optimization.formats.webp.quality'));
        $image->save($webpPath);
        
        return $webpPath;
    }
}
```

### Filament File Upload Integration
**Enhanced FileUpload Component:**
```php
// In Filament Resource forms
FileUpload::make('hero_image')
    ->label('Hero Image')
    ->image()
    ->maxSize(51200) // 50MB
    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
    ->disk('public')
    ->directory('projects/images')
    ->visibility('public')
    ->imageResizeMode('contain')
    ->imageCropAspectRatio('16:9')
    ->imageResizeTargetWidth('1920')
    ->imageResizeTargetHeight('1080')
    ->afterStateUpdated(function ($state, $set) {
        if ($state) {
            // Trigger image optimization
            $optimized = app(ImageOptimizationService::class)
                ->processUpload($state);
            
            // Store optimization results in hidden field
            $set('hero_image_optimized', $optimized);
        }
    })
```

### Database Schema for Optimized Images
**Enhanced image storage in database:**
```sql
-- Add to projects table or create separate images table
ALTER TABLE projects ADD COLUMN hero_image_data JSON;

-- Example JSON structure:
{
  "original": "/storage/projects/images/hero-original.jpg",
  "webp": {
    "thumbnail": "/storage/projects/images/hero-thumb.webp",
    "medium": "/storage/projects/images/hero-medium.webp", 
    "large": "/storage/projects/images/hero-large.webp"
  },
  "jpeg": {
    "thumbnail": "/storage/projects/images/hero-thumb.jpg",
    "medium": "/storage/projects/images/hero-medium.jpg",
    "large": "/storage/projects/images/hero-large.jpg"
  },
  "metadata": {
    "original_size": "25MB",
    "optimized_size": "2.1MB",
    "compression_ratio": "91.6%",
    "dimensions": {"width": 1920, "height": 1080}
  }
}
```

### Frontend Responsive Image Delivery
**Smart image serving in Blade templates:**
```blade
{{-- Enhanced image component with WebP support --}}
<picture class="responsive-image">
    {{-- WebP sources for modern browsers --}}
    <source 
        srcset="{{ $image_data['webp']['thumbnail'] }} 300w,
                {{ $image_data['webp']['medium'] }} 800w,
                {{ $image_data['webp']['large'] }} 1920w"
        sizes="(max-width: 768px) 300px, (max-width: 1200px) 800px, 1920px"
        type="image/webp">
    
    {{-- JPEG fallback for older browsers --}}
    <source 
        srcset="{{ $image_data['jpeg']['thumbnail'] }} 300w,
                {{ $image_data['jpeg']['medium'] }} 800w,
                {{ $image_data['jpeg']['large'] }} 1920w"
        sizes="(max-width: 768px) 300px, (max-width: 1200px) 800px, 1920px"
        type="image/jpeg">
    
    {{-- Default fallback --}}
    <img 
        src="{{ $image_data['jpeg']['large'] }}" 
        alt="{{ $image_alt }}"
        class="lazyload"
        loading="lazy">
</picture>
```

### Image Optimization Benefits
**Performance Improvements:**
- **90%+ size reduction** (25MB → 2-3MB typical)
- **WebP format** - 25-35% smaller than JPEG
- **Responsive delivery** - appropriate size per device
- **Lazy loading** - images load when needed
- **Browser compatibility** - automatic fallbacks

**Quality Preservation:**
- **Lossless conversion** for most images
- **Configurable quality** settings per format
- **Original backup** always preserved
- **Metadata retention** (EXIF data optional)

### Dashboard Image Management
**Enhanced Filament interface:**
- **Upload progress** with optimization status
- **Before/after** size comparison
- **Quality preview** with zoom functionality
- **Bulk optimization** for existing images
- **Storage analytics** showing space saved

### Implementation Packages
**Required Laravel packages:**
```bash
composer require intervention/image
composer require spatie/laravel-image-optimizer
composer require spatie/image-optimizer
```

**Optional advanced features:**
```bash
composer require tinify/tinify  # TinyPNG API integration
composer require league/flysystem-aws-s3-v3  # S3 storage
```

### Image Processing Queue
**Background processing for large images:**
```php
// Queue job for heavy image processing
class OptimizeImageJob implements ShouldQueue
{
    public function handle()
    {
        // Process image optimization in background
        // Send notification when complete
    }
}
```

This system ensures your agency's high-quality images are delivered with optimal performance while maintaining visual excellence.

### 1.6 Jobs System
**Migration: `create_jobs_table`**
```sql
- id (primary key)
- title (string, required)
- slug (string, unique, required)
- description (text, required)
- requirements (text, nullable)
- location (string, nullable)
- job_type (enum: 'full_time', 'part_time', 'contract', 'internship')
- experience_level (enum: 'entry', 'mid', 'senior', 'lead')
- salary_range (string, nullable)
- department (string, nullable)
- status (enum: 'active', 'inactive', 'closed')
- application_deadline (date, nullable)
- created_at, updated_at
```

**Model: `App\Models\Job`**
- Relationships: hasMany(JobApplication)
- Scopes: active(), byType(), byDepartment()

### 1.3 Job Applications System
**Migration: `create_job_applications_table`**
```sql
- id (primary key)
- job_id (foreign key to jobs)
- full_name (string, required)
- email (string, required)
- phone (string, nullable)
- cover_letter (text, nullable)
- resume_path (string, required)
- portfolio_url (string, nullable)
- experience_years (integer, nullable)
- status (enum: 'pending', 'reviewed', 'shortlisted', 'rejected', 'hired')
- notes (text, nullable) // Admin notes
- applied_at (timestamp, default: now)
- created_at, updated_at
```

**Model: `App\Models\JobApplication`**
- Relationships: belongsTo(Job)
- File handling for resume uploads
- Email notifications

## Phase 2: Filament Dashboard Resources

### 2.1 Service Category Resource (`App\Filament\Resources\ServiceCategoryResource`)
**Features:**
- CRUD operations for service categories
- Template name management
- Color scheme configuration
- Icon management
- Sort ordering

**Form Fields:**
- TextInput: name, slug, icon
- Textarea: description
- Select: template_name (dropdown with available templates)
- KeyValue: color_scheme (primary, secondary, accent colors)
- Toggle: is_active
- TextInput: sort_order

**Table Columns:**
- TextColumn: name, template_name
- BadgeColumn: is_active
- TextColumn: projects_count (computed)
- TextColumn: sort_order

### 2.2 Portfolio Project Resource (`App\Filament\Resources\ProjectResource`)
**Features:**
- CRUD operations for portfolio projects
- Service category relationship
- Image upload for featured_image and gallery
- Rich text editors for challenge/solution/results
- Client information management
- Project outcome tracking

**Form Fields:**
- Select: service_category_id (relationship to ServiceCategory)
- TextInput: title, client_name, project_url, duration
- Textarea: short_description, project_summary
- RichEditor: description, challenge, solution, results
- Select: status
- DatePicker: completion_date
- FileUpload: featured_image (single), gallery_images (multiple)
- TagsInput: technologies_used, services_provided
- Hidden: slug (auto-generated)

**Table Columns:**
- TextColumn: title, client_name, serviceCategory.name, status
- ImageColumn: featured_image
- DateColumn: completion_date, created_at
- BadgeColumn: status

**Filters:**
- SelectFilter: service_category_id, status
- DateFilter: completion_date

### 2.2 Job Resource (`App\Filament\Resources\JobResource`)
**Features:**
- CRUD operations for job postings
- Rich text editor for description and requirements
- Status management
- Application deadline tracking
- Application count display

**Form Fields:**
- TextInput: title, location, salary_range, department
- RichEditor: description, requirements
- Select: job_type, experience_level, status
- DatePicker: application_deadline

**Table Columns:**
- TextColumn: title, department, job_type, status
- DateColumn: application_deadline, created_at
- BadgeColumn: status
- TextColumn: applications_count (computed)

### 2.3 Job Application Resource (`App\Filament\Resources\JobApplicationResource`)
**Features:**
- View and manage job applications
- Download resume files
- Status management workflow
- Email notifications to applicants
- Admin notes system
- Filtering by job, status, date

**Form Fields:**
- TextInput: full_name, email, phone (readonly)
- Textarea: cover_letter (readonly)
- Select: status (editable)
- Textarea: notes (admin only)
- FileUpload: resume_path (readonly, downloadable)

**Table Columns:**
- TextColumn: full_name, email, job.title
- BadgeColumn: status
- DateColumn: applied_at
- Actions: view, download_resume, change_status

**Filters:**
- SelectFilter: job_id, status
- DateRangeFilter: applied_at

## Phase 3: Route Updates

### 3.1 Dynamic Project Routes
**Replace static routes with:**
```php
// Dynamic project route
Route::get('/project/{slug}', [ProjectController::class, 'show'])->name('project.show');

// Projects listing page (optional)
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
```

**Controller: `App\Http\Controllers\ProjectController`**
```php
public function show($slug)
{
    $project = Project::where('slug', $slug)
        ->where('status', 'active')
        ->firstOrFail();
    
    return view('front.pages.project-detail', compact('project'));
}

public function index()
{
    $projects = Project::active()
        ->orderBy('sort_order')
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('front.pages.projects', compact('projects'));
}
```

### 3.2 Job Application Routes
```php
// Job listings
Route::get('/careers', [JobController::class, 'index'])->name('careers');
Route::get('/careers/{slug}', [JobController::class, 'show'])->name('job.show');

// Job application
Route::post('/careers/{job}/apply', [JobApplicationController::class, 'store'])->name('job.apply');
```

**Controllers:**
- `App\Http\Controllers\JobController`
- `App\Http\Controllers\JobApplicationController`

## Phase 4: File Upload Security

### 4.1 Resume Upload Security
**Storage Configuration:**
- Private storage disk for resumes
- File validation: PDF, DOC, DOCX only
- Maximum file size: 5MB
- Virus scanning (optional)
- Unique filename generation

**Validation Rules:**
```php
'resume' => [
    'required',
    'file',
    'mimes:pdf,doc,docx',
    'max:5120', // 5MB
]
```

**Storage Path:**
`storage/app/private/resumes/{year}/{month}/{unique_filename}`

### 4.2 Project Image Security
**Image Upload Security:**
- Public storage for project images
- Image validation: JPG, PNG, WebP only
- Maximum file size: 10MB
- Image optimization/resizing
- Alt text for accessibility

## Phase 5: Email Notification System

### 5.1 Job Application Notifications
**Email Types:**
1. **Application Received** (to applicant)
2. **New Application** (to admin)
3. **Status Update** (to applicant)

**Mail Classes:**
- `App\Mail\JobApplicationReceived`
- `App\Mail\NewJobApplication`
- `App\Mail\JobApplicationStatusUpdate`

**Queue Configuration:**
- Use Laravel queues for email sending
- Database queue driver
- Job retry mechanism

### 5.2 Admin Dashboard Notifications
**Filament Notifications:**
- Real-time notifications for new applications
- Email integration with dashboard
- Notification history

## Phase 6: Data Migration

### 6.1 Project Data Migration
**Seeder: `ProjectSeeder`**
- Extract data from existing static project pages
- Create database records for each project
- Generate appropriate slugs
- Set featured status for key projects

### 6.2 Existing Route Redirects
**Redirect old project URLs:**
```php
// Redirect old static routes to new dynamic routes
Route::redirect('/project/loja', '/project/loja-dynamic');
Route::redirect('/project/zenda', '/project/zenda-dynamic');
// ... etc for all projects
```

## Phase 7: API Endpoints (Optional)

### 7.1 Project API
```php
Route::apiResource('projects', ProjectApiController::class)->only(['index', 'show']);
```

### 7.2 Jobs API
```php
Route::apiResource('jobs', JobApiController::class)->only(['index', 'show']);
Route::post('jobs/{job}/apply', [JobApplicationApiController::class, 'store']);
```

## Implementation Priority

### High Priority
1. ✅ Database migrations and models
2. ✅ Basic Filament resources (Project, Job)
3. ✅ Dynamic project routes
4. ✅ File upload security for resumes

### Medium Priority
1. ✅ Job application system
2. ✅ Email notifications
3. ✅ Data migration from static content

### Low Priority
1. ✅ API endpoints
2. ✅ Advanced filtering and search
3. ✅ Performance optimization

## Security Considerations

1. **File Upload Security**
   - Validate file types and sizes
   - Store resumes in private storage
   - Generate unique filenames
   - Implement virus scanning

2. **Data Validation**
   - Strict validation rules for all inputs
   - CSRF protection on forms
   - Rate limiting on application submissions

3. **Access Control**
   - Admin-only access to dashboard resources
   - Proper authorization policies
   - Secure file download endpoints

## Performance Considerations

1. **Database Optimization**
   - Proper indexing on slug, status fields
   - Eager loading for relationships
   - Query optimization

2. **File Storage**
   - CDN for public project images
   - Image optimization and caching
   - Efficient file serving

3. **Caching**
   - Cache project listings
   - Cache job postings
   - Redis for session storage

---

**Note:** This plan focuses on backend/dashboard implementation only. Frontend integration will be handled separately by the client.
