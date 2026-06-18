<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login() { return view('auth.login'); }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate(['email'=>'required|email', 'password'=>'required']);
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }
        return back()->withErrors(['email'=>'Email atau password salah.'])->onlyInput('email');
    }

    public function register() { return view('auth.register'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255', 'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed', 'role'=>'required|in:mahasiswa,dosen,jurusan',
            'identifier'=>'nullable|string|max:50', 'phone'=>'nullable|string|max:30'
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
