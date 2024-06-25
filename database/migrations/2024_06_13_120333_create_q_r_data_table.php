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
        Schema::create('q_r_data', function (Blueprint $table) {
            $table->id();
            $table->string('grade_name');
            $table->string('origin');
            $table->string('batch_no');
            $table->string('net_weight');
            $table->string('gross_weight');
            $table->string('lot_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_r_data');
    }
};
