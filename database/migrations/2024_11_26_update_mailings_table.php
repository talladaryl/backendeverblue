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
        Schema::table('mailings', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('mailings', 'type')) {
                $table->string('type')->default('single')->after('channel');
            }
            if (!Schema::hasColumn('mailings', 'recipient_type')) {
                $table->string('recipient_type')->default('custom')->after('type');
            }
            if (!Schema::hasColumn('mailings', 'recipients')) {
                $table->json('recipients')->nullable()->after('recipient_type');
            }
            if (!Schema::hasColumn('mailings', 'media_urls')) {
                $table->json('media_urls')->nullable()->after('recipients');
            }
            if (!Schema::hasColumn('mailings', 'sent_count')) {
                $table->integer('sent_count')->default(0)->after('sent_at');
            }
            if (!Schema::hasColumn('mailings', 'failed_count')) {
                $table->integer('failed_count')->default(0)->after('sent_count');
            }
            if (!Schema::hasColumn('mailings', 'metadata')) {
                $table->json('metadata')->nullable()->after('failed_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mailings', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'recipient_type',
                'recipients',
                'media_urls',
                'sent_count',
                'failed_count',
                'metadata',
            ]);
        });
    }
};
