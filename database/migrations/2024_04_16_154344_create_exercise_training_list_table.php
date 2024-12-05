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
        Schema::create('exercise_training_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_list_id');
            $table->unsignedBigInteger('exercise_id');
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->foreign('training_list_id')->references('id')->on('training_lists')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_training_list');
    }
};
