<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('channel');
            $table->string('recipient');
            $table->string('message_sid')->nullable();
            $table->enum('status', ['success', 'failed', 'pending'])->default('pending');
            $table->text('message_body');
            $table->text('error_message')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('event_id');
            $table->index('channel');
            $table->index('status');
            $table->index('message_sid');
            $table->index('sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_histories');
    }
};
