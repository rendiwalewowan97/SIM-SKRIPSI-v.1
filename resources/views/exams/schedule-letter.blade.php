<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Surat Undangan Ujian Proposal/Skripsi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white p-8 text-slate-900">
<div class="mx-auto max-w-6xl text-[15px] leading-relaxed">

    <!-- KOP SURAT -->
    <div class="relative min-h-[120px]">
        <img src="{{ asset('images/logo-unmus.png') }}"
             alt="Logo UNMUS"
             class="absolute left-0 top-0 h-24 w-24">

        <div class="text-center font-bold uppercase leading-tight">
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

    <table class="mb-5 w-full">
        <tr>
            <td class="w-24 py-1">Nomor</td>
            <td class="w-4">:</td>
            <td>.../.../.../{{ now()->format('Y') }}</td>
            <td class="text-right">Merauke, {{ now()->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="py-1">Lampiran</td>
            <td>:</td>
            <td colspan="2">1 Berkas</td>
        </tr>
        <tr>
            <td class="py-1">Perihal</td>
            <td>:</td>
            <td colspan="2">Undangan {{ $exam->type == 'seminar_proposal' ? 'Proposal' : 'Skripsi' }}</td>
        </tr>
    </table>

    <p class="mb-2">Kepada Yth:</p>

    <table class="mb-5 w-full">
        <tr>
            <td class="py-1">1. Marsujitullah, S.Kom., M.T</td>
            <td class="py-1">9. Suwarjono, S.Kom., M.T</td>
        </tr>
        <tr>
            <td class="py-1">2. Dedy Abdianto Nggego, S.SI, M.Kom</td>
            <td class="py-1">10. Rachmat, S.Kom., M.Kom</td>
        </tr>
        <tr>
            <td class="py-1">3. Dr. Heru Ismanto, S.Si., M.Cs</td>
            <td class="py-1">11. Lilik Sumaryanti, S.Kom., M.Cs</td>
        </tr>
        <tr>
            <td class="py-1">4. Yuliana Kolyaan, S.Kom., M.T</td>
            <td class="py-1">12. Agus Prayitno, S.Kom., M.Cs</td>
        </tr>
        <tr>
            <td class="py-1">5. Chusnul Chotimah, S.Kom., M.Kom</td>
            <td class="py-1">13. Nilfred Patawaran, S.Kom., M.Kom</td>
        </tr>
        <tr>
            <td class="py-1">6. Susanto, S.Kom., M.T</td>
            <td class="py-1">14. Syaiful Nugraha, S.Kom., M.Kom</td>
        </tr>
        <tr>
            <td class="py-1">7. Izak Habel Wayangkau, S.T., M.T</td>
            <td class="py-1">15. Teddy Istanto, S.Kom., M.Kom</td>
        </tr>
        <tr>
            <td class="py-1">8. Dr. Fransiskus X Manggau, S.Kom., M.T</td>
            <td></td>
        </tr>
    </table>

    <p class="mb-4">
        di-<br>
        <span class="ml-10">Tempat</span>
    </p>

    <p class="mb-4 text-justify indent-10">
        Sehubungan dengan akan dilaksanakannya Ujian
        {{ $exam->type == 'seminar_proposal' ? 'Proposal' : 'Skripsi' }}
        Mahasiswa Jurusan Teknik Informatika Universitas Musamus (UNMUS)
        Semester Ganjil/Genap Tahun Akademik 2025/2026 pada hari
        {{ $exam->scheduled_at ? $exam->scheduled_at->locale('id')->translatedFormat('l, d F Y') : '.................... 2026' }},
        maka dengan ini kami mohon kesediaan Bapak/Ibu untuk menjadi
        Penguji/Pembimbing/Sekretaris/Ketua Sidang
        {{ $exam->type == 'seminar_proposal' ? 'Proposal' : 'Skripsi' }}
        sesuai jadwal terlampir.
    </p>

    <p class="mb-4 text-justify indent-10">
        Demikian undangan ini disampaikan, atas perhatian dan kehadirannya
        disampaikan terima kasih.
    </p>

    <div class="mt-16 flex justify-end">
        <div class="w-72 text-left">
            <p>Plt Ketua Jurusan</p>

            <br><br><br>

            <p class="font-bold underline">{{ $chairName ?? 'Nama Ketua Jurusan' }}</p>
            <p>NIP. {{ $chairNip ?? '-' }}</p>
        </div>
    </div>

    <!-- HALAMAN JADWAL -->
    <div class="mt-20 page-break-before">

        <div class="relative min-h-[120px]">
            <img src="{{ asset('images/logo-unmus.png') }}"
                 alt="Logo UNMUS"
                 class="absolute left-0 top-0 h-24 w-24">

            <div class="text-center font-bold uppercase leading-tight">
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

        @php
            $jadwal = $exam->scheduled_at ?? now();

            $bulan = $jadwal->month;

            if ($bulan >= 7) {
                $semester = 'Ganjil';
                $tahunAkademik = $jadwal->year . '/' . ($jadwal->year + 1);
            } else {
                $semester = 'Genap';
                $tahunAkademik = ($jadwal->year - 1) . '/' . $jadwal->year;
            }
        @endphp

        <div class="mb-4 text-center font-bold uppercase">
            <p>Jadwal Ujian {{ $exam->type == 'seminar_proposal' ? 'Proposal' : 'Skripsi' }}</p>
            <p>
                Semester {{ $semester }}
                Tahun Akademik {{ $tahunAkademik }}
            </p>
        </div>

        <table class="w-full border-collapse text-[11px]">
            <thead>
                <tr>
                    <th class="border border-black p-2">HARI/<br>TANGGAL</th>
                    <th class="border border-black p-2">NO</th>
                    <th class="border border-black p-2">WAKTU</th>
                    <th class="border border-black p-2">NAMA MAHASISWA</th>
                    <th class="border border-black p-2">NPM</th>
                    <th class="border border-black p-2">JUDUL</th>
                    <th class="border border-black p-2">DOSEN PEMBIMBING</th>
                    <th class="border border-black p-2">DOSEN PENGUJI</th>
                    <th class="border border-black p-2">KETUA SIDANG</th>
                    <th class="border border-black p-2">SEKRETARIS</th>
                </tr>
            </thead>

            <tbody>
                @forelse($sameDayExams as $index => $item)
                    @php
                        $title = $examTitles[$item->student_id][0] ?? null;
                    @endphp

                    <tr>
                        @if($index === 0)
                            <td class="border border-black p-2 text-center align-middle" rowspan="{{ $sameDayExams->count() }}">
                                {{ $item->scheduled_at ? $item->scheduled_at->locale('id')->translatedFormat('l') : '-' }}<br>
                                {{ $item->scheduled_at ? $item->scheduled_at->locale('id')->translatedFormat('d F Y') : '-' }}
                            </td>
                        @endif

                        <td class="border border-black p-2 text-center">
                            {{ $index + 1 }}
                        </td>

                        <td class="border border-black p-2 text-center">
                            {{ $item->scheduled_at ? $item->scheduled_at->format('H:i') : '-' }}
                        </td>

                        <td class="border border-black p-2">
                            {{ $item->student->name ?? '-' }}
                        </td>

                        <td class="border border-black p-2">
                            {{ $item->student->identifier ?? '-' }}
                        </td>

                        <td class="border border-black p-2">
                            {{ $title->title ?? '-' }}
                        </td>

                        <td class="border border-black p-2">
                            1. {{ $item->supervisor1->name ?? $title->supervisor1->name ?? $title->supervisor->name ?? '-' }}<br>
                            2. {{ $item->supervisor2->name ?? $title->supervisor2->name ?? '-' }}
                        </td>

                        <td class="border border-black p-2">
                            1. {{ $item->examiner1->name ?? '-' }}<br>
                            2. {{ $item->examiner2->name ?? '-' }}<br>
                            3. {{ $item->examiner3->name ?? '-' }}
                        </td>

                        <td class="border border-black p-2">
                            {{ $item->chairman->name ?? '-' }}
                        </td>

                        <td class="border border-black p-2">
                            {{ $item->secretary->name ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="border border-black p-3 text-center">
                            Belum ada jadwal sidang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-16 flex justify-end">
            <div class="w-72 text-left">
                <p>Merauke, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
                <p>Plt Ketua Jurusan Teknik Informatika</p>

                <br><br><br>

                <p class="font-bold underline">{{ $chairName ?? 'Nama Ketua Jurusan' }}</p>
                <p>NIP. {{ $chairNip ?? '-' }}</p>
            </div>
        </div>
    </div>

    <button onclick="window.print()"
            class="mt-8 rounded bg-indigo-600 px-4 py-2 text-white print:hidden">
        Download/Cetak PDF
    </button>

</div>

<style>
    @media print {
        .page-break-before {
            page-break-before: always;
        }

        @page {
            size: A4 landscape;
            margin: 12mm;
        }
    }
</style>

</body>
</html>