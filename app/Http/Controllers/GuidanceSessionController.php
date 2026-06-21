<?php
namespace App\Http\Controllers;

use App\Models\{GuidanceSession, User, TitleSubmission, Notification};
use App\Services\FcmService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GuidanceSessionController extends Controller
{
    public function index(Request $request)
    {
        $u = auth()->user();
        $items = GuidanceSession::with('student','supervisor')
            ->when($u->isMahasiswa(), fn($q) => $q->where('student_id',$u->id))
            ->when($u->isDosen(), fn($q) => $q->where('supervisor_id',$u->id))
            ->when($request->status, fn($q,$v) => $q->where('status',$v))
            ->when($request->type, fn($q,$v) => $q->where('type',$v))
            ->latest()->paginate(10)->withQueryString();
        return view('guidances.index', compact('items'));
    }

    public function create()
    {
        abort_unless(auth()->user()->isMahasiswa(), 403);
        $approved = TitleSubmission::with('supervisor1','supervisor2')
            ->where('student_id', auth()->id())
            ->where('status', 'disetujui')
            ->whereNotNull('supervisor_1_id')
            ->whereNotNull('supervisor_2_id')
            ->latest()
            ->first();

        if (!$approved) {
            return redirect()->route('titles.index')
                ->with('error', 'Anda belum bisa mengajukan bimbingan. Judul harus lolos voting dan jurusan harus menetapkan pembimbing 1 dan 2.');
        }

        $dosens = collect([$approved->supervisor1, $approved->supervisor2])->filter();
        return view('guidances.create', compact('dosens','approved'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isMahasiswa(), 403);

        $data = $request->validate([
            'supervisor_id' => 'required|exists:users,id',
            'type' => 'required|in:proposal,skripsi',
            'session_date' => 'required|date',
            'chapter' => 'nullable|string|max:100',
            'student_note' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:8192'
        ]);

        $approved = TitleSubmission::where('student_id', auth()->id())
            ->where('status', 'disetujui')
            ->whereNotNull('supervisor_1_id')
            ->whereNotNull('supervisor_2_id')
            ->latest()
            ->first();

        abort_unless($approved, 403);

        abort_unless(
            in_array((int) $data['supervisor_id'], [
                (int) $approved->supervisor_1_id,
                (int) $approved->supervisor_2_id
            ]),
            403
        );

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('guidance', 'public');
        }

        unset($data['file']);

        $guidance = GuidanceSession::create($data + [
            'student_id' => auth()->id(),
            'status' => 'menunggu',
        ]);

        Notification::create([
            'user_id' => $guidance->supervisor_id,
            'title' => 'Bimbingan baru',
            'message' => $guidance->student->name . ' mengirim catatan bimbingan.',
            'url' => route('guidances.edit', $guidance),
        ]);

        app(FcmService::class)->sendToUser(
            $guidance->supervisor,
            'Bimbingan Baru',
            $guidance->student->name . ' mengirim catatan bimbingan.',
            route('guidances.edit', $guidance)
        );

        try {
            Mail::raw(
                auth()->user()->name . ' mengirim bimbingan baru.',
                fn($mail) => $mail->to($guidance->supervisor->email)->subject('Bimbingan baru SIM Skripsi')
            );
        } catch (\Throwable $e) {}

        return redirect()->route('guidances.index')->with('success', 'Bimbingan berhasil dikirim ke dosen.');
    }

    public function letter()
    {
        $u = auth()->user();
        $items = GuidanceSession::with('student.titleSubmissions','supervisor')->when($u->isMahasiswa(), fn($q)=>$q->where('student_id',$u->id))->when($u->isDosen() && !$u->isJurusan(), fn($q)=>$q->where('supervisor_id',$u->id))->orderBy('session_date')->get();
        $ketuaJurusan = User::where('role', 'dosen')->where('position', 'ketua_jurusan')->first();
        return view('guidances.guidances-letter', compact('items','ketuaJurusan'));
    }

    public function show(GuidanceSession $guidance)
    {
        $this->authorizeView($guidance);
        return view('guidances.show', compact('guidance'));
    }

    public function file(GuidanceSession $guidance)
    {
        $this->authorizeView($guidance);

        abort_unless($guidance->file_path && Storage::disk('public')->exists($guidance->file_path), 404, 'File tidak ditemukan.');

        return response()->file(Storage::disk('public')->path($guidance->file_path));
    }

    public function edit(GuidanceSession $guidance)
    {
        $u = auth()->user();
        if ($u->isMahasiswa()) {
            abort_unless($guidance->student_id === $u->id && in_array($guidance->status, ['menunggu','revisi']), 403);
            $approved = TitleSubmission::with('supervisor1','supervisor2')
                ->where('student_id', $u->id)
                ->where('status', 'disetujui')
                ->whereNotNull('supervisor_1_id')
                ->whereNotNull('supervisor_2_id')
                ->latest()
                ->first();
            abort_unless($approved, 403);
            $dosens = collect([$approved->supervisor1, $approved->supervisor2])->filter();
            return view('guidances.create', compact('guidance','dosens','approved'));
        }
        abort_unless($u->isDosen() && $guidance->supervisor_id === $u->id, 403);
        return view('guidances.review', compact('guidance'));
    }

    public function update(Request $request, GuidanceSession $guidance)
    {
        $u = auth()->user();
        if ($u->isMahasiswa()) {
            abort_unless($guidance->student_id === $u->id && in_array($guidance->status, ['menunggu','revisi']), 403);
            $data = $request->validate([
                'supervisor_id'=>'required|exists:users,id', 'type'=>'required|in:proposal,skripsi',
                'session_date'=>'required|date', 'chapter'=>'nullable|string|max:100',
                'student_note'=>'required|string', 'file'=>'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:8192'
            ]);
            $approved = TitleSubmission::where('student_id', $u->id)
                ->where('status', 'disetujui')
                ->whereNotNull('supervisor_1_id')
                ->whereNotNull('supervisor_2_id')
                ->latest()
                ->first();
            abort_unless($approved, 403);
            abort_unless(in_array((int) $data['supervisor_id'], [(int) $approved->supervisor_1_id, (int) $approved->supervisor_2_id]), 403);

            if ($request->hasFile('file')) $data['file_path'] = $request->file('file')->store('guidance','public');
            unset($data['file']);
            $data['status'] = 'menunggu';
            $guidance->update($data);
            Notification::create(['user_id'=>$guidance->supervisor_id,'title'=>'Bimbingan dikirim ulang','message'=>$guidance->student->name.' memperbarui catatan bimbingan.','url'=>route('guidances.edit',$guidance)]);
            return redirect()->route('guidances.index')->with('success','Bimbingan berhasil diperbarui dan dikirim ulang.');
        }
        return $this->review($request, $guidance);
    }

    public function review(Request $request, GuidanceSession $guidance)
    {
        abort_unless(
            auth()->user()->isDosen() && $guidance->supervisor_id === auth()->id(),
            403
        );

        $data = $request->validate([
            'supervisor_note' => 'required|string',
            'status' => 'required|in:direview,selesai,revisi',
        ]);

        $guidance->update($data);

        $statusText = strtoupper($guidance->status);

        Notification::create([
            'user_id' => $guidance->student_id,
            'title' => 'Bimbingan diperbarui',
            'message' => 'Dosen memberi catatan: ' . $statusText,
            'url' => route('guidances.show', $guidance),
        ]);

        app(FcmService::class)->sendToUser(
            $guidance->student,
            'Bimbingan Diperbarui',
            'Dosen memberi status bimbingan: ' . $statusText,
            route('guidances.show', $guidance)
        );

        return redirect()
            ->route('guidances.index')
            ->with('success', 'Review bimbingan tersimpan.');
    }

    public function destroy(GuidanceSession $guidance)
    {
        abort_unless(auth()->user()->isJurusan() || ($guidance->student_id === auth()->id() && $guidance->status === 'menunggu'), 403);
        $guidance->delete();
        return redirect()->route('guidances.index')->with('success','Data bimbingan dihapus.');
    }

    private function authorizeView(GuidanceSession $guidance): void
    {
        $u = auth()->user();
        abort_unless($u->isJurusan() || $guidance->student_id === $u->id || $guidance->supervisor_id === $u->id, 403);
    }

}
