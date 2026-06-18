<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeNotificationCreated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public array $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = [
            'id' => $notification->id,
            'user_id' => $notification->user_id,
            'title' => $notification->title,
            'message' => $notification->message,
            'url' => $notification->url,
            'read_at' => optional($notification->read_at)->toDateTimeString(),
            'created_at' => optional($notification->created_at)->diffForHumans(),
        ];
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('notifications.'.$this->notificationUserId())];
    }

    public function broadcastAs(): string
    {
        return 'notification.created';
    }

    private function notificationUserId(): int
    {
        return (int) ($this->notification['user_id'] ?? request()->user()?->id ?? 0);
    }
}
