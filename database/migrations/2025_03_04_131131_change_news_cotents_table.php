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
        Schema::table('news_contents', function (Blueprint $table) {
        $table->text('content')->nullable()->change();
        $table->string('image')->nullable()->after('content');
        $table->string('video')->nullable()->after('image');
        $table->string('link')->nullable()->after('video');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_contents', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('video');
            $table->dropColumn('link');
        });
    }
};
