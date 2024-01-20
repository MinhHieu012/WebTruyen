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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('')->nullable();
            $table->string('description')->default('')->nullable();
            $table->tinyInteger('index')->default(0)->nullable();
            $table->longText('header_script')->nullable();
            $table->longText('body_script')->nullable();
            $table->longText('footer_script')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
