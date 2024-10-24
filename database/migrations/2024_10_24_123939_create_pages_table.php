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
        Schema::create('pages', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->string('caption')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->text('short_description')->nullable();
            $table->text('full_content')->nullable();
            $table->date('date');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('url')->unique();
            $table->boolean('can_comment')->default(false);
            $table->boolean('can_like')->default(false);
            $table->string('images')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
