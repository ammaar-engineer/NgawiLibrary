<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Ambil semua user (dipaginasi) hanya dengan kolom yang dibutuhkan.
     */
    public function index(): JsonResponse
    {
        $users = User::query()
            ->select(['id', 'name', 'email', 'email_verified_at', 'created_at'])
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
            'id' => $user->id,                                      // int
            'name' => $user->name,                                  // string
            'email' => $user->email,                                // string
            'email_verified_at' => $user->email_verified_at?->toIso8601String(), // string|null
            'created_at' => $user->created_at->toIso8601String(),  // string
            'updated_at' => $user->updated_at->toIso8601String(),  // string
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
            ->whereNotNull('email_verified_at')
            ->firstOrFail();

        return response()->json($user);
    }

    /**
     * Contoh agregasi ringan: jumlah user yang sudah verifikasi.
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total' => User::query()->count(),
            'verified' => User::query()->whereNotNull('email_verified_at')->count(),
        ]);
    }
}
