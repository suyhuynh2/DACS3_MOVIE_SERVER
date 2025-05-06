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
        Schema::create('rating', function (Blueprint $table) {
            $table->id('rating_id');
            $table->unsignedBigInteger('movie_id');
            $table->string('firebase_uid');
            $table->integer('score');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('movie_id')->references('movie_id')->on('movie')->onDelete('cascade');
            $table->foreign('firebase_uid')->references('firebase_uid')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating');
    }
};
