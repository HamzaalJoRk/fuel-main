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
        Schema::table('refuelings', function (Blueprint $table) {
            $table->foreignId('tank_id')->constrained()->onDelete('cascade'); // ربط التزود بالوقود بالخزان
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refuelings', function (Blueprint $table) {
            //
        });
    }
};
