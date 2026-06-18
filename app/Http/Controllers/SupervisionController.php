<?php
namespace App\Http\Controllers;

use App\Models\{TitleSubmission, GuidanceSession, ExamRegistration};

class SupervisionController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isDosen(), 403);
        $dosen = auth()->user();
        $students = TitleSubmission::with('student')
            ->where('supervisor_id', $dosen->id)
            ->where('status','disetujui')
            ->latest()
            ->get()
            ->unique('student_id')
            ->map(function($title) use ($dosen) {
                $s = $title->student;
                $s->title_submission = $title;
                $s->guidance_count = GuidanceSession::where('student_id',$s->id)->where('supervisor_id',$dosen->id)->count();
                $s->last_guidance = GuidanceSession::where('student_id',$s->id)->where('supervisor_id',$dosen->id)->latest()->first();
                $s->proposal_exam = ExamRegistration::where('student_id',$s->id)->where('type','seminar_proposal')->latest()->first();
                $s->skripsi_exam = ExamRegistration::where('student_id',$s->id)->where('type','sidang_skripsi')->latest()->first();
                return $s;
            });
        return view('supervisions.index', compact('students'));
    }
}
