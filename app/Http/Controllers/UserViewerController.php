<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserViewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Password;
use Str;

// Brij Negi Update
class UserViewerController extends Controller
{
    // Register User
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:user_viewer,email',
                'password' => 'required|string|min:8',
                'company_id' => 'required|exists:companies,id',
            ]);

            $token = bin2hex(random_bytes(32));

            $user = UserViewer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'company_id' => $request->company_id,
                'email_verification_token' => $token,
            ]);

            // Mail::to($user->email)->send(new \App\Mail\VerifyEmail($token));
            $this->sendVerificationEmail($user);

            return response()->json(['message' => __('Registration successful. Check your email to verify your account.'), 'status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server Error: ' . $e->getMessage(), 'status' => 'error'], 200);
        }
    }


    public function sendVerificationEmail(UserViewer $userViewer)
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $userViewer->id, 'hash' => sha1($userViewer->email)]
        );

        Mail::send('emails.verify', ['verificationUrl' => $verificationUrl], function ($message) use ($userViewer) {
            $message->to($userViewer->email)
                ->subject('Verify Your Email Address');
        });
    }

    public function logout(Request $request)
    {
        //Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => __('Logged out successfully!')], 200);
    }


    // Login User
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = UserViewer::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => __('User not found.'), 'status' => 'error'], 200);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => __('Invalid email or password.'), 'status' => 'error'], 200);
        }

        if (!$user->email_verified_at) {
            return response()->json(['error' => __('Email not verified.'), 'status' => 'error'], 200);
        }

        // Auth::login($user);
        session()->put('UserViewer', $user->id);
       // dd(session('UserViewer'));
        return response()->json(['message' => __('Login successful'), 'status' => 'success'], 200);
    }

    // Forgot Password
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = UserViewer::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => __('User not found.')], 404);
        }

        $token = bin2hex(random_bytes(32));

        $user->password_reset_token = $token;
        $user->password_reset_token_expires_at = now()->addMinutes(60);
        $user->save();

        $url = url('/userviewer/reset-password/' . $token);

        Mail::send('emails.forgot_password', ['user' => $user, 'url' => $url], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Your Password');
        });

        return response()->json(['status' => 'success', 'message' => __('Password reset link sent successfully.')]);
    }


    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status' => 'success', 'message' => __($status)]);
        }

        return response()->json(['status' => 'error', 'message' => __($status)], 400);
    }

    public function showResetPasswordForm($token)
    {
        $user = UserViewer::where('password_reset_token', $token)->first();

        if (!$user || $user->password_reset_token_expires_at < now()) {
            return response()->json(['status' => 'error', 'message' => __('Invalid or expired token.')], 404);
        }

        return view('auth.userviewer_reset_password', ['user' => $user, 'token' => $token,  'url' => url('/reset-password/' . $token)]);
    }

    public function resetPassword(Request $request)
    {
        try {
            // Validate incoming request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
                'token' => 'required|string',
            ]);

            $user = UserViewer::where('email', $request->email)
                ->where('password_reset_token', $request->token)
                ->first();

            if (!$user || $user->password_reset_token_expires_at < now()) {
                return response()->json(['message' => __('Invalid or expired token')], 404);
            }

            $user->password = Hash::make($request->password);
            $user->password_reset_token = null;
            $user->password_reset_token_expires_at = null;
            $user->save();

            return response()->json(['message' => __('Password reset successfully')]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }

    // Resend Verification Email
    public function resendVerification(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $user = UserViewer::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['message' => __('User not found'), 'status' => 'error'], 200);
            }

            if ($user->email_verified_at) {
                return response()->json(['message' => __('Email is already verified'), 'status' => 'error'], 200);
            }

            // Generate verification token
            $token = bin2hex(random_bytes(32));
            $user->email_verification_token = $token;
            $user->save();

            $verificationUrl = url("verify-email/{$token}");

            // Send email with verification link
            // Mail::to($user->email)->send(new EmailVerificationMail($verificationUrl));
            $this->sendVerificationEmail($user);

            return response()->json(['message' => __('Verification email sent successfully'), 'status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}
