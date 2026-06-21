

<?php $__env->startSection('content'); ?>
<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Notifikasi</h1>

    <div class="flex gap-2">
        <form method="POST" action="<?php echo e(route('notifications.readAll')); ?>">
            <?php echo csrf_field(); ?>
            <button class="rounded bg-slate-800 px-4 py-2 text-white">
                Tandai Semua Dibaca
            </button>
        </form>

        <form method="POST" action="<?php echo e(route('notifications.clearRead')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button
                onclick="return confirm('Hapus semua notifikasi yang sudah dibaca?')"
                class="rounded bg-red-600 px-4 py-2 text-white">
                Bersihkan Pesan yang Sudah Dibaca
            </button>
        </form>
    </div>
</div>

<div class="rounded bg-white shadow">
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="border-t p-4 hover:bg-slate-50 <?php echo e($n->read_at ? 'opacity-70' : ''); ?>">
            <div class="flex items-start justify-between gap-4">

                <a href="<?php echo e(route('notifications.read', $n)); ?>" class="block flex-1">
                    <div class="flex justify-between gap-4">
                        <h2 class="font-bold"><?php echo e($n->title); ?></h2>
                        <span class="text-sm text-slate-500">
                            <?php echo e($n->created_at->diffForHumans()); ?>

                        </span>
                    </div>

                    <p class="text-slate-600"><?php echo e($n->message); ?></p>

                    <?php if (! ($n->read_at)): ?>
                        <span class="mt-2 inline-block rounded bg-indigo-100 px-2 py-1 text-xs text-indigo-700">
                            Baru
                        </span>
                    <?php endif; ?>
                </a>

                <?php if($n->read_at): ?>
                    <form method="POST" action="<?php echo e(route('notifications.destroy', $n)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button
                            onclick="return confirm('Hapus notifikasi ini?')"
                            class="rounded bg-red-500 px-3 py-1 text-xs text-white hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="p-4 text-slate-500">Belum ada notifikasi.</p>
    <?php endif; ?>
</div>

<div class="mt-4">
    <?php echo e($items->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/notifications/index.blade.php ENDPATH**/ ?>