
<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h1 class="text-2xl font-bold">Tracking Riwayat Bimbingan & Skripsi</h1>
    <p class="text-slate-500">Mahasiswa: <?php echo e($student->name); ?> · <?php echo e($student->identifier ?: '-'); ?></p>
</div>
<!-- <div class="space-y-4">
    <section class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-bold">1. Pengajuan Judul</h2>
        <?php $__empty_1 = true; $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border-t py-3 first:border-t-0"><div class="font-semibold"><?php echo e($t->title); ?></div><div class="text-sm text-slate-500">Status: <?php echo e($t->status); ?> · Dosen: <?php echo e($t->supervisor->name ?? '-'); ?> · <?php echo e($t->created_at->format('d/m/Y H:i')); ?></div></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <p class="text-slate-500">Belum ada pengajuan judul.</p> <?php endif; ?>
    </section>
    <section class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-bold">2. Riwayat Bimbingan</h2>
        <?php $__empty_1 = true; $__currentLoopData = $guidances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border-t py-3 first:border-t-0"><div class="font-semibold"><?php echo e(strtoupper($g->type)); ?> - <?php echo e($g->session_date->format('d/m/Y')); ?></div><div class="text-sm text-slate-500">Dosen: <?php echo e($g->supervisor->name); ?> · Status: <?php echo e($g->status); ?></div><p class="mt-1 text-sm">Mahasiswa: <?php echo e($g->student_note); ?></p><p class="mt-1 text-sm">Dosen: <?php echo e($g->supervisor_note ?: '-'); ?></p></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <p class="text-slate-500">Belum ada bimbingan.</p> <?php endif; ?>
    </section>
    <section class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-bold">3. Pendaftaran & Jadwal Sidang</h2>
        <?php $__empty_1 = true; $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border-t py-3 first:border-t-0"><div class="font-semibold"><?php echo e(str_replace('_',' ',strtoupper($e->type))); ?></div><div class="text-sm text-slate-500">Status: <?php echo e($e->status); ?> · Jadwal: <?php echo e(optional($e->scheduled_at)->format('d/m/Y H:i') ?? '-'); ?> · Ruang: <?php echo e($e->room ?? '-'); ?></div></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <p class="text-slate-500">Belum ada pendaftaran sidang.</p> <?php endif; ?>
    </section>
    <section class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-bold">4. Arsip Skripsi</h2>
        <?php $__empty_1 = true; $__currentLoopData = $archives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border-t py-3 first:border-t-0"><a class="font-semibold text-indigo-700" href="<?php echo e(route('archives.show',$a)); ?>"><?php echo e($a->title); ?></a><div class="text-sm text-slate-500">Tahun: <?php echo e($a->year); ?> · Keyword: <?php echo e($a->keywords ?: '-'); ?></div></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <p class="text-slate-500">Belum ada arsip.</p> <?php endif; ?>
    </section>
</div> -->
<?php
    $steps = [
        [
            'title' => 'Pengajuan Judul',
            'desc' => 'Tahap pengajuan judul skripsi',
            'color' => $titles->count() ? 'bg-emerald-500' : 'bg-red-500',
            'items' => $titles,
        ],
        [
            'title' => 'Riwayat Bimbingan',
            'desc' => 'Tahap proses bimbingan skripsi',
            'color' => $guidances->count() ? 'bg-emerald-500' : 'bg-red-500',
            'items' => $guidances,
        ],
        [
            'title' => 'Pendaftaran & Jadwal Sidang',
            'desc' => 'Tahap pendaftaran dan jadwal sidang',
            'color' => $exams->count() ? 'bg-emerald-500' : 'bg-red-500',
            'items' => $exams,
        ],
        [
            'title' => 'Arsip Skripsi',
            'desc' => 'Tahap arsip/finalisasi skripsi',
            'color' => $archives->count() ? 'bg-emerald-500' : 'bg-yellow-400',
            'items' => $archives,
        ],
    ];
?>

<div class="mb-6 rounded bg-white p-5 shadow">
    <h2 class="mb-3 text-sm font-bold text-slate-700">LEGENDA</h2>

    <div class="space-y-2 text-sm text-slate-500">
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
            tahapan sudah selesai
        </div>
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full bg-yellow-400"></span>
            tahapan belum selesai
        </div>
        <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full bg-red-500"></span>
            tahapan belum dapat dilakukan
        </div>
    </div>
</div>

<div class="relative">
    <div class="absolute left-7 top-0 h-full w-1 bg-slate-200"></div>

    <div class="space-y-6">
        <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <section class="relative flex gap-5">
                <div class="z-10 flex h-14 w-14 shrink-0 items-center justify-center rounded-full text-xl font-bold text-white shadow <?php echo e($step['color']); ?>">
                    <?php echo e($index + 1); ?>

                </div>

                <div class="w-full rounded bg-white p-5 shadow">
                    <h2 class="mb-2 text-xl font-bold text-sky-700">
                        <?php echo e($step['title']); ?>

                        <span class="text-base">➜</span>
                    </h2>

                    <p class="mb-4 text-sm text-slate-500">
                        <?php echo e($step['desc']); ?>

                    </p>

                    <?php if($step['title'] == 'Pengajuan Judul'): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border-t py-3 first:border-t-0">
                                <div class="font-semibold text-slate-700"><?php echo e($t->title); ?></div>
                                <div class="text-sm text-slate-500">
                                    Status: <?php echo e($t->status); ?> ·
                                    Dosen: <?php echo e($t->supervisor->name ?? '-'); ?> ·
                                    <?php echo e($t->created_at->format('d/m/Y H:i')); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">--- belum dilakukan ---</p>
                        <?php endif; ?>

                    <?php elseif($step['title'] == 'Riwayat Bimbingan'): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $guidances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border-t py-3 first:border-t-0">
                                <div class="font-semibold text-slate-700">
                                    <?php echo e(strtoupper($g->type)); ?> - <?php echo e($g->session_date->format('d/m/Y')); ?>

                                </div>
                                <div class="text-sm text-slate-500">
                                    Dosen: <?php echo e($g->supervisor->name); ?> · Status: <?php echo e($g->status); ?>

                                </div>
                                <p class="mt-1 text-sm">Mahasiswa: <?php echo e($g->student_note); ?></p>
                                <p class="mt-1 text-sm">Dosen: <?php echo e($g->supervisor_note ?: '-'); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">--- belum dilakukan ---</p>
                        <?php endif; ?>

                    <?php elseif($step['title'] == 'Pendaftaran & Jadwal Sidang'): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border-t py-3 first:border-t-0">
                                <div class="font-semibold text-slate-700">
                                    <?php echo e(str_replace('_',' ',strtoupper($e->type))); ?>

                                </div>
                                <div class="text-sm text-slate-500">
                                    Status: <?php echo e($e->status); ?> ·
                                    Jadwal: <?php echo e(optional($e->scheduled_at)->format('d/m/Y H:i') ?? '-'); ?> ·
                                    Ruang: <?php echo e($e->room ?? '-'); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">--- belum dilakukan ---</p>
                        <?php endif; ?>

                    <?php elseif($step['title'] == 'Arsip Skripsi'): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $archives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border-t py-3 first:border-t-0">
                                <a class="font-semibold text-indigo-700 hover:underline"
                                   href="<?php echo e(route('archives.show',$a)); ?>">
                                    <?php echo e($a->title); ?>

                                </a>
                                <div class="text-sm text-slate-500">
                                    Tahun: <?php echo e($a->year); ?> · Keyword: <?php echo e($a->keywords ?: '-'); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">--- belum dilakukan ---</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/progress/show.blade.php ENDPATH**/ ?>