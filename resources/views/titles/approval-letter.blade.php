<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Surat Penunjukan Dosen Pembimbing</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white p-8 text-slate-900">
<div class="mx-auto max-w-3xl text-[15px] leading-relaxed">

    <!-- KOP SURAT -->
    <div class="relative min-h-[110px]">

        <img src="{{ asset('images/logo-unmus.png') }}"
             alt="Logo UNMUS"
             class="absolute left-0 top-0 h-24 w-24">

        <div class="text-center font-bold uppercase">
            <p>Kementerian Pendidikan Tinggi,</p>
            <p>Sains, dan Teknologi</p>
            <p>Universitas Musamus (UNMUS)</p>
            <p>Fakultas Teknik</p>
            <p>Jurusan Teknik Informatika</p>
        </div>

        <p class="mt-2 text-center text-sm">
            Jl. Kamizaun Mopah Lama Merauke 99611<br>
            Email: informatika@unmus.ac.id
        </p>
    </div>

    <hr class="my-5 border-2 border-slate-900">

    <p class="mb-4">Berdasarkan data di bawah ini:</p>

    <table class="mb-5 w-full">
        <tr>
            <td class="w-32 py-1">NAMA</td>
            <td>: {{ $title->student->name }}</td>
        </tr>
        <tr>
            <td class="py-1">NPM</td>
            <td>: {{ $title->student->identifier ?: '-' }}</td>
        </tr>
        <tr>
            <td class="py-1">JURUSAN</td>
            <td>: Teknik Informatika</td>
        </tr>
        <tr>
            <td class="py-1 align-top">JUDUL</td>
            <td>: {{ $title->title }}</td>
        </tr>
    </table>

    <p class="mb-2">Maka dengan ini menunjuk Bapak/Ibu Dosen:</p>

    <table class="mb-5 w-full">
        <tr>
            <td class="w-6 py-1">1.</td>
            <td class="py-1">
                {{ $title->supervisor1->name ?? $title->supervisor->name ?? '-' }} : Sebagai Pembimbing 1
            </td>
        </tr>
        <tr>
            <td class="py-1">2.</td>
            <td class="py-1">
                {{ $title->supervisor2->name ?? '-' }} : Sebagai Pembimbing 2
            </td>
        </tr>
    </table>

    <p class="text-justify">
        Menindaklanjuti hal tersebut bersama ini kami memohon kesediaan Bapak/Ibu
        untuk dapat membimbing dan mengarahkan mahasiswa tersebut dalam penyusunan
        proposalnya. Judul yang diajukan tersebut masih bersifat sementara, apabila
        ada koreksi/perubahan terhadap judul tersebut maka dapat dilakukan dengan
        berkoordinasi dengan Ketua Jurusan Teknik Informatika. Demikian penyampaian
        ini, atas kerjasamanya diucapkan terima kasih.
    </p>

    <div class="mt-16 flex justify-end">
        <div class="w-64 text-left">
            <p>Merauke, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
            <p>Plt. Ketua Jurusan</p>

            <br><br><br>

            <p class="font-bold underline">{{ $chairName ?? 'Nama Ketua Jurusan' }}</p>
            <p>NIP. {{ $chairNip ?? '-' }}</p>
        </div>
    </div>

    <button onclick="window.print()"
            class="mt-8 rounded bg-indigo-600 px-4 py-2 text-white print:hidden">
        Download/Cetak PDF
    </button>

</div>
</body>
</html>