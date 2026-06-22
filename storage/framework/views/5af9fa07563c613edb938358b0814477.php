<?php $__env->startSection('content'); ?>
<h1 class="mb-4 text-2xl font-bold">Review Pengajuan Judul</h1>

<div class="mb-4 rounded bg-white p-4 shadow">
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <h2 class="font-bold"><?php echo e($title->title); ?></h2>
            <p class="text-sm text-slate-500">Mahasiswa: <?php echo e($title->student->name); ?></p>
        </div>
        <?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['value' => $title->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $attributes = $__attributesOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__attributesOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51ed764111e345fc11534f121cfeb451)): ?>
<?php $component = $__componentOriginal51ed764111e345fc11534f121cfeb451; ?>
<?php unset($__componentOriginal51ed764111e345fc11534f121cfeb451); ?>
<?php endif; ?>
    </div>

    <div class="mt-4 rounded border bg-slate-50 p-3 text-sm">
        <b>Voting Dosen:</b>
        Setuju <?php echo e($title->setuju_votes_count ?? 0); ?> /
        Tidak Setuju <?php echo e($title->tidak_setuju_votes_count ?? 0); ?>.
        Minimal setuju: <?php echo e($minimalSetuju); ?> dari <?php echo e($totalDosen); ?> dosen.
    </div>

    <p class="mt-3 whitespace-pre-line"><?php echo e($title->background); ?></p>
</div>

<form method="POST" action="<?php echo e(route('titles.review', $title)); ?>" class="rounded bg-white p-4 shadow">
    <?php echo csrf_field(); ?>

    <label class="mb-2 block font-semibold">Status Judul</label>
    <select name="status" class="mb-4 w-full rounded border p-2" required>
        <?php $__currentLoopData = ['diajukan','disetujui','ditolak','revisi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($s); ?>" <?php if(old('status', $title->status) == $s): echo 'selected'; endif; ?>>
                <?php echo e(strtoupper($s)); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block font-semibold">Dosen Pembimbing 1</label>
            <select name="supervisor_1_id" class="mb-4 w-full rounded border p-2">
                <option value="">- Pilih dosen -</option>
                <?php $__currentLoopData = $dosens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($d->id); ?>" <?php if(old('supervisor_1_id', $title->supervisor_1_id ?? $title->supervisor_id) == $d->id): echo 'selected'; endif; ?>>
                        <?php echo e($d->name); ?> <?php echo e($d->identifier ? '- '.$d->identifier : ''); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Dosen Pembimbing 2</label>
            <select name="supervisor_2_id" class="mb-4 w-full rounded border p-2">
                <option value="">- Pilih dosen -</option>
                <?php $__currentLoopData = $dosens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($d->id); ?>" <?php if(old('supervisor_2_id', $title->supervisor_2_id) == $d->id): echo 'selected'; endif; ?>>
                        <?php echo e($d->name); ?> <?php echo e($d->identifier ? '- '.$d->identifier : ''); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    <label class="mb-2 block font-semibold">Catatan Jurusan</label>
    <textarea name="notes" rows="5" class="mb-4 w-full rounded border p-2"><?php echo e(old('notes', $title->notes)); ?></textarea>

    <button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan Alur Judul</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/titles/review.blade.php ENDPATH**/ ?>