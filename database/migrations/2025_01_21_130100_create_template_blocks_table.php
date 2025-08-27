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
        Schema::create('template_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->constrained()->onDelete('cascade');
            $table->string('block_name');
            $table->string('block_type'); // hero, intro, separator, gallery, etc.
            $table->longText('html_template'); // Blade template code
            $table->text('css_styles')->nullable(); // Custom CSS for this block
            $table->json('content_schema'); // Define form fields for dashboard
            $table->json('default_content')->nullable(); // Default values for fields
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['service_category_id', 'block_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_blocks');
    }
};
