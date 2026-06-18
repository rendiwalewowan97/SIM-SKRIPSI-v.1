@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="rounded-xl bg-white p-6 shadow">
        <div class="border-b pb-4">
            <h1 class="text-2xl font-bold">{{ $archive->title }}</h1>
            <p class="text-sm text-slate-500">Detail arsip skripsi mahasiswa</p>
        </div>

        <dl class="mt-6 grid gap-5 md:grid-cols-2">
            <div>
                <dt class="text-sm text-slate-500">Mahasiswa</dt>
                <dd>{{ $archive->student->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-slate-500">Tahun</dt>
                <dd>{{ $archive->year }}</dd>
            </div>
            <div>
                <dt class="text-sm text-slate-500">Keyword</dt>
                <dd>{{ $archive->keywords ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-slate-500">Publik</dt>
                <dd>{{ $archive->is_public ? 'Ya' : 'Tidak' }}</dd>
            </div>
        </dl>

        <div class="mt-8 border-t pt-6">
            <h2 class="mb-3 text-lg font-semibold">Dokumen Arsip</h2>
            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                <a href="{{ route('archives.preview', [$archive, 'skripsi']) }}"
                   target="_blank"
                   class="rounded-lg bg-indigo-600 px-4 py-2 text-center text-white hover:bg-indigo-700">
                    Preview File Skripsi
                </a>

                <a href="{{ route('archives.download', [$archive, 'skripsi']) }}"
                   class="rounded-lg bg-green-600 px-4 py-2 text-center text-white hover:bg-green-700">
                    Download File Skripsi
                </a>

                @if($archive->abstract_path)
                    <a href="{{ route('archives.preview', [$archive, 'abstract']) }}"
                       target="_blank"
                       class="rounded-lg bg-slate-700 px-4 py-2 text-center text-white hover:bg-slate-800">
                        Preview Abstrak
                    </a>

                    <a href="{{ route('archives.download', [$archive, 'abstract']) }}"
                       class="rounded-lg bg-emerald-600 px-4 py-2 text-center text-white hover:bg-emerald-700">
                        Download Abstrak
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="rounded-xl bg-white p-6 shadow">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold">Preview Skripsi</h2>
            <span class="text-sm text-slate-500">PDF ditampilkan langsung dari local project</span>
        </div>

        <iframe src="{{ route('archives.preview', [$archive, 'skripsi']) }}"
                class="h-[750px] w-full rounded-lg border"
                title="Preview File Skripsi"></iframe>
    </div>

    @if($archive->abstract_path)
        <div class="rounded-xl bg-white p-6 shadow">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold">Preview Abstrak</h2>
                <span class="text-sm text-slate-500">PDF ditampilkan langsung dari local project</span>
            </div>

            <iframe src="{{ route('archives.preview', [$archive, 'abstract']) }}"
                    class="h-[600px] w-full rounded-lg border"
                    title="Preview File Abstrak"></iframe>
        </div>
    @endif
</div>
@endsection
