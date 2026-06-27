<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        /* ----------------------------
     | Validate Input
     -----------------------------*/
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        /* ----------------------------
     | Rate Limiting
     -----------------------------*/
        $key = Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            Toastr::error('Too many login attempts. Try again later.');
            return back();
        }

        /* ----------------------------
     | Remember Me Flag
     -----------------------------*/
        // $remember = $request->boolean('remember');

        /* ----------------------------
     | Attempt Login
     -----------------------------*/
        if (Auth::guard('web')->attempt(
            [
                'email'  => $request->email,
                'password' => $request->password,
                'status' => 1
            ],
            // $remember
        )) {

            RateLimiter::clear($key);
            $request->session()->regenerate();

            Toastr::success('Welcome back!');
            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($key, 60);

        Toastr::error('Invalid email or password');
        return back()->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Toastr::success('Logged out successfully');
        return redirect()->route('admin.login');
    }


    public function showLinkRequestForm()
    {
        return view('admin.auth.forgot-password');
    }

    // Send reset link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $admin = User::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'This email is not registered as an admin']);
        }

        $token = Str::random(64);


        DB::table('admin_password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send email
        Mail::send('admin.auth.emails.reset-link', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Admin Password Reset');
        });
        Toastr::success('Password reset link sent to your email!');

        return back();
    }

    // Show reset password form
    public function showResetForm($token)
    {
        $email = DB::table('admin_password_resets')->where('token', $token)->first();
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    // Reset password submit
    public function reset(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $resetData = DB::table('admin_password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if (!$resetData) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        User::where('email', $request->email)->update([
            'password' => bcrypt($request->password),
        ]);

        // Delete reset token
        DB::table('admin_password_resets')->where('email', $request->email)->delete();
        Toastr::success('Password has been reset successfully!');

        return redirect()->route('admin.login');
    }
}
