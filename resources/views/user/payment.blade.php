<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Payments</title>
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
                    <th scope="col">Invoice Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Room Type</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th scope="col">Room Rent</th>
                    <th scope="col">Meals Bill</th>
                    <th scope="col">Total Bill</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>INV-9982</td>
                    <td>Guest User</td>
                    <td>Deluxe Room</td>
                    <td>2026-07-15</td>
                    <td>2026-07-20</td>
                    <td>₹3000</td>
                    <td>₹500</td>
                    <td>₹3500</td>
                    <td class="action">
                        <button class="btn btn-primary btn-sm"><i class="fa-solid fa-print"></i> View Invoice</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>