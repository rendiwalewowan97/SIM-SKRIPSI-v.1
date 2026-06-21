<?php

return [
    'enabled' => env('FCM_ENABLED', false),

    'project_id' => env('FCM_PROJECT_ID'),
    'vapid_key' => env('FCM_VAPID_KEY'),

    'web' => [
        'apiKey' => env('FIREBASE_API_KEY'),
        'authDomain' => env('FIREBASE_AUTH_DOMAIN'),
        'projectId' => env('FCM_PROJECT_ID'),
        'storageBucket' => env('FIREBASE_STORAGE_BUCKET'),
        'messagingSenderId' => env('FIREBASE_MESSAGING_SENDER_ID'),
        'appId' => env('FIREBASE_APP_ID'),
    ],

    'credentials' => base_path(env('GOOGLE_APPLICATION_CREDENTIALS')),
];