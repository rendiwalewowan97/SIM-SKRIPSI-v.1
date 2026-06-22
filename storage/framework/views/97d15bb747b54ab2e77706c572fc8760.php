<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Lembar Konsultasi Skripsi</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            .page-break {
                page-break-after: always;
            }

            .print-hidden {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body class="bg-white p-8 text-slate-900">

<?php
    $first = $items->first();
    $student = $first->student ?? auth()->user();

    $supervisors = $items
        ->pluck('supervisor')
        ->filter()
        ->unique('id')
        ->values();

    $pembimbing1 = $supervisors->get(0);
    $pembimbing2 = $supervisors->get(1);

    // Ambil judul skripsi dari relasi yang benar di model User: titleSubmissions()
    // Prioritas: judul yang sudah disetujui. Jika belum ada, ambil judul terakhir sebagai cadangan.
    $title = $student?->titleSubmissions()
        ->where('status', 'disetujui')
        ->latest()
        ->first();

    if (!$title) {
        $title = $student?->titleSubmissions()
            ->latest()
            ->first();
    }

    $judulSkripsi = $title?->title ?? '-';

    $letters = collect([
        [
            'label' => 'Dosen Pembimbing I',
            'supervisor' => $pembimbing1,
        ],
        [
            'label' => 'Dosen Pembimbing II',
            'supervisor' => $pembimbing2,
        ],
    ]);
?>

<?php $__currentLoopData = $letters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php
        $supervisor = $letter['supervisor'];

        $filteredItems = $supervisor
            ? $items->where('supervisor_id', $supervisor->id)
            : collect();
    ?>

    <div class="mx-auto max-w-4xl <?php echo e(!$loop->last ? 'page-break' : ''); ?>">


<div class="relative mb-4 min-h-[120px]">

    
    <img src="<?php echo e(asset('images/logo-unmus.png')); ?>"
         alt="Logo UNMUS"
         class="absolute left-0 top-0 h-24 w-24">

    <div class="text-center">
        <h1 class="text-sm font-bold uppercase">
            Kementerian Pendidikan Tinggi, Sains dan Teknologi
        </h1>

        <h2 class="text-lg font-bold uppercase">
            Universitas Musamus (UNMUS)
        </h2>

        <h3 class="font-bold uppercase">
            Fakultas Teknik
        </h3>

        <h3 class="font-bold uppercase">
            Jurusan Teknik Informatika
        </h3>

        <p class="mt-1 text-xs">
            Jalan Kamizaun Mopah Lama Merauke 99611
            <br>
            Email : informatics@unmus.ac.id
        </p>
    </div>

</div>

        <hr class="my-4 border-2 border-black">

        
        <h2 class="mb-6 text-center text-lg font-bold uppercase">
            Lembar Konsultasi
        </h2>

        
        <table class="mb-6 w-full text-sm">
            <tbody>
                <tr>
                    <td class="w-40 font-semibold">NAMA</td>
                    <td class="w-4">:</td>
                    <td><?php echo e($student->name ?? '-'); ?></td>
                </tr>

                <tr>
                    <td class="font-semibold">NPM</td>
                    <td>:</td>
                    <td><?php echo e($student->identifier ?? '-'); ?></td>
                </tr>

                <tr>
                    <td class="font-semibold">PEMBIMBING</td>
                    <td>:</td>
                    <td><?php echo e($supervisor->name ?? '-'); ?></td>
                </tr>

                <tr>
                    <td class="font-semibold align-top">
                        JUDUL SKRIPSI
                    </td>
                    <td class="align-top">:</td>
                    <td class="align-top">
                        <?php echo e($judulSkripsi); ?>

                    </td>
                </tr>
            </tbody>
        </table>

        
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr>
                    <th class="w-12 border border-black p-2 text-center">
                        NO
                    </th>

                    <th class="w-28 border border-black p-2 text-center">
                        TANGGAL
                    </th>

                    <th class="border border-black p-2 text-center">
                        CATATAN DOSEN PEMBIMBING
                    </th>

                    <th class="w-28 border border-black p-2 text-center">
                        STATUS
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $filteredItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="border border-black p-2 text-center">
                            <?php echo e($loop->iteration); ?>

                        </td>

                        <td class="border border-black p-2 text-center">
                            <?php echo e($g->session_date?->format('d/m/Y') ?? '-'); ?>

                        </td>

                        <td class="border border-black p-2">
                            <?php echo e($g->supervisor_note ?? '-'); ?>

                        </td>

                        <td class="border border-black p-2 text-center uppercase">
                            <?php echo e($g->status ?? '-'); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php for($i = 1; $i <= 8; $i++): ?>
                        <tr>
                            <td class="border border-black p-3 text-center">
                                <?php echo e($i); ?>

                            </td>

                            <td class="border border-black p-3">
                                &nbsp;
                            </td>

                            <td class="border border-black p-3">
                                &nbsp;
                            </td>

                            <td class="border border-black p-3">
                                &nbsp;
                            </td>
                        </tr>
                    <?php endfor; ?>
                <?php endif; ?>
            </tbody>
        </table>

        
        <div class="mt-12 grid grid-cols-2 gap-20">

            
            <div class="text-center">
                <p>Mengetahui</p>

                <p>
                    Plt. Ketua Jurusan Teknik Informatika
                </p>

                <div class="h-24"></div>

                <p class="font-bold underline">
                    <?php echo e($ketuaJurusan->name ?? '-'); ?>

                </p>

                <p>
                    NIP. <?php echo e($ketuaJurusan->identifier ?? '-'); ?>

                </p>
            </div>

            
            <div class="text-center">
                <p>&nbsp;</p>

                <p>
                    <?php echo e($letter['label']); ?>

                </p>

                <div class="h-24"></div>

                <p class="font-bold underline">
                    <?php echo e($supervisor->name ?? '-'); ?>

                </p>

                <p>
                    NIP. <?php echo e($supervisor->identifier ?? '-'); ?>

                </p>
            </div>

        </div>

    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<div class="mt-8 text-center print-hidden">
    <button onclick="window.print()"
            class="rounded bg-indigo-600 px-5 py-2 text-white hover:bg-indigo-700">
        Download / Cetak PDF
    </button>
</div>

</body>
</html><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/guidances/guidances-letter.blade.php ENDPATH**/ ?>