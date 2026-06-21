<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIM Skripsi') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
</head>

@if(config('firebase.enabled') && auth()->check())
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js";
    import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-messaging.js";

    const firebaseConfig = @json(config('firebase.web'));

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    async function initFcm() {
        try {
            if (!('Notification' in window)) {
                console.log('Browser tidak mendukung notifikasi.');
                return;
            }

            if (!('serviceWorker' in navigator)) {
                console.log('Browser tidak mendukung service worker.');
                return;
            }

            const permission = await Notification.requestPermission();

            console.log('Notification permission:', permission);

            if (permission !== 'granted') {
                return;
            }

            const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');

            console.log('Service Worker berhasil:', registration);

            const token = await getToken(messaging, {
                vapidKey: "{{ config('firebase.vapid_key') }}",
                serviceWorkerRegistration: registration
            });

            console.log('FCM TOKEN:', token);

            if (!token) {
                console.log('Token FCM kosong.');
                return;
            }

            const response = await fetch("{{ route('fcm.token.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    token: token
                })
            });

            const result = await response.json();

            console.log('Simpan token response:', result);

        } catch (error) {
            console.error('FCM ERROR:', error);
        }
    }

    initFcm();

    // NOTIF MUNCUL KETIKA BROWSER DIBUKA
    // onMessage(messaging, (payload) => {
    //     console.log('FCM foreground:', payload);

    //     const title =
    //         payload.notification?.title ||
    //         payload.data?.title ||
    //         'SIM Skripsi';

    //     const body =
    //         payload.notification?.body ||
    //         payload.data?.body ||
    //         'Anda memiliki notifikasi baru.';

    //     new Notification(title, {
    //         body: body,
    //         icon: '/favicon.ico'
    //     });
    // });
</script>
@endif

<body class="bg-slate-50 text-slate-800">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full bg-[#81C1C3] text-white shadow-lg transition-transform duration-300 md:translate-x-0">

        <div class="flex items-center justify-between border-b border-[#74B3B5] px-4 py-4">
            <a href="{{ route('dashboard') }}" class="text-lg font-bold">
                SIM Skripsi
            </a>

            <button onclick="toggleSidebar()"
                    class="text-xl md:hidden">
                ✕
            </button>
        </div>

        @auth
        <nav class="space-y-1 p-4 text-sm">

            <a href="{{ route('archives.index') }}"
               class="flex items-center gap-3 rounded px-3 py-2 transition hover:bg-[#74B3B5]">
                🗂️ <span>Arsip</span>
            </a>

            <a href="{{ route('titles.index') }}"
               class="flex items-center gap-3 rounded px-3 py-2 transition hover:bg-[#74B3B5]">
                📄 <span>Judul</span>
            </a>

            @if(auth()->user()->isMahasiswa() || auth()->user()->isDosen())
            <a href="{{ route('guidances.index') }}"
               class="flex items-center gap-3 rounded px-3 py-2 transition hover:bg-[#74B3B5]">
                📚 <span>Bimbingan</span>
            </a>
            @endif

            @if(!auth()->user()->isDosen())
            <a href="{{ route('exams.index') }}"
               class="flex items-center gap-3 rounded px-3 py-2 transition hover:bg-[#74B3B5]">
                🗓️ <span>Sidang</span>
            </a>
            @endif

            <a href="{{ route('progress.index') }}"
               class="flex items-center gap-3 rounded px-3 py-2 transition hover:bg-[#74B3B5]">
                📈 <span>Monitoring</span>
            </a>

            <!-- <a href="{{ route('notifications.index') }}"
               class="relative flex items-center gap-3 rounded px-3 py-2 transition hover:bg-[#74B3B5]">
                🔔 <span>Notifikasi</span>
                @php($unreadNotifications = auth()->user()->internalNotifications()->whereNull('read_at')->count())
                <span id="notificationBadge"
                      class="{{ $unreadNotifications ? '' : 'hidden' }} ml-auto rounded-full bg-red-600 px-2 py-0.5 text-xs font-bold text-white">
                    {{ $unreadNotifications }}
                </span>
            </a> -->

            @if(auth()->user()->isJurusan())
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 rounded px-3 py-2 transition hover:bg-[#74B3B5]">
                👥 <span>Pengguna</span>
            </a>
            @endif

        </nav>
        @endauth
    </aside>

    {{-- Overlay Mobile --}}
    <div id="overlay"
         onclick="toggleSidebar()"
         class="fixed inset-0 z-30 hidden bg-black/40 md:hidden"></div>

    {{-- Main Content --}}
    <div class="flex-1 md:ml-64">

        {{-- Topbar --}}
        <header class="sticky top-0 z-20 flex items-center justify-between bg-[#81C1C3] px-4 py-3 text-white shadow">

            <div class="flex items-center gap-3">

                <button onclick="toggleSidebar()"
                        class="rounded bg-[#5FA9AD] px-3 py-2 text-white md:hidden">
                    ☰
                </button>

                <h1 class="font-bold">
                    SIM Skripsi & Bimbingan
                </h1>

            </div>

            @auth
            <div class="flex items-center gap-4">

                @php($topUnreadNotifications = $unreadNotifications ?? auth()->user()->internalNotifications()->whereNull('read_at')->count())
                <a href="{{ route('notifications.index') }}"
                   class="relative rounded bg-white/20 px-3 py-2 text-white transition hover:bg-white/30"
                   title="Notifikasi">
                    🔔
                    <span id="topNotificationBadge"
                          class="{{ $topUnreadNotifications ? '' : 'hidden' }} absolute -right-2 -top-2 rounded-full bg-red-600 px-1.5 py-0.5 text-xs font-bold text-white">
                        {{ $topUnreadNotifications }}
                    </span>
                </a>

                <div class="text-right">
                    <div class="font-semibold text-white">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="text-xs text-white/80">
                        {{ auth()->user()->role }}
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded bg-white/20 px-3 py-2 text-sm text-white transition hover:bg-white/30">
                        🚪 Logout
                    </button>
                </form>

            </div>
            @endauth

        </header>

        <main class="mx-auto max-w-7xl p-4">

            @if(session('success'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 p-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

@auth
<div id="realtimeNotificationToast" class="fixed right-4 top-20 z-50 hidden w-80 rounded-lg border border-slate-200 bg-white p-4 text-slate-800 shadow-xl">
    <div class="flex items-start gap-3">
        <div class="text-2xl">🔔</div>
        <div class="min-w-0 flex-1">
            <div id="toastNotificationTitle" class="font-bold"></div>
            <div id="toastNotificationMessage" class="mt-1 text-sm text-slate-600"></div>
            <a id="toastNotificationLink" href="{{ route('notifications.index') }}" class="mt-2 inline-block text-sm font-semibold text-[#5FA9AD] hover:underline">Buka notifikasi</a>
        </div>
        <button type="button" onclick="document.getElementById('realtimeNotificationToast').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
    </div>
</div>

<script>
    window.authUserId = {{ auth()->id() }};

    function incrementNotificationBadge() {
        ['notificationBadge', 'topNotificationBadge'].forEach((id) => {
            const badge = document.getElementById(id);
            if (!badge) return;
            const current = parseInt((badge.textContent || '0').trim(), 10) || 0;
            badge.textContent = current + 1;
            badge.classList.remove('hidden');
        });
    }

    function showRealtimeToast(notification) {
        const toast = document.getElementById('realtimeNotificationToast');
        const title = document.getElementById('toastNotificationTitle');
        const message = document.getElementById('toastNotificationMessage');
        const link = document.getElementById('toastNotificationLink');
        if (!toast || !title || !message || !link) return;

        title.textContent = notification.title || 'Notifikasi baru';
        message.textContent = notification.message || '';
        link.href = notification.url || '{{ route('notifications.index') }}';
        toast.classList.remove('hidden');

        setTimeout(() => toast.classList.add('hidden'), 8000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (!window.Echo || !window.authUserId) return;

        window.Echo.private(`notifications.${window.authUserId}`)
            .listen('.notification.created', (event) => {
                incrementNotificationBadge();
                showRealtimeToast(event.notification || event);
            });
    });
</script>
@endauth

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>

</body>
</html>

