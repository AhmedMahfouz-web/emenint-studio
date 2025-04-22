<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('symbol');
            $table->string('symbol_ar')->nullable();
            $table->decimal('exchange_rate', 10, 4)->default(1.0000);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default currency
        DB::table('currencies')->insert([
            'code' => 'EGP',
            'name' => 'Egyptian Pound',
            'name_ar' => 'جنيه مصري',
            'symbol' => 'EGP',
            'symbol_ar' => 'ج.م',
            'exchange_rate' => 1.0000,
            'is_default' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add USD as a secondary currency
        DB::table('currencies')->insert([
            'code' => 'USD',
            'name' => 'US Dollar',
            'name_ar' => 'دولار أمريكي',
            'symbol' => '$',
            'symbol_ar' => '$',
            'exchange_rate' => 30.9000,
            'is_default' => false,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
