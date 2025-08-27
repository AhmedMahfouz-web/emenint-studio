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
        // Schema::create('project_block_contents', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
        //     $table->foreignId('template_block_id')->constrained('template_blocks')->onDelete('cascade');
        //     $table->json('content_data');
        //     $table->text('custom_css')->nullable();
        //     $table->boolean('is_visible')->default(true);
        //     $table->integer('sort_order')->default(0);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_block_contents');
    }
};
