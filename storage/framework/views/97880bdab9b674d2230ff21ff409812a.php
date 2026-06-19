<?php $__env->startSection('content'); ?>
<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Manajemen Pengguna</h1>
    <a href="<?php echo e(route('users.create')); ?>" class="rounded bg-indigo-600 px-4 py-2 text-white">Tambah Pengguna</a>
</div>

<form class="mb-4 grid gap-2 md:grid-cols-5">
    <input name="q" value="<?php echo e(request('q')); ?>" class="rounded border p-2 md:col-span-2" placeholder="Cari nama/email/NIM/NIDN">

    <select name="role" class="rounded border p-2">
        <option value="">Semua role</option>
        <?php $__currentLoopData = ['mahasiswa','dosen','jurusan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($r); ?>" <?php if(request('role')==$r): echo 'selected'; endif; ?>><?php echo e(ucfirst($r)); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <select name="position" class="rounded border p-2">
        <option value="">Semua jabatan</option>
        <option value="ketua_jurusan" <?php if(request('position')=='ketua_jurusan'): echo 'selected'; endif; ?>>Ketua Jurusan</option>
    </select>

    <button class="rounded bg-slate-800 px-4 py-2 text-white">Filter</button>
</form>

<div class="overflow-x-auto rounded bg-white shadow">
    <table class="w-full text-sm">
        <thead class="bg-slate-100">
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Jabatan</th>
                <th>NIM/NIDN</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t">
                    <td class="p-3 font-medium"><?php echo e($u->name); ?></td>
                    <td><?php echo e($u->email); ?></td>
                    <td><?php echo e(ucfirst($u->role)); ?></td>
                    <td><?php echo e($u->position === 'ketua_jurusan' ? 'Ketua Jurusan' : '-'); ?></td>
                    <td><?php echo e($u->identifier); ?></td>
                    <td><?php echo e($u->phone); ?></td>
                    <td class="space-x-2">
                        <a class="text-blue-700" href="<?php echo e(route('users.edit',$u)); ?>">Edit</a>
                        <?php if($u->id !== auth()->id()): ?>
                            <form class="inline" method="POST" action="<?php echo e(route('users.destroy',$u)); ?>" onsubmit="return confirm('Hapus pengguna?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="text-red-700">Hapus</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="p-4 text-center text-slate-500">Belum ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-4"><?php echo e($items->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/users/index.blade.php ENDPATH**/ ?>