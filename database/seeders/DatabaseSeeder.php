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
        ]);
    }
}
