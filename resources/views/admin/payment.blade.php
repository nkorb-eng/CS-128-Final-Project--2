<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="searchsection d-flex align-items-center p-3">
        <input type="text" name="search_bar" id="search_bar" placeholder="Search by name..." onkeyup="searchFun()" class="form-control w-25">
    </div>

    <div class="roombooktable table-responsive-xl">
        <table class="table table-bordered table-hover align-middle" id="table-data">
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
                    <td class="fw-bold">{{ $res->Name }}</td>
                    <td>{{ $res->RoomType }}</td>
                    <td>{{ $res->Bed }}</td>
                    <td>{{ $res->meal }}</td>
                    <td>{{ $res->cin }}</td>
                    <td>{{ $res->cout }}</td>
                    <td class="fw-bold text-success">$ {{ number_format($res->finaltotal, 2) }}</td>
                    <td class="action text-nowrap text-center">
                        <a href="{{ route('admin.payment.invoice', $res->id) }}" target="_blank" class="btn btn-primary btn-sm me-1">
                            <i class="fa-solid fa-print"></i> Print
                        </a>
                        <a href="{{ route('admin.payment.delete', $res->id) }}" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
<script>
    const searchFun = () => {
        let filter = document.getElementById('search_bar').value.toUpperCase();
        let tr = document.getElementById("table-data").getElementsByTagName('tr');
        for (let i = 0; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName('td')[1];
            if (td) tr[i].style.display = (td.textContent || td.innerText).toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    }
</script>
</html>
