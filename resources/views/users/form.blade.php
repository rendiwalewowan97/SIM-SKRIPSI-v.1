@extends('layouts.app')

@section('content')
<h1 class="mb-4 text-2xl font-bold">
    {{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}
</h1>

<form method="POST"
      action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}"
      class="rounded bg-white p-4 shadow">

    @csrf
    @isset($user)
        @method('PUT')
    @endisset

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block font-semibold">Nama</label>
            <input name="name" value="{{ old('name', $user->name ?? '') }}" class="mb-4 w-full rounded border p-2" required>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="mb-4 w-full rounded border p-2" required>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <div>
            <label class="mb-2 block font-semibold">Role</label>
            <select name="role" class="mb-4 w-full rounded border p-2" required>
                @foreach(['mahasiswa', 'dosen', 'jurusan'] as $r)
                    <option value="{{ $r }}" @selected(old('role', $user->role ?? '') == $r)>
                        {{ ucfirst($r) }}
                    </option>
                @endforeach
            </select>
            <p class="-mt-3 mb-4 text-xs text-slate-500">
                Ketua Jurusan tetap menggunakan role Dosen.
            </p>
        </div>

        <div>
            <label class="mb-2 block font-semibold">Jabatan</label>
            <select name="position" class="mb-4 w-full rounded border p-2">
                <option value="" @selected(old('position', $user->position ?? '') == '')>Tidak Ada</option>
                <option value="ketua_jurusan" @selected(old('position', $user->position ?? '') == 'ketua_jurusan')>
                    Ketua Jurusan
                </option>
            </select>
        </div>

        <div>
            <label class="mb-2 block font-semibold">NIM/NIDN</label>
            <input name="identifier" value="{{ old('identifier', $user->identifier ?? '') }}" class="mb-4 w-full rounded border p-2">
        </div>

        <div>
            <label class="mb-2 block font-semibold">Telepon</label>
            <input name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="mb-4 w-full rounded border p-2">
        </div>
    </div>

    <label class="mb-2 block font-semibold">
        Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}
    </label>
    <input type="password" name="password" class="mb-4 w-full rounded border p-2" {{ isset($user) ? '' : 'required' }}>

    <button class="rounded bg-indigo-600 px-4 py-2 text-white">Simpan</button>
</form>
@endsection
