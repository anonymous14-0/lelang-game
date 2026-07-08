<?php

/*
|--------------------------------------------------------------------------
| AuthController
|--------------------------------------------------------------------------
|
| Controller API untuk autentikasi mobile GameBid. File ini menerima request
| register, login, pengecekan user aktif, dan logout dari aplikasi Android.
| Data user disimpan pada tabel users melalui Eloquent ORM, password diamankan
| dengan hashing Laravel, dan token akses dibuat menggunakan Laravel Sanctum.
|
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST /api/register
    //
    // Mendaftarkan user baru dari aplikasi Android. Request berisi name, email,
    // dan password. Email harus unik pada tabel users untuk mencegah duplikasi
    // akun. Jika valid, password di-hash lalu Sanctum membuat token mobile.
    //
    // Akses: public, belum memerlukan login.
    // Response: status, message, token, dan data user yang baru dibuat.
    public function register(Request $request)
    {
        $request->validate([
            // Nama wajib diisi karena dipakai Android untuk menampilkan identitas user.
            'name' => 'required',

            // Email wajib valid dan unik agar satu email hanya memiliki satu akun.
            'email' => 'required|email|unique:users',

            // Password minimal 6 karakter untuk keamanan dasar kredensial login.
            'password' => 'required|min:6',
        ]);

        // Mass assignment aman karena model User membatasi kolom melalui $fillable.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'pembeli',
            // Password tidak disimpan plaintext; Hash::make melindungi data user.
            'password' => Hash::make($request->password)
        ]);

        // Token Sanctum dikirim ke Android dan digunakan untuk endpoint privat.
        $token = $user
            ->createToken('mobile-token')
            ->plainTextToken;

        return response()->json([
            // Menandakan registrasi berhasil.
            'status' => true,

            // Pesan yang dapat ditampilkan pada Android.
            'message' => 'Register berhasil',

            // Bearer token untuk autentikasi request selanjutnya.
            'token' => $token,

            // Data user dari tabel users.
            'user' => $user
        ], 201);
    }

    // POST /api/login
    //
    // Memproses autentikasi pengguna menggunakan email dan password. Jika
    // kredensial valid, Laravel Sanctum membuat access token untuk Android.
    //
    // Akses: public.
    // Request: email, password.
    // Response sukses: status, message, token, user.
    // Response gagal: status false dan pesan error dengan HTTP 401.
    public function login(Request $request)
    {
        $request->validate([
            // Email harus memiliki format valid agar query pencarian user akurat.
            'email' => 'required|email',

            // Password wajib dikirim untuk dibandingkan dengan hash di database.
            'password' => 'required'
        ]);

        // Query Eloquent mengambil user berdasarkan email tanpa SQL mentah,
        // sehingga parameter terlindungi dari SQL injection.
        $user = User::where(
            'email',
            $request->email
        )->first();

        // Hash::check membandingkan password input dengan hash pada tabel users.
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Token Sanctum dikirim ke Android dan digunakan untuk endpoint privat.
        $token = $user
            ->createToken('mobile-token')
            ->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user
        ]);
    }

    // GET /api/user
    //
    // Mengambil data user yang sedang login berdasarkan token Sanctum. Endpoint
    // ini digunakan Android untuk validasi sesi dan menampilkan profil.
    //
    // Akses: private, wajib auth:sanctum.
    // Response: status dan user.
    public function user(Request $request)
    {
        return response()->json([
            'status' => true,
            'user' => $request->user()
        ]);
    }

    // POST /api/logout
    //
    // Menghapus seluruh token milik user yang sedang login. Setelah token
    // dihapus, Android harus login ulang untuk mengakses endpoint privat.
    //
    // Akses: private, wajib auth:sanctum.
    // Response: status dan message.
    public function logout(Request $request)
    {
        // Menghapus personal access tokens pada tabel personal_access_tokens.
        $request->user()
            ->tokens()
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}