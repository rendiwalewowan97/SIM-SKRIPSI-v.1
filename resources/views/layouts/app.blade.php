<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIM Skripsi') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

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

            <a href="{{ route('notifications.index') }}"
               class="flex items-center gap-3 rounded px-3 py-2 transition hover:bg-[#74B3B5]">
                🔔 <span>Notifikasi</span>
            </a>

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

