<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
    <style>
        #editpanel{
            position: fixed;
            z-index: 1000;
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            background-color: #00000079;
        }
        #editpanel .guestdetailpanelform{
            height: 620px;
            width: 1170px;
            background-color: #ccdff4;
            border-radius: 10px;
            position: relative;
            top: 20px;
            animation: guestinfoform .3s ease;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div id="editpanel">
        <form method="POST" action="{{ route('admin.roombook.update', $booking->id) }}" class="guestdetailpanelform">
            @csrf
            <div class="head">
                <h3>EDIT RESERVATION</h3>
                <a href="{{ route('admin.roombook') }}"><i class="fa-solid fa-circle-xmark"></i></a>
            </div>
            <div class="middle">
                <div class="guestinfo">
                    <h4>Guest information</h4>
                    <input type="text" name="Name" placeholder="Enter Full name" value="{{ $booking->Name }}">
                    <input type="email" name="Email" placeholder="Enter Email" value="{{ $booking->Email }}">

                    <select name="Country" class="selectinput">
                        <option value selected>Select your country</option>
                        @foreach ($countries as $value)
                            <option value="{{ $value }}" @selected($booking->Country === $value)>{{ $value }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="Phone" placeholder="Enter Phoneno" value="{{ $booking->Phone }}">
                </div>

                <div class="line"></div>

                <div class="reservationinfo">
                    <h4>Reservation information</h4>
                    <select name="RoomType" class="selectinput">
                        <option value selected>Type Of Room</option>
                        <option value="Superior Room" @selected($booking->RoomType === 'Superior Room')>SUPERIOR ROOM</option>
                        <option value="Deluxe Room" @selected($booking->RoomType === 'Deluxe Room')>DELUXE ROOM</option>
                        <option value="Guest House" @selected($booking->RoomType === 'Guest House')>GUEST HOUSE</option>
                        <option value="Single Room" @selected($booking->RoomType === 'Single Room')>SINGLE ROOM</option>
                    </select>
                    <select name="Bed" class="selectinput">
                        <option value selected>Bedding Type</option>
                        <option value="Single" @selected($booking->Bed === 'Single')>Single</option>
                        <option value="Double" @selected($booking->Bed === 'Double')>Double</option>
                        <option value="Triple" @selected($booking->Bed === 'Triple')>Triple</option>
                        <option value="Quad" @selected($booking->Bed === 'Quad')>Quad</option>
                        <option value="None" @selected($booking->Bed === 'None')>None</option>
                    </select>
                    <select name="NoofRoom" class="selectinput">
                        <option value selected>No of Room</option>
                        <option value="1" @selected($booking->NoofRoom === '1')>1</option>
                    </select>
                    <select name="Meal" class="selectinput">
                        <option value selected>Meal</option>
                        <option value="Room only" @selected($booking->Meal === 'Room only')>Room only</option>
                        <option value="Breakfast" @selected($booking->Meal === 'Breakfast')>Breakfast</option>
                        <option value="Half Board" @selected($booking->Meal === 'Half Board')>Half Board</option>
                        <option value="Full Board" @selected($booking->Meal === 'Full Board')>Full Board</option>
                    </select>
                    <div class="datesection">
                        <span>
                            <label for="cin"> Check-In</label>
                            <input name="cin" type="date" value="{{ $booking->cin }}">
                        </span>
                        <span>
                            <label for="cin"> Check-Out</label>
                            <input name="cout" type="date" value="{{ $booking->cout }}">
                        </span>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn btn-success" name="guestdetailedit">Edit</button>
            </div>
        </form>
    </div>
</body>
</html>
