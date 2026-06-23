<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'SIM Skripsi')); ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#81C1C3] via-[#74B3B5] to-[#5FA9AD]">

    <div class="flex min-h-screen items-center justify-center px-4 py-8">

        <div
            class="w-full max-w-xl rounded-3xl bg-white/95 p-8 shadow-[0_25px_80px_rgba(0,0,0,0.18)] backdrop-blur-md sm:p-10">

            
            <div class="mb-8 text-center">

                <div class="mx-auto mb-5 flex h-28 w-28 items-center justify-center rounded-3xl bg-slate-50 shadow-sm">
                    <img src="<?php echo e(asset('images/logo-unmus.png')); ?>"
                         alt="Logo UNMUS"
                         class="h-20 w-20 object-contain">
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-slate-800">
                    SIM Skripsi
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Universitas Musamus
                </p>

            </div>

            
            <div class="border-t border-slate-100 pt-6">
                <?php echo $__env->yieldContent('content'); ?>
            </div>

        </div>

    </div>

</body>
</html><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/layouts/guest.blade.php ENDPATH**/ ?>