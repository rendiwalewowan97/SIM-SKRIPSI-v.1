<?php $__env->startSection('content'); ?>
<h1 class="mb-4 text-2xl font-bold"><?php echo e(isset($title) ? 'Edit Pengajuan Judul' : 'Ajukan Judul Skripsi'); ?></h1>
<form method="POST" action="<?php echo e(isset($title) ? route('titles.update',$title) : route('titles.store')); ?>" class="rounded bg-white p-4 shadow">
<?php echo csrf_field(); ?> <?php if(isset($title)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
<label class="mb-2 block font-semibold">Judul</label>
<input name="title" value="<?php echo e(old('title',$title->title ?? '')); ?>" class="mb-4 w-full rounded border p-2" required>
<label class="mb-2 block font-semibold">Jumlah SKS yang Telah Lulus</label>
<input type="number" min="0" max="200" name="sks" value="<?php echo e(old('sks',$title->sks ?? '')); ?>" class="mb-4 w-full rounded border p-2" required>
<label class="mb-2 block font-semibold">Latar Belakang Singkat</label>
<textarea name="background" rows="7" class="mb-4 w-full rounded border p-2"><?php echo e(old('background',$title->background ?? '')); ?></textarea>
<button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan</button>
<a href="<?php echo e(route('titles.index')); ?>" class="ml-2 text-slate-600">Kembali</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/titles/create.blade.php ENDPATH**/ ?>