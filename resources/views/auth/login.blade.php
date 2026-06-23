@extends('layouts.guest')

@section('content')

<h2 class="mb-6 text-center text-2xl font-bold text-slate-800">
    Login
</h2>

<form method="POST" action="{{ route('login.post') }}">
    @csrf

    <div class="mb-4">
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Email
        </label>

        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            class="w-full rounded-xl border border-slate-200 px-4 py-3 transition focus:border-[#5FA9AD] focus:outline-none focus:ring-2 focus:ring-[#81C1C3]/40">
    </div>

    <div class="mb-4">
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Password
        </label>

        <input
            type="password"
            name="password"
            required
            class="w-full rounded-xl border border-slate-200 px-4 py-3 transition focus:border-[#5FA9AD] focus:outline-none focus:ring-2 focus:ring-[#81C1C3]/40">
    </div>

    <div class="mb-6 flex items-center">
        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input
                type="checkbox"
                name="remember"
                class="rounded border-slate-300 text-[#5FA9AD] focus:ring-[#81C1C3]">
            Ingat saya
        </label>
    </div>

    <button
        type="submit"
        class="w-full rounded-xl bg-[#5FA9AD] px-4 py-3 font-medium text-white transition hover:bg-[#4D9599]">
        Masuk
    </button>

</form>

<p class="mt-6 text-center text-sm text-slate-600">
    Belum punya akun?
    <a href="{{ route('register') }}"
       class="font-medium text-[#5FA9AD] hover:underline">
        Daftar
    </a>
</p>

@if(app()->environment('local'))
<div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm">
    <h3 class="mb-2 font-semibold text-slate-700">
        Akun Demo
    </h3>

    <div class="space-y-1 text-slate-600">
        <div><b>Jurusan</b> : jurusan@unmus.ac.id / password</div>
        <div><b>Dosen</b> : dosen@unmus.ac.id / password</div>
        <div><b>Mahasiswa</b> : mahasiswa@unmus.ac.id / password</div>
    </div>
</div>
@endif

@endsection