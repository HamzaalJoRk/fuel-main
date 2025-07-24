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
        Schema::table('tanks', function (Blueprint $table) {
            $table->string('shape')->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('side', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tanks', function (Blueprint $table) {
            $table->dropColumn(['shape', 'length', 'width', 'side', 'height']);
        });
    }
};
