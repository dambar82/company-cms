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
        Schema::table('image_galleries', function (Blueprint $table) {
            $table->dropForeign('image_galleries_project_id_foreign');
            $table->dropColumn('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_galleries', function (Blueprint $table) {
            $table->foreignId('project_id')
                ->constrained('image_galleries')
                ->onDelete('cascade');
        });
    }
};
