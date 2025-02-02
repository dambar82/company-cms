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
        Schema::table('audios', function (Blueprint $table) {
            $table->dropForeign('audios_project_id_foreign');
            $table->dropColumn('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audios', function (Blueprint $table) {
            $table->foreignId('project_id')
                ->constrained('audios')
                ->onDelete('cascade');
        });
    }
};
