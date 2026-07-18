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
    /** Show the combined login / signup page (was index.php). */
    public function showLogin()
    {
        return view('auth.login');
    }

    /** User login against the signup table (case-sensitive password). */
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

    /** Register a new site user (was the signup block in index.php). */
    public function signup(Request $request)
    {
        $username = $request->input('Username');
        $email = $request->input('Email');
        $password = $request->input('Password');
        $cpassword = $request->input('CPassword');

        if ($username == '' || $email == '' || $password == '') {
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

    /** Destroy the session (was logout.php). */
    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
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
}
