<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->id('history_id');
            $table->string('firebase_uid');
            $table->unsignedBigInteger('movie_id');
            $table->string('watched_at')->nullable();
            $table->string('progress')->nullable();      // thời gian xem đến đâu (hh:mm:ss)
            $table->timestamps();

            $table->foreign('firebase_uid')->references('firebase_uid')->on('users')->onDelete('cascade');
            $table->foreign('movie_id')->references('movie_id')->on('movie')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('history');
    }
};
