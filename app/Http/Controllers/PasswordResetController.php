<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class PasswordResetController extends Controller
{
    // Show the forgot password form
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    // Send the reset link to the user's email
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Get the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with that email address.']);
        }

        // Generate the token with the user ID and current timestamp
        $tokenData = [
            'id' => $user->id,
            'timestamp' => Carbon::now()->timestamp
        ];

        // Encrypt the token
        $token = Crypt::encrypt($tokenData);

        // Create the reset URL with the encrypted token
        $resetUrl = route('change-password', ['token' => $token]);


        Mail::send('emails.reset_password', ['url' => $resetUrl, 'name' => $user->name], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Your Password');
        });

        return back()->with('status', 'Password reset link sent!');
    }

    // Show the reset password form
    public function showResetPasswordForm($token)
    {
        // Check if the token exists
        try {
            // Decrypt the token
            $tokenData = Crypt::decrypt($token);

            // Check token expiration (15 minutes)
            if (Carbon::now()->timestamp - $tokenData['timestamp'] > 900) {
                return redirect()->route('new')->withErrors(['token' => 'This link has expired.']);
            }
            return view('change-password', ['token' => $token]);
        } catch (\Exception $e) {
            return redirect()->route('new')->withErrors(['token' => 'Invalid or expired token.']);
        }
    }

    // Handle the reset password form submission
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        try {
            // Decrypt the token
            $tokenData = Crypt::decrypt($request->token);

            // Check if the token has expired (15 minutes)
            if (Carbon::now()->timestamp - $tokenData['timestamp'] > 900) {
                return back()->withErrors(['token' => 'This link has expired.']);
            }
            // Find the user by ID
            $user = Customer::where('id', $tokenData['id'])->first();

            if (!$user) {
                return back()->withErrors(['email' => 'No user found with that email address.']);
            }
            if($request->password != $request->password_confirmation){
                return back()->withErrors(['email' => "Confirmation password didn't match."]);
            }
            Customer::where('id', $tokenData['id'])->update(['password' => Hash::make($request->password)]);

            return redirect()->route('new')->with('status', 'Password has been reset!');
        } catch (\Exception $e) {
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }
    }
}
