<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    // Show verification notice
    public function show()
    {
        return view('auth.verify');
    }

    // Mark user's email as verified (simple implementation)
    public function verify(Request $request)
    {
        $user = Auth::user();
        if ($user && ! empty($user->email_verified_at) === false) {
            $user->email_verified_at = now();
            $user->save();
        }

        return redirect($this->redirectTo)->with('status', 'Email verified (stub).');
    }

    // Resend verification email (stub)
    public function resend(Request $request)
    {
        $user = $request->user();
        if ($user && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('status', 'Verification link sent.');
    }
}
