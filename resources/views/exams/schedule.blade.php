@extends('layouts.app')
@section('content')
<h1 class="mb-4 text-2xl font-bold">Verifikasi & Jadwalkan Sidang</h1>
<div class="mb-4 rounded bg-white p-4 shadow">
    <p><b>Mahasiswa:</b> {{ $exam->student->name }}</p>
    <p><b>Jenis:</b> {{ str_replace('_',' ', $exam->type) }}</p>
    <p><b>Catatan:</b> {{ $exam->notes ?? '-' }}</p>
    @if($exam->documents)
        <div class="mt-2"><b>Dokumen:</b>
            <ul class="list-disc pl-6">
            @foreach($exam->documents as $label => $path)
                <li><a class="text-indigo-700" target="_blank" href="{{ asset('storage/'.$path) }}">{{ ucwords(str_replace('_',' ', $label)) }}</a></li>
            @endforeach
            </ul>
        </div>
    @endif
</div>
<form method="POST" action="{{ route('exams.verify',$exam) }}" class="rounded bg-white p-4 shadow">@csrf
    <label class="mb-2 block font-semibold">Status</label>
    <select name="status" class="mb-4 w-full rounded border p-2" required>@foreach(['diajukan','diverifikasi','dijadwalkan','ditolak','selesai'] as $s)<option value="{{ $s }}" @selected(old('status',$exam->status)==$s)>{{ strtoupper($s) }}</option>@endforeach</select>
    <div class="grid gap-4 md:grid-cols-2">
        <div><label class="mb-2 block font-semibold">Tanggal/Jam Sidang</label><input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', optional($exam->scheduled_at)->format('Y-m-d\TH:i')) }}" class="mb-4 w-full rounded border p-2"></div>
        <div><label class="mb-2 block font-semibold">Ruangan</label><input name="room" value="{{ old('room',$exam->room) }}" class="mb-4 w-full rounded border p-2"></div>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        @foreach(['supervisor_1_id'=>'Dosen Pembimbing 1','supervisor_2_id'=>'Dosen Pembimbing 2','examiner_1_id'=>'Dosen Penguji 1','examiner_2_id'=>'Dosen Penguji 2','examiner_3_id'=>'Dosen Penguji 3','chairman_id'=>'Ketua Sidang','secretary_id'=>'Sekretaris Sidang'] as $name => $label)
        <div><label class="mb-2 block font-semibold">{{ $label }}</label><select name="{{ $name }}" class="w-full rounded border p-2"><option value="">-- Pilih Dosen --</option>@foreach($dosens as $dosen)<option value="{{ $dosen->id }}" @selected(old($name, $exam->{$name}) == $dosen->id)>{{ $dosen->name }} - {{ $dosen->identifier }}</option>@endforeach</select></div>
        @endforeach
    </div>
    <label class="mb-2 mt-4 block font-semibold">Catatan Jurusan</label><textarea name="notes" rows="5" class="mb-4 w-full rounded border p-2">{{ old('notes',$exam->notes) }}</textarea>
    <button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan</button>
</form>
@endsection
