<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $service;
    public function __construct(AuthService $service) { $this->service = $service; }

    public function showRegister() { return view('auth.register'); }
    public function showLogin() { return view('auth.login'); }

    public function register(Request $request)
    {
        $this->service->registerUser($request->all());
        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status === 'suspended') {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Account suspended, contact admin to login again']);
            }

            return redirect()->intended('dashboard');
        }

        // response if login fails!
        return back()->withErrors(['email' => 'Invalid credentials.Please Try again']);
    }

    public function showVerifyEmail(Request $request) 
    {
        // If the session has the masked email, display it; otherwise, show null
        return view('auth.passwords.verify-email', [
            'masked' => session('masked', null),
            'email' => session('email', null)
        ]);
    } 

    public function verifyEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (!$user) return back()->withErrors(['email' => 'Email not found.']);

        // Store in session (not flashed)
        session(['email' => $user->email, 'masked' => $this->maskEmail($user->email)]);

        return redirect()->route('password.verify.code.view');
    }

    public function verifyCode(Request $request)
    {
        // Use session() directly
        if ($request->code === '123456') {
            return redirect()->route('password.reset.new.view');
        }
        return back()->withErrors(['code' => 'Invalid code.']);
    }

    public function updatePassword(Request $request)
    {
        $email = session('email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Session expired.']);
        }

        $request->validate(['password' => 'required|min:8']);
        $user = User::where('email', $email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        // Manually clear the session now that we are done
        session()->forget(['email', 'masked']);

        return redirect()->route('login')->with('status', 'Password reset successfully!');
    }

    private function maskEmail($email) {
        $parts = explode('@', $email);
        return substr($parts[0], 0, 4) . '******' . substr($parts[0], -3) . '@' . $parts[1];
    }

    public function showResetInput(Request $request)
    {
        // Check if we have the email in the session from the previous redirect
        if (!session()->has('email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Session expired. Please try again.']);
        }

        return view('auth.passwords.reset-input', [
            'email' => session('email')
        ]);
    }

    public function logout() { Auth::logout(); return redirect('/'); }
}