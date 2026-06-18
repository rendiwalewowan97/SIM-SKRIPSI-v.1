@extends('layouts.guest')
@section('content')
<div class="mx-auto max-w-lg rounded bg-white p-6 shadow">
    <h1 class="mb-4 text-2xl font-bold">Registrasi</h1>
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <label class="mb-2 block font-semibold">Nama</label>
        <input name="name" value="{{ old('name') }}" class="mb-4 w-full rounded border p-2" required>

        <label class="mb-2 block font-semibold">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="mb-4 w-full rounded border p-2" required>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mb-2 block font-semibold">Role</label>
                <select name="role" class="mb-4 w-full rounded border p-2">
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                    <option value="jurusan">Jurusan</option>
                </select>
            </div>
            <div>
                <label class="mb-2 block font-semibold">NIM/NIDN</label>
                <input name="identifier" value="{{ old('identifier') }}" class="mb-4 w-full rounded border p-2">
            </div>
        </div>

        <label class="mb-2 block font-semibold">Telepon</label>
        <input name="phone" value="{{ old('phone') }}" class="mb-4 w-full rounded border p-2">

        <label class="mb-2 block font-semibold">Password</label>
        <input type="password" name="password" class="mb-4 w-full rounded border p-2" required>

        <label class="mb-2 block font-semibold">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="mb-4 w-full rounded border p-2" required>

        <button class="w-full rounded bg-indigo-600 px-4 py-2 text-white">Daftar</button>
    </form>
    <p class="mt-4 text-center text-sm">Sudah punya akun? <a class="text-indigo-700" href="{{ route('login') }}">Log in</a></p>
</div>
@endsection
