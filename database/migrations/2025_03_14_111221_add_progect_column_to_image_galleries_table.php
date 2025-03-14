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
            $table->smallInteger('project')->after('caption')->nullable();
        });

        Schema::table('video_galleries', function (Blueprint $table) {
            $table->smallInteger('project')->after('is_published')->nullable();
        });

        Schema::table('news', function (Blueprint $table) {
            $table->smallInteger('project')->after('active')->nullable();
        });

        Schema::table('audios', function (Blueprint $table) {
            $table->smallInteger('project')->after('path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_galleries', function (Blueprint $table) {
            $table->dropColumn('project');
        });

        Schema::table('video_galleries', function (Blueprint $table) {
            $table->dropColumn('project');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('project');
        });

        Schema::table('audios', function (Blueprint $table) {
            $table->dropColumn('project');
        });
    }
};
