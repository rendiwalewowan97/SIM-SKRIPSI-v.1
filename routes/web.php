<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    DashboardController,
    TitleSubmissionController,
    GuidanceSessionController,
    ExamRegistrationController,
    ThesisArchiveController,
    NotificationController,
    UserController,
    ProgressController,
    SupervisionController,
    ChatController
    
};

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('titles', TitleSubmissionController::class);
    Route::post('/titles/{title}/review', [TitleSubmissionController::class, 'review'])->name('titles.review');
    Route::post('/titles/{title}/vote', [TitleSubmissionController::class, 'vote'])->name('titles.vote');

    Route::get('/guidances-letter', [GuidanceSessionController::class, 'letter'])->name('guidances.letter');
    Route::get('/guidances/{guidance}/file', [GuidanceSessionController::class, 'file'])->name('guidances.file');
    Route::resource('guidances', GuidanceSessionController::class);
    Route::post('/guidances/{guidance}/review', [GuidanceSessionController::class, 'review'])->name('guidances.review');

    Route::get('/exams/{exam}/document', [ExamRegistrationController::class, 'document'])->name('exams.document');
    Route::resource('exams', ExamRegistrationController::class);
    Route::post('/exams/{exam}/verify', [ExamRegistrationController::class, 'verify'])->name('exams.verify');
    Route::post('/exams/{exam}/finish', [ExamRegistrationController::class, 'finish'])->name('exams.finish');

    Route::get('/archives/{archive}/preview/{type}', [ThesisArchiveController::class, 'preview'])->name('archives.preview');
    Route::get('/archives/{archive}/download/{type}', [ThesisArchiveController::class, 'download'])->name('archives.download');
    Route::resource('archives', ThesisArchiveController::class);

    // untuk publish
    Route::patch('/archives/{archive}/publish', [ThesisArchiveController::class, 'publish'])
    ->name('archives.publish');
    Route::patch('/archives/{archive}/unpublish', [ThesisArchiveController::class, 'unpublish'])
    ->name('archives.unpublish');

    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
    Route::get('/progress/{student}', [ProgressController::class, 'show'])->name('progress.show');
    Route::get('/supervisions', [SupervisionController::class, 'index'])->name('supervisions.index');
    Route::get('/titles/{title}/approval-letter', [TitleSubmissionController::class, 'approvalLetter'])->name('titles.approvalLetter');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::get('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');

    Route::middleware('role:jurusan')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    Route::get('/exams/{exam}/schedule-letter', 
    [ExamRegistrationController::class, 'scheduleLetter'])
    ->name('exams.schedule.letter');


    Route::get('/chats', [ChatController::class, 'index'])
        ->name('chats.index');

    Route::get('/chats/{user}', [ChatController::class, 'show'])
        ->name('chats.show');

    Route::get('/chats/{user}/fetch', [ChatController::class, 'fetch'])
        ->name('chats.fetch');

    Route::post('/chats/{user}', [ChatController::class, 'store'])
        ->name('chats.store');
    
});
