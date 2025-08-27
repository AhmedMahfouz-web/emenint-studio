<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('template_blocks', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('service_category_id')->constrained('service_categories')->onDelete('cascade');
        //     $table->enum('block_type', ['hero', 'gallery', 'description', 'challenge_solution', 'results', 'tech_stack', 'testimonial', 'cta']);
        //     $table->string('block_name');
        //     $table->json('content_schema');
        //     $table->json('default_content')->nullable();
        //     $table->text('html_template');
        //     $table->text('css_styles')->nullable();
        //     $table->integer('sort_order')->default(0);
        //     $table->boolean('is_active')->default(true);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_blocks');
    }
};
