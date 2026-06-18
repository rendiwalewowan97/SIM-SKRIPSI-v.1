@extends('layouts.app')
@section('content')
<div class="mb-4 flex items-center justify-between"><h1 class="text-2xl font-bold">Arsip Skripsi</h1>
        @if(auth()->user()->isJurusan())
        <a href="{{ route('archives.create') }}"
           class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
            Tambah Arsip
        </a>
    @endif
</div>
<form class="mb-4 flex gap-2"><input name="q" value="{{ request('q') }}" class="w-full rounded border p-2" placeholder="Cari judul, keyword, tahun"><button class="rounded bg-slate-800 px-4 py-2 text-white">Cari</button></form>
<div class="grid gap-4 md:grid-cols-2">@forelse($items as $a)<div class="rounded bg-white p-4 shadow"><div class="flex justify-between gap-2"><h2 class="font-bold text-indigo-700"><a href="{{ route('archives.show',$a) }}">{{ $a->title }}</a></h2><span class="text-sm text-slate-500">{{ $a->year }}</span></div><p class="text-sm text-slate-500">{{ $a->student->name }} · {{ $a->keywords }}</p><div class="mt-3 flex gap-3 text-sm"><a class="text-indigo-700" target="_blank" href="{{ asset('storage/'.$a->file_path) }}">File Skripsi</a>@if($a->abstract_path)<a class="text-indigo-700" target="_blank" href="{{ asset('storage/'.$a->abstract_path) }}">Abstrak</a>@endif 
@if(auth()->user()->isJurusan())
    <a class="text-blue-700 hover:text-blue-900"
       href="{{ route('archives.edit',$a) }}">
        Edit
    </a>
@endif
</div>
</div>@empty <p class="text-slate-500">Belum ada arsip.</p>@endforelse</div><div class="mt-4">{{ $items->links() }}</div>
@endsection
