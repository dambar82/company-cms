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
        Schema::table('news', function (Blueprint $table) {
            $table->renameColumn('content', 'meta_description');
            $table->dropColumn('images');
            $table->dropColumn('video');
            $table->dropColumn('link_to_video');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->renameColumn('meta_description', 'content');
            $table->string('images');
            $table->string('video');
            $table->string('link_to_video');
        });
    }
};
