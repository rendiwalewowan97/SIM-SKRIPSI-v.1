<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-4xl">
    <div class="rounded-xl bg-white p-6 shadow">

        
        <div class="flex flex-col gap-3 border-b pb-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Detail Pendaftaran Sidang
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Informasi lengkap pendaftaran sidang mahasiswa
                </p>
            </div>

            <?php if (isset($component)) { $__componentOriginal51ed764111e345fc11534f121cfeb451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51ed764111e345fc11534f121cfeb451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status','data' => ['value' => $exam->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($exam->status)]); ?>
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

        
        <div class="mt-6 grid gap-5 md:grid-cols-2">

            <div>
                <dt class="text-sm font-medium text-slate-500">
                    Mahasiswa
                </dt>
                <dd class="mt-1 text-slate-800">
                    <?php echo e($exam->student->name); ?>

                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-slate-500">
                    Jenis Sidang
                </dt>
                <dd class="mt-1 text-slate-800 capitalize">
                    <?php echo e(str_replace('_', ' ', $exam->type)); ?>

                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-slate-500">
                    Jadwal Sidang
                </dt>
                <dd class="mt-1 text-slate-800">
                    <?php echo e($exam->scheduled_at?->format('d/m/Y H:i') ?? '-'); ?>

                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-slate-500">
                    Ruangan
                </dt>
                <dd class="mt-1 text-slate-800">
                    <?php echo e($exam->room ?: '-'); ?>

                </dd>
            </div>
        </div>


        
        <div class="mt-8 border-t pt-6">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">
                Tim <?php echo e($exam->type === 'seminar_proposal' ? 'Seminar Proposal' : 'Sidang Skripsi'); ?>

            </h2>

            <div class="grid gap-4 md:grid-cols-2">
                <div><dt class="text-sm font-medium text-slate-500">Pembimbing 1</dt><dd><?php echo e($exam->supervisor1->name ?? '-'); ?></dd></div>
                <div><dt class="text-sm font-medium text-slate-500">Pembimbing 2</dt><dd><?php echo e($exam->supervisor2->name ?? '-'); ?></dd></div>
                <div><dt class="text-sm font-medium text-slate-500">Ketua</dt><dd><?php echo e($exam->chairman->name ?? '-'); ?></dd></div>
                <div><dt class="text-sm font-medium text-slate-500">Sekretaris</dt><dd><?php echo e($exam->secretary->name ?? '-'); ?></dd></div>
                <div><dt class="text-sm font-medium text-slate-500">Penguji 1</dt><dd><?php echo e($exam->examiner1->name ?? '-'); ?></dd></div>
                <div><dt class="text-sm font-medium text-slate-500">Penguji 2</dt><dd><?php echo e($exam->examiner2->name ?? '-'); ?></dd></div>
                <div><dt class="text-sm font-medium text-slate-500">Penguji 3</dt><dd><?php echo e($exam->examiner3->name ?? '-'); ?></dd></div>
            </div>
        </div>

        
        <div class="mt-8 border-t pt-6">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">
                Catatan
            </h2>

            <div class="rounded-lg bg-slate-50 p-4 text-slate-700">
                <?php echo e($exam->notes ?: 'Tidak ada catatan.'); ?>

            </div>
        </div>

        <!-- 
        <?php if($exam->document_path): ?>
        <div class="mt-6 border-t pt-6">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">
                Dokumen Pendukung
            </h2>

            <a href="<?php echo e(asset('storage/'.$exam->document_path)); ?>"
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

                Unduh / Lihat Dokumen
            </a>
        </div>
        <?php endif; ?> -->

        
        <?php if($exam->status === 'dijadwalkan'): ?>
        <div class="mt-6 border-t pt-6">
            <a href="<?php echo e(route('exams.schedule.letter', $exam)); ?>"
            target="_blank"
            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-white transition hover:bg-green-700">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16"/>
                </svg>

                Download Surat Jadwal Sidang
            </a>
        </div>
        <?php endif; ?>


    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/exams/show.blade.php ENDPATH**/ ?>