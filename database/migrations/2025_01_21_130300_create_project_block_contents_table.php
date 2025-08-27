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
        Schema::create('project_block_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_block_id')->constrained()->onDelete('cascade');
            $table->json('content_data'); // Actual content for this block instance
            $table->text('custom_css')->nullable(); // Project-specific CSS overrides
            $table->boolean('is_visible')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['project_id', 'sort_order']);
            $table->unique(['project_id', 'template_block_id', 'sort_order'], 'unique_project_block_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_block_contents');
    }
};
