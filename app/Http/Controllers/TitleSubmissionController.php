<?php
namespace App\Http\Controllers;

use App\Models\{TitleSubmission, TitleVote, User, Notification, AppSetting};
use App\Services\FcmService;
use Illuminate\Http\Request;

class TitleSubmissionController extends Controller
{
    /**
     * Aturan voting: judul disetujui jika suara setuju lebih dari setengah total dosen.
     * Ubah angka ini sesuai jumlah dosen aktif di jurusan.
     */
    private int $totalDosen = 15;

    public function index(Request $request)
    {
        $u = auth()->user();

        $items = TitleSubmission::with('student','supervisor','supervisor1','supervisor2')
            ->withCount(['setujuVotes','tidakSetujuVotes'])
            ->when($u->isMahasiswa(), fn($q) => $q->where('student_id', $u->id))
            ->when($request->status, fn($q, $v) => $q->where('status', $v))
            ->when($request->q, fn($q, $v) => $q->where(function ($qq) use ($v) {
                $qq->where('title', 'like', "%$v%")
                    ->orWhereHas('student', fn($s) => $s->where('name', 'like', "%$v%"));
            }))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('titles.index', compact('items'));
    }

    public function create()
    {
        abort_unless(auth()->user()->isMahasiswa() || auth()->user()->isJurusan(), 403);
        return view('titles.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isMahasiswa() || auth()->user()->isJurusan(), 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'sks' => 'required|integer|min:0|max:200',
            'background' => 'nullable|string',
        ]);

        $title = TitleSubmission::create($data + [
            'student_id' => auth()->id(),
            'status' => 'diajukan',
        ]);

        $jurusanUsers = User::where('role', 'jurusan')->get();

        foreach ($jurusanUsers as $jurusan) {
            Notification::create([
                'user_id' => $jurusan->id,
                'title' => 'Pengajuan judul baru',
                'message' => auth()->user()->name . ' mengajukan judul skripsi.',
                'url' => route('titles.show', $title),
            ]);

            app(FcmService::class)->sendToUser(
                $jurusan,
                'Pengajuan Judul Baru',
                auth()->user()->name . ' mengajukan judul skripsi.',
                route('titles.show', $title)
            );
        }

        return redirect()->route('titles.index')->with('success', 'Judul berhasil diajukan.');
    }

    public function show(TitleSubmission $title)
    {
        $this->authorizeView($title);

        $title->load('student','supervisor','supervisor1','supervisor2','votes.dosen')
            ->loadCount(['setujuVotes','tidakSetujuVotes']);

        $totalDosen = $this->totalDosen;
        $minimalSetuju = intdiv($totalDosen, 2) + 1;
        $myVote = $title->votes->firstWhere('dosen_id', auth()->id());

        return view('titles.show', compact('title','totalDosen','minimalSetuju','myVote'));
    }

    public function edit(TitleSubmission $title)
    {
        $u = auth()->user();

        if ($u->isMahasiswa()) {
            abort_unless($title->student_id === $u->id && in_array($title->status, ['diajukan','revisi']), 403);
            return view('titles.create', compact('title'));
        }

        abort_unless($u->isJurusan(), 403);

        $title->loadCount(['setujuVotes','tidakSetujuVotes']);
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();
        $totalDosen = $this->totalDosen;
        $minimalSetuju = intdiv($totalDosen, 2) + 1;

        return view('titles.review', compact('title','dosens','totalDosen','minimalSetuju'));
    }

    public function update(Request $request, TitleSubmission $title)
    {
        $u = auth()->user();

        if ($u->isMahasiswa()) {
            abort_unless($title->student_id === $u->id && in_array($title->status, ['diajukan','revisi']), 403);

            $data = $request->validate([
                'title' => 'required|string|max:255',
                'sks' => 'required|integer|min:0|max:200',
                'background' => 'nullable|string',
            ]);

            $title->update($data + ['status' => 'diajukan']);

            return redirect()->route('titles.index')->with('success', 'Pengajuan judul diperbarui dan dikirim ulang.');
        }

        abort_unless($u->isJurusan(), 403);
        return $this->review($request, $title);
    }

    public function vote(Request $request, TitleSubmission $title)
    {
        abort_unless(auth()->user()->isDosen(), 403);
        abort_unless(in_array($title->status, ['diajukan','revisi']), 403);

        $data = $request->validate([
            'vote' => 'required|in:setuju,tidak_setuju',
        ]);

        TitleVote::updateOrCreate(
            ['title_submission_id' => $title->id, 'dosen_id' => auth()->id()],
            ['vote' => $data['vote']]
        );

        $setuju = $title->setujuVotes()->count();
        $minimalSetuju = intdiv($this->totalDosen, 2) + 1;

        if ($setuju >= $minimalSetuju && $title->status !== 'disetujui') {
            $title->update([
                'status' => 'disetujui',
                'approved_at' => now(),
            ]);

            Notification::create([
                'user_id' => $title->student_id,
                'title' => 'Judul lolos voting',
                'message' => 'Judul Anda lolos voting dosen. Selanjutnya jurusan akan menetapkan pembimbing 1 dan 2.',
                'url' => route('titles.show', $title),
            ]);

            app(FcmService::class)->sendToUser(
                $title->student,
                'Judul Lolos Voting',
                'Judul Anda lolos voting dosen. Selanjutnya jurusan akan menetapkan pembimbing 1 dan 2.',
                route('titles.show', $title)
            );

            foreach (User::where('role', 'jurusan')->get() as $jurusan) {
                Notification::create([
                    'user_id' => $jurusan->id,
                    'title' => 'Judul lolos voting',
                    'message' => $title->student->name . ' telah lolos voting judul. Silakan tetapkan pembimbing.',
                    'url' => route('titles.edit', $title),
                ]);

                app(FcmService::class)->sendToUser(
                    $jurusan,
                    'Judul Lolos Voting',
                    $title->student->name . ' telah lolos voting judul. Silakan tetapkan pembimbing.',
                    route('titles.edit', $title)
                );
            }
        }

        return back()->with('success', 'Voting berhasil disimpan.');
    }

    public function review(Request $request, TitleSubmission $title)
    {
        abort_unless(auth()->user()->isJurusan(), 403);

        $data = $request->validate([
            'status' => 'required|in:diajukan,disetujui,ditolak,revisi',
            'supervisor_1_id' => 'nullable|exists:users,id|different:supervisor_2_id',
            'supervisor_2_id' => 'nullable|exists:users,id|different:supervisor_1_id',
            'notes' => 'nullable|string',
        ]);

        $data['supervisor_id'] = $data['supervisor_1_id'] ?? null;
        $data['approved_at'] = $data['status'] === 'disetujui'
            ? ($title->approved_at ?? now())
            : null;
        $data['assigned_at'] = (!empty($data['supervisor_1_id']) && !empty($data['supervisor_2_id']))
            ? ($title->assigned_at ?? now())
            : null;

        $title->update($data);

        $title->load('student', 'supervisor1', 'supervisor2');

        $message = 'Status judul Anda: ' . strtoupper($title->status) . '.';

        if ($title->supervisor_1_id && $title->supervisor_2_id) {
            $message .= ' Pembimbing 1: ' . ($title->supervisor1->name ?? '-') .
                        ', Pembimbing 2: ' . ($title->supervisor2->name ?? '-') . '.';
        }

        if ($title->notes) {
            $message .= ' Catatan: ' . $title->notes;
        }

        Notification::create([
            'user_id' => $title->student_id,
            'title' => 'Status pengajuan judul',
            'message' => $message,
            'url' => route('titles.show', $title),
        ]);

        app(FcmService::class)->sendToUser(
            $title->student,
            'Status Pengajuan Judul',
            $message,
            route('titles.show', $title)
        );

        return redirect()
            ->route('titles.index')
            ->with('success', 'Alur judul dan pembimbing berhasil diperbarui.');
    }

    public function approvalLetter(TitleSubmission $title)
    {
        $this->authorizeView($title);
        abort_unless($title->status === 'disetujui', 404);

        $title->load('student','supervisor','supervisor1','supervisor2');
        $ketuaJurusan = User::where('role', 'dosen')->where('position', 'ketua_jurusan')->first();
        $chairName = $ketuaJurusan->name ?? AppSetting::getValue('ketua_jurusan_name', 'Nama Ketua Jurusan');
        $chairNip = $ketuaJurusan->identifier ?? AppSetting::getValue('ketua_jurusan_nip', '-');

        return view('titles.approval-letter', compact('title','chairName','chairNip'));
    }

    public function destroy(TitleSubmission $title)
    {
        abort_unless(auth()->user()->isJurusan() || $title->student_id === auth()->id(), 403);
        $title->delete();
        return redirect()->route('titles.index')->with('success', 'Pengajuan judul dihapus.');
    }

    private function authorizeView(TitleSubmission $title): void
    {
        $u = auth()->user();

        abort_unless(
            $u->isJurusan()
            || $u->isDosen()
            || $title->student_id === $u->id
            || $title->supervisor_id === $u->id
            || $title->supervisor_1_id === $u->id
            || $title->supervisor_2_id === $u->id,
            403
        );
    }
}
