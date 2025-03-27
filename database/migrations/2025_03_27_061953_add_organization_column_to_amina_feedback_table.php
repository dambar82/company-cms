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
        Schema::table('amina_feedback', function (Blueprint $table) {
            $table->string('organization')->after('creator')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amina_feedback', function (Blueprint $table) {
            $table->dropColumn('organization');
        });
    }
};
