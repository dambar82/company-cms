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
        Schema::create('amina_feedback', function (Blueprint $table) {
            $table->id();
            $table->string('creator');
            $table->string('job_title')->nullable();
            $table->string('region');
            $table->string('fio');
            $table->string('email');
            $table->string('text');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amina_feedback');
    }
};
