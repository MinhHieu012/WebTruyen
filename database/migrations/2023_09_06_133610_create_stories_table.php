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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('image')->default('')->nullable();
            $table->string('name')->default('')->nullable();
            $table->text('desc')->nullable();
            $table->bigInteger('author_id')->default(0)->nullable();
            $table->tinyInteger('status')->default(0)->nullable()->comment('0: inactive, 1: active');
            $table->tinyInteger('is_full')->default(0)->nullable();
            $table->tinyInteger('is_new')->default(0)->nullable();
            $table->tinyInteger('hot_day')->default(0)->nullable();
            $table->tinyInteger('hot_month')->default(0)->nullable();
            $table->tinyInteger('hot_all_time')->default(0)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
