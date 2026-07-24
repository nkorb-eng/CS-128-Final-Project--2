<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - My Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="searchsection d-flex align-items-center justify-content-between p-3">
        <input type="text" name="search_bar" id="search_bar" placeholder="Search by name..." onkeyup="searchFun()" class="form-control w-25">
    </div>

    <div class="roombooktable table-responsive-xl">
        <table class="table table-bordered table-hover" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Invoice Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Room Type</th>
                    <th scope="col">Beds</th>
                    <th scope="col">Meal Plan</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th scope="col">Bill</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($payments as $res)
                <tr>
                    <td>{{ $res->id }}</td>
                    <td>{{ $res->Name }}</td>
                    <td>{{ $res->RoomType }}</td>
                    <td>{{ $res->Bed }}</td>
                    <td>{{ $res->meal }}</td>
                    <td>{{ $res->cin }}</td>
                    <td>{{ $res->cout }}</td>
                    <td class="fw-bold text-success">${{ number_format($res->finaltotal, 2) }}</td>
                    <td class="action text-center">
                        <a href="{{ route('user.invoice', $res->id) }}" target="_blank" class="btn btn-primary btn-sm text-white text-decoration-none">
                            <i class="fa-solid fa-print"></i> View Invoice
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
