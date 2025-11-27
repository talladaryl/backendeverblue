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
        Schema::table('events', function (Blueprint $table) {
            // Ajouter les colonnes d'archivage si elles n'existent pas
            if (!Schema::hasColumn('events', 'is_archived')) {
                $table->boolean('is_archived')->default(false)->after('status');
            }
            if (!Schema::hasColumn('events', 'archived_at')) {
                $table->dateTime('archived_at')->nullable()->after('is_archived');
            }

            // Ajouter les index
            $table->index('is_archived');
            $table->index('archived_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['is_archived', 'archived_at']);
        });
    }
};
