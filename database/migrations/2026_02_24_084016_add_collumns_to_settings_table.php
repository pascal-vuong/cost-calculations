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
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('member_discount', 5, 2)->default(0.20);
            $table->decimal('super_member_discount', 5, 2)->default(0.50);
            $table->decimal('child', 5, 2)->default(1.00);
            $table->decimal('youth', 5, 2)->default(0.50);
            $table->decimal('greenfee', 5, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
