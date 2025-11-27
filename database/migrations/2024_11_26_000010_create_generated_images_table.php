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
        Schema::create('generated_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('prompt');
            $table->text('negative_prompt')->nullable();
            $table->string('image_url');
            $table->string('thumbnail_url')->nullable();
            $table->string('style')->default('realistic');
            $table->string('size')->default('1024x1024');
            $table->string('quality')->default('high');
            $table->string('task_id')->nullable();
            $table->enum('status', ['processing', 'completed', 'failed'])->default('processing');
            $table->string('ai_model')->default('gamma');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('event_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_images');
    }
};
