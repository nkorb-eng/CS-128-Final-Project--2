<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Roombook;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    /** Show Room Detail Page with auto-default fallback */
    public function showRoomDetail($slug)
    {
        $defaultTitles = [
            'superior-room' => 'Superior Room',
            'deluxe-room'   => 'Deluxe Room',
            'guest-room'    => 'Guest Room',
            'single-room'   => 'Single Room',
        ];

        $title = $defaultTitles[$slug] ?? Str::headline($slug);

        $detail = Detail::firstOrCreate(
            ['slug' => $slug],
            [
                'category'    => 'room',
                'title'       => $title,
                'description' => "<p>Welcome to the <strong>{$title}</strong>. Enjoy luxury amenities, comfortable bedding, high-speed Wi-Fi, and 24/7 room service during your stay.</p>",
            ]
        );

        return view('details.show', compact('detail'));
    }

    /** Show Facility Detail Page with auto-default fallback */
    public function showFacilityDetail($slug)
    {
        $defaultTitles = [
            'swimming-pool'   => 'Swimming Pool',
            'spa'             => 'Spa',
            'restaurants'     => '24*7 Restaurants',
            'gym'             => '24*7 Gym',
            'heli-service'    => 'Heli Service',
        ];

        $title = $defaultTitles[$slug] ?? Str::headline($slug);

        $detail = Detail::firstOrCreate(
            ['slug' => $slug],
            [
                'category'    => 'facility',
                'title'       => $title,
                'description' => "<p>Experience our world-class <strong>{$title}</strong> designed for your comfort and ultimate relaxation.</p>",
            ]
        );

        return view('details.show', compact('detail'));
    }

    /** Save Admin Edits (Title, Image, Rich Text HTML) */
    public function updateDetail(Request $request, $id)
    {
        $detail = Detail::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            if ($detail->image && Storage::disk('public')->exists($detail->image)) {
                Storage::disk('public')->delete($detail->image);
            }
            $validated['image'] = $request->file('image')->store('details', 'public');
        }

        $detail->update($validated);

        return back()->with('success', 'Detail page updated successfully!');
    }

    public function showBookForm(Request $request)
    {
        return view('book', [
            'countries' => self::countries(),
            'selectedRoom' => $request->query('type', '') 
        ]);
    }

    public function book(Request $request)
    {
        $name = $request->input('Name');
        $email = $request->input('Email');
        $country = $request->input('Country');

        if ($name == '' || $email == '' || $country == '') {
            return back()->with('error', 'Fill the proper details');
        }

        $cin = $request->input('cin');
        $cout = $request->input('cout');

        Roombook::create([
            'Name' => $name,
            'Email' => $email,
            'Country' => $country,
            'Phone' => $request->input('Phone'),
            'RoomType' => $request->input('RoomType'),
            'Bed' => $request->input('Bed'),
            'Meal' => $request->input('Meal'),
            'cin' => $cin,
            'cout' => $cout,
            'stat' => 'NotConfirm',
            'NoofRoom' => '1',
            'nodays' => $this->dayDiff($cin, $cout),
        ]);

        return redirect()->route('home')->with('success', 'Reservation successful! Check your user panel.');
    }

    public static function dayDiff($cin, $cout): int
    {
        if (! $cin || ! $cout) { return 0; }
        return (int) Carbon::parse($cin)->diffInDays(Carbon::parse($cout));
    }

    public static function countries(): array
    {
        return ['Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegowina', 'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo', 'Congo, the Democratic Republic of the', 'Cook Islands', 'Costa Rica', "Cote d'Ivoire", 'Croatia (Hrvatska)', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands (Malvinas)', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'France Metropolitan', 'French Guiana', 'French Polynesia', 'French Southern Territories', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard and Mc Donald Islands', 'Holy See (Vatican City State)', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran (Islamic Republic of)', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', "Korea, Democratic People's Republic of", 'Korea, Republic of', 'Kuwait', 'Kyrgyzstan', "Lao, People's Democratic Republic", 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libyan Arab Jamahiriya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia, The Former Yugoslav Republic of', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia, Federated States of', 'Moldova, Republic of', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russian Federation', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia (Slovak Republic)', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia and the South Sandwich Islands', 'Spain', 'Sri Lanka', 'St. Helena', 'St. Pierre and Miquelon', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen Islands', 'Swaziland', 'Sweden', 'Switzerland', 'Syrian Arab Republic', 'Taiwan, Province of China', 'Tajikistan', 'Tanzania, United Republic of', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'United States Minor Outlying Islands', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Venezuela', 'Vietnam', 'Virgin Islands (British)', 'Virgin Islands (U.S.)', 'Wallis and Futuna Islands', 'Western Sahara', 'Yemen', 'Yugoslavia', 'Zambia', 'Zimbabwe'];
    }
}