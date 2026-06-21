<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'position', 'identifier', 'phone'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }

    public function titleSubmissions() { return $this->hasMany(TitleSubmission::class, 'student_id'); }
    public function supervisedTitles() { return $this->hasMany(TitleSubmission::class, 'supervisor_id'); }
    public function guidanceSessions() { return $this->hasMany(GuidanceSession::class, 'student_id'); }
    public function supervisedGuidances() { return $this->hasMany(GuidanceSession::class, 'supervisor_id'); }
    public function examRegistrations() { return $this->hasMany(ExamRegistration::class, 'student_id'); }
    public function thesisArchives() { return $this->hasMany(ThesisArchive::class, 'student_id'); }
    public function internalNotifications() { return $this->hasMany(Notification::class); }

    public function isJurusan(): bool { return $this->role === 'jurusan'; }
    public function isKetuaJurusan(): bool { return $this->role === 'dosen' && $this->position === 'ketua_jurusan'; }
    public function isDosen(): bool { return $this->role === 'dosen'; }
    public function isMahasiswa(): bool { return $this->role === 'mahasiswa'; }

    public function titles(){ return $this->hasMany(TitleSubmission::class, 'student_id'); }

    public function fcmTokens(){ return $this->hasMany(\App\Models\FcmToken::class); }
}
