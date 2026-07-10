<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
</head>
<body>
    <div class="searchsection">
        <input type="text" name="search_bar" id="search_bar" placeholder="search..." onkeyup="searchFun()">
    </div>

    <div class="roombooktable" class="table-responsive-xl">
        <table class="table table-bordered" id="table-data">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Room Type</th>
                    <th scope="col">Bed Type</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th scope="col">No of Day</th>
                    <th scope="col">No of Room</th>
                    <th scope="col">Meal Type</th>
                    <th scope="col">Room Rent</th>
                    <th scope="col">Bed Rent</th>
                    <th scope="col">Meals</th>
                    <th scope="col">Total Bill</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($payments as $res)
                <tr>
                    <td>{{ $res->id }}</td>
                    <td>{{ $res->Name }}</td>
                    <td>{{ $res->RoomType }}</td>
                    <td>{{ $res->Bed }}</td>
                    <td>{{ $res->cin }}</td>
                    <td>{{ $res->cout }}</td>
                    <td>{{ $res->noofdays }}</td>
                    <td>{{ $res->NoofRoom }}</td>
                    <td>{{ $res->meal }}</td>
                    <td>{{ $res->roomtotal }}</td>
                    <td>{{ $res->bedtotal }}</td>
                    <td>{{ $res->mealtotal }}</td>
                    <td>{{ $res->finaltotal }}</td>
                    <td class="action">
                        <a href="{{ route('admin.payment.invoice', $res->id) }}" target="_blank"><button class="btn btn-primary"><i class="fa-solid fa-print"></i>Print</button></a>
                        <a href="{{ route('admin.payment.delete', $res->id) }}"><button class="btn btn-danger">Delete</button></a>
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

</html>
