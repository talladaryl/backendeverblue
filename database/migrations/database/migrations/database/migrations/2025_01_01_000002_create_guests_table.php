<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id');
            $table->string('full_name', 200);
            $table->string('email', 180)->nullable();
            $table->string('phone', 50)->nullable();
            $table->boolean('plus_one_allowed')->default(false);
            $table->json('metadata')->nullable(); // allergies, tags, seat, etc.
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            // NOTE: we do NOT place a global unique index on email here because uniqueness depends on event.guest_mode.
            // For "strict" mode we enforce uniqueness per event via validation (and we can optionally create a conditional unique index at the DB level if desired).
        });
    }

    public function down()
    {
        Schema::dropIfExists('guests');
    }
}