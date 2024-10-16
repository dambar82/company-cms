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
        Schema::dropIfExists('amina_news');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('amina_news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('images')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }
};
