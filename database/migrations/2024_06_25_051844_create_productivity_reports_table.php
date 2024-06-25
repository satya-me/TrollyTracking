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
        Schema::create('productivity_reports', function (Blueprint $table) {
            $table->id();
            $table->string('trolly_name');
            $table->string('department');
            $table->string('supervisor');
            $table->timestamp('entry_time')->nullable();
            $table->timestamp('exit_time')->nullable();
            $table->string('total_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productivity_reports');
    }
};
