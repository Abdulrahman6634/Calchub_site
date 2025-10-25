<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // Show email request form
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    // Send verification code
    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'We could not find a user with that email address.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        // Check if user is locked from reset attempts
        if ($user->password_reset_locked_until && Carbon::now()->lt($user->password_reset_locked_until)) {
            $lockTime = Carbon::parse($user->password_reset_locked_until)->diffForHumans();
            return response()->json([
                'success' => false,
                'message' => 'Too many reset attempts. Please try again ' . $lockTime . '.'
            ]);
        }

        // Generate 6-digit verification code
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Set token expiration (15 minutes from now)
        $tokenExpiresAt = Carbon::now()->addMinutes(15);

        // Update user record
        $user->update([
            'password_reset_token' => Hash::make($verificationCode),
            'password_reset_token_expires_at' => $tokenExpiresAt,
            'password_reset_email_sent_at' => Carbon::now(),
            'password_reset_attempts' => 0
        ]);

        // Send email
        try {
            Mail::to($user->email)->send(new PasswordResetEmail($verificationCode, $user->name));
            
            return response()->json([
                'success' => true,
                'message' => 'Verification code sent to your email!',
                'email' => $this->maskEmail($request->email)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification email. Please try again.'
            ]);
        }
    }

    // Verify code and show password reset form
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        // Check if token exists and is not expired
        if (!$user->password_reset_token || !$user->password_reset_token_expires_at) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired verification code.'
            ]);
        }

        // Check if token is expired
        if (Carbon::now()->gt($user->password_reset_token_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Verification code has expired. Please request a new one.'
            ]);
        }

        // Check if account is locked
        if ($user->password_reset_locked_until && Carbon::now()->lt($user->password_reset_locked_until)) {
            $lockTime = Carbon::parse($user->password_reset_locked_until)->diffForHumans();
            return response()->json([
                'success' => false,
                'message' => 'Too many failed attempts. Please try again ' . $lockTime . '.'
            ]);
        }

        // Verify the code
        if (!Hash::check($request->code, $user->password_reset_token)) {
            $attempts = $user->password_reset_attempts + 1;
            $user->update(['password_reset_attempts' => $attempts]);

            // Lock account after 5 failed attempts for 30 minutes
            if ($attempts >= 5) {
                $user->update([
                    'password_reset_locked_until' => Carbon::now()->addMinutes(30)
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Too many failed attempts. Account locked for 30 minutes.'
                ]);
            }

            $remainingAttempts = 5 - $attempts;
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code. ' . $remainingAttempts . ' attempts remaining.'
            ]);
        }

        // Code is valid - generate session token for password reset
        $sessionToken = Str::random(60);
        session(['password_reset_token' => $sessionToken]);
        session(['password_reset_email' => $user->email]);

        // Clear the verification code
        $user->update([
            'password_reset_token' => null,
            'password_reset_token_expires_at' => null,
            'password_reset_attempts' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Code verified successfully!',
            'session_token' => $sessionToken
        ]);
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
            'session_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        // Verify session token
        if ($request->session_token !== session('password_reset_token')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid session. Please start the reset process again.'
            ]);
        }

        $email = session('password_reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }

        // Update password and clear reset fields
        $user->update([
            'password' => Hash::make($request->password),
            'password_reset_token' => null,
            'password_reset_token_expires_at' => null,
            'password_reset_email_sent_at' => null,
            'password_reset_attempts' => 0,
            'password_reset_locked_until' => null
        ]);

        // Clear session
        session()->forget(['password_reset_token', 'password_reset_email']);

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully! You can now login with your new password.',
            'redirect_url' => route('signin.form')
        ]);
    }

    // Resend verification code
    public function resendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        // Check if we can resend (prevent spam - wait 1 minute between resends)
        if ($user->password_reset_email_sent_at && 
            Carbon::now()->diffInSeconds($user->password_reset_email_sent_at) < 60) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait a moment before requesting a new code.'
            ]);
        }

        return $this->sendVerificationCode($request);
    }

    // Helper function to mask email
    private function maskEmail($email)
    {
        $parts = explode('@', $email);
        $username = $parts[0];
        $domain = $parts[1];
        
        $maskedUsername = substr($username, 0, 2) . '***' . substr($username, -1);
        
        return $maskedUsername . '@' . $domain;
    }
}