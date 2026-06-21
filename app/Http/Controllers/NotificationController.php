<?php
namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $items = Notification::where('user_id', auth()->id())->latest()->paginate(20);
        return view('notifications.index', compact('items'));
    }

    public function read(Notification $notification)
    {
        abort_unless($notification->user_id === auth()->id(), 403);
        $notification->update(['read_at'=>now()]);
        return redirect($notification->url ?: route('dashboard'));
    }

    public function readAll()
    {
        Notification::where('user_id', auth()->id())->whereNull('read_at')->update(['read_at'=>now()]);
        return back()->with('success','Semua notifikasi ditandai dibaca.');
    }

    public function destroy(Notification $notification)
    {
        abort_unless($notification->user_id == auth()->id(), 403);

        $notification->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function clearRead()
    {
        Notification::where('user_id', auth()->id())
            ->whereNotNull('read_at')
            ->delete();

        return back()->with('success', 'Semua notifikasi yang sudah dibaca berhasil dihapus.');
    }
}
