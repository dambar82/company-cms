<?php

use App\Models\MDT\Category;
use App\Models\MDT\Service;
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
        Schema::create('service_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Service::class);
            $table->foreignIdFor(Category::class);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('preview')->nullable();
            $table->string('video')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_contents');
    }
};
