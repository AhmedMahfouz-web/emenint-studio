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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('short_description')->nullable()->after('description');
            $table->text('project_summary')->nullable()->after('client_name');
            $table->text('challenge')->nullable()->after('project_summary');
            $table->text('solution')->nullable()->after('challenge');
            $table->text('results')->nullable()->after('solution');
            $table->string('featured_image')->nullable()->after('status');
            $table->json('gallery_images')->nullable()->after('featured_image');
            $table->string('project_url')->nullable()->after('gallery_images');
            $table->date('completion_date')->nullable()->after('project_url');
            $table->string('duration')->nullable()->after('completion_date');
            $table->json('technologies_used')->nullable()->after('duration');
            $table->json('services_provided')->nullable()->after('technologies_used');
            $table->string('meta_title')->nullable()->after('sort_order');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'short_description',
                'project_summary',
                'challenge',
                'solution',
                'results',
                'featured_image',
                'gallery_images',
                'project_url',
                'completion_date',
                'duration',
                'technologies_used',
                'services_provided',
                'meta_title',
                'meta_description',
            ]);
        });
    }
};
