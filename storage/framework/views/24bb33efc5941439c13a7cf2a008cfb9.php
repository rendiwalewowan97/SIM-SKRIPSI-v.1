
<?php $__env->startSection('content'); ?>
<h1 class="mb-4 text-2xl font-bold">Review Bimbingan</h1>
<div class="mb-4 rounded bg-white p-4 shadow"><p><b>Mahasiswa:</b> <?php echo e($guidance->student->name); ?></p><p><b>Jenis:</b> <?php echo e(ucfirst($guidance->type)); ?> · <?php echo e($guidance->chapter); ?></p><p class="mt-3 whitespace-pre-line"><?php echo e($guidance->student_note); ?></p><?php if($guidance->file_path): ?><a class="text-indigo-700" target="_blank" href="<?php echo e(asset('storage/'.$guidance->file_path)); ?>">Lihat file mahasiswa</a><?php endif; ?></div>
<form method="POST" action="<?php echo e(route('guidances.review',$guidance)); ?>" class="rounded bg-white p-4 shadow"><?php echo csrf_field(); ?>
<label class="mb-2 block font-semibold">Status</label><select name="status" class="mb-4 w-full rounded border p-2" required><?php $__currentLoopData = ['direview','revisi','selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(old('status',$guidance->status)==$s): echo 'selected'; endif; ?>><?php echo e(strtoupper($s)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
<label class="mb-2 block font-semibold">Catatan Dosen</label><textarea name="supervisor_note" rows="6" class="mb-4 w-full rounded border p-2" required><?php echo e(old('supervisor_note',$guidance->supervisor_note)); ?></textarea>
<button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan Review</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/guidances/review.blade.php ENDPATH**/ ?>