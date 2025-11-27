<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRsvpsTable extends Migration
{
    public function up()
    {
        Schema::create('rsvps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('guest_id');
            $table->enum('status', ['yes', 'no', 'maybe']);
            $table->integer('plus_one_count')->default(0);
            $table->json('answers')->nullable();
            $table->timestamps();

            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');

            // Guarantee one RSVP per guest
            $table->unique('guest_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rsvps');
    }
}