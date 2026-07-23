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
            'Username' => 'Dara sok',
            'Email' => 'DaraSok@gmail.com',
            'Password' => '12345678',
        ]);

        // Room inventory
        // Room inventory
        $rooms = [

            // type, bedding, price, image

            ['Superior Room', 'Single', 35, 'rooms/superior.jpg'],
            ['Guest House', 'Quad', 27, 'rooms/guest.jpg'],
            ['Deluxe Room', 'Triple', 32, 'rooms/deluxe.jpg'],
            ['Single Room', 'Single', 10, 'rooms/single.jpg'],
            ['Superior Room', 'Double', 40, 'rooms/superior.jpg'],
            ['Superior Room', 'Triple', 45, 'rooms/superior.jpg'],
            ['Superior Room', 'Quad', 50, 'rooms/superior.jpg'],


            ['Deluxe Room', 'Single', 22, 'rooms/deluxe.jpg'],
            ['Deluxe Room', 'Double', 27, 'rooms/deluxe.jpg'],
            ['Deluxe Room', 'Triple', 32, 'rooms/deluxe.jpg'],


            ['Guest House', 'Single', 12, 'rooms/guest.jpg'],
            ['Guest House', 'Double', 17, 'rooms/guest.jpg'],
            ['Guest House', 'Triple', 22, 'rooms/guest.jpg'],
            ['Guest House', 'Quad', 27, 'rooms/guest.jpg'],


            ['Single Room', 'Single', 10, 'rooms/single.jpg'],

        ];


        $roomIndex = 100;


        foreach ($rooms as [$type, $bedding, $price, $image]) {

            $roomIndex++;

            Room::create([
                'room_no' => $roomIndex,
                'type' => $type,
                'bedding' => $bedding,
                'price' => $price,
                'image' => $image,
            ]);

        }

        // Staff
        $staff = [
            ['សុខា', 'Manager'],
            ['វិសាល', 'Cook'],
            ['ចាន់ដារា', 'Cook'],
            ['សុភា', 'Helper'],
            ['មករា', 'Helper'],
            ['ស្រីនាង', 'Cleaner'],
            ['ដារ៉ា', 'Waiter'],
            ['វិចិត្រ', 'Waiter'],
            ['រតនា', 'Waiter'],
            ['សុវណ្ណា', 'Cook'],
        ];
        foreach ($staff as [$name, $work]) {
            Staff::create(['name' => $name, 'work' => $work]);
        }

        // Sample confirmed booking + its payment
        Roombook::create([
            'id' => 41,
            'Name' => 'Dara SOk',
            'Email' => 'DaraSok@gmail.com',
            'Country' => 'cambodia',
            'Phone' => '097283174',
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
            'Name' => 'DaraSok',
            'Email' => 'DaraSok@gmail.com',
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
