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
        Schema::create('imc_history', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->integer('imc');
            $table->unsignedInteger('member_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imc_history');
    }
};
