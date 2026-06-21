@extends('layouts.app')

@section('content')
<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Notifikasi</h1>

    <div class="flex gap-2">
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <button class="rounded bg-slate-800 px-4 py-2 text-white">
                Tandai Semua Dibaca
            </button>
        </form>

        <form method="POST" action="{{ route('notifications.clearRead') }}">
            @csrf
            @method('DELETE')
            <button
                onclick="return confirm('Hapus semua notifikasi yang sudah dibaca?')"
                class="rounded bg-red-600 px-4 py-2 text-white">
                Bersihkan Pesan yang Sudah Dibaca
            </button>
        </form>
    </div>
</div>

<div class="rounded bg-white shadow">
    @forelse($items as $n)
        <div class="border-t p-4 hover:bg-slate-50 {{ $n->read_at ? 'opacity-70' : '' }}">
            <div class="flex items-start justify-between gap-4">

                <a href="{{ route('notifications.read', $n) }}" class="block flex-1">
                    <div class="flex justify-between gap-4">
                        <h2 class="font-bold">{{ $n->title }}</h2>
                        <span class="text-sm text-slate-500">
                            {{ $n->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <p class="text-slate-600">{{ $n->message }}</p>

                    @unless($n->read_at)
                        <span class="mt-2 inline-block rounded bg-indigo-100 px-2 py-1 text-xs text-indigo-700">
                            Baru
                        </span>
                    @endunless
                </a>

                @if($n->read_at)
                    <form method="POST" action="{{ route('notifications.destroy', $n) }}">
                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Hapus notifikasi ini?')"
                            class="rounded bg-red-500 px-3 py-1 text-xs text-white hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                @endif

            </div>
        </div>
    @empty
        <p class="p-4 text-slate-500">Belum ada notifikasi.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $items->links() }}
</div>
@endsection