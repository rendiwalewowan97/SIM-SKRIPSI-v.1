@extends('layouts.app')
@section('content')
<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Manajemen Pengguna</h1>
    <a href="{{ route('users.create') }}" class="rounded bg-indigo-600 px-4 py-2 text-white">Tambah Pengguna</a>
</div>

<form class="mb-4 grid gap-2 md:grid-cols-5">
    <input name="q" value="{{ request('q') }}" class="rounded border p-2 md:col-span-2" placeholder="Cari nama/email/NIM/NIDN">

    <select name="role" class="rounded border p-2">
        <option value="">Semua role</option>
        @foreach(['mahasiswa','dosen','jurusan'] as $r)
            <option value="{{ $r }}" @selected(request('role')==$r)>{{ ucfirst($r) }}</option>
        @endforeach
    </select>

    <select name="position" class="rounded border p-2">
        <option value="">Semua jabatan</option>
        <option value="ketua_jurusan" @selected(request('position')=='ketua_jurusan')>Ketua Jurusan</option>
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
            @forelse($items as $u)
                <tr class="border-t">
                    <td class="p-3 font-medium">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ ucfirst($u->role) }}</td>
                    <td>{{ $u->position === 'ketua_jurusan' ? 'Ketua Jurusan' : '-' }}</td>
                    <td>{{ $u->identifier }}</td>
                    <td>{{ $u->phone }}</td>
                    <td class="space-x-2">
                        <a class="text-blue-700" href="{{ route('users.edit',$u) }}">Edit</a>
                        @if($u->id !== auth()->id())
                            <form class="inline" method="POST" action="{{ route('users.destroy',$u) }}" onsubmit="return confirm('Hapus pengguna?')">
                                @csrf @method('DELETE')
                                <button class="text-red-700">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="p-4 text-center text-slate-500">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $items->links() }}</div>
@endsection
