<?php

namespace App\Http\Controllers;

use App\Models\FcmToken;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        // Hapus token ini dari user mana pun
        // agar 1 token browser hanya dimiliki 1 akun terakhir yang login
        FcmToken::where('token', $request->token)->delete();

        // Hapus token lama milik user yang sedang login
        FcmToken::where('user_id', auth()->id())->delete();

        // Simpan token baru untuk user saat ini
        FcmToken::create([
            'user_id' => auth()->id(),
            'token' => $request->token,
            'device_name' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}