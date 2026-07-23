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
    <title>Edit Reservation</title>
</head>
<body>
    <div id="editpanel">
        <form method="POST" action="{{ route('admin.roombook.update', $booking->id) }}" class="guestdetailpanelform">
            @csrf
            <div class="head">
                <h3>EDIT RESERVATION & ASSIGN ROOM</h3>
                <a href="{{ route('admin.roombook') }}"><i class="fa-solid fa-circle-xmark"></i></a>
            </div>
            <div class="middle">
                <div class="guestinfo">
                    <h4>Guest information</h4>
                    <input type="text" name="Name" placeholder="Enter Full name" value="{{ $booking->Name }}" required>
                    <input type="email" name="Email" placeholder="Enter Email" value="{{ $booking->Email }}" required>

                    <select name="Country" class="selectinput" required>
                        <option value="" disabled>Select your country</option>
                        @foreach ($countries as $value)
                            <option value="{{ $value }}" @selected($booking->Country === $value)>{{ $value }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="Phone" placeholder="Enter Phoneno" value="{{ $booking->Phone }}" required>
                </div>

                <div class="line"></div>

                <div class="reservationinfo">
                    <h4>Reservation information</h4>
                    <select name="RoomType" id="roomTypeSelect" class="selectinput" onchange="updateAvailableRooms()" required>
                        <option value="" disabled>Type Of Room</option>
                        <option value="Superior Room" @selected($booking->RoomType === 'Superior Room')>SUPERIOR ROOM</option>
                        <option value="Deluxe Room" @selected($booking->RoomType === 'Deluxe Room')>DELUXE ROOM</option>
                        <option value="Guest House" @selected($booking->RoomType === 'Guest House')>GUEST HOUSE</option>
                        <option value="Single Room" @selected($booking->RoomType === 'Single Room')>SINGLE ROOM</option>
                    </select>
                    
                    <select name="Bed" id="bedSelect" class="selectinput" onchange="updateAvailableRooms()" required>
                        <option value="" disabled>Bedding Type</option>
                        <option value="Single" @selected($booking->Bed === 'Single')>Single</option>
                        <option value="Double" @selected($booking->Bed === 'Double')>Double</option>
                        <option value="Triple" @selected($booking->Bed === 'Triple')>Triple</option>
                        <option value="Quad" @selected($booking->Bed === 'Quad')>Quad</option>
                    </select>
                    
                    <div class="mb-2 px-2">
                        <label class="small fw-bold text-dark d-block mb-1">Select Available Room Number:</label>
                        <select name="NoofRoom" id="roomNoSelect" class="form-select border-primary fw-bold text-dark" style="height: 40px; border-radius: 5px;" required>
                            <option value="Pending">Pending Assignment</option>
                            </select>
                    </div>

                    <select name="Meal" class="selectinput" required>
                        <option value="" disabled>Meal</option>
                        <option value="Room only" @selected($booking->Meal === 'Room only')>Room only</option>
                        <option value="Breakfast" @selected($booking->Meal === 'Breakfast')>Breakfast</option>
                        <option value="Half Board" @selected($booking->Meal === 'Half Board')>Half Board</option>
                        <option value="Full Board" @selected($booking->Meal === 'Full Board')>Full Board</option>
                    </select>
                    <div class="datesection">
                        <span>
                            <label for="cin"> Check-In</label>
                            <input name="cin" type="date" value="{{ $booking->cin }}" required>
                        </span>
                        <span>
                            <label for="cout"> Check-Out</label>
                            <input name="cout" type="date" value="{{ $booking->cout }}" required>
                        </span>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button type="submit" class="btn btn-success" name="guestdetailedit">Save & Verify Assignment</button>
            </div>
        </form>
    </div>

    <script>
        // Injects the multi-dimensional map built by the controller
        const roomsMap = @json($roomsMap);
        const originallyAssignedRoom = "{{ $booking->NoofRoom }}";

        function updateAvailableRooms() {
            const selectedType = document.getElementById('roomTypeSelect').value;
            const selectedBed = document.getElementById('bedSelect').value;
            const roomNoDropdown = document.getElementById('roomNoSelect');

            // Reset dropdown options, keeping only the Pending assignment fallback
            roomNoDropdown.innerHTML = '<option value="Pending">Pending Assignment</option>';

            if (selectedType && selectedBed) {
                // Build search array key matching controller mapping metrics
                const lookupKey = selectedType + '_' + selectedBed;
                const matches = roomsMap[lookupKey] || [];

                // Populate matching options
                matches.forEach(roomNo => {
                    const opt = document.createElement('option');
                    opt.value = roomNo;
                    opt.textContent = 'Room #' + roomNo;
                    
                    // Keep selected state if matches original assignment configuration
                    if (roomNo === originallyAssignedRoom) {
                        opt.selected = true;
                    }
                    roomNoDropdown.appendChild(opt);
                });

                // Safety fallback: if an assigned room exists but was filtered out, keep it visible
                if (originallyAssignedRoom !== 'Pending' && !matches.includes(originallyAssignedRoom)) {
                    // Check if current form selections match the original room state parameters
                    if (selectedType === "{{ $booking->RoomType }}" && selectedBed === "{{ $booking->Bed }}") {
                        const savedOpt = document.createElement('option');
                        savedOpt.value = originallyAssignedRoom;
                        savedOpt.textContent = 'Room #' + originallyAssignedRoom + ' (Assigned)';
                        savedOpt.selected = true;
                        roomNoDropdown.appendChild(savedOpt);
                    }
                }
            }
        }

        // Initialize immediately upon document ready state to render original metrics setup
        document.addEventListener('DOMContentLoaded', updateAvailableRooms);
    </script>

    @if (session('error'))
        <script>swal({ title: @json(session('error')), icon: 'error' });</script>
    @endif
    @if ($errors->any())
        <script>swal({ title: "{{ $errors->first() }}", icon: 'error' });</script>
    @endif
</body>
</html>