

<?php $__env->startSection('content'); ?>
<div class="mb-4 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold">Monitoring Progress Mahasiswa</h1>
        <p class="text-sm text-slate-500">
            Alur : Pengajuan Judul → Bimbingan Proposal → Seminar Proposal →
            Bimbingan Skripsi → Sidang Skripsi → Arsip.
        </p>
    </div>
</div>


<form class="mb-4 flex gap-2">
    <input
        type="text"
        name="q"
        value="<?php echo e(request('q')); ?>"
        class="w-full rounded border p-2"
        placeholder="Cari mahasiswa/NIM">
        
    <button class="rounded bg-slate-800 px-4 py-2 text-white hover:bg-slate-900">
        Cari
    </button>
</form>

<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="w-full text-sm">
        <thead class="bg-slate-100">
            <tr>
                <th class="px-4 py-3 text-left">Mahasiswa</th>
                <th class="px-4 py-3 text-left">NIM</th>
                <th class="px-4 py-3 text-center">Progress</th>
                <th class="px-4 py-3 text-center">Judul</th>
                <th class="px-4 py-3 text-center">Proposal</th>
                <th class="px-4 py-3 text-center">Sempro</th>
                <th class="px-4 py-3 text-center">Skripsi</th>
                <th class="px-4 py-3 text-center">Sidang</th>
                <th class="px-4 py-3 text-center">Arsip</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-medium">
                    <?php echo e($s->name); ?>

                </td>

                <td class="px-4 py-3">
                    <?php echo e($s->identifier ?: '-'); ?>

                </td>

                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <div class="h-2 flex-1 rounded bg-slate-200">
                            <div
                                class="h-2 rounded bg-indigo-600"
                                style="width: <?php echo e($s->progress_percent); ?>%">
                            </div>
                        </div>
                        <span class="font-semibold text-indigo-700">
                            <?php echo e($s->progress_percent); ?>%
                        </span>
                    </div>
                </td>

                <td class="px-4 py-3 text-center">
                    <?php if($s->approved_title): ?>
                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                            Ya
                        </span>
                    <?php else: ?>
                        <span class="rounded bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                            Belum
                        </span>
                    <?php endif; ?>
                </td>

                <td class="px-4 py-3 text-center">
                    <?php echo e($s->proposal_guidance_count); ?>

                </td>

                <td class="px-4 py-3 text-center">
                    <?php echo e($s->proposal_exam->status ?? '-'); ?>

                </td>

                <td class="px-4 py-3 text-center">
                    <?php echo e($s->skripsi_guidance_count); ?>

                </td>

                <td class="px-4 py-3 text-center">
                    <?php echo e($s->skripsi_exam->status ?? '-'); ?>

                </td>

                <td class="px-4 py-3 text-center">
                    <?php if($s->archive): ?>
                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                            Ada
                        </span>
                    <?php else: ?>
                        <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-700">
                            Belum
                        </span>
                    <?php endif; ?>
                </td>

                <td class="px-4 py-3">
                    <div class="flex justify-center gap-2">

                        
                        <a href="<?php echo e(route('progress.show', $s)); ?>"
                        class="rounded bg-indigo-600 px-3 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                            Timeline
                        </a>

                        
                        <a href="<?php echo e(route('guidances.index')); ?>"
                        class="rounded bg-slate-600 px-3 py-2 text-xs font-medium text-white hover:bg-slate-700">
                            Tracking
                        </a>

                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="10" class="px-4 py-6 text-center text-slate-500">
                    Belum ada data mahasiswa.
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-4">
    <?php echo e($students->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/progress/index.blade.php ENDPATH**/ ?>