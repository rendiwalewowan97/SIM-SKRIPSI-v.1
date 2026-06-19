<?php
namespace App\Http\Controllers;

use App\Models\{ExamRegistration, GuidanceSession, Notification, TitleSubmission, User, AppSetting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExamRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $u = auth()->user();
        $items = ExamRegistration::with('student','chairman','secretary','examiner1','examiner2')
            ->when($u->isMahasiswa(), fn($q)=>$q->where('student_id',$u->id))
            ->when($request->status, fn($q,$v)=>$q->where('status',$v))
            ->when($request->type, fn($q,$v)=>$q->where('type',$v))
            ->latest()->paginate(10)->withQueryString();
        return view('exams.index', compact('items'));
    }
    public function create()
    {
        abort_unless(auth()->user()->isMahasiswa(), 403);

        $title = TitleSubmission::where('student_id', auth()->id())
            ->where('status', 'disetujui')
            ->whereNotNull('supervisor_1_id')
            ->whereNotNull('supervisor_2_id')
            ->latest()
            ->first();

        if (!$title) {
            return redirect()->route('titles.index')
                ->with('error', 'Anda belum bisa daftar seminar/sidang. Judul harus lolos voting dan pembimbing 1 serta 2 harus ditetapkan jurusan.');
        }

        return view('exams.create', compact('title'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isMahasiswa(), 403);

        $data = $request->validate([
            'type' => 'required|in:seminar_proposal,sidang_skripsi',
            'notes' => 'nullable|string',
            'documents' => 'required|array',
            'documents.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:8192',
        ]);

        $title = TitleSubmission::where('student_id', auth()->id())
            ->where('status', 'disetujui')
            ->whereNotNull('supervisor_1_id')
            ->whereNotNull('supervisor_2_id')
            ->latest()
            ->first();

        abort_unless($title, 403);

        if ($data['type'] === 'sidang_skripsi') {
            $seminarSelesai = ExamRegistration::where('student_id', auth()->id())
                ->where('type', 'seminar_proposal')
                ->where('status', 'selesai')
                ->exists();

            abort_unless($seminarSelesai, 403, 'Anda belum bisa daftar sidang skripsi karena seminar proposal belum selesai.');
        }

        $paths = [];

        foreach ($request->file('documents', []) as $key => $file) {
            if ($file && $file->isValid()) {
                $paths[$key] = $file->store('exams', 'public');
            }
        }

        $exam = ExamRegistration::create([
            'student_id' => auth()->id(),
            'type' => $data['type'],
            'notes' => $data['notes'] ?? null,
            'documents' => $paths,
            'document_path' => reset($paths) ?: null,
            'supervisor_1_id' => $title->supervisor_1_id,
            'supervisor_2_id' => $title->supervisor_2_id,
            'status' => 'diajukan',
        ]);

        foreach (User::where('role', 'jurusan')->get() as $jurusan) {
            Notification::create([
                'user_id' => $jurusan->id,
                'title' => 'Pendaftaran sidang baru',
                'message' => auth()->user()->name . ' mendaftar ' . str_replace('_', ' ', $exam->type) . '.',
                'url' => route('exams.edit', $exam),
            ]);
        }

        return redirect()
            ->route('exams.index')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }

    public function show(ExamRegistration $exam)
    {
        abort_unless(auth()->user()->isJurusan() || $exam->student_id === auth()->id(), 403);
        $exam->load('student','supervisor1','supervisor2','examiner1','examiner2','examiner3','chairman','secretary');
        return view('exams.show', compact('exam'));
    }

    public function document(Request $request, ExamRegistration $exam)
    {
        abort_unless(auth()->user()->isJurusan() || $exam->student_id === auth()->id(), 403);

        $path = $request->query('path');
        abort_unless($path && !str_contains($path, '..') && !Str::startsWith($path, ['/', '\\']), 404, 'File tidak ditemukan.');
        abort_unless(Storage::disk('public')->exists($path), 404, 'File tidak ditemukan.');

        return response()->file(Storage::disk('public')->path($path));
    }

    public function edit(ExamRegistration $exam){ abort_unless(auth()->user()->isJurusan(), 403); $dosens=User::where('role','dosen')->orderBy('name')->get(); return view('exams.schedule', compact('exam','dosens')); }
    public function update(Request $request, ExamRegistration $exam){ return $this->verify($request, $exam); }
    public function verify(Request $request, ExamRegistration $exam)
    {
        abort_unless(auth()->user()->isJurusan(), 403);
        $data = $request->validate([
            'status'=>'required|in:diajukan,diverifikasi,dijadwalkan,ditolak,selesai','scheduled_at'=>'nullable|date','room'=>'nullable|string|max:100','notes'=>'nullable|string',
            'supervisor_1_id'=>'nullable|exists:users,id','supervisor_2_id'=>'nullable|exists:users,id','examiner_1_id'=>'nullable|exists:users,id','examiner_2_id'=>'nullable|exists:users,id','examiner_3_id'=>'nullable|exists:users,id','chairman_id'=>'nullable|exists:users,id','secretary_id'=>'nullable|exists:users,id'
        ]);
        $exam->update($data);
        Notification::create(['user_id'=>$exam->student_id,'title'=>'Status pendaftaran sidang','message'=>'Status pendaftaran: '.strtoupper($exam->status),'url'=>route('exams.show',$exam)]);
        return redirect()->route('exams.index')->with('success','Pendaftaran sidang diperbarui.');
    }
    public function finish(ExamRegistration $exam){ abort_unless(auth()->user()->isJurusan(), 403); $exam->update(['status'=>'selesai']); Notification::create(['user_id'=>$exam->student_id,'title'=>'Sidang selesai','message'=>'Status sidang Anda telah ditandai selesai.','url'=>route('exams.show',$exam)]); return back()->with('success','Sidang ditandai selesai.'); }
    public function destroy(ExamRegistration $exam){ abort_unless(auth()->user()->isJurusan() || ($exam->student_id === auth()->id() && $exam->status === 'diajukan'), 403); $exam->delete(); return redirect()->route('exams.index')->with('success','Pendaftaran sidang dihapus.'); }
    public function scheduleLetter(ExamRegistration $exam)
    {
        $exam->load('student','supervisor1','supervisor2','examiner1','examiner2','examiner3','chairman','secretary');

        $examTitle = TitleSubmission::with('supervisor','supervisor1','supervisor2')
            ->where('student_id', $exam->student_id)
            ->where('status', 'disetujui')
            ->latest()
            ->first();

        $ketuaJurusan = User::where('role', 'dosen')->where('position', 'ketua_jurusan')->first();
        $chairName = $ketuaJurusan->name ?? AppSetting::getValue('ketua_jurusan_name', 'Nama Ketua Jurusan');
        $chairNip = $ketuaJurusan->identifier ?? AppSetting::getValue('ketua_jurusan_nip', '-');
        return view('exams.schedule-letter', compact('exam','examTitle','chairName','chairNip')); 
    }
}
