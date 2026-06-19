

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-4xl">
    <div class="rounded-xl bg-white p-6 shadow">

        
        <div class="flex flex-col gap-3 border-b pb-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Detail Bimbingan
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Informasi detail sesi bimbingan mahasiswa
                </p>
            </div>

            <?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['value' => $guidance->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($guidance->status)]); ?>
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
        </div>

        
        <dl class="mt-6 grid gap-5 md:grid-cols-2">

            <div>
                <dt class="text-sm font-medium text-slate-500">
                    Mahasiswa
                </dt>
                <dd class="mt-1 text-slate-800">
                    <?php echo e($guidance->student->name); ?>

                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-slate-500">
                    Dosen
                </dt>
                <dd class="mt-1 text-slate-800">
                    <?php echo e($guidance->supervisor->name); ?>

                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-slate-500">
                    Tanggal
                </dt>
                <dd class="mt-1 text-slate-800">
                    <?php echo e($guidance->session_date?->format('d/m/Y') ?? '-'); ?>

                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-slate-500">
                    Jenis / Bab
                </dt>
                <dd class="mt-1 text-slate-800">
                    <?php echo e(ucfirst($guidance->type)); ?> - <?php echo e($guidance->chapter); ?>

                </dd>
            </div>

        </dl>

        
        <div class="mt-8 border-t pt-6">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">
                Catatan Mahasiswa
            </h2>

            <div class="rounded-lg bg-slate-50 p-4 text-slate-700">
                <p class="whitespace-pre-line">
                    <?php echo e($guidance->student_note ?: '-'); ?>

                </p>
            </div>
        </div>

        
        <div class="mt-6 border-t pt-6">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">
                Catatan Dosen
            </h2>

            <div class="rounded-lg bg-slate-50 p-4 text-slate-700">
                <p class="whitespace-pre-line">
                    <?php echo e($guidance->supervisor_note ?: '-'); ?>

                </p>
            </div>
        </div>

        
        <?php if($guidance->file_path): ?>
        <div class="mt-6 border-t pt-6">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">
                File Bimbingan
            </h2>

            <a href="<?php echo e(route('guidances.file', $guidance)); ?>"
               target="_blank"
               class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 16V4m0 12l-4-4m4 4l4-4M4 20h16"/>
                </svg>

                Unduh / Lihat File
            </a>
        </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\SKRIPSI ORANG\SIM-SKRIPSI-v.1\resources\views/guidances/show.blade.php ENDPATH**/ ?>