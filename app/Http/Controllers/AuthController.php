<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Ambil semua user (dipaginasi) hanya dengan kolom yang dibutuhkan.
     */
    public function index(): JsonResponse
    {
        $users = User::query()
            ->select(['id', 'email', 'created_at'])
            ->latest('id')
            ->paginate(15);

        return response()->json($users);
    }

    /**
     * Ambil satu user berdasarkan id. 404 otomatis jika tidak ada.
     */
    public function show(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);

        // Tipe data sudah sesuai migration + casts di model User.
        return response()->json([
            'id' => $user->id,                                    // int
            'email' => $user->email,                              // string
            'created_at' => $user->created_at->toIso8601String(), // string
            'updated_at' => $user->updated_at->toIso8601String(), // string
        ]);
    }

    /**
     * Cari user berdasarkan email, hanya yang sudah verifikasi.
     */
    public function findByEmail(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::query()
            ->where('email', $validated['email'])
            ->firstOrFail();

        return response()->json($user);
    }

    /**
     * Contoh agregasi ringan: jumlah user terdaftar.
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total' => User::query()->count(),
        ]);
    }

    public function loginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function registerForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($validated); // password di-hash oleh cast 'hashed'

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
