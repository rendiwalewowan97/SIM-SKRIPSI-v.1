

<?php $__env->startSection('content'); ?>
<h1 class="mb-4 text-2xl font-bold">
    <?php echo e(isset($guidance) ? 'Edit / Kirim Ulang Bimbingan' : 'Ajukan Bimbingan'); ?>

</h1>

<?php if(!$approved): ?>
<div class="mb-4 rounded border border-yellow-200 bg-yellow-50 p-3 text-yellow-700">
    Belum ada judul yang disetujui. Anda tetap bisa menyimpan bimbingan, tetapi alur ideal dimulai setelah judul disetujui jurusan.
</div>
<?php endif; ?>

<form
    method="POST"
    enctype="multipart/form-data"
    action="<?php echo e(isset($guidance) ? route('guidances.update', $guidance) : route('guidances.store')); ?>"
    class="rounded bg-white p-4 shadow">
    <?php echo csrf_field(); ?>

    <?php if(isset($guidance)): ?>
    <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block font-semibold">Dosen Pembimbing</label>

            <select name="supervisor_id" class="mb-4 w-full rounded border p-2" required>
                <?php $__currentLoopData = $dosens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option
                    value="<?php echo e($d->id); ?>"
                    <?php if(old('supervisor_id', $guidance->supervisor_id ?? optional($approved)->supervisor_id) == $d->id): echo 'selected'; endif; ?>
                    >
                    <?php echo e($d->name); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Jenis Bimbingan</label>

            <select name="type" class="mb-4 w-full rounded border p-2" required>
                <?php $__currentLoopData = ['proposal' => 'Proposal', 'skripsi' => 'Skripsi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option
                    value="<?php echo e($k); ?>"
                    <?php if(old('type', $guidance->type ?? '') == $k): echo 'selected'; endif; ?>
                    >
                    <?php echo e($v); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block font-semibold">Tanggal</label>

            <input
                type="date"
                name="session_date"
                value="<?php echo e(old('session_date', isset($guidance) && $guidance->session_date ? $guidance->session_date->format('Y-m-d') : now()->format('Y-m-d'))); ?>"
                class="mb-4 w-full rounded border p-2"
                required>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Bab/Topik</label>

            <input
                name="chapter"
                value="<?php echo e(old('chapter', $guidance->chapter ?? '')); ?>"
                class="mb-4 w-full rounded border p-2"
                placeholder="Contoh: BAB I / Metodologi">
        </div>
    </div>

    <label class="mb-2 block font-semibold">Catatan Mahasiswa</label>

    <textarea
        name="student_note"
        rows="6"
        class="mb-4 w-full rounded border p-2"
        required><?php echo e(old('student_note', $guidance->student_note ?? '')); ?></textarea>

    <label class="mb-2 block font-semibold">
        Upload File Proposal/Skripsi/Naskah Revisi
    </label>

    <input
        type="file"
        name="file"
        class="mb-4 w-full rounded border p-2">

    <?php if(isset($guidance)): ?>
    <?php if($guidance->file_path): ?>
    <p class="mb-4 text-sm">
        File saat ini:
        <a
            class="text-indigo-700"
            target="_blank"
            href="<?php echo e(asset('storage/' . $guidance->file_path)); ?>">
            Download
        </a>
    </p>
    <?php endif; ?>
    <?php endif; ?>

    <button class="rounded bg-indigo-600 px-4 py-2 text-white">
        <?php echo e(isset($guidance) ? 'Kirim Ulang' : 'Kirim ke Dosen'); ?>

    </button>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/guidances/create.blade.php ENDPATH**/ ?>