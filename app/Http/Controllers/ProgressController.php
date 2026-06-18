<?php
namespace App\Http\Controllers;

use App\Models\{User, TitleSubmission, GuidanceSession, ExamRegistration, ThesisArchive};
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $u = auth()->user();
        $students = User::where('role','mahasiswa')
            ->when($u->isMahasiswa(), fn($q) => $q->where('id',$u->id))
            ->when($u->isDosen(), function($q) use ($u) {
                $q->whereIn('id', TitleSubmission::where('supervisor_id',$u->id)->select('student_id'));
            })
            ->when($request->q, fn($q,$v) => $q->where(function($qq) use ($v){
                $qq->where('name','like',"%$v%")->orWhere('identifier','like',"%$v%");
            }))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $students->getCollection()->transform(function($student) {
            $approvedTitle = TitleSubmission::where('student_id',$student->id)->where('status','disetujui')->latest()->first();
            $proposalGuidance = GuidanceSession::where('student_id',$student->id)->where('type','proposal')->count();
            $skripsiGuidance = GuidanceSession::where('student_id',$student->id)->where('type','skripsi')->count();
            $proposalExam = ExamRegistration::where('student_id',$student->id)->where('type','seminar_proposal')->latest()->first();
            $skripsiExam = ExamRegistration::where('student_id',$student->id)->where('type','sidang_skripsi')->latest()->first();
            $archive = ThesisArchive::where('student_id',$student->id)->latest()->first();
            $steps = [
                (bool) $approvedTitle,
                $proposalGuidance > 0,
                $proposalExam && in_array($proposalExam->status, ['dijadwalkan','selesai']),
                $skripsiGuidance > 0,
                $skripsiExam && in_array($skripsiExam->status, ['dijadwalkan','selesai']),
                (bool) $archive,
            ];
            $student->progress_percent = (int) round((collect($steps)->filter()->count() / count($steps)) * 100);
            $student->approved_title = $approvedTitle;
            $student->proposal_guidance_count = $proposalGuidance;
            $student->skripsi_guidance_count = $skripsiGuidance;
            $student->proposal_exam = $proposalExam;
            $student->skripsi_exam = $skripsiExam;
            $student->archive = $archive;
            return $student;
        });

        return view('progress.index', compact('students'));
    }

    public function show(User $student)
    {
        abort_unless($student->role === 'mahasiswa', 404);
        $u = auth()->user();
        if ($u->isMahasiswa()) abort_unless($student->id === $u->id, 403);
        if ($u->isDosen()) {
            abort_unless(TitleSubmission::where('student_id',$student->id)->where('supervisor_id',$u->id)->exists(), 403);
        }
        return view('progress.show', [
            'student' => $student,
            'titles' => TitleSubmission::with('supervisor')->where('student_id',$student->id)->latest()->get(),
            'guidances' => GuidanceSession::with('supervisor')->where('student_id',$student->id)->latest()->get(),
            'exams' => ExamRegistration::where('student_id',$student->id)->latest()->get(),
            'archives' => ThesisArchive::where('student_id',$student->id)->latest()->get(),
        ]);
    }
}
