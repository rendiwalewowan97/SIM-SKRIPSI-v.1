@extends('layouts.app')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Daftar Seminar/Sidang</h1>

<form method="POST"
      action="{{ route('exams.store') }}"
      enctype="multipart/form-data"
      class="rounded bg-white p-4 shadow">
    @csrf

    <label class="mb-2 block font-semibold">Jenis Pendaftaran</label>
    <select id="type" name="type" class="mb-4 w-full rounded border p-2" required>
        <option value="seminar_proposal">Seminar Proposal</option>
        <option value="sidang_skripsi">Sidang Skripsi</option>
    </select>

    {{-- FORM SEMINAR PROPOSAL --}}
    <div id="form-seminar-proposal">
        <label class="mb-2 block font-semibold">KRS dan KHS (Semester Awal s/d Akhir)</label>
        <input type="file" name="documents[krs_khs]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Transkip Nilai Sementara (Min. Lulus 120 SKS)</label>
        <input type="file" name="documents[transkip]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Tanda Tangan Kartu Asistensi Pembimbingan (Min. 6 kali)</label>
        <input type="file" name="documents[kartu_asistensi]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Kartu Kontrol Telah Mengikuti Seminar (Min. 6 kali)</label>
        <input type="file" name="documents[kartu_kontrol]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Surat Keterangan Bebas Plagiat (Max. 30%)</label>
        <input type="file" name="documents[bebas_plagiat]" class="mb-4 w-full rounded border p-2">
    </div>

    {{-- FORM SIDANG SKRIPSI --}}
    <div id="form-sidang-skripsi" class="hidden">
        <label class="mb-2 block font-semibold">KRS dan KHS (Semester Awal s/d Akhir)</label>
        <input type="file" name="documents[krs_khs]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Transkip Nilai Sementara (Min. Lulus 120 SKS)</label>
        <input type="file" name="documents[transkip]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Tanda Tangan Kartu Asistensi Pembimbingan (Min. 6 kali)</label>
        <input type="file" name="documents[kartu_asistensi]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Kartu Kontrol Telah Mengikuti Seminar (Min. 6 kali)</label>
        <input type="file" name="documents[kartu_kontrol]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Slip Pembayaran SPP (Semester 1 s/d Akhir)</label>
        <input type="file" name="documents[slip_spp]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Foto 4x6 Latar Merah (2 Lembar)</label>
        <input type="file" name="documents[foto]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">SK Pembimbing dan Tim Pelaksana Ujian</label>
        <input type="file" name="documents[sk_pembimbing]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Berita Acara Ujian Proposal</label>
        <input type="file" name="documents[berita_acara]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Surat Keterangan Bebas Plagiat (Max. 30%)</label>
        <input type="file" name="documents[bebas_plagiat]" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Naskah Lengkap</label>
        <input type="file" name="documents[naskah_lengkap]" class="mb-4 w-full rounded border p-2">
    </div>

    <label class="mb-2 block font-semibold">Catatan</label>
    <textarea name="notes" rows="5" class="mb-4 w-full rounded border p-2">{{ old('notes') }}</textarea>

    <button class="rounded bg-indigo-600 px-4 py-2 text-white">
        Kirim Pendaftaran
    </button>
</form>

<script>
    const typeSelect = document.getElementById('type');
    const formSeminar = document.getElementById('form-seminar-proposal');
    const formSidang = document.getElementById('form-sidang-skripsi');

    function disableInputs(container, status) {
        container.querySelectorAll('input').forEach(input => {
            input.disabled = status;

            if (status) {
                input.required = false;
            }
        });
    }

    function enableInputs(container) {
        container.querySelectorAll('input').forEach(input => {
            input.disabled = false;
            input.required = true;
        });
    }

    function toggleForm() {
        if (typeSelect.value === 'seminar_proposal') {
            formSeminar.classList.remove('hidden');
            formSidang.classList.add('hidden');

            enableInputs(formSeminar);
            disableInputs(formSidang, true);
        } else {
            formSeminar.classList.add('hidden');
            formSidang.classList.remove('hidden');

            disableInputs(formSeminar, true);
            enableInputs(formSidang);
        }
    }

    typeSelect.addEventListener('change', toggleForm);
    toggleForm();
</script>
@endsection
