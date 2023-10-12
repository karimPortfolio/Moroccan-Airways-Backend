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
        Schema::create('user_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('title' , 10);
            $table->string('name' , 100);
            $table->string('nationality' , 50);
            $table->string('passport' , 200);
            $table->string('countryResidence' , 255);
            $table->string('email' , 100);
            $table->string('mobile' , 20);
            $table->string('passengersAdultes' , 50);
            $table->string('passengersChilds' , 50);
            $table->string('class' , 50);
            $table->integer('extras');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('flight_id');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
            $table->foreign('flight_id')->references('id')->on('flights')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reservations');
    }
};
