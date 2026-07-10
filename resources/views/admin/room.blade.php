<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('adminassets/css/room.css') }}">
</head>

<body>
    <div class="addroomsection">
        <form action="{{ route('admin.room.store') }}" method="POST">
            @csrf
            <label for="troom">Type of Room :</label>
            <select name="troom" class="form-control">
                <option value selected></option>
                <option value="Superior Room">SUPERIOR ROOM</option>
                <option value="Deluxe Room">DELUXE ROOM</option>
                <option value="Guest House">GUEST HOUSE</option>
                <option value="Single Room">SINGLE ROOM</option>
            </select>

            <label for="bed">Type of Bed :</label>
            <select name="bed" class="form-control">
                <option value selected></option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Triple">Triple</option>
                <option value="Quad">Quad</option>
                <option value="None">None</option>
            </select>

            <button type="submit" class="btn btn-success" name="addroom">Add Room</button>
        </form>
    </div>

    <div class="room">
        @foreach ($rooms as $row)
            @php
                $boxClass = match ($row->type) {
                    'Superior Room' => 'roomboxsuperior',
                    'Deluxe Room' => 'roomboxdelux',
                    'Guest House' => 'roomboguest',
                    'Single Room' => 'roomboxsingle',
                    default => '',
                };
            @endphp
            <div class="roombox {{ $boxClass }}">
                <div class="text-center no-boder">
                    <i class="fa-solid fa-bed fa-4x mb-2"></i>
                    <h3>{{ $row->type }}</h3>
                    <div class="mb-1">{{ $row->bedding }}</div>
                    <a href="{{ route('admin.room.delete', $row->id) }}"><button class="btn btn-danger">Delete</button></a>
                </div>
            </div>
        @endforeach
    </div>

</body>

</html>
