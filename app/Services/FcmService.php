<?php

namespace App\Services;

use App\Models\User;
use Google\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    public function sendToUser(User $user, string $title, string $body, ?string $url = null): void
    {
        if (!config('firebase.enabled')) {
            return;
        }

        $tokens = $user->fcmTokens()->pluck('token')->unique()->values()->toArray();

        foreach ($tokens as $token) {
            $this->sendToToken($token, $title, $body, $url);
        }
    }

    private function sendToToken(string $token, string $title, string $body, ?string $url = null): void
    {
        $projectId = config('firebase.project_id');

        $client = new Client();
        $client->setAuthConfig(config('firebase.credentials'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'] ?? null;

        if (!$accessToken) {
            return;
        }

        $response = Http::withToken($accessToken)->post(
            "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send",
            [
                'message' => [
                    'token' => $token,

                    // DATA ONLY agar tidak muncul double notification
                    'data' => [
                        'title' => $title,
                        'body' => $body,
                        'url' => $url ?? url('/notifications'),
                    ],
                ],
            ]
        );

        Log::info('FCM RESPONSE', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
    }
}