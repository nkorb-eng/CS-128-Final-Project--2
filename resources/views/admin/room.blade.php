<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin Room Inventory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="{{ asset('adminassets/css/room.css') }}">
    
    <!-- RESTORED STYLES -->
    <style>
        .overlay-panel {
            display: none;
            position: fixed;
            z-index: 10000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }
        .room-form-card {
            background-color: #fff;
            width: 500px;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .top-action-bar {
            padding: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }
    </style>
</head>

<body>
    <div id="roomdetailpanel" class="overlay-panel">
        <form action="{{ route('admin.room.store') }}" method="POST" class="room-form-card">
            @csrf
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0 fw-bold">Add New Room</h4>
                <i class="fa-solid fa-xmark fs-4 text-secondary" style="cursor: pointer;" onclick="closeroompanel()"></i>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Room Number:</label>
                <input type="text" name="room_no" class="form-control" placeholder="e.g., 101" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Type of Room:</label>
                <select name="type" class="form-control" required>
                    <option value="" selected disabled>Select Room Type</option>
                    <option value="Superior Room">SUPERIOR ROOM</option>
                    <option value="Deluxe Room">DELUXE ROOM</option>
                    <option value="Guest House">GUEST HOUSE</option>
                    <option value="Single Room">SINGLE ROOM</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Type of Bed:</label>
                <select name="bedding" class="form-control" required>
                    <option value="" selected disabled>Select Bed Type</option>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Triple">Triple</option>
                    <option value="Quad">Quad</option>
                    <option value="None">None</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Save Room</button>
        </form>
    </div>

    <div id="bulkupdatepanel" class="overlay-panel">
        <form action="{{ route('admin.room.bulk_update') }}" method="POST" class="room-form-card border-top border-primary border-5">
            @csrf
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0 fw-bold text-primary">Update Prices</h4>
                <i class="fa-solid fa-xmark fs-4 text-secondary" style="cursor: pointer;" onclick="closebulkpanel()"></i>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Target Room Type:</label>
                <select name="type" id="bulkType" class="form-control" onchange="showOldPrice()" required>
                    <option value="" selected disabled>Which rooms to update?</option>
                    <option value="Superior Room">SUPERIOR ROOM</option>
                    <option value="Deluxe Room">DELUXE ROOM</option>
                    <option value="Guest House">GUEST HOUSE</option>
                    <option value="Single Room">SINGLE ROOM</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Target Bed Type (Optional):</label>
                <select name="bedding" id="bulkBed" class="form-control" onchange="showOldPrice()" required>
                    <option value="Any" selected>Any Bedding (Update All)</option>
                    <option value="Single">Single Only</option>
                    <option value="Double">Double Only</option>
                    <option value="Triple">Triple Only</option>
                    <option value="Quad">Quad Only</option>
                    <option value="None">None Only</option>
                </select>
            </div>

            <div id="oldPriceDisplay" class="mb-3 p-2 bg-light border rounded text-info fw-bold text-center" style="display: none;"></div>

            <div class="mb-4">
                <label class="form-label fw-bold text-success">New Price ($):</label>
                <input type="number" name="price" class="form-control border-success" placeholder="e.g., 12" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Update Prices</button>
        </form>
    </div>

    <div class="top-action-bar">
        <form action="{{ route('admin.room') }}" method="GET" class="me-auto mb-0 d-flex align-items-center">
            <label for="sort" class="fw-bold me-2 text-nowrap">Sort By:</label>
            <select name="sort" id="sort" class="form-select border-secondary w-auto" onchange="this.form.submit()">
                <option value="room_no" {{ request('sort') == 'room_no' ? 'selected' : '' }}>Room Number</option>
                <option value="type" {{ request('sort') == 'type' ? 'selected' : '' }}>Room Type</option>
                <option value="bedding" {{ request('sort') == 'bedding' ? 'selected' : '' }}>Bed Type</option>
            </select>
        </form>

        <button class="btn btn-outline-primary fw-bold px-4 py-2" onclick="openbulkpanel()">
            Update Prices
        </button>
        <button class="btn btn-success fw-bold px-4 py-2" onclick="openroompanel()">
            Add Room
        </button>
    </div>

    <div class="room mt-4">
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
            <div class="roombox {{ $boxClass }} position-relative">
                <span class="position-absolute top-0 start-0 m-2 badge bg-dark fs-6">#{{ $row->room_no }}</span>
                
                <div class="text-center no-border mt-4">
                    <i class="fa-solid fa-bed fa-4x mb-2"></i>
                    <h3>{{ $row->type }}</h3>
                    <div class="mb-1 fw-bold">{{ $row->bedding }} Bed</div>
                    <div class="mb-3 text-dark fw-bold bg-light rounded mx-4 py-1">${{ $row->price }} / night</div>
                    <a href="{{ route('admin.room.delete', $row->id) }}" class="btn btn-danger px-4">Delete</a>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function openroompanel() {
            document.getElementById('roomdetailpanel').style.display = 'flex';
        }
        function closeroompanel() {
            document.getElementById('roomdetailpanel').style.display = 'none';
        }

        function openbulkpanel() {
            document.getElementById('bulkupdatepanel').style.display = 'flex';
        }
        function closebulkpanel() {
            document.getElementById('bulkupdatepanel').style.display = 'none';
        }

        const priceMap = @json($priceMap);

        function showOldPrice() {
            const typeSelect = document.getElementById('bulkType').value;
            const bedSelect = document.getElementById('bulkBed').value;
            const displayBox = document.getElementById('oldPriceDisplay');

            if (typeSelect) {
                displayBox.style.display = 'block';

                if (bedSelect === 'Any') {
                    displayBox.className = "mb-3 p-2 bg-warning bg-opacity-25 border border-warning rounded text-dark fw-bold text-center";
                    displayBox.innerHTML = `this will update price for ALL beds for ${typeSelect}`;
                } else {
                    const lookupKey = typeSelect + '_' + bedSelect;
                    const currentRate = priceMap[lookupKey];
                    
                    if (currentRate && currentRate > 0) {
                        displayBox.className = "mb-3 p-2 text-primary border border-primary rounded fw-bold text-center";
                        displayBox.innerHTML = `Current price for this : <span class="fs-5 text-dark">$${currentRate}</span>`;
                    } else {
                        displayBox.className = "mb-3 p-2 bg-light border border-secondary rounded text-secondary fw-bold text-center";
                        displayBox.innerHTML = `No rooms for this exact combo exist.`;
                    }
                }
            } else {
                displayBox.style.display = 'none';
            }
        }
    </script>

    @if (session('success'))
        <script>swal({ title: @json(session('success')), icon: 'success' });</script>
    @endif
    @if (session('error'))
        <script>swal({ title: @json(session('error')), icon: 'error' });</script>
    @endif
    @if ($errors->any())
        <script>swal({ title: "{{ $errors->first() }}", icon: 'error' });</script>
    @endif
</body>
</html>
