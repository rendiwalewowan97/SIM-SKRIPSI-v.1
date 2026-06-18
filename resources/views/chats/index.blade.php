@extends('layouts.app')

@section('content')
<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Chat Masuk</h1>
</div>

<div class="rounded bg-white shadow">
    @forelse($users as $user)
        <a href="{{ route('chats.show', $user) }}"
           class="flex items-center justify-between border-b p-4 hover:bg-slate-50">

            <div>
                <div class="font-semibold">
                    {{ $user->name }}
                </div>

                <div class="text-sm text-slate-500">
                    {{ $user->identifier ?? '-' }} · {{ ucfirst($user->role) }}
                </div>
            </div>

            <span class="rounded bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                Buka Chat
            </span>
        </a>
    @empty
        <div class="p-4 text-center text-slate-500">
            Belum ada mahasiswa yang bisa diajak chat.
        </div>
    @endforelse
</div>
@endsection