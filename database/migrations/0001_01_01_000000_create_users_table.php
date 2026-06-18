<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role',['mahasiswa','dosen','jurusan'])->default('mahasiswa');
            $table->string('position')->nullable()->after('role');
            $table->string('identifier')->nullable();
            $table->string('phone')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', fn(Blueprint $t)=>[
            $t->string('email')->primary(),
            $t->string('token'),
            $t->timestamp('created_at')->nullable()
        ]);

        Schema::create('sessions', fn(Blueprint $t)=>[
            $t->string('id')->primary(),
            $t->foreignId('user_id')->nullable()->index(),
            $t->string('ip_address',45)->nullable(),
            $t->text('user_agent')->nullable(),
            $t->longText('payload'),
            $t->integer('last_activity')->index()
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
