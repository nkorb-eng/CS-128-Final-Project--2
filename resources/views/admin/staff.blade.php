<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin Staff</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('adminassets/css/room.css') }}">
    <style>
        .room {
            align-items: flex-start;
        }

        .staff-card { 
            background-color: #ccdff4; 
            padding: 25px 20px; 
            border-radius: 12px; 
            width: 220px; 
            height: fit-content;
            margin: 15px; 
            text-align: center; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>
    <div class="addroomsection">
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            <label for="staffname">Name :</label>
            <input type="text" name="staffname" class="form-control" required>

            <label for="staffwork">Work :</label>
            <select name="staffwork" class="form-control" required>
                <option value="" selected disabled>Select Role</option>
                <option value="Manager">Manager</option>
                <option value="Cook">Cook</option>
                <option value="Helper">Helper</option>
                <option value="Cleaner">Cleaner</option>
                <option value="Waiter">Waiter</option>
            </select>

            <button type="submit" class="btn btn-success" name="addstaff">Add Staff</button>
        </form>
    </div>

    <div class="room">
        @foreach ($staff as $row)
            <div class="staff-card">
                <i class="fa fa-users fa-4x text-primary mb-3"></i>
                <h4 class="fw-bold text-dark mb-1">{{ $row->name }}</h4>
                <div class="badge bg-secondary mb-3 fs-6">{{ $row->work }}</div>
                <div>
                    <a href="{{ route('admin.staff.delete', $row->id) }}" class="btn btn-danger btn-sm px-4" onclick="return confirm('Remove staff member?')">Delete</a>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>