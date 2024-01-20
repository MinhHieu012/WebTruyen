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
        Schema::create('stars', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('story_id')->default(0)->nullable();
            $table->string('controller_name')->default('')->nullable();
            $table->string('stars', 40)->default('0')->nullable();
            $table->integer('count')->default(0)->nullable();
            $table->tinyInteger('approved')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stars');
    }
};
