<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - User Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
</head>
<body>
    <div class="searchsection">
        <input type="text" name="search_bar" id="search_bar" placeholder="search...">
    </div>

    <div class="roombooktable" class="table-responsive-xl">
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Country</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Type of Room</th>
                    <th scope="col">Type of Bed</th>
                    <th scope="col">No of Room</th>
                    <th scope="col">Meal</th>
                    <th scope="col">Check-In</th>
                    <th scope="col">Check-Out</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>101</td>
                    <td>Guest User</td>
                    <td>{{ session('usermail') }}</td>
                    <td>United States</td>
                    <td>+1 234 567 890</td>
                    <td>Deluxe Room</td>
                    <td>Double</td>
                    <td>1</td>
                    <td>Breakfast</td>
                    <td>2026-07-15</td>
                    <td>2026-07-20</td>
                    <td><span class="badge bg-success">Confirm</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>