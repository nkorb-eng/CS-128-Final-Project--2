<?php

namespace Database\Seeders;

use App\Models\EmpLogin;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Roombook;
use App\Models\Signup;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin login (from the original emp_login table)
        EmpLogin::create(['Emp_Email' => 'Admin@gmail.com', 'Emp_Password' => '1234']);

        // Sample registered user
        Signup::create([
            'Username' => 'Tushar Pankhaniya',
            'Email' => 'tusharpankhaniya2202@gmail.com',
            'Password' => '123',
        ]);

        // Room inventory
        $rooms = [
            ['Superior Room', 'Single'], ['Superior Room', 'Triple'], ['Superior Room', 'Quad'],
            ['Deluxe Room', 'Single'], ['Deluxe Room', 'Double'], ['Deluxe Room', 'Triple'],
            ['Guest House', 'Single'], ['Guest House', 'Double'], ['Guest House', 'Triple'],
            ['Guest House', 'Quad'], ['Superior Room', 'Double'], ['Single Room', 'Single'],
            ['Superior Room', 'Single'], ['Deluxe Room', 'Single'], ['Deluxe Room', 'Triple'],
            ['Guest House', 'Double'], ['Deluxe Room', 'Single'],
        ];
        foreach ($rooms as [$type, $bedding]) {
            Room::create(['type' => $type, 'bedding' => $bedding]);
        }

        // Staff
        $staff = [
            ['Tushar pankhaniya', 'Manager'], ['rohit patel', 'Cook'], ['Dipak', 'Cook'],
            ['tirth', 'Helper'], ['mohan', 'Helper'], ['shyam', 'cleaner'],
            ['rohan', 'weighter'], ['hiren', 'weighter'], ['nikunj', 'weighter'],
            ['rekha', 'Cook'],
        ];
        foreach ($staff as [$name, $work]) {
            Staff::create(['name' => $name, 'work' => $work]);
        }

        // Sample confirmed booking + its payment
        Roombook::create([
            'id' => 41,
            'Name' => 'Tushar pankhaniya',
            'Email' => 'pankhaniyatushar9@gmail.com',
            'Country' => 'India',
            'Phone' => '9313346569',
            'RoomType' => 'Single Room',
            'Bed' => 'Single',
            'Meal' => 'Room only',
            'NoofRoom' => '1',
            'cin' => '2022-11-09',
            'cout' => '2022-11-10',
            'nodays' => 1,
            'stat' => 'Confirm',
        ]);

        Payment::create([
            'id' => 41,
            'Name' => 'Tushar pankhaniya',
            'Email' => 'pankhaniyatushar9@gmail.com',
            'RoomType' => 'Single Room',
            'Bed' => 'Single',
            'NoofRoom' => 1,
            'cin' => '2022-11-09',
            'cout' => '2022-11-10',
            'noofdays' => 1,
            'roomtotal' => 1000.00,
            'bedtotal' => 10.00,
            'meal' => 'Room only',
            'mealtotal' => 0.00,
            'finaltotal' => 1010.00,
            'amount_paid' => 0,
            'status' => 'Unpaid',
        ]);

        // ---- Demo data for the seeded login user (so their panel is populated) ----
        $demoEmail = 'tusharpankhaniya2202@gmail.com';

        // A confirmed + fully paid stay
        Roombook::create([
            'id' => 42, 'Name' => 'Tushar Pankhaniya', 'Email' => $demoEmail,
            'Country' => 'India', 'Phone' => '9876543210', 'RoomType' => 'Deluxe Room',
            'Bed' => 'Double', 'Meal' => 'Breakfast', 'NoofRoom' => '1',
            'cin' => '2026-07-10', 'cout' => '2026-07-13', 'nodays' => 3, 'stat' => 'Confirm',
        ]);
        [$r, $b, $m, $f] = Payment::calculate('Deluxe Room', 'Double', 'Breakfast', 3, 1);
        $grand = round($f * 1.10, 2);
        Payment::create([
            'id' => 42, 'Name' => 'Tushar Pankhaniya', 'Email' => $demoEmail,
            'RoomType' => 'Deluxe Room', 'Bed' => 'Double', 'NoofRoom' => 1,
            'cin' => '2026-07-10', 'cout' => '2026-07-13', 'noofdays' => 3,
            'roomtotal' => $r, 'bedtotal' => $b, 'meal' => 'Breakfast', 'mealtotal' => $m,
            'finaltotal' => $f, 'amount_paid' => $grand, 'method' => 'Card',
            'status' => 'Paid', 'paid_at' => '2026-07-10 14:20:00',
        ]);

        // A confirmed but still-unpaid stay
        Roombook::create([
            'id' => 43, 'Name' => 'Tushar Pankhaniya', 'Email' => $demoEmail,
            'Country' => 'India', 'Phone' => '9876543210', 'RoomType' => 'Superior Room',
            'Bed' => 'Single', 'Meal' => 'Room only', 'NoofRoom' => '1',
            'cin' => '2026-07-20', 'cout' => '2026-07-22', 'nodays' => 2, 'stat' => 'Confirm',
        ]);
        [$r2, $b2, $m2, $f2] = Payment::calculate('Superior Room', 'Single', 'Room only', 2, 1);
        Payment::create([
            'id' => 43, 'Name' => 'Tushar Pankhaniya', 'Email' => $demoEmail,
            'RoomType' => 'Superior Room', 'Bed' => 'Single', 'NoofRoom' => 1,
            'cin' => '2026-07-20', 'cout' => '2026-07-22', 'noofdays' => 2,
            'roomtotal' => $r2, 'bedtotal' => $b2, 'meal' => 'Room only', 'mealtotal' => $m2,
            'finaltotal' => $f2, 'amount_paid' => 0, 'status' => 'Unpaid',
        ]);
    }
}
