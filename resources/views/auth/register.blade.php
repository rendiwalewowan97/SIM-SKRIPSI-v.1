@extends('layouts.guest')

@section('content')

<h2 class="mb-6 text-center text-2xl font-bold text-slate-800">
    Registrasi
</h2>

<form method="POST" action="{{ route('register.store') }}">
    @csrf

    <div class="mb-4">
        <label class="mb-2 block text-sm font-semibold text-slate-700">Nama</label>
        <input
            name="name"
            value="{{ old('name') }}"
            required
            class="w-full rounded-xl border border-slate-200 px-4 py-3 transition focus:border-[#5FA9AD] focus:outline-none focus:ring-2 focus:ring-[#81C1C3]/40">
    </div>

    <div class="mb-4">
        <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            class="w-full rounded-xl border border-slate-200 px-4 py-3 transition focus:border-[#5FA9AD] focus:outline-none focus:ring-2 focus:ring-[#81C1C3]/40">
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div class="mb-4">
            <label class="mb-2 block text-sm font-semibold text-slate-700">Role</label>
            <select
                name="role"
                class="w-full rounded-xl border border-slate-200 px-4 py-3 transition focus:border-[#5FA9AD] focus:outline-none focus:ring-2 focus:ring-[#81C1C3]/40">
                <option value="mahasiswa" @selected(old('role') == 'mahasiswa')>Mahasiswa</option>
                <option value="dosen" @selected(old('role') == 'dosen')>Dosen</option>
                <option value="jurusan" @selected(old('role') == 'jurusan')>Jurusan</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="mb-2 block text-sm font-semibold text-slate-700">NPM / NIP</label>
            <input
                name="identifier"
                value="{{ old('identifier') }}"
                class="w-full rounded-xl border border-slate-200 px-4 py-3 transition focus:border-[#5FA9AD] focus:outline-none focus:ring-2 focus:ring-[#81C1C3]/40">
        </div>
    </div>

    <div class="mb-4">
        <label class="mb-2 block text-sm font-semibold text-slate-700">Telepon</label>
        <input
            name="phone"
            value="{{ old('phone') }}"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 transition focus:border-[#5FA9AD] focus:outline-none focus:ring-2 focus:ring-[#81C1C3]/40">
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div class="mb-5">
            <label class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
            <input
                type="password"
                name="password"
                required
                class="w-full rounded-xl border border-slate-200 px-4 py-3 transition focus:border-[#5FA9AD] focus:outline-none focus:ring-2 focus:ring-[#81C1C3]/40">
        </div>

        <div class="mb-5">
            <label class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                required
                class="w-full rounded-xl border border-slate-200 px-4 py-3 transition focus:border-[#5FA9AD] focus:outline-none focus:ring-2 focus:ring-[#81C1C3]/40">
        </div>
    </div>

    <button
        type="submit"
        class="w-full rounded-xl bg-[#5FA9AD] px-4 py-3 font-medium text-white transition hover:bg-[#4D9599]">
        Daftar
    </button>
</form>

<p class="mt-6 text-center text-sm text-slate-600">
    Sudah punya akun?
    <a href="{{ route('login') }}"
       class="font-medium text-[#5FA9AD] hover:underline">
        Login
    </a>
</p>

@endsection