<?php
namespace App\Http\Controllers;

use App\Models\{TitleSubmission, GuidanceSession, ExamRegistration, ThesisArchive, Notification, User};

class DashboardController extends Controller
{
    public function __invoke()
    {
        $u = auth()->user();
        $titles = TitleSubmission::query();
        $guidances = GuidanceSession::query();
        $exams = ExamRegistration::query();

        if ($u->isMahasiswa()) {
            $titles->where('student_id', $u->id);
            $guidances->where('student_id', $u->id);
            $exams->where('student_id', $u->id);
        }
        if ($u->isDosen()) {
            $titles->where('supervisor_id', $u->id);
            $guidances->where('supervisor_id', $u->id);
            $exams->whereIn('student_id', GuidanceSession::where('supervisor_id', $u->id)->select('student_id'));
        }

        return view('dashboard', [
            'stats' => [
                'mahasiswa' => User::where('role','mahasiswa')->count(),
                'dosen' => User::where('role','dosen')->count(),
                'judul_menunggu' => (clone $titles)->where('status','diajukan')->count(),
                'bimbingan_menunggu' => (clone $guidances)->whereIn('status',['menunggu','direview','revisi'])->count(),
                'sidang_menunggu' => (clone $exams)->whereIn('status',['diajukan','diverifikasi'])->count(),
                'arsip' => ThesisArchive::count(),
            ],
            'titles' => $titles->with('student','supervisor')->latest()->take(5)->get(),
            'guidances' => $guidances->with('student','supervisor')->latest()->take(5)->get(),
            'exams' => $exams->with('student')->latest()->take(5)->get(),
            'archives' => ThesisArchive::with('student')->latest()->take(5)->get(),
            'notifications' => Notification::where('user_id',$u->id)->latest()->take(5)->get(),
        ]);
    }
}
