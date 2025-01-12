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
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'company')) {
                $table->string('company')->nullable();
            }
            if (!Schema::hasColumn('clients', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('clients', 'address')) {
                $table->text('address')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['company', 'email', 'address']);
        });
    }
};
