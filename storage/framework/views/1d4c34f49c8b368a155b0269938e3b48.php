<?php $__env->startSection('content'); ?>

<h1 class="mb-6 text-2xl font-bold">
    <?php echo e(isset($title) ? 'Edit Pengajuan Judul' : 'Ajukan Judul Skripsi'); ?>

</h1>

<form method="POST"
      action="<?php echo e(isset($title) ? route('titles.update', $title) : route('titles.store')); ?>"
      class="rounded-lg bg-white p-6 shadow">


<?php echo csrf_field(); ?>
<?php if(isset($title)): ?>
    <?php echo method_field('PUT'); ?>
<?php endif; ?>


<div class="mb-5">
    <label class="mb-2 block font-semibold text-slate-700">
        Judul Skripsi
    </label>

    <input type="text"
           name="title"
           value="<?php echo e(old('title', $title->title ?? '')); ?>"
           class="w-full rounded border border-slate-300 p-2 focus:border-indigo-500 focus:outline-none"
           placeholder="Masukkan judul skripsi"
           required>

    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="mb-5">
    <label class="mb-2 block font-semibold text-slate-700">
        Jumlah SKS yang Telah Lulus
    </label>

    <input type="number"
           name="sks"
           min="112"
           max="200"
           value="<?php echo e(old('sks', $title->sks ?? '')); ?>"
           class="w-full rounded border border-slate-300 p-2 focus:border-indigo-500 focus:outline-none"
           required>

    <p class="mt-1 text-sm text-slate-500">
        Minimal telah lulus <strong>112 SKS</strong> untuk mengajukan judul skripsi.
    </p>

    <?php $__errorArgs = ['sks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="mb-6">
    <label class="mb-2 block font-semibold text-slate-700">
        Latar Belakang Singkat
    </label>

    <textarea name="background"
              rows="7"
              class="w-full rounded border border-slate-300 p-2 focus:border-indigo-500 focus:outline-none"
              placeholder="Jelaskan latar belakang penelitian secara singkat"><?php echo e(old('background', $title->background ?? '')); ?></textarea>

    <?php $__errorArgs = ['background'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="flex items-center gap-2">
    <button type="submit"
            class="rounded bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">
        Simpan
    </button>

    <a href="<?php echo e(route('titles.index')); ?>"
       class="rounded border border-slate-300 px-4 py-2 text-slate-700 transition hover:bg-slate-100">
        Kembali
    </a>
</div>


</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/titles/create.blade.php ENDPATH**/ ?>