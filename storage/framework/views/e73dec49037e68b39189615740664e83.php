<?php $__env->startSection('content'); ?>
<h1 class="mb-4 text-2xl font-bold">
    <?php echo e(isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna'); ?>

</h1>

<form method="POST"
      action="<?php echo e(isset($user) ? route('users.update', $user) : route('users.store')); ?>"
      class="rounded bg-white p-4 shadow">

    <?php echo csrf_field(); ?>
    <?php if(isset($user)): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block font-semibold">Nama</label>
            <input name="name" value="<?php echo e(old('name', $user->name ?? '')); ?>" class="mb-4 w-full rounded border p-2" required>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Email</label>
            <input type="email" name="email" value="<?php echo e(old('email', $user->email ?? '')); ?>" class="mb-4 w-full rounded border p-2" required>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <div>
            <label class="mb-2 block font-semibold">Role</label>
            <select name="role" class="mb-4 w-full rounded border p-2" required>
                <?php $__currentLoopData = ['mahasiswa', 'dosen', 'jurusan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($r); ?>" <?php if(old('role', $user->role ?? '') == $r): echo 'selected'; endif; ?>>
                        <?php echo e(ucfirst($r)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <p class="-mt-3 mb-4 text-xs text-slate-500">
                Ketua Jurusan tetap menggunakan role Dosen.
            </p>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Jabatan</label>
            <select name="position" class="mb-4 w-full rounded border p-2">
                <option value="" <?php if(old('position', $user->position ?? '') == ''): echo 'selected'; endif; ?>>Tidak Ada</option>
                <option value="ketua_jurusan" <?php if(old('position', $user->position ?? '') == 'ketua_jurusan'): echo 'selected'; endif; ?>>
                    Ketua Jurusan
                </option>
            </select>
        </div>

        <div>
            <label class="mb-2 block font-semibold">NIM/NIDN</label>
            <input name="identifier" value="<?php echo e(old('identifier', $user->identifier ?? '')); ?>" class="mb-4 w-full rounded border p-2">
        </div>

        <div>
            <label class="mb-2 block font-semibold">Telepon</label>
            <input name="phone" value="<?php echo e(old('phone', $user->phone ?? '')); ?>" class="mb-4 w-full rounded border p-2">
        </div>
    </div>

    <label class="mb-2 block font-semibold">
        Password <?php echo e(isset($user) ? '(kosongkan jika tidak diubah)' : ''); ?>

    </label>
    <input type="password" name="password" class="mb-4 w-full rounded border p-2" <?php echo e(isset($user) ? '' : 'required'); ?>>

    <button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SIM-SKRIPSI-PATCHED-ARSIP-PREVIEW\resources\views/users/form.blade.php ENDPATH**/ ?>