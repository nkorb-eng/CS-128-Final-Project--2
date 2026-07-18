<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
    <title>BlueBird - Admin Reservations</title>
</head>

<body>
    <div class="searchsection d-flex align-items-center justify-content-between p-3">
        <input type="text" name="search_bar" id="search_bar" placeholder="Search by name..." onkeyup="searchFun()" class="form-control w-25">
        <form action="{{ route('admin.roombook.export') }}" method="post" class="m-0">
            @csrf
            <button class="btn btn-success" id="exportexcel" name="exportexcel" type="submit"><i class="fa-solid fa-file-excel"></i> Export to Excel</button>
        </form>
    </div>

    <div class="roombooktable table-responsive-xl">
        <table class="table table-bordered table-hover" id="table-data">
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
                    <th scope="col">No of Day</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="action text-center">Action</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($bookings as $res)
                <tr>
                    <td>{{ $res->id }}</td>
                    <td>{{ $res->Name }}</td>
                    <td>{{ $res->Email }}</td>
                    <td>{{ $res->Country }}</td>
                    <td>{{ $res->Phone }}</td>
                    <td>{{ $res->RoomType }}</td>
                    <td>{{ $res->Bed }}</td>
                    <td>{{ $res->NoofRoom }}</td>
                    <td>{{ $res->Meal }}</td>
                    <td>{{ $res->cin }}</td>
                    <td>{{ $res->cout }}</td>
                    <td>{{ $res->nodays }}</td>
                    <td>
                        @if ($res->stat === 'Confirm')
                            <span class="badge bg-success">Confirmed</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td class="action text-nowrap">
                        @if ($res->stat !== 'Confirm')
                            <a href="{{ route('admin.roombook.confirm', $res->id) }}" class='btn btn-success btn-sm'>Confirm</a>
                        @endif
                        <a href="{{ route('admin.roombook.edit', $res->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{ route('admin.roombook.delete', $res->id) }}" class='btn btn-danger btn-sm'>Delete</a>
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
        let myTable = document.getElementById("table-data");
        let tr = myTable.getElementsByTagName('tr');
        for (var i = 0; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName('td')[1];
            if (td) {
                let textvalue = td.textContent || td.innerHTML;
                tr[i].style.display = textvalue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    }
</script>

@if (session('success'))
    <script>swal({ title: @json(session('success')), icon: 'success' });</script>
@endif
@if (session('error'))
    <script>swal({ title: @json(session('error')), icon: 'error' });</script>
@endif
</html>