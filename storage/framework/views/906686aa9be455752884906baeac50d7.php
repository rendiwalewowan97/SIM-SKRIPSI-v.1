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

        <div class="grid w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl md:grid-cols-2">

            
            <div class="hidden bg-[#81C1C3] p-10 text-white md:flex md:flex-col md:justify-between">

                <div>

                    <div class="mb-6 flex items-center gap-4">

                        <img src="<?php echo e(asset('images/logo-unmus.png')); ?>"
                             alt="Logo UNMUS"
                             class="h-16 w-16 rounded-xl bg-white/20 p-2">

                        <div>
                            <h1 class="text-2xl font-bold">
                                SIM Skripsi & Bimbingan
                            </h1>

                            <p class="text-sm text-white/80">
                                Universitas Musamus
                            </p>
                        </div>

                    </div>

                    <p class="text-white/90">
                        Sistem informasi untuk membantu proses pengajuan judul,
                        bimbingan proposal, seminar proposal, bimbingan skripsi,
                        sidang skripsi, monitoring progres mahasiswa, dan
                        pengelolaan arsip skripsi secara terintegrasi.
                    </p>

                </div>

                <div class="mt-10 text-sm text-white/80">
                    © <?php echo e(date('Y')); ?> Universitas Musamus
                </div>

            </div>

            
            <div class="p-6 sm:p-8 md:p-10">

                <div class="mb-8 text-center md:text-left">

                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-[#DDF3F3] text-3xl md:mx-0">
                        🔐
                    </div>

                    <h2 class="text-2xl font-bold text-slate-800">
                        Selamat Datang
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Silakan masuk untuk melanjutkan ke sistem.
                    </p>

                </div>

                <?php echo $__env->yieldContent('content'); ?>

            </div>

        </div>

    </div>

</body>
</html><?php /**PATH D:\PROJECT\SKRIPSI ORANG\SIM-SKRIPSI-v.1\resources\views/layouts/guest.blade.php ENDPATH**/ ?>