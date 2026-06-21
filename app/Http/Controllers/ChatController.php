<?php
namespace App\Http\Controllers;

use App\Models\{Message, User, Notification};
use App\Services\FcmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{
    public function index()
    {
        $auth = auth()->user();
        if ($auth->isMahasiswa()) $users = User::where('id','!=',$auth->id)->where('role','dosen')->get();
        elseif ($auth->isDosen()) $users = User::where('id','!=',$auth->id)->where('role','mahasiswa')->get();
        else $users = collect();
        return view('chats.index', compact('users'));
    }
    public function show(User $user)
    {
        $auth = auth()->user(); abort_unless($this->canChatWith($auth,$user), 403);
        $messages = $this->thread($auth, $user)->orderBy('created_at')->get();
        Message::where('sender_id',$user->id)->where('receiver_id',$auth->id)->whereNull('read_at')->update(['read_at'=>now()]);
        return view('chats.show', ['receiver'=>$user,'messages'=>$messages]);
    }
    public function fetch(User $user)
    {
        $auth = auth()->user(); abort_unless($this->canChatWith($auth,$user), 403);
        Message::where('sender_id',$user->id)->where('receiver_id',$auth->id)->whereNull('read_at')->update(['read_at'=>now()]);
        return response()->json($this->thread($auth,$user)->orderBy('created_at')->get()->map(fn($m)=>['id'=>$m->id,'sender_id'=>$m->sender_id,'message'=>e($m->message),'time'=>$m->created_at->format('H:i'),'mine'=>$m->sender_id==$auth->id]));
    }

    public function store(Request $request, User $user)
    {
        $auth = auth()->user();

        abort_unless($this->canChatWith($auth, $user), 403);

        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = Message::create([
            'sender_id' => $auth->id,
            'receiver_id' => $user->id,
            'message' => $data['message'],
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Chat baru',
            'message' => $auth->name . ' mengirim pesan baru.',
            'url' => route('chats.show', $auth),
        ]);

        app(FcmService::class)->sendToUser(
            $user,
            'Chat Baru',
            $auth->name . ' mengirim pesan baru.',
            route('chats.show', $auth)
        );

        try {
            Mail::raw(
                $auth->name . " mengirim pesan chat baru:\n\n" . $data['message'],
                fn($mail) => $mail->to($user->email)->subject('Chat baru SIM Skripsi')
            );
        } catch (\Throwable $e) {}

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'id' => $message->id,
            ]);
        }

        return redirect()
            ->route('chats.show', $user)
            ->with('success', 'Pesan berhasil dikirim.');
    }

    private function thread(User $auth, User $user){ return Message::where(fn($q)=>$q->where('sender_id',$auth->id)->where('receiver_id',$user->id))->orWhere(fn($q)=>$q->where('sender_id',$user->id)->where('receiver_id',$auth->id)); }
    private function canChatWith(User $auth, User $user): bool
    { if ($auth->id === $user->id) return false; return ($auth->isMahasiswa() && $user->isDosen()) || ($auth->isDosen() && $user->isMahasiswa()); }
}
