<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // Vérifier et ajouter les colonnes si elles n'existent pas
            if (!Schema::hasColumn('guests', 'name')) {
                $table->string('name')->after('event_id');
            }
            if (!Schema::hasColumn('guests', 'email')) {
                $table->string('email')->after('name');
            }
            if (!Schema::hasColumn('guests', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'phone']);
        });
    }
};
