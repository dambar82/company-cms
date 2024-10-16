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
        Schema::dropIfExists('amina_videos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('amina_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('path');
            $table->string('preview')->nullable();
            $table->timestamps();
        });
    }
};
