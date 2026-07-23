<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Roombook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    /** Loads the main wrapper panel */
    public function panel()
    {
        return view('user.user_panel');
    }

    /** Loads the stats for the dashboard tab */
    public function dashboard(Request $request)
    {
        $email = $request->session()->get('usermail');

        // Count active bookings for this user
        $activeBookingsCount = Roombook::where('Email', $email)->where('stat', '!=', 'Confirm')->count();
        $totalBookingsCount = Roombook::where('Email', $email)->count();

        // Calculate total money spent
        $totalSpent = Payment::where('Email', $email)->sum('finaltotal');

        // Get chart data: Rooms booked by this user
        $chart = [
            'Superior Room' => Roombook::where('Email', $email)->where('RoomType', 'Superior Room')->count(),
            'Deluxe Room'   => Roombook::where('Email', $email)->where('RoomType', 'Deluxe Room')->count(),
            'Guest House'   => Roombook::where('Email', $email)->where('RoomType', 'Guest House')->count(),
            'Single Room'   => Roombook::where('Email', $email)->where('RoomType', 'Single Room')->count(),
        ];

        // Expenses history for the Morris chart
        $payments = Payment::where('Email', $email)->orderBy('cout', 'asc')->get();
        $expenseData = [];
        foreach ($payments as $p) {
            $expenseData[] = ['date' => (string) $p->cout, 'spent' => $p->finaltotal];
        }

        return view('user.dashboard', compact('activeBookingsCount', 'totalBookingsCount', 'totalSpent', 'chart', 'expenseData'));
    }

    /** Loads the bookings list */
    public function roombook(Request $request)
    {
        $email = $request->session()->get('usermail');
        $bookings = Roombook::where('Email', $email)->get();
        
        return view('user.roombook', compact('bookings'));
    }

    /** Loads the payments list */
    public function payment(Request $request)
    {
        $email = $request->session()->get('usermail');
        $payments = Payment::where('Email', $email)->get();
        
        return view('user.payment', compact('payments'));
    }

    /** Loads the user profile */
    public function profile(Request $request)
    {
        $email = $request->session()->get('usermail');
        $user = User::where('Email', $email)->first();

        return view('user.userprofile', compact('user'));
    }

    /** Shows the edit-profile form */
    public function editProfile(Request $request)
    {
        $email = $request->session()->get('usermail');
        $user = User::where('Email', $email)->firstOrFail();

        return view('user.editprofile', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $email = $request->session()->get('usermail');
        $user = User::where('Email', $email)->firstOrFail();

        $validated = $request->validate([
            'Username' => 'required|string|max:50',
            'Email'    => 'required|email|max:50|unique:users,Email,' . $user->UserID . ',UserID',
            'Phone'    => 'nullable|string|max:30',
            'Country'  => 'nullable|string|max:100',
            'avater'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Process avatar file upload if a new image was chosen
        if ($request->hasFile('avater')) {
            // Delete old avatar from storage if present
            if ($user->avater && Storage::disk('public')->exists($user->avater)) {
                Storage::disk('public')->delete($user->avater);
            }

            // Store new image in storage/app/public/avatars
            $path = $request->file('avater')->store('avatars', 'public');
            $validated['avater'] = $path;
        }

        $user->update($validated);

        // Keep the session in sync if the email itself changed
        $request->session()->put('usermail', $validated['Email']);

        return redirect()->route('user.userprofile')->with('success', 'Profile updated successfully');
    }

    /** Shows the change-password form */
    public function editPassword()
    {
        return view('user.changepassword');
    }

    /** Saves a new password */
public function updatePassword(Request $request)
{
    $email = $request->session()->get('usermail');
    $user = User::where('Email', $email)->firstOrFail();

    $request->validate([
        'current_password' => 'required',
        'new_password'     => 'required|min:3|confirmed',
    ]);

    $passwordMatches = str_starts_with($user->Password, '$2y$')
        ? Hash::check($request->input('current_password'), $user->Password)
        : hash_equals($user->Password, $request->input('current_password'));

    if (!$passwordMatches) {
        return back()->with('error', 'Current password is incorrect');
    }

    // Always hash the new password before saving to DB
    $user->update([
        'Password' => Hash::make($request->input('new_password'))
    ]);

    return redirect()->route('user.userprofile')->with('success', 'Password changed successfully!');
}

    /** Prints a specific invoice */
    public function invoice(Request $request, $id)
    {
        $email = $request->session()->get('usermail');
        $payment = Payment::where('id', $id)->where('Email', $email)->firstOrFail();

        $roomRate = match ($payment->RoomType) {
            'Superior Room' => 320,
            'Deluxe Room'   => 220,
            'Guest House'   => 180,
            'Single Room'   => 150,
            default         => 0,
        };
        $bedRate = match ($payment->Bed) {
            'Single' => $roomRate * 1 / 100,
            'Double' => $roomRate * 2 / 100,
            'Triple' => $roomRate * 3 / 100,
            'Quad'   => $roomRate * 4 / 100,
            default  => 0,
        };
        $mealRate = match ($payment->meal) {
            'Breakfast'  => $bedRate * 2,
            'Half Board' => $bedRate * 3,
            'Full Board' => $bedRate * 4,
            default      => 0,
        };

        return view('user.invoice', compact('payment', 'roomRate', 'bedRate', 'mealRate'));
    }
}