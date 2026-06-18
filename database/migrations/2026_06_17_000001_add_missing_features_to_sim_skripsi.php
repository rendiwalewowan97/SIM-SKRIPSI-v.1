<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'position')) $table->string('position')->nullable()->after('role');
        });
        Schema::table('title_submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('title_submissions', 'sks')) $table->unsignedSmallInteger('sks')->nullable()->after('title');
        });
        Schema::create('title_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('title_submission_id')->constrained('title_submissions')->cascadeOnDelete();
            $table->foreignId('dosen_id')->constrained('users')->cascadeOnDelete();
            $table->enum('vote', ['setuju', 'tidak_setuju']);
            $table->timestamps();
            $table->unique(['title_submission_id', 'dosen_id']);
        });
        Schema::table('exam_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('exam_registrations', 'documents')) $table->json('documents')->nullable()->after('document_path');
            foreach (['supervisor_1_id','supervisor_2_id','examiner_1_id','examiner_2_id','examiner_3_id','chairman_id','secretary_id'] as $col) {
                if (!Schema::hasColumn('exam_registrations', $col)) $table->foreignId($col)->nullable()->constrained('users')->nullOnDelete();
            }
        });
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('app_settings');
        Schema::dropIfExists('title_votes');
        Schema::table('exam_registrations', function (Blueprint $table) {
            foreach (['documents','supervisor_1_id','supervisor_2_id','examiner_1_id','examiner_2_id','examiner_3_id','chairman_id','secretary_id'] as $col) {
                if (Schema::hasColumn('exam_registrations', $col)) $table->dropColumn($col);
            }
        });
        Schema::table('title_submissions', fn(Blueprint $table) => Schema::hasColumn('title_submissions','sks') ? $table->dropColumn('sks') : null);
        Schema::table('users', fn(Blueprint $table) => Schema::hasColumn('users','position') ? $table->dropColumn('position') : null);
    }
};
