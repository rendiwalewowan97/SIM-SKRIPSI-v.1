importScripts('https://www.gstatic.com/firebasejs/10.13.2/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.13.2/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyDyYLYSK_6DOFxYPMCnGqfyOVXlMQqBVr0",
    authDomain: "sim-skripsi.firebaseapp.com",
    projectId: "sim-skripsi",
    storageBucket: "sim-skripsi.firebasestorage.app",
    messagingSenderId: "461969760443",
    appId: "1:461969760443:web:7866f802134eecfc5dc99e"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    const notificationTitle =
        payload.notification?.title ||
        payload.data?.title ||
        'SIM Skripsi';

    const notificationOptions = {
        body:
            payload.notification?.body ||
            payload.data?.body ||
            'Anda memiliki notifikasi baru.',
        icon: '/favicon.ico',
        badge: '/favicon.ico',
        requireInteraction: true,
        data: {
            url:
                payload?.webpush?.fcm_options?.link ||
                payload?.fcmOptions?.link ||
                payload?.data?.url ||
                '/'
        }
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions
    );
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    const url = event.notification.data?.url || '/';

    event.waitUntil(
        clients.openWindow(url)
    );
});