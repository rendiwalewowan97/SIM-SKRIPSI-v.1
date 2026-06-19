

<?php $__env->startSection('content'); ?>

<h1 class="mb-4 text-2xl font-bold">
    <?php echo e(isset($archive) ? 'Edit Arsip' : 'Tambah Arsip Skripsi'); ?>

</h1>

<form method="POST"
      action="<?php echo e(isset($archive) ? route('archives.update', $archive) : route('archives.store')); ?>"
      enctype="multipart/form-data"
      class="rounded bg-white p-4 shadow">

 
<?php echo csrf_field(); ?>

<?php if(isset($archive)): ?>
    <?php echo method_field('PUT'); ?>
<?php endif; ?>

<?php if(auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan()): ?>
    <label class="mb-2 block font-semibold">Mahasiswa</label>
    <select name="student_id" class="mb-4 w-full rounded border p-2">
        <option value="">Gunakan akun saya</option>
        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($s->id); ?>"
                <?php if(old('student_id', $archive->student_id ?? '') == $s->id): echo 'selected'; endif; ?>>
                <?php echo e($s->name); ?> - <?php echo e($s->identifier); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
<?php else: ?>
    <label class="mb-2 block font-semibold">Mahasiswa</label>
    <input type="text"
           value="<?php echo e(auth()->user()->name); ?> - <?php echo e(auth()->user()->identifier); ?>"
           class="mb-4 w-full rounded border bg-slate-100 p-2"
           readonly>
<?php endif; ?>

<label class="mb-2 block font-semibold">Judul Skripsi</label>
<input name="title"
       value="<?php echo e(old('title', $archive->title ?? '')); ?>"
       class="mb-4 w-full rounded border p-2"
       required>

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="mb-2 block font-semibold">Tahun</label>
        <input name="year"
               value="<?php echo e(old('year', $archive->year ?? date('Y'))); ?>"
               class="mb-4 w-full rounded border p-2"
               required>
    </div>

    <div>
        <label class="mb-2 block font-semibold">Keyword</label>
        <input name="keywords"
               value="<?php echo e(old('keywords', $archive->keywords ?? '')); ?>"
               class="mb-4 w-full rounded border p-2">
    </div>
</div>

<label class="mb-2 block font-semibold">
    Dokumen Skripsi PDF <?php echo e(isset($archive) ? '(kosongkan jika tidak diganti)' : ''); ?>

</label>
<input type="file"
       name="file"
       accept="application/pdf"
       class="mb-4 w-full rounded border p-2"
       <?php echo e(isset($archive) ? '' : 'required'); ?>>

<?php if(auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan()): ?>
    <label class="mb-4 flex items-center gap-2">
        <input type="checkbox"
               name="is_public"
               value="1"
               <?php if(old('is_public', $archive->is_public ?? true)): echo 'checked'; endif; ?>>

        Publik untuk pencarian referensi
    </label>
<?php else: ?>
    <div class="mb-4 rounded bg-yellow-50 p-3 text-sm text-yellow-800">
        Arsip yang diupload mahasiswa akan menunggu verifikasi jurusan sebelum dipublikasikan.
    </div>
<?php endif; ?>

<button class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
    Simpan Arsip
</button>
 

</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/archives/create.blade.php ENDPATH**/ ?>