<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ProjectImage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set default values for existing records
        ProjectImage::whereNull('alt_text')->update(['alt_text' => 'Project Image']);
        ProjectImage::where('is_featured', true)->update(['is_featured' => false]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse - this is just data cleanup
    }
};
