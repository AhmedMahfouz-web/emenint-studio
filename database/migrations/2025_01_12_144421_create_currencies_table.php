<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 3)->unique(); // USD, EUR, etc.
            $table->string('symbol')->nullable(); // $, €, etc.
            $table->decimal('exchange_rate', 10, 4)->default(1.0000);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add currency_id to invoices table
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('currency_id')->nullable()->constrained()->nullOnDelete();
        });

        // Add currency_id to products table
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('currency_id')->nullable()->constrained()->nullOnDelete();
        });

        // Create default currency
        DB::table('currencies')->insert([
            'name' => 'Egyptian Pound',
            'code' => 'EGP',
            'symbol' => 'ج.م',
            'exchange_rate' => 1.0000,
            'is_default' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropColumn('currency_id');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropColumn('currency_id');
        });

        Schema::dropIfExists('currencies');
    }
};
