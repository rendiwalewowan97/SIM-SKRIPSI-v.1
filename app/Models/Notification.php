<?php

namespace App\Models;

use App\Events\RealtimeNotificationCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (Notification $notification) {
            broadcast(new RealtimeNotificationCreated($notification));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
