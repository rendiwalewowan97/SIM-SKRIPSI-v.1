<?php

namespace App\Http\Controllers;

use App\Models\ThesisArchive;
use App\Models\User;
use App\Models\Notification;
use App\Services\FcmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ThesisArchiveController extends Controller
{
    public function index(Request $request)
    {
        $items = ThesisArchive::with('student')
            ->when(!auth()->user()->isJurusan() && !auth()->user()->isKetuaJurusan(), function ($q) {
                $q->where('is_public', true)
                  ->orWhere('student_id', auth()->id());
            })
            ->when($request->q, function ($q, $v) {
                $q->where(function ($qq) use ($v) {
                    $qq->where('title', 'like', "%$v%")
                        ->orWhere('keywords', 'like', "%$v%")
                        ->orWhere('year', 'like', "%$v%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('archives.index', compact('items'));
    }

    public function create()
    {
        abort_unless(
            auth()->user()->isJurusan() ||
            auth()->user()->isKetuaJurusan() ||
            auth()->user()->isMahasiswa(),
            403
        );

        return view('archives.create', [
            'students' => User::where('role', 'mahasiswa')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'year' => 'required|digits:4',
            'keywords' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:pdf|max:51200',
            'abstract' => 'nullable|file|mimes:pdf|max:20480',
            'is_public' => 'nullable|boolean',
        ]);

        $data['student_id'] =
            (auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan()) && $request->student_id
                ? $request->student_id
                : auth()->id();

        $data['file_path'] = $this->uploadToPublic($request->file('file'), 'skripsi');

        if ($request->hasFile('abstract')) {
            $data['abstract_path'] = $this->uploadToPublic($request->file('abstract'), 'abstrak');
        }

        unset($data['file'], $data['abstract']);

        $data['is_public'] =
            auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan()
                ? $request->boolean('is_public', true)
                : false;

        $archive = ThesisArchive::create($data);

        if (auth()->user()->isMahasiswa()) {
            $jurusanUsers = User::whereIn('role', ['jurusan', 'ketua_jurusan'])->get();

            foreach ($jurusanUsers as $jurusan) {
                Notification::create([
                    'user_id' => $jurusan->id,
                    'title' => 'Pengajuan arsip skripsi baru',
                    'message' => auth()->user()->name . ' mengajukan arsip skripsi dengan judul "' . $archive->title . '".',
                    'url' => route('archives.show', $archive),
                ]);

                app(FcmService::class)->sendToUser(
                    $jurusan,
                    'Pengajuan Arsip Skripsi',
                    auth()->user()->name . ' mengajukan arsip skripsi baru.',
                    route('archives.show', $archive)
                );
            }
        }

        return redirect()
            ->route('archives.index')
            ->with('success', 'Arsip skripsi berhasil disimpan.');
    }

    public function show(ThesisArchive $archive)
    {
        $this->authorizeArchive($archive);

        return view('archives.show', compact('archive'));
    }

    public function preview(ThesisArchive $archive, string $type)
    {
        $this->authorizeArchive($archive);

        [$absolutePath, $fileName] = $this->resolveArchiveFile($archive, $type);

        abort_unless(
            $absolutePath && File::exists($absolutePath),
            404,
            'File tidak ditemukan di local project.'
        );

        return Response::file($absolutePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }

    public function download(ThesisArchive $archive, string $type)
    {
        abort_if(auth()->user()->isMahasiswa(), 403);

        $this->authorizeArchive($archive);

        [$absolutePath, $fileName] = $this->resolveArchiveFile($archive, $type);

        abort_unless(
            $absolutePath && File::exists($absolutePath),
            404,
            'File tidak ditemukan di local project.'
        );

        return response()->download($absolutePath, $fileName);
    }

    public function edit(ThesisArchive $archive)
    {
        abort_unless(
            auth()->user()->isJurusan() ||
            auth()->user()->isKetuaJurusan() ||
            $archive->student_id === auth()->id(),
            403
        );

        return view('archives.create', [
            'archive' => $archive,
            'students' => User::where('role', 'mahasiswa')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, ThesisArchive $archive)
    {
        abort_unless(
            auth()->user()->isJurusan() ||
            auth()->user()->isKetuaJurusan() ||
            $archive->student_id === auth()->id(),
            403
        );

        $data = $request->validate([
            'student_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'year' => 'required|digits:4',
            'keywords' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:51200',
            'abstract' => 'nullable|file|mimes:pdf|max:20480',
            'is_public' => 'nullable|boolean',
        ]);

        if ((auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan()) && $request->student_id) {
            $data['student_id'] = $request->student_id;
        } else {
            unset($data['student_id']);
        }

        if ($request->hasFile('file')) {
            $this->deleteArchiveFile($archive->file_path);
            $data['file_path'] = $this->uploadToPublic($request->file('file'), 'skripsi');
        }

        if ($request->hasFile('abstract')) {
            $this->deleteArchiveFile($archive->abstract_path);
            $data['abstract_path'] = $this->uploadToPublic($request->file('abstract'), 'abstrak');
        }

        unset($data['file'], $data['abstract']);

        if (auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan()) {
            $data['is_public'] = $request->boolean('is_public', false);
        } else {
            unset($data['is_public']);
        }

        $archive->update($data);

        return redirect()
            ->route('archives.show', $archive)
            ->with('success', 'Arsip skripsi diperbarui.');
    }

    public function destroy(ThesisArchive $archive)
    {
        abort_unless(
            auth()->user()->isJurusan() ||
            auth()->user()->isKetuaJurusan() ||
            $archive->student_id === auth()->id(),
            403
        );

        $this->deleteArchiveFile($archive->file_path);
        $this->deleteArchiveFile($archive->abstract_path);

        $archive->delete();

        return redirect()
            ->route('archives.index')
            ->with('success', 'Arsip skripsi dihapus.');
    }

    public function publish(ThesisArchive $archive)
    {
        abort_unless(
            auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan(),
            403
        );

        $archive->update([
            'is_public' => true,
        ]);

        if ($archive->student_id && $archive->student) {
            Notification::create([
                'user_id' => $archive->student_id,
                'title' => 'Arsip skripsi dipublish',
                'message' => 'Arsip skripsi Anda dengan judul "' . $archive->title . '" sudah lengkap dan dipublish.',
                'url' => route('archives.show', $archive),
            ]);

            app(FcmService::class)->sendToUser(
                $archive->student,
                'Arsip Skripsi Dipublish',
                'Arsip skripsi Anda telah dipublish oleh jurusan.',
                route('archives.show', $archive)
            );
        }

        return back()->with('success', 'Arsip berhasil dipublish dan notifikasi dikirim ke mahasiswa.');
    }

    public function unpublish(ThesisArchive $archive)
    {
        abort_unless(
            auth()->user()->isJurusan() || auth()->user()->isKetuaJurusan(),
            403
        );

        $archive->update([
            'is_public' => false,
        ]);

        return back()->with('success', 'Publish arsip berhasil dibatalkan.');
    }

    private function authorizeArchive(ThesisArchive $archive): void
    {
        abort_unless(
            $archive->is_public ||
            auth()->user()->isJurusan() ||
            auth()->user()->isKetuaJurusan() ||
            $archive->student_id === auth()->id(),
            403
        );
    }

    private function uploadToPublic($file, string $prefix): string
    {
        $folder = public_path('uploads/archives');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $name = $prefix . '-' . date('YmdHis') . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        $file->move($folder, $name);

        return 'uploads/archives/' . $name;
    }

    private function resolveArchiveFile(ThesisArchive $archive, string $type): array
    {
        $relativePath = $type === 'abstract'
            ? $archive->abstract_path
            : $archive->file_path;

        if (!$relativePath) {
            return [null, null];
        }

        $relativePath = ltrim($relativePath, '/');

        $publicPath = public_path($relativePath);

        if (File::exists($publicPath)) {
            return [$publicPath, basename($relativePath)];
        }

        if (Storage::disk('public')->exists($relativePath)) {
            return [
                Storage::disk('public')->path($relativePath),
                basename($relativePath),
            ];
        }

        return [$publicPath, basename($relativePath)];
    }

    private function deleteArchiveFile(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $relativePath = ltrim($relativePath, '/');
        $publicPath = public_path($relativePath);

        if (File::exists($publicPath)) {
            File::delete($publicPath);
            return;
        }

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}