<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\OtpVerification;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // Show the login form
    public function signup()
    {
        return view('login');
    }

    // Handle the login request
       public function login(Request $request)
    {
        // Validate login form input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if user exists but do not log them in yet
        $credentials = $request->only('email', 'password');
        if (Auth::validate($credentials)) {
            // Store the email in session
            $request->session()->put('email', $request->email);

            // Generate OTP and send email
            $this->sendOtp($request->email);

            // Redirect to OTP verification page
            return redirect()->route('verify');
        } else {
        }

        // If login fails, redirect back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    protected function sendOtp($email)
    {
        // User ka naam fetch kar rahe hain
        $user = User::where('email', $email)->first();
        $name = $user->name; // assuming 'name' column exists in OtpVerification table

        $otp = (string) random_int(100000, 999999);
        OtpVerification::updateOrCreate(
            ['email' => $email],
            ['otp' => $otp, 'otp_created_at' => now()]
        );

        try {
            $status = "failed";
            $errorMessage = null;
        
            // Send the email using a view and pass the 'name' to the view
            Mail::send('emails.otp', ['otp' => $otp, 'name' => $name], function ($message) use ($email) {
                $message->to($email)
                        ->subject('Your OTP Code');
            });
        
            // If no exception is thrown, mark as success
            $status = "success";
            $mailMsg = "Email sent successfully!";
        } catch (Exception $e) {
            // Catch any errors and log them
            $errorMessage = $e->getMessage();
            $mailMsg = "Email could not be sent. Error: {$errorMessage}";
        }
        try{
            $response = Http::withBasicAuth(env('CLICKSEND_USERNAME'), env('CLICKSEND_API_KEY'))
        ->post('https://rest.clicksend.com/v3/sms/send', [
            'messages' => [
                [
                    'body' => "Hello {$user->name}, your OTP code for login is {$otp}. Do not share this code with anyone.",
                    'to' => $user->phone,
                    'from' => env('CLICKSEND_SENDER')
                ]
            ]
        ]);
        $smsStatus = "success";

    }
        catch (Exception $e) {
            // Catch any errors and log them
            $errorMessage = $e->getMessage();
            $mailMsg = "Msg could not be sent. Error: {$errorMessage}";
        }
        
        // Logging email activity to the EmailLogs model
        try {
            \App\Models\EmailLogs::create([
                'meta' => json_encode([
                    "recipient_email" => $email,
                    "recipient_name" => $name,
                    "subject" => 'Your OTP Code',
                    "otp" => $otp, // Optionally include the OTP if needed for reference
                ]),
                'status' => $status,
                'error_message' => $errorMessage,
            ]);
        } catch (Exception $logException) {
            // Log any error encountered during email log saving
            Log::error('Failed to log email activity: ' . $logException->getMessage());
        }
        
        return $mailMsg;
    }


    // Show OTP verification form
    public function showOtpVerificationForm()
    {
        return view('verify'); // Create this view for OTP input
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        // Get the email from session
        $email = $request->session()->get('email');

        // Check if the OTP is valid for the email
        $otpVerification = OtpVerification::where('email', $email)
            ->where('otp', $request->otp)
            ->first();

        if ($otpVerification) {
            // OTP verified, delete the OTP record
            $otpVerification->delete();

            $user = \App\Models\User::where('email', $email)->first();
            Auth::login($user);
            
            // Set the current time in Sweden/Stockholm timezone
            // $user->last_login = Carbon::now('Europe/Stockholm');
            $user->save();

            // Redirect to the dashboard
            return redirect()->route('dashboard');
        }

        // Return error if OTP is invalid
        return back()->withErrors(['otp' => 'Invalid OTP.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
