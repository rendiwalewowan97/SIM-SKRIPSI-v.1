<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'SIM Skripsi')); ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>
</head>

<?php if(config('firebase.enabled') && auth()->check()): ?>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js";
    import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-messaging.js";

    const firebaseConfig = <?php echo json_encode(config('firebase.web'), 15, 512) ?>;

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
                vapidKey: "<?php echo e(config('firebase.vapid_key')); ?>",
                serviceWorkerRegistration: registration
            });

            console.log('FCM TOKEN:', token);

            if (!token) {
                console.log('Token FCM kosong.');
                return;
            }

            const response = await fetch("<?php echo e(route('fcm.token.store')); ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
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
<?php endif; ?>

<body class="bg-slate-50 text-slate-800">

<div class="flex min-h-screen">

    
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full overflow-y-auto bg-[#81C1C3] text-white shadow-xl transition-transform duration-300 md:translate-x-0">

        
        <div class="px-5 pt-6 pb-5">
            <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3">
                <img src="<?php echo e(asset('images/logo-unmus.png')); ?>"
                    class="h-12 w-12 rounded-full"
                    alt="Logo">

                <div>
                    <div class="text-2xl font-bold leading-tight">
                        SIM Skripsi
                    </div>
                    <div class="text-sm font-semibold text-white/90">
                        Universitas Musamus
                    </div>
                </div>
            </a>

            <button onclick="toggleSidebar()"
                class="absolute right-4 top-4 text-xl md:hidden">
                ✕
            </button>
        </div>

        <?php if(auth()->guard()->check()): ?>
        <nav class="px-4 pb-6 text-base font-semibold">

            
            <a href="<?php echo e(route('dashboard')); ?>"
                class="mb-1.5 flex items-center gap-3 rounded-2xl px-4 py-3 transition
                <?php echo e(request()->routeIs('dashboard')
                    ? 'bg-white text-[#2D9EA3] shadow-lg'
                    : 'text-white hover:bg-white/15'); ?>">

                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 0 0-1.414 0l-7 7A1 1 0 0 0 3 11h1v6a1 1 0 0 0 1 1h4v-4h2v4h4a1 1 0 0 0 1-1v-6h1a1 1 0 0 0 .707-1.707l-7-7Z"/>
                </svg>

                <span>Dashboard</span>
            </a>

            
            <a href="<?php echo e(route('archives.index')); ?>"
                class="mb-1.5 flex items-center gap-3 rounded-2xl px-4 py-3 transition
                <?php echo e(request()->routeIs('archives.*')
                    ? 'bg-white text-[#2D9EA3] shadow-lg'
                    : 'text-white hover:bg-white/15'); ?>">

                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 3a2 2 0 0 0-2 2v2h16V5a2 2 0 0 0-2-2H4Zm14 6H2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9Zm-5 3a1 1 0 1 1 0 2H7a1 1 0 1 1 0-2h6Z"/>
                </svg>

                <span>Arsip</span>
            </a>

            
            <a href="<?php echo e(route('titles.index')); ?>"
                class="mb-1.5 flex items-center gap-3 rounded-2xl px-4 py-3 transition
                <?php echo e(request()->routeIs('titles.*')
                    ? 'bg-white text-[#2D9EA3] shadow-lg'
                    : 'text-white hover:bg-white/15'); ?>">

                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H4Zm7 1.5V8h4.5L11 3.5ZM6 11h8a1 1 0 1 1 0 2H6a1 1 0 1 1 0-2Zm0 3h5a1 1 0 1 1 0 2H6a1 1 0 1 1 0-2Z"/>
                </svg>

                <span>Judul</span>
            </a>

            <?php if(auth()->user()->isMahasiswa() || auth()->user()->isDosen()): ?>
            
            <a href="<?php echo e(route('guidances.index')); ?>"
                class="mb-1.5 flex items-center gap-3 rounded-2xl px-4 py-3 transition
                <?php echo e(request()->routeIs('guidances.*')
                    ? 'bg-white text-[#2D9EA3] shadow-lg'
                    : 'text-white hover:bg-white/15'); ?>">

                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6.5 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM7 10c-3.314 0-6 1.79-6 4v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-1c0-2.21-2.686-4-6-4Zm6.5.5c-.6 0-1.166.08-1.676.225A4.77 4.77 0 0 1 15 15v1h3a1 1 0 0 0 1-1v-.5c0-2.21-2.462-4-5.5-4Z"/>
                </svg>

                <span>Bimbingan</span>
            </a>
            <?php endif; ?>

            <?php if(!auth()->user()->isDosen()): ?>
            
            <a href="<?php echo e(route('exams.index')); ?>"
                class="mb-1.5 flex items-center gap-3 rounded-2xl px-4 py-3 transition
                <?php echo e(request()->routeIs('exams.*')
                    ? 'bg-white text-[#2D9EA3] shadow-lg'
                    : 'text-white hover:bg-white/15'); ?>">

                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6 2a1 1 0 0 1 1 1v1h6V3a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v2H2V6a2 2 0 0 1 2-2h1V3a1 1 0 0 1 1-1Zm12 8v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-6h16ZM5 12v2h2v-2H5Zm4 0v2h2v-2H9Zm4 0v2h2v-2h-2Z"/>
                </svg>

                <span>Sidang</span>
            </a>
            <?php endif; ?>

            
            <a href="<?php echo e(route('progress.index')); ?>"
                class="mb-1.5 flex items-center gap-3 rounded-2xl px-4 py-3 transition
                <?php echo e(request()->routeIs('progress.*')
                    ? 'bg-white text-[#2D9EA3] shadow-lg'
                    : 'text-white hover:bg-white/15'); ?>">

                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 3a1 1 0 0 1 1 1v11h12a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm13.707 4.293a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0L9 10.414l-3.293 3.293a1 1 0 0 1-1.414-1.414l4-4a1 1 0 0 1 1.414 0L12 10.586l3.293-3.293a1 1 0 0 1 1.414 0Z"/>
                </svg>

                <span>Monitoring</span>
            </a>

            
            <!-- <?php ($sidebarUnreadNotifications = $unreadNotifications ?? auth()->user()->internalNotifications()->whereNull('read_at')->count()); ?>
            <a href="<?php echo e(route('notifications.index')); ?>"
                class="mb-1.5 flex items-center gap-3 rounded-2xl px-4 py-3 transition
                <?php echo e(request()->routeIs('notifications.*')
                    ? 'bg-white text-[#2D9EA3] shadow-lg'
                    : 'text-white hover:bg-white/15'); ?>">

                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a5 5 0 0 0-5 5v2.586L4.293 10.293A1 1 0 0 0 5 12h10a1 1 0 0 0 .707-1.707L15 9.586V7a5 5 0 0 0-5-5Zm0 16a2 2 0 0 0 1.995-1.85L12 16H8a2 2 0 0 0 2 2Z"/>
                </svg>

                <span class="flex-1">Notifikasi</span>

                <span id="notificationBadge"
                    class="<?php echo e($sidebarUnreadNotifications ? '' : 'hidden'); ?> rounded-full bg-red-600 px-2 py-0.5 text-xs font-bold text-white">
                    <?php echo e($sidebarUnreadNotifications); ?>

                </span>
            </a> -->

            <?php if(auth()->user()->isJurusan()): ?>
            
            <a href="<?php echo e(route('users.index')); ?>"
                class="mb-1.5 flex items-center gap-3 rounded-2xl px-4 py-3 transition
                <?php echo e(request()->routeIs('users.*')
                    ? 'bg-white text-[#2D9EA3] shadow-lg'
                    : 'text-white hover:bg-white/15'); ?>">

                <svg class="h-6 w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 8a7 7 0 1 1 14 0H3Z"/>
                </svg>

                <span>Pengguna</span>
            </a>
            <?php endif; ?>

        </nav>
        <?php endif; ?>
    </aside>

    
    <div id="overlay"
         onclick="toggleSidebar()"
         class="fixed inset-0 z-30 hidden bg-black/40 md:hidden"></div>

    
    <div class="flex-1 md:ml-64">

    
    <header class="sticky top-0 z-20 flex items-center justify-between bg-[#81C1C3] px-4 py-3 text-white shadow">

        <div class="flex items-center gap-6">

            
            <button onclick="toggleSidebar()"
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 text-white transition hover:bg-white/30 md:hidden">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
                </svg>
            </button>

            <div>
                <h1 class="text-base font-bold leading-tight md:text-lg">
                    SIM Skripsi & Bimbingan
                </h1>
                <p class="hidden text-xs text-white/80 md:block">
                    Universitas Musamus
                </p>
            </div>

        </div>

        <?php if(auth()->guard()->check()): ?>
        <div class="flex items-center gap-6">

            <?php ($topUnreadNotifications = $unreadNotifications ?? auth()->user()->internalNotifications()->whereNull('read_at')->count()); ?>

            
            <a href="<?php echo e(route('notifications.index')); ?>"
            class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-amber-400 text-white shadow-md transition duration-200 hover:scale-105 hover:bg-amber-500"
            title="Notifikasi">

                <svg class="h-6 w-6"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 20 20">
                    <path d="M10 2a5 5 0 0 0-5 5v2.586L4.293 10.293A1 1 0 0 0 5 12h10a1 1 0 0 0 .707-1.707L15 9.586V7a5 5 0 0 0-5-5Zm0 16a2 2 0 0 0 1.995-1.85L12 16H8a2 2 0 0 0 2 2Z"/>
                </svg>

                <span id="topNotificationBadge"
                    class="<?php echo e($topUnreadNotifications ? '' : 'hidden'); ?> absolute -right-1.5 -top-1.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-red-600 px-1 text-xs font-bold text-white ring-2 ring-white">
                    <?php echo e($topUnreadNotifications); ?>

                </span>

            </a>

            
            <div class="hidden text-right sm:block">
                <div class="text-sm font-semibold text-white">
                    <?php echo e(auth()->user()->name); ?>

                </div>
                <div class="text-xs capitalize text-white/80">
                    <?php echo e(str_replace('_', ' ', auth()->user()->role)); ?>

                </div>
            </div>

            
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit"
                        class="flex h-10 items-center gap-2 rounded-xl bg-white/20 px-3 text-sm font-semibold text-white transition hover:bg-white/30"
                        title="Logout">

                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H3"/>
                    </svg>

                    <span class="hidden md:inline">Logout</span>
                </button>
            </form>

        </div>
        <?php endif; ?>

    </header>

        <main class="mx-auto max-w-7xl p-4">

            <?php if(session('success')): ?>
                <div class="mb-4 rounded border border-green-200 bg-green-50 p-3 text-green-700">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-red-700">
                    <ul class="list-disc pl-5">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($e); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>

        </main>

    </div>

</div>

<?php if(auth()->guard()->check()): ?>
<div id="realtimeNotificationToast" class="fixed right-4 top-20 z-50 hidden w-80 rounded-lg border border-slate-200 bg-white p-4 text-slate-800 shadow-xl">
    <div class="flex items-start gap-3">
        <div class="text-2xl">🔔</div>
        <div class="min-w-0 flex-1">
            <div id="toastNotificationTitle" class="font-bold"></div>
            <div id="toastNotificationMessage" class="mt-1 text-sm text-slate-600"></div>
            <a id="toastNotificationLink" href="<?php echo e(route('notifications.index')); ?>" class="mt-2 inline-block text-sm font-semibold text-[#5FA9AD] hover:underline">Buka notifikasi</a>
        </div>
        <button type="button" onclick="document.getElementById('realtimeNotificationToast').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
    </div>
</div>

<script>
    window.authUserId = <?php echo e(auth()->id()); ?>;

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
        link.href = notification.url || '<?php echo e(route('notifications.index')); ?>';
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
<?php endif; ?>

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

<?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/layouts/app.blade.php ENDPATH**/ ?>