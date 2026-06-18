<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('title_submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('title_submissions', 'supervisor_1_id')) {
                $table->foreignId('supervisor_1_id')->nullable()->after('supervisor_id')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('title_submissions', 'supervisor_2_id')) {
                $table->foreignId('supervisor_2_id')->nullable()->after('supervisor_1_id')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('title_submissions', 'assigned_at')) {
                $table->timestamp('assigned_at')->nullable()->after('approved_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('title_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('title_submissions', 'supervisor_2_id')) {
                $table->dropConstrainedForeignId('supervisor_2_id');
            }

            if (Schema::hasColumn('title_submissions', 'supervisor_1_id')) {
                $table->dropConstrainedForeignId('supervisor_1_id');
            }

            if (Schema::hasColumn('title_submissions', 'assigned_at')) {
                $table->dropColumn('assigned_at');
            }
        });
    }
};
