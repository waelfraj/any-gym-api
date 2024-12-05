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
        Schema::create('training_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('coach_id');
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->boolean('is_reserved')->default(false);
            $table->integer('total_calories')->nullable()->default(0);
            $table->string('difficulty')->nullable()->default('easy');
            $table->timestamps();
            $table->foreign('coach_id')->references('id')->on('coaches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_lists');
    }
};
