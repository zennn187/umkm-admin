<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('pages.auth.login'); // Menggunakan view yang sama (form toggle)
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek apakah user aktif
            if (!$user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda dinonaktifkan. Hubungi administrator.',
                ]);
            }

            // Redirect ke dashboard berdasarkan role
            $redirectMessage = $this->getWelcomeMessage($user);

            return redirect()->route('dashboard')
                ->with('success', $redirectMessage);
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Get welcome message based on user role
     */
    private function getWelcomeMessage($user)
    {
        $roleMessages = [
            'super_admin' => 'Login berhasil! Selamat datang Super Admin.',
            'admin' => 'Login berhasil! Selamat datang Admin.',
            'mitra' => 'Login berhasil! Selamat datang Mitra UMKM.',
            'user' => 'Login berhasil! Selamat datang Pelanggan.',
        ];

        return $roleMessages[$user->role] ?? 'Login berhasil! Selamat datang.';
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        // Validasi input - SESUAI DENGAN STRUCTURE DATA ANDA
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,mitra,super_admin',
            'terms' => 'required|accepted',
        ], [
            'terms.required' => 'Anda harus menyetujui Syarat & Ketentuan.',
            'terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.in' => 'Role yang dipilih tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('showRegister', true); // Untuk auto-show register form
        }

        // Buat user baru dengan role yang dipilih - SESUAI STRUCTURE DATA
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
            'email_verified_at' => now(), // Auto verifikasi untuk sekarang
        ];

        // Jika role mitra, tambahkan data tambahan (sesuai kebutuhan)
        if ($request->role === 'mitra') {
            // Anda bisa menambahkan field khusus untuk mitra jika ada
            // Misalnya: $userData['nama_usaha'] = $request->nama_usaha ?? null;
        }

        $user = User::create($userData);

        // Auto login setelah registrasi
        Auth::login($user);

        // Redirect ke dashboard dengan pesan sesuai role
        $registrationMessage = $this->getRegistrationMessage($user);

        return redirect()->route('dashboard')
            ->with('success', $registrationMessage);
    }

    /**
     * Get registration message based on user role
     */
    private function getRegistrationMessage($user)
    {
        $messages = [
            'super_admin' => 'Registrasi Super Admin berhasil! Anda memiliki akses penuh sistem.',
            'mitra' => 'Registrasi Mitra berhasil! Lengkapi profil UMKM Anda.',
            'user' => 'Registrasi berhasil! Selamat bergabung dengan UMKM Makanan.',
        ];

        return $messages[$user->role] ?? 'Registrasi berhasil!';
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'Pengguna';

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', "Logout berhasil. Sampai jumpa, $userName!");
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('pages.auth.forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem kami.',
        ]);

        // TODO: Implementasi pengiriman email reset password
        // Sementara beri pesan sukses

        return back()->with('success', 'Link reset password telah dikirim ke email Anda. (Fitur dalam pengembangan)');
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm($token)
    {
        return view('pages.auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle reset password request
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // TODO: Implementasi logika reset password yang sesungguhnya
        // Sementara simulasikan reset password

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru. (Fitur dalam pengembangan)');
    }
}
