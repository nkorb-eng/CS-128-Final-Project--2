<?php

namespace App\Http\Controllers;

use App\Models\EmpLogin;
use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    /** Show the combined login / signup page. */
    public function showLogin()
    {
        return view('auth.login');
    }

    /** User login against the signup table. */
    public function userLogin(Request $request)
    {
        $user = Signup::where('Email', $request->input('Email'))
            ->where('Password', $request->input('Password'))
            ->first();

        if ($user) {
            $request->session()->put('usermail', $user->Email);

            return redirect()->route('home');
        }

        return back()->with('error', 'Something went wrong');
    }

    /** Employee/admin login against the emp_login table. */
    public function empLogin(Request $request)
    {
        $emp = EmpLogin::where('Emp_Email', $request->input('Emp_Email'))
            ->where('Emp_Password', $request->input('Emp_Password'))
            ->first();

        if ($emp) {
            $request->session()->put('usermail', $emp->Emp_Email);
            $request->session()->put('is_admin', true);

            return redirect()->route('admin.panel');
        }

        return back()->with('error', 'Something went wrong');
    }

    /** Register a new site user. */
    public function signup(Request $request)
    {
        $username = $request->input('Username');
        $email = $request->input('Email');
        $password = $request->input('Password');
        $cpassword = $request->input('CPassword');

        if ($username === '' || $email === '' || $password === '') {
            return back()->with('error', 'Fill the proper details');
        }

        if ($password !== $cpassword) {
            return back()->with('error', 'Password does not match');
        }

        if (Signup::where('Email', $email)->exists()) {
            return back()->with('error', 'Email already exists');
        }

        Signup::create([
            'Username' => $username,
            'Email' => $email,
            'Password' => $password,
        ]);

        $request->session()->put('usermail', $email);

        return redirect()->route('home');
    }

    /** Destroy the current login session. */
    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('login');
    }

    public function redirectToGoogle(Request $request)
    {
        return Socialite::driver('google')
            ->redirectUrl($this->googleRedirectUrl($request))
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl($this->googleRedirectUrl($request))
                ->user();
        } catch (InvalidStateException $exception) {
            report($exception);

            return redirect()
                ->route('login')
                ->with('error', 'Your Google sign-in session expired. Please try again.');
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('login')
                ->with('error', 'Google sign-in could not be completed. Please try again.');
        }

        $user = Signup::where('Email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = Signup::create([
                'Username' => $googleUser->getName(),
                'Email' => $googleUser->getEmail(),
                // A random local password is needed because Google authenticates this user.
                'Password' => Str::random(20),
            ]);
        }

        $request->session()->put('usermail', $user->Email);

        return redirect()->route('home');
    }

    /**
     * Uses the browser's local host for both OAuth requests, so its session
     * cookie and Socialite state are retained. Other environments keep the
     * configured redirect URL.
     */
    private function googleRedirectUrl(Request $request): string
    {
        $host = $request->getHost();

        if (! in_array($host, ['127.0.0.1', 'localhost'], true)) {
            return (string) config('services.google.redirect');
        }

        $scheme = $request->getScheme();
        $port = $request->getPort();
        $defaultPort = $scheme === 'https' ? 443 : 80;
        $authority = $host.($port === $defaultPort ? '' : ':'.$port);

        return $scheme.'://'.$authority.route('google.callback', [], false);
    }
}
