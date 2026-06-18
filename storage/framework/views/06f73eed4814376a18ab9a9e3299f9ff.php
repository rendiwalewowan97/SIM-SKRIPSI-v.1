<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-4xl rounded-xl bg-white p-6 shadow">
    <div class="flex justify-between gap-3 border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold"><?php echo e($title->title); ?></h1>
            <p class="text-sm text-slate-500">Detail pengajuan judul skripsi</p>
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

    <dl class="mt-6 grid gap-5 md:grid-cols-2">
        <div><dt class="text-sm text-slate-500">Mahasiswa</dt><dd><?php echo e($title->student->name); ?></dd></div>
        <div><dt class="text-sm text-slate-500">Jumlah SKS</dt><dd><?php echo e($title->sks ?? '-'); ?></dd></div>
        <div><dt class="text-sm text-slate-500">Pembimbing 1</dt><dd><?php echo e($title->supervisor1->name ?? $title->supervisor->name ?? '-'); ?></dd></div>
        <div><dt class="text-sm text-slate-500">Pembimbing 2</dt><dd><?php echo e($title->supervisor2->name ?? '-'); ?></dd></div>
        <div><dt class="text-sm text-slate-500">Tanggal Lolos Voting</dt><dd><?php echo e(optional($title->approved_at)->format('d/m/Y H:i') ?? '-'); ?></dd></div>
        <div><dt class="text-sm text-slate-500">Tanggal Penetapan Pembimbing</dt><dd><?php echo e(optional($title->assigned_at)->format('d/m/Y H:i') ?? '-'); ?></dd></div>
        <div class="md:col-span-2"><dt class="text-sm text-slate-500">Catatan</dt><dd><?php echo e($title->notes ?: '-'); ?></dd></div>
    </dl>

    <div class="mt-8 border-t pt-6">
        <h2 class="mb-3 font-semibold">Latar Belakang</h2>
        <div class="rounded bg-slate-50 p-4"><p class="whitespace-pre-line"><?php echo e($title->background ?: '-'); ?></p></div>
    </div>

    <div class="mt-6 rounded-lg border bg-slate-50 p-4">
        <h2 class="mb-2 font-semibold">Hasil Voting Dosen</h2>
        <p>Setuju: <b><?php echo e($title->setuju_votes_count ?? 0); ?></b> | Tidak Setuju: <b><?php echo e($title->tidak_setuju_votes_count ?? 0); ?></b></p>
        <p class="text-sm text-slate-500">Syarat lolos voting: minimal <?php echo e($minimalSetuju ?? 8); ?> suara setuju dari <?php echo e($totalDosen ?? 15); ?> dosen.</p>

        <?php if(auth()->user()->isDosen() && in_array($title->status, ['diajukan','revisi'])): ?>
        <form method="POST" action="<?php echo e(route('titles.vote', $title)); ?>" class="mt-4 flex flex-wrap gap-2">
            <?php echo csrf_field(); ?>
            <button name="vote" value="setuju" class="rounded bg-green-600 px-4 py-2 text-white">Setuju</button>
            <button name="vote" value="tidak_setuju" class="rounded bg-red-600 px-4 py-2 text-white">Tidak Setuju</button>
            <?php if($myVote): ?><span class="py-2 text-sm text-slate-500">Voting Anda: <?php echo e(str_replace('_',' ', strtoupper($myVote->vote))); ?></span><?php endif; ?>
        </form>
        <?php elseif(auth()->user()->isDosen()): ?>
            <p class="mt-3 text-sm text-slate-500">Voting sudah selesai karena status judul bukan diajukan/revisi.</p>
        <?php endif; ?>
    </div>

    <?php if(auth()->user()->isJurusan()): ?>
    <div class="mt-6 border-t pt-6">
        <a href="<?php echo e(route('titles.edit', $title)); ?>" class="rounded bg-indigo-600 px-4 py-2 text-white">Tetapkan Pembimbing</a>
    </div>
    <?php endif; ?>

    <?php if($title->status === 'disetujui' && auth()->user()->isMahasiswa()): ?>
    <div class="mt-6 border-t pt-6">
        <a href="<?php echo e(route('titles.approvalLetter', $title)); ?>" target="_blank" class="rounded bg-green-600 px-4 py-2 text-white">Download Surat Penunjukan Pembimbing</a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/titles/show.blade.php ENDPATH**/ ?>