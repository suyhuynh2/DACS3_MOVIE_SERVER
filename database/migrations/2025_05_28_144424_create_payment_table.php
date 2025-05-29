<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('firebase_uid');
            $table->integer('amount');
            $table->string('content');
            $table->string('status');
            $table->string('order_code');
            $table->timestamps();

            $table->foreign('firebase_uid')->references('firebase_uid')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
