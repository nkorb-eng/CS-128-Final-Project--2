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

    <div class="roombooktable table-responsive-xl">
        <table class="table table-bordered table-hover align-middle" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Country</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Type of Room</th>
                    <th scope="col">Type of Bed</th>
                    <th scope="col">Room Number</th>
                    <th scope="col">Meal</th>
                    <th scope="col">Check-In</th>
                    <th scope="col">Check-Out</th>
                    <th scope="col" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($bookings as $res)
                <tr>
                    <td>{{ $res->id }}</td>
                    <td class="fw-bold">{{ $res->Name }}</td>
                    <td>{{ $res->Email }}</td>
                    <td>{{ $res->Country }}</td>
                    <td>{{ $res->Phone }}</td>
                    <td>{{ $res->RoomType }}</td>
                    <td>{{ $res->Bed }}</td>
                    
                    <td>
                        @if ($res->stat === 'Confirm')
                            <span class="badge bg-dark px-2 py-1 fs-6">#{{ $res->NoofRoom }}</span>
                        @else
                            <span class="text-muted small italic">Pending</span>
                        @endif
                    </td>

                    <td>{{ $res->Meal }}</td>
                    <td>{{ $res->cin }}</td>
                    <td>{{ $res->cout }}</td>
                    <td class="text-center">
                        @if ($res->stat === 'Confirm')
                            <span class="badge bg-success px-3 py-1">Confirmed</span>
                        @else
                            <span class="badge bg-warning text-dark px-3 py-1">Pending</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>