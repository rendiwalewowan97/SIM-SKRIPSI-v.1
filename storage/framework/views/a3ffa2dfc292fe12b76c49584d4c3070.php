

<?php $__env->startSection('content'); ?>

<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Arsip Skripsi</h1>

 
<?php if(auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan() || auth()->user()->isMahasiswa()): ?>
    <a href="<?php echo e(route('archives.create')); ?>"
       class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
        Tambah Arsip
    </a>
<?php endif; ?>
 

</div>

<form class="mb-4 flex gap-2">
    <input name="q"
           value="<?php echo e(request('q')); ?>"
           class="w-full rounded border p-2"
           placeholder="Cari judul, keyword, tahun">

 
<button class="rounded bg-slate-800 px-4 py-2 text-white">
    Cari
</button>
 

</form>

<div class="overflow-x-auto rounded bg-white shadow">
    <table class="w-full text-sm text-center">
        <thead class="bg-slate-100 text-center">
            <tr>
                <th class="p-3 text-center">No</th>
                <th class="p-3 text-center">Judul</th>
                <th class="p-3 text-center">NPM</th>
                <th class="p-3 text-center">Mahasiswa</th>
                <th class="p-3 text-center">Tahun</th>
                <th class="p-3 text-center">Keyword</th>
                <th class="p-3 text-center">Status</th>
                <th class="p-3 text-center w-44">Aksi</th>
            </tr>
        </thead>

 
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr class="border-t text-center hover:bg-slate-50">

            <td class="p-3">
                <?php echo e($items->firstItem() + $loop->index); ?>

            </td>

            <td class="p-3 font-medium">
                <?php echo e($a->title); ?>

            </td>

            <td class="p-3">
                <?php echo e($a->student->identifier ?? '-'); ?>

            </td>

            <td class="p-3">
                <?php echo e($a->student->name ?? '-'); ?>

            </td>

            <td class="p-3">
                <?php echo e($a->year); ?>

            </td>

            <td class="p-3">
                <?php echo e($a->keywords ?? '-'); ?>

            </td>

            <td class="p-3">
                <?php if($a->is_public): ?>
                    <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">
                        Published
                    </span>
                <?php else: ?>
                    <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-700">
                        Menunggu Publish
                    </span>
                <?php endif; ?>
            </td>

            <td class="p-3">
                <div class="flex items-center justify-center gap-3">

                    
                    <a href="<?php echo e(route('archives.show', $a)); ?>"
                       title="Detail Arsip"
                       class="text-indigo-700 hover:text-indigo-900">

                        <svg class="h-5 w-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>

                    </a>

                    
                    <?php if(auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan()): ?>

                        <?php if(!$a->is_public): ?>

                            <form method="POST"
                                  action="<?php echo e(route('archives.publish', $a)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>

                                <button type="submit"
                                        title="Publish Arsip"
                                        onclick="return confirm('Publish arsip ini?')"
                                        class="text-green-600 hover:text-green-800">

                                    <svg class="h-5 w-5"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>

                                </button>
                            </form>

                        <?php else: ?>

                            <form method="POST"
                                  action="<?php echo e(route('archives.unpublish', $a)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>

                                <button type="submit"
                                        title="Batalkan Publish"
                                        onclick="return confirm('Batalkan publish arsip ini?')"
                                        class="text-yellow-600 hover:text-yellow-800">

                                    <svg class="h-5 w-5"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>

                                </button>
                            </form>

                        <?php endif; ?>

                    <?php endif; ?>

                    
                    <?php if(
                        auth()->user()->isJurusan() ||
                        auth()->user()->isKetuaJurusan() ||
                        (
                            $a->student_id === auth()->id() &&
                            !$a->is_public
                        )
                    ): ?>
                        <a href="<?php echo e(route('archives.edit', $a)); ?>"
                           class="text-blue-700 hover:text-blue-900"
                           title="Edit Arsip">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24">
                                <path stroke="currentColor"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                            </svg>

                        </a>
                    <?php endif; ?>

                    
                    <?php if(auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan()): ?>

                        <form method="POST"
                              action="<?php echo e(route('archives.destroy', $a)); ?>"
                              onsubmit="return confirm('Yakin ingin menghapus arsip ini?')">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="submit"
                                    class="text-red-600 hover:text-red-800"
                                    title="Hapus Arsip">

                                <svg class="h-5 w-5"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-8 0v12a1 1 0 001 1h8a1 1 0 001-1V7"/>
                                </svg>

                            </button>

                        </form>

                    <?php endif; ?>

                </div>
            </td>

        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="8" class="p-4 text-center text-slate-500">
                Belum ada arsip.
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
 

</div>

<div class="mt-4">
    <?php echo e($items->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/archives/index.blade.php ENDPATH**/ ?>