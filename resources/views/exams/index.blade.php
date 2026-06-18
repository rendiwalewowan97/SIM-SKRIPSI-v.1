@extends('layouts.app')

@section('content')

<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Pendaftaran Seminar/Sidang</h1>


@if(auth()->user()->isMahasiswa())
    <a href="{{ route('exams.create') }}"
       class="rounded bg-indigo-600 px-4 py-2 text-white">
        Daftar Sidang
    </a>
@endif

</div>

<form class="mb-4 grid gap-2 md:grid-cols-4">
    <select name="type" class="rounded border p-2">
        <option value="">Semua jenis</option>
        @foreach(['seminar_proposal','sidang_skripsi'] as $s)
            <option value="{{ $s }}" @selected(request('type') == $s)>
                {{ str_replace('_', ' ', $s) }}
            </option>
        @endforeach
    </select>

<select name="status" class="rounded border p-2">
    <option value="">Semua status</option>
    @foreach(['diajukan','diverifikasi','dijadwalkan','ditolak','selesai'] as $s)
        <option value="{{ $s }}" @selected(request('status') == $s)>
            {{ strtoupper($s) }}
        </option>
    @endforeach
</select>

<button class="rounded bg-slate-800 px-4 py-2 text-white">
    Filter
</button>

</form>

<div class="overflow-x-auto rounded bg-white shadow">
    <table class="w-full text-sm">
        <thead class="bg-slate-100">
            <tr>
                <th class="p-3 text-left">Jenis</th>
                <th>Mahasiswa</th>
                <th>Jadwal</th>
                <th>Ruangan</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

    <tbody>
        @forelse($items as $e)
            <tr class="border-t">
                <td class="p-3">
                    {{ str_replace('_', ' ', $e->type) }}
                </td>

                <td>{{ $e->student->name }}</td>

                <td>
                    {{ $e->scheduled_at?->format('d/m/Y H:i') ?? '-' }}
                </td>

                <td>{{ $e->room ?? '-' }}</td>

                <td>
                    <x-status :value="$e->status" />
                </td>

                <td class="whitespace-nowrap">
                    <div class="flex items-center justify-center gap-3">

                        {{-- Detail --}}
                        <a href="{{ route('exams.show', $e) }}"
                           class="text-indigo-700 hover:text-indigo-900"
                           title="Detail">
                            <svg class="w-5 h-5"
                                 aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24">
                                <path stroke="currentColor"
                                      stroke-width="2"
                                      d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                <path stroke="currentColor"
                                      stroke-width="2"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </a>

                        {{-- Verifikasi / Jadwal --}}
                        @if(auth()->user()->isJurusan())
                            <a href="{{ route('exams.edit', $e) }}"
                               class="text-blue-700 hover:text-blue-900"
                               title="Verifikasi / Jadwal">
                                <svg class="w-5 h-5"
                                     aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24">
                                    <path stroke="currentColor"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z"/>
                                </svg>
                            </a>
                        @endif

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-slate-500">
                    Belum ada data.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</div>

<div class="mt-4">
    {{ $items->links() }}
</div>
@endsection
