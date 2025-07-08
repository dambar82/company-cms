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
        Schema::table('posters', function (Blueprint $table) {
            $table->renameColumn('poster', 'poster_rus');
            $table->string('poster_tat')->after('poster_rus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posters', function (Blueprint $table) {
            $table->renameColumn('poster_rus', 'poster');
            $table->dropColumn('poster_tat');
        });
    }
};
