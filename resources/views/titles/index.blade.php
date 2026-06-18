@extends('layouts.app')

@section('content')

<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Pengajuan Judul</h1>

@if(auth()->user()->isMahasiswa())
    <a href="{{ route('titles.create') }}"
       class="rounded bg-indigo-600 px-4 py-2 text-white">
        Ajukan Judul
    </a>
@endif

</div>

<form class="mb-4 grid gap-2 md:grid-cols-4">
    <input name="q"
           value="{{ request('q') }}"
           class="rounded border p-2 md:col-span-2"
           placeholder="Cari judul/mahasiswa">

<select name="status" class="rounded border p-2">
    <option value="">Semua status</option>
    @foreach(['Diajukan','Disetujui','Ditolak','Revisi'] as $s)
        <option value="{{ $s }}" @selected(request('status') == $s)>
            {{ $s }}
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
                <th class="p-3 text-left">Judul</th>
                <th>Mahasiswa</th>
                <th>Dosen</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

    <tbody>
        @forelse($items as $t)
            <tr class="border-t">
                <td class="p-3 font-medium">
                    {{ $t->title }}
                </td>

                <td>{{ $t->student->name }}</td>

                <td>{{ $t->supervisor->name ?? '-' }}</td>

                <td>
                    <x-status :value="$t->status" />
                </td>

                <td class="whitespace-nowrap">
                    <div class="flex items-center justify-center gap-3">

                        {{-- Detail --}}
                        <a href="{{ route('titles.show', $t) }}"
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

                        {{-- Edit / Review --}}
                        @if(auth()->user()->isJurusan() || (auth()->id() == $t->student_id && in_array($t->status, ['diajukan','revisi'])))
                            <a href="{{ route('titles.edit', $t) }}"
                               class="text-blue-700 hover:text-blue-900"
                               title="Edit / Review">
                                <svg class="w-5 h-5"
                                     aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24">
                                    <path stroke="currentColor"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                </svg>
                            </a>
                        @endif            

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-4 text-center text-slate-500">
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
