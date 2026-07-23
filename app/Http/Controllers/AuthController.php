<?php

namespace App\Http\Controllers;

use App\Models\EmpLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $credentials = $request->validate([
            'Email' => ['required', 'email'],
            'Password' => ['required', 'string'],
        ]);

        $user = User::where('Email', $credentials['Email'])->first();

        if ($user && $this->passwordMatches($credentials['Password'], $user->Password)) {
            $this->upgradeLegacyPassword($user, $credentials['Password']);
            $request->session()->regenerate();
            $request->session()->put('usermail', $user->Email);

            return redirect()->route('home');
        }

        return back()->withInput($request->only('Email'))
            ->with('error', 'Invalid email or password.');
    }

    /** Employee/admin login against the emp_login table. */
    public function empLogin(Request $request)
    {
        $credentials = $request->validate([
            'Emp_Email' => ['required', 'email'],
            'Emp_Password' => ['required', 'string'],
        ]);

        $emp = EmpLogin::where('Emp_Email', $credentials['Emp_Email'])->first();

        if ($emp && $this->passwordMatches($credentials['Emp_Password'], $emp->Emp_Password)) {
            if (! $this->isHashedPassword($emp->Emp_Password)) {
                $emp->update(['Emp_Password' => Hash::make($credentials['Emp_Password'])]);
            }

            $request->session()->regenerate();
            $request->session()->put('usermail', $emp->Emp_Email);
            $request->session()->put('is_admin', true);

            return redirect()->route('admin.panel');
        }

        return back()->withInput($request->only('Emp_Email'))
            ->with('error', 'Invalid email or password.');
    }

    /** Register a new site user. */
    public function signup(Request $request)
    {
        $data = $request->validate([
            'Username' => ['required', 'string', 'max:50'],
            'Email' => ['required', 'email', 'max:50'],
            'Password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);

        if (User::where('Email', $data['Email'])->exists()) {
            return back()->withInput($request->except(['Password', 'Password_confirmation']))
                ->with('error', 'Email already exists');
        }

        User::create([
            'Username' => $data['Username'],
            'Email' => $data['Email'],
            'Password' => Hash::make($data['Password']),
        ]);

        $request->session()->regenerate();
        $request->session()->put('usermail', $data['Email']);

        return redirect()->route('home');
    }

    /** Destroy the current login session. */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function redirectToGoogle(Request $request)
    {
        $redirectUrl = $this->googleRedirectUrl();

        if (! config('services.google.client_id') || ! config('services.google.client_secret') || ! $redirectUrl) {
            return redirect()->route('login')
                ->with('error', 'Google sign-in has not been configured yet.');
        }

        return Socialite::driver('google')
    ->redirectUrl($redirectUrl)
    ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl($this->googleRedirectUrl())
                ->user();
        } catch (InvalidStateException $exception) {
            report($exception);

            return redirect()
                ->route('login')
                ->with('error', '');
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('login')
                ->with('error', 'Google sign-in could not be completed. Please try again.');
        }

        $email = $googleUser->getEmail();

        if (! $email) {
            return redirect()->route('login')
                ->with('error', 'Google did not provide an email address for this account.');
        }

        $user = User::firstOrCreate(
            ['Email' => $email],
            [
                'Username' => Str::limit($googleUser->getName() ?: Str::before($email, '@'), 50, ''),
                'Password' => Hash::make(Str::random(40)),
                'avater'   => $googleUser->getAvatar(),
            ],
        );

        $request->session()->regenerate();
        $request->session()->put('usermail', $user->Email);

        return redirect()->route('home');
    }

    /** Google requires this value to exactly match its Cloud Console setting. */
    private function googleRedirectUrl(): string
    {
        return (string) config('services.google.redirect');
    }


    private function passwordMatches(string $plainTextPassword, string $storedPassword): bool
    {
        return $this->isHashedPassword($storedPassword)
            ? Hash::check($plainTextPassword, $storedPassword)
            : hash_equals($storedPassword, $plainTextPassword);
    }

    private function upgradeLegacyPassword(User $user, string $plainTextPassword): void
    {
        if (! $this->isHashedPassword($user->Password)) {
            $user->update(['Password' => Hash::make($plainTextPassword)]);
        }
    }

    private function isHashedPassword(string $password): bool
    {
        return str_starts_with($password, '$2y$') || str_starts_with($password, '$argon2');
    }
}
