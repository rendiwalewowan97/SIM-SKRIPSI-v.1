<?php $__env->startSection('content'); ?>

<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Bimbingan Proposal/Skripsi</h1>


<?php if(auth()->user()->isMahasiswa()): ?>
        <div class="flex items-center gap-2">
            
            <a href="<?php echo e(route('guidances.letter')); ?>" target="_blank"
               class="rounded bg-red-600 px-4 py-2 text-white transition hover:bg-red-700">
                Export PDF
            </a>

            
            <a href="<?php echo e(route('guidances.create')); ?>"
               class="rounded bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">
                Tambah Bimbingan
            </a>
        </div>
<?php endif; ?>

</div>

<form class="mb-4 grid gap-2 md:grid-cols-4">
    <select name="type" class="rounded border p-2">
        <option value="">Semua jenis</option>
        <?php $__currentLoopData = ['proposal','skripsi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($s); ?>" <?php if(request('type') == $s): echo 'selected'; endif; ?>>
                <?php echo e($s); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

<select name="status" class="rounded border p-2">
    <option value="">Semua status</option>
    <?php $__currentLoopData = ['menunggu','direview','selesai','revisi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($s); ?>" <?php if(request('status') == $s): echo 'selected'; endif; ?>>
            <?php echo e($s); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

<button class="rounded bg-slate-800 px-4 py-2 text-white">
    Filter
</button>

</form>

<div class="overflow-x-auto rounded bg-white shadow">
    <table class="w-full text-sm">
        <thead class="bg-slate-100">
            <tr>
                <th class="p-3 text-left">Tanggal</th>
                <th>Jenis</th>
                <th>Mahasiswa</th>
                <th>Dosen</th>
                <th>Bab/Topik</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-t">
                <td class="p-3">
                    <?php echo e($g->session_date?->format('d/m/Y')); ?>

                </td>

                <td><?php echo e(ucfirst($g->type)); ?></td>

                <td><?php echo e($g->student->name); ?></td>

                <td><?php echo e($g->supervisor->name); ?></td>

                <td><?php echo e($g->chapter ?? '-'); ?></td>

                <td>
                    <?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['value' => $g->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($g->status)]); ?>
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
                </td>

                <td class="whitespace-nowrap">
                    <div class="flex items-center justify-center gap-3">

                        
                        <a href="<?php echo e(route('guidances.show', $g)); ?>"
                           class="text-indigo-700 hover:text-indigo-900"
                           title="Detail">
                            <svg class="w-5 h-5"
                                 aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24">
                                <path stroke="currentColor"
                                      stroke-width="2"
                                      d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                <path stroke="currentColor"
                                      stroke-width="2"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </a>

                        
                        
                        <?php if(auth()->user()->isDosen() && auth()->id() == $g->supervisor_id): ?>
                            <a href="<?php echo e(route('guidances.edit', $g)); ?>"
                               class="text-blue-700 hover:text-blue-900"
                               title="Review">
                                <svg class="w-5 h-5"
                                     aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
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

                        
                        <?php if(
                            (auth()->user()->isMahasiswa() && auth()->id() == $g->student_id) ||
                            (auth()->user()->isDosen() && auth()->id() == $g->supervisor_id)
                        ): ?>
                            <a href="<?php echo e(route('chats.show', auth()->user()->isMahasiswa() ? $g->supervisor_id : $g->student_id)); ?>"
                            class="text-green-700 hover:text-green-900"
                            title="Chat">
                                <svg class="w-5 h-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 10h8m-8 4h5m8-2a9 9 0 1 1-4.219-7.627L21 4l-1.373 4.219A8.96 8.96 0 0 1 21 12Z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        
                        <?php if(
                            auth()->user()->isDosen() &&
                            auth()->id() == $g->supervisor_id &&
                            $g->status === 'selesai'
                        ): ?>
                            <form method="POST"
                                action="<?php echo e(route('guidances.destroy', $g)); ?>"
                                onsubmit="return confirm('Yakin ingin menghapus bimbingan yang sudah selesai ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button type="submit"
                                        class="text-red-700 hover:text-red-900"
                                        title="Hapus">
                                    <svg class="w-5 h-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 7h12m-9 4v6m6-6v6M9 7V4h6v3m-9 0 1 13h10l1-13"/>
                                    </svg>
                                </button>
                            </form>
                        <?php endif; ?>

                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="p-4 text-center text-slate-500">
                    Belum ada data.
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/guidances/index.blade.php ENDPATH**/ ?>