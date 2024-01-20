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
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('hot_day');
            $table->dropColumn('hot_month');
            $table->dropColumn('hot_all_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->tinyInteger('hot_day')->default(0)->nullable();
            $table->tinyInteger('hot_month')->default(0)->nullable();
            $table->tinyInteger('hot_all_time')->default(0)->nullable();
        });
    }
};
