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
        Schema::table('service_contents', function (Blueprint $table) {
            $table->boolean('is_first')->default(false)->after('video');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_contents', function (Blueprint $table) {
            $table->dropColumn('is_first');
        });
    }
};
