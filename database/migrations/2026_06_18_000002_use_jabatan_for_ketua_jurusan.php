<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'position')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('position')->nullable()->after('role');
            });
        }

        try {
            DB::statement("UPDATE users SET position = 'ketua_jurusan', role = 'dosen' WHERE role = 'ketua_jurusan'");
        } catch (\Throwable $e) {
            // Database lama mungkin belum mengenal enum ketua_jurusan.
        }

        try {
            DB::statement("ALTER TABLE users MODIFY role ENUM('mahasiswa','dosen','jurusan') NOT NULL DEFAULT 'mahasiswa'");
        } catch (\Throwable $e) {
            // Abaikan jika driver database bukan MySQL atau struktur sudah sesuai.
        }
    }

    public function down(): void
    {
        // Tidak menghapus position agar data ketua jurusan tidak hilang.
    }
};
