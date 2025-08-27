<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\TemplateBlock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateBlockSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $brandingCategory = ServiceCategory::where('slug', 'branding')->first();
        
        if (!$brandingCategory) {
            return;
        }

        $blocks = [
            [
                'service_category_id' => $brandingCategory->id,
                'block_name' => 'Hero Header',
                'block_type' => 'hero',
                'html_template' => '<section class="page-header">
    <div id="header-animation" class="bh">
        <div class="js-parallaxheader singleimage cover-image"
            style="background-image:url(\'{{ $hero_image }}\');"></div>
    </div>
</section>',
                'content_schema' => [
                    'hero_image' => [
                        'type' => 'file_upload',
                        'label' => 'Hero Background Image',
                        'accept' => 'image/*',
                        'required' => true,
                        'help' => 'Main project showcase image'
                    ]
                ],
                'default_content' => [
                    'hero_image' => '/images/placeholder-hero.jpg'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'service_category_id' => $brandingCategory->id,
                'block_name' => 'Project Introduction',
                'block_type' => 'intro',
                'html_template' => '<section class="introtext">
    <div class="grid-width text-center">
        <div class="subline inview inview--up">
            ({{ $project_name }})
        </div>
        <div class="editor-content copy-l inview inview--up content-sml">
            <p class="p1">{{ $description }}</p>
        </div>
    </div>
</section>',
                'content_schema' => [
                    'project_name' => [
                        'type' => 'text',
                        'label' => 'Project Name',
                        'required' => true,
                        'placeholder' => 'e.g., artal, mentor'
                    ],
                    'description' => [
                        'type' => 'rich_editor',
                        'label' => 'Project Description',
                        'required' => true,
                        'toolbar' => ['bold', 'italic', 'link']
                    ]
                ],
                'default_content' => [
                    'project_name' => 'project name',
                    'description' => 'Project description goes here...'
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'service_category_id' => $brandingCategory->id,
                'block_name' => 'Section Separator',
                'block_type' => 'separator',
                'html_template' => '<section class="separator inview inview--up">
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
</section>',
                'content_schema' => [
                    'section_from' => [
                        'type' => 'text',
                        'label' => 'From Section Number',
                        'default' => '01',
                        'required' => true
                    ],
                    'section_to' => [
                        'type' => 'text',
                        'label' => 'To Section Number',
                        'default' => '02',
                        'required' => true
                    ],
                    'top_text' => [
                        'type' => 'text',
                        'label' => 'Top Text',
                        'default' => 'Project Info',
                        'required' => true
                    ],
                    'bottom_text' => [
                        'type' => 'text',
                        'label' => 'Bottom Text',
                        'default' => 'Sample',
                        'required' => true
                    ]
                ],
                'default_content' => [
                    'section_from' => '01',
                    'section_to' => '02',
                    'top_text' => 'Project Info',
                    'bottom_text' => 'Sample'
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'service_category_id' => $brandingCategory->id,
                'block_name' => 'Image Gallery',
                'block_type' => 'gallery',
                'html_template' => '<section class="bilder">
    <div class="grid-width">
        <div class="flex bilder-wrap-1 flex--nom">
            <div class="bilder-wrap-image">
                <div class="inview inview--up">
                    <img data-src="{{ $image_url }}" alt="{{ $image_alt }}" class="lazyload" />
                </div>
            </div>
        </div>
    </div>
</section>',
                'content_schema' => [
                    'image_url' => [
                        'type' => 'file_upload',
                        'label' => 'Gallery Image',
                        'accept' => 'image/*',
                        'required' => true
                    ],
                    'image_alt' => [
                        'type' => 'text',
                        'label' => 'Image Alt Text',
                        'required' => false,
                        'help' => 'Describe the image for accessibility'
                    ]
                ],
                'default_content' => [
                    'image_url' => '/images/placeholder-gallery.jpg',
                    'image_alt' => 'Gallery image'
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($blocks as $block) {
            TemplateBlock::create($block);
        }
    }
}
