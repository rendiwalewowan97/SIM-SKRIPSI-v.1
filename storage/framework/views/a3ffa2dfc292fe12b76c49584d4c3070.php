
<?php $__env->startSection('content'); ?>
<div class="mb-4 flex items-center justify-between"><h1 class="text-2xl font-bold">Arsip Skripsi</h1>
        <?php if(auth()->user()->isJurusan()): ?>
        <a href="<?php echo e(route('archives.create')); ?>"
           class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
            Tambah Arsip
        </a>
    <?php endif; ?>
</div>
<form class="mb-4 flex gap-2"><input name="q" value="<?php echo e(request('q')); ?>" class="w-full rounded border p-2" placeholder="Cari judul, keyword, tahun"><button class="rounded bg-slate-800 px-4 py-2 text-white">Cari</button></form>
<div class="grid gap-4 md:grid-cols-2"><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="rounded bg-white p-4 shadow"><div class="flex justify-between gap-2"><h2 class="font-bold text-indigo-700"><a href="<?php echo e(route('archives.show',$a)); ?>"><?php echo e($a->title); ?></a></h2><span class="text-sm text-slate-500"><?php echo e($a->year); ?></span></div><p class="text-sm text-slate-500"><?php echo e($a->student->name); ?> · <?php echo e($a->keywords); ?></p><div class="mt-3 flex gap-3 text-sm"><a class="text-indigo-700" target="_blank" href="<?php echo e(asset('storage/'.$a->file_path)); ?>">File Skripsi</a><?php if($a->abstract_path): ?><a class="text-indigo-700" target="_blank" href="<?php echo e(asset('storage/'.$a->abstract_path)); ?>">Abstrak</a><?php endif; ?> 
<?php if(auth()->user()->isJurusan()): ?>
    <a class="text-blue-700 hover:text-blue-900"
       href="<?php echo e(route('archives.edit',$a)); ?>">
        Edit
    </a>
<?php endif; ?>
</div>
</div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <p class="text-slate-500">Belum ada arsip.</p><?php endif; ?></div><div class="mt-4"><?php echo e($items->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/archives/index.blade.php ENDPATH**/ ?>