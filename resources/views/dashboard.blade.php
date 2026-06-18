@extends('layouts.app')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <p class="text-slate-500">Monitoring proses skripsi, bimbingan, sidang, dan arsip.</p>
</div>
<div class="grid gap-4 md:grid-cols-3 lg:grid-cols-6">
    @foreach($stats as $label=>$value)
    <div class="rounded bg-white p-4 shadow"><div class="text-sm text-slate-500">{{ ucwords(str_replace('_',' ', $label)) }}</div><div class="text-3xl font-bold">{{ $value }}</div></div>
    @endforeach
</div>
<div class="mt-6 grid gap-4 lg:grid-cols-2">
    <section class="rounded bg-white p-4 shadow"><h2 class="mb-3 font-bold">Judul Terbaru</h2>@forelse($titles as $t)<div class="border-t py-2"><a class="font-semibold text-indigo-700" href="{{ route('titles.show',$t) }}">{{ $t->title }}</a><div class="text-sm text-slate-500">{{ $t->student->name }} · <x-status :value="$t->status" /></div></div>@empty <p class="text-slate-500">Belum ada data.</p>@endforelse</section>
    <section class="rounded bg-white p-4 shadow"><h2 class="mb-3 font-bold">Bimbingan Terbaru</h2>@forelse($guidances as $g)<div class="border-t py-2"><a class="font-semibold text-indigo-700" href="{{ route('guidances.show',$g) }}">{{ ucfirst($g->type) }} - {{ $g->chapter }}</a><div class="text-sm text-slate-500">{{ $g->student->name }} · <x-status :value="$g->status" /></div></div>@empty <p class="text-slate-500">Belum ada data.</p>@endforelse</section>
    <section class="rounded bg-white p-4 shadow"><h2 class="mb-3 font-bold">Pendaftaran Sidang</h2>@forelse($exams as $e)<div class="border-t py-2"><a class="font-semibold text-indigo-700" href="{{ route('exams.show',$e) }}">{{ str_replace('_',' ', $e->type) }}</a><div class="text-sm text-slate-500">{{ $e->student->name }} · <x-status :value="$e->status" /></div></div>@empty <p class="text-slate-500">Belum ada data.</p>@endforelse</section>
    <section class="rounded bg-white p-4 shadow"><h2 class="mb-3 font-bold">Notifikasi</h2>@forelse($notifications as $n)<div class="border-t py-2"><a class="font-semibold text-indigo-700" href="{{ route('notifications.read',$n) }}">{{ $n->title }}</a><div class="text-sm text-slate-500">{{ $n->created_at->diffForHumans() }}</div></div>@empty <p class="text-slate-500">Belum ada notifikasi.</p>@endforelse</section>
</div>
@endsection
