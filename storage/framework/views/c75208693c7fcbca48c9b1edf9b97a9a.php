<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['value']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['value']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php $map=['diajukan'=>'bg-yellow-100 text-yellow-800','menunggu'=>'bg-yellow-100 text-yellow-800','disetujui'=>'bg-green-100 text-green-800','diverifikasi'=>'bg-blue-100 text-blue-800','dijadwalkan'=>'bg-indigo-100 text-indigo-800','selesai'=>'bg-green-100 text-green-800','ditolak'=>'bg-red-100 text-red-800','revisi'=>'bg-orange-100 text-orange-800','direview'=>'bg-blue-100 text-blue-800']; ?>
<span class="rounded px-2 py-1 text-xs font-semibold <?php echo e($map[$value] ?? 'bg-slate-100 text-slate-700'); ?>"><?php echo e(strtoupper(str_replace('_',' ', $value))); ?></span>
<?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/components/status.blade.php ENDPATH**/ ?>