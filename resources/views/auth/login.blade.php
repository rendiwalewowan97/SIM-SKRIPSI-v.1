@extends('layouts.guest')
@section('content')
<div class="mx-auto max-w-md rounded bg-white p-6 shadow"><h1 class="mb-4 text-2xl font-bold">Login</h1><form method="POST" action="{{ route('login.post') }}">@csrf<label class="mb-2 block font-semibold">Email</label><input type="email" name="email" value="{{ old('email') }}" class="mb-4 w-full rounded border p-2" required autofocus><label class="mb-2 block font-semibold">Password</label><input type="password" name="password" class="mb-4 w-full rounded border p-2" required><label class="mb-4 flex gap-2"><input type="checkbox" name="remember"> Ingat saya</label><button class="w-full rounded bg-indigo-600 px-4 py-2 text-white">Masuk</button></form>
<p class="mt-4 text-center text-sm">Belum punya akun? <a class="text-indigo-700" href="{{ route('register') }}">Daftar</a></p>
<div class="mt-4 rounded bg-slate-50 p-3 text-sm text-slate-600"><b>Akun demo:</b><br>jurusan@unmus.ac.id / password<br>dosen@unmus.ac.id / password<br>mahasiswa@unmus.ac.id / password</div></div>
@endsection
