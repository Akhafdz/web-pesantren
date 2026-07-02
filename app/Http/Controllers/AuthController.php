<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // 1. PROSES REGISTRASI AKUN
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Simpan ke MySQL dengan Password yang sudah di-hash otomatis oleh Bcrypt
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'santri', // Otomatis mendaftar sebagai santri
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Registrasi berhasil! Silakan login.'], 201);
    }

    // 2. PROSES LOGIN AKUN
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Cari user berdasarkan email
        $user = DB::table('users')->where('email', $request->email)->first();

        // Validasi email dan kecocokan password terenkripsi
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Email atau password salah.'], 401);
        }

        // Kirim data struktur session untuk dibaca sessionStorage frontend
        return response()->json([
            'message' => 'Login Berhasil!',
            'user' => [
                'id' => $user->id,
                'display_name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ], 200);
    }
}