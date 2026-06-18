<?php $__env->startSection('content'); ?>
<h1 class="mb-4 text-2xl font-bold">Verifikasi & Jadwalkan Sidang</h1>
<div class="mb-4 rounded bg-white p-4 shadow">
    <p><b>Mahasiswa:</b> <?php echo e($exam->student->name); ?></p>
    <p><b>Jenis:</b> <?php echo e(str_replace('_',' ', $exam->type)); ?></p>
    <p><b>Catatan:</b> <?php echo e($exam->notes ?? '-'); ?></p>
    <?php if($exam->documents): ?>
        <div class="mt-2"><b>Dokumen:</b>
            <ul class="list-disc pl-6">
            <?php $__currentLoopData = $exam->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a class="text-indigo-700" target="_blank" href="<?php echo e(asset('storage/'.$path)); ?>"><?php echo e(ucwords(str_replace('_',' ', $label))); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
<form method="POST" action="<?php echo e(route('exams.verify',$exam)); ?>" class="rounded bg-white p-4 shadow"><?php echo csrf_field(); ?>
    <label class="mb-2 block font-semibold">Status</label>
    <select name="status" class="mb-4 w-full rounded border p-2" required><?php $__currentLoopData = ['diajukan','diverifikasi','dijadwalkan','ditolak','selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(old('status',$exam->status)==$s): echo 'selected'; endif; ?>><?php echo e(strtoupper($s)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
    <div class="grid gap-4 md:grid-cols-2">
        <div><label class="mb-2 block font-semibold">Tanggal/Jam Sidang</label><input type="datetime-local" name="scheduled_at" value="<?php echo e(old('scheduled_at', optional($exam->scheduled_at)->format('Y-m-d\TH:i'))); ?>" class="mb-4 w-full rounded border p-2"></div>
        <div><label class="mb-2 block font-semibold">Ruangan</label><input name="room" value="<?php echo e(old('room',$exam->room)); ?>" class="mb-4 w-full rounded border p-2"></div>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <?php $__currentLoopData = ['supervisor_1_id'=>'Dosen Pembimbing 1','supervisor_2_id'=>'Dosen Pembimbing 2','examiner_1_id'=>'Dosen Penguji 1','examiner_2_id'=>'Dosen Penguji 2','examiner_3_id'=>'Dosen Penguji 3','chairman_id'=>'Ketua Sidang','secretary_id'=>'Sekretaris Sidang']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div><label class="mb-2 block font-semibold"><?php echo e($label); ?></label><select name="<?php echo e($name); ?>" class="w-full rounded border p-2"><option value="">-- Pilih Dosen --</option><?php $__currentLoopData = $dosens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dosen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($dosen->id); ?>" <?php if(old($name, $exam->{$name}) == $dosen->id): echo 'selected'; endif; ?>><?php echo e($dosen->name); ?> - <?php echo e($dosen->identifier); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <label class="mb-2 mt-4 block font-semibold">Catatan Jurusan</label><textarea name="notes" rows="5" class="mb-4 w-full rounded border p-2"><?php echo e(old('notes',$exam->notes)); ?></textarea>
    <button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/exams/schedule.blade.php ENDPATH**/ ?>