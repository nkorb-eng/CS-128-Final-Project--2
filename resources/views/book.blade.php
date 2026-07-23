@extends('extend.app')

@include('extend.navHead')

@section('content')
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-0 rounded-3 overflow-hidden">

                    <div class="bg-dark text-white p-4 text-center">
                        <h2 class="fw-bold m-0"><i class="fa-solid fa-bookmark me-3 text-success"></i>HOTEL BLUEBIRD
                            RESERVATION</h2>
                        <p class="text-muted small m-0 mt-1">Please fill below to book</p>
                    </div>

                    <div class="card-body p-5 bg-light">
                        <form action="{{ route('room.book.submit') }}" method="POST">
                            @csrf
                            <div class="row g-4">

                                <div class="col-md-6 border-end pe-md-4">
                                    <h4 class="fw-bold mb-4 text-secondary border-bottom pb-2"><i
                                            class="fa-solid fa-user me-2"></i>Guest Information</h4>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Full Name</label>
                                        <input type="text" name="Name" class="form-control" placeholder="Enter full name"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Email Address</label>
                                        <input type="email" name="Email" value="{{ session('usermail') }}"
                                            class="form-control bg-white text-muted" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Country</label>
                                        <select name="Country" class="form-select" required>
                                            <option value="" selected disabled>Select your country</option>
                                            @foreach ($countries as $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Phone Number</label>
                                        <input type="text" name="Phone" class="form-control" placeholder="+855 123 456 789"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-md-4">
                                    <h4 class="fw-bold mb-4 text-secondary border-bottom pb-2"><i
                                            class="fa-solid fa-hotel me-2"></i>Reservation Details</h4>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Type of Room</label>
                                        <select name="RoomType" id="room_type" class="form-select"
                                            onchange="updateBedOptions()" required>

                                            <option value="" disabled selected>
                                                Select Room Type
                                            </option>

                                            @foreach($rooms->unique('type') as $room)

                                                <option value="{{ $room->type }}">
                                                    {{ strtoupper($room->type) }}
                                                </option>

                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Bedding Layout Configuration</label>
                                        <select name="Bed" id="bedding" class="form-select"
                                            onchange="calculateLiveEstimate()" required>

                                            <option disabled selected>
                                                Select Bed
                                            </option>

                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Meal Board Plan</label>
                                        <select name="Meal" id="meal_plan" class="form-select"
                                            onchange="calculateLiveEstimate()" required>
                                            <option value="" selected disabled>Select Meal Type</option>
                                            <option value="Room only">Room only</option>
                                            <option value="Breakfast">Breakfast</option>
                                            <option value="Half Board">Half Board</option>
                                            <option value="Full Board">Full Board</option>
                                        </select>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Check In Date</label>
                                            <input name="cin" id="check_in" type="date" class="form-control"
                                                onchange="calculateLiveEstimate()" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Check Out Date</label>
                                            <input name="cout" id="check_out" type="date" class="form-control"
                                                onchange="calculateLiveEstimate()" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">

                                <div class="text-start">
                                    <span class="text-muted fw-semibold d-block small uppercase text-tracking">Estimated
                                        Total Price:</span>
                                    <span class="fs-2 fw-bold text-success" id="livePriceDisplay">$ 0.00</span>
                                </div>

                                <div class="text-end">
                                    <a href="{{ route('home') }}"
                                        class="btn btn-outline-secondary px-5 py-2 me-2 fw-bold">Cancel</a>
                                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold">Submit Booking
                                        Order</button>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('extend.footer')
   
@endsection
<script>
    const rooms = @json($rooms);
</script>
<script>
    function calculateLiveEstimate() {
        const roomType = document.getElementById('room_type').value;
        const bedding = document.getElementById('bedding').value;
        const mealPlan = document.getElementById('meal_plan').value;
        const checkInVal = document.getElementById('check_in').value;
        const checkOutVal = document.getElementById('check_out').value;
        const priceDisplay = document.getElementById('livePriceDisplay');

        // Calculate Days Stayed
        let days = 0;
        if (checkInVal && checkOutVal) {
            const dateIn = new Date(checkInVal);
            const dateOut = new Date(checkOutVal);
            const diffTime = dateOut - dateIn;
            days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (days < 0) days = 0;
        }

        // Base Room Selection Rates

        const roomSelect = document.getElementById('room_type');

        const selectedOption = roomSelect.options[roomSelect.selectedIndex];


        let basePrice = 0;

        let selectedRoom = rooms.find(room =>
            room.type === roomType &&
            room.bedding === bedding
        );

        if (selectedRoom) {
            basePrice = Number(selectedRoom.price);
        }

        // Bedding Cost Additions
        let bedAdder = 0;
        switch (bedding) {
            case 'Double': bedAdder = 5.00; break;
            case 'Triple': bedAdder = 10.00; break;
            case 'Quad': bedAdder = 15.00; break;
        }

        // Meal Plan Cost Additions
        let mealRate = 0;
        switch (mealPlan) {
            case 'Breakfast': mealRate = 5.00; break;
            case 'Half Board': mealRate = 10.00; break;
            case 'Full Board': mealRate = 15.00; break;
        }

        // Total Pricing Calculation
        let totalBill = 0;
        if (days > 0 && basePrice > 0) {
            let roomAndBedTotal = (basePrice + bedAdder) * days;
            let mealTotal = mealRate * days;
            totalBill = roomAndBedTotal + mealTotal;
        }

        // Display Total
        priceDisplay.innerText = '$ ' + totalBill.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    document.addEventListener('DOMContentLoaded', function () {
        calculateLiveEstimate();
    });



    function updateBedOptions() {

        const roomType = document.getElementById('room_type').value;

        const bedSelect = document.getElementById('bedding');

        bedSelect.innerHTML = `
        <option value="" disabled selected>
            Select Bed
        </option>
    `;


        rooms
            .filter(room => room.type === roomType)
            .forEach(room => {

                bedSelect.innerHTML += `
            <option value="${room.bedding}">
                ${room.bedding}
            </option>
        `;

            });

    }
</script>