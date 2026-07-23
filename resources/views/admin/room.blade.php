<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Existing Room CSS -->
    <link rel="stylesheet" href="{{ asset('adminassets/css/room.css') }}">

    <style>
        .room-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            background: #fff;
            height: 100%;
        }

        .room-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 26px rgba(0, 0, 0, 0.15);
        }

        .room-img-wrap {
            position: relative;
            height: 180px;
            width: 100%;
            background: #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .room-img-wrap img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .room-img-wrap i.fa-bed {
            font-size: 48px;
            color: #adb5bd;
        }

        .room-number-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.65);
            color: #fff;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            z-index: 2;
        }

        .room-card-body {
            padding: 14px 16px;
        }

        .room-type {
            font-weight: 700;
            font-size: 17px;
            margin-bottom: 2px;
        }

        .room-bedding {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .room-price {
            font-weight: 700;
            color: #198754;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .room-actions .btn {
            font-size: 13px;
        }

        .side-panel-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1050;
        }

        .side-panel-overlay.active {
            display: block;
        }

        .side-panel {
            position: fixed;
            top: 0;
            right: -420px;
            width: 400px;
            max-width: 90%;
            height: 100%;
            background: #fff;
            z-index: 1060;
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.2);
            transition: right 0.3s ease;
            overflow-y: auto;
        }

        .side-panel.active {
            right: 0;
        }

        .side-panel-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .side-panel-body {
            padding: 20px;
        }

        .current-img-preview {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>

<body>

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <h3 class="mb-0"><i class="fa-solid fa-hotel me-2"></i>Room Management</h3>

            <div class="d-flex gap-2 flex-wrap">
                <select id="sortRooms" class="form-select" style="width:auto;" onchange="sortRoomCards()">
                    <option value="default">Sort By</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="room_no_asc">Room No: Ascending</option>
                    <option value="room_no_desc">Room No: Descending</option>
                </select>

                <button class="btn btn-outline-primary" onclick="openbulkpanel()">
                    <i class="fa-solid fa-tags me-1"></i> Bulk Update Prices
                </button>

                <button class="btn btn-primary" onclick="openroompanel()">
                    <i class="fa-solid fa-plus me-1"></i> Add Room
                </button>
            </div>
        </div>

        <div class="row g-4" id="roomCardsContainer">
            @foreach($rooms as $row)
                <div class="col-xl-3 col-lg-4 col-md-6" data-room-id="{{ $row->id }}" data-price="{{ $row->price }}"
                    data-room-no="{{ $row->room_no }}">
                    <div class="room-card">
                        <div class="room-img-wrap">
                            <span class="room-number-badge">
                                #{{ $row->room_no }}
                            </span>

                            @if($row->image)
                                <img src="{{ asset('storage/' . $row->image) }}" class="img-fluid"
                                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">

                                <div style="display:none;width:100%;height:180px;align-items:center;justify-content:center;">
                                    <i class="fa-solid fa-bed fa-3x text-secondary"></i>
                                </div>
                            @else
                                <div style="display:flex;width:100%;height:180px;align-items:center;justify-content:center;">
                                    <i class="fa-solid fa-bed fa-3x text-secondary"></i>
                                </div>
                            @endif
                        </div>
                        <div class="room-card-body">
                            <div class="room-type">{{ $row->type }}</div>
                            <div class="room-bedding"><i class="fa-solid fa-bed me-1"></i>{{ $row->bedding }}</div>
                            <div class="room-price">${{ number_format($row->price, 2) }}</div>

                            <div class="room-actions d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary flex-fill" onclick='editRoom(
                                            {{ $row->id }},
                                            @json($row->room_no),
                                            @json($row->type),
                                            @json($row->bedding),
                                            @json($row->price),
                                            @json($row->image ? asset("storage/" . $row->image) : "")
                                        )'>
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>

                                <button type="button" class="btn btn-sm btn-outline-danger flex-fill"
                                    onclick="deleteRoom({{ $row->id }})">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($rooms->isEmpty())
            <div class="text-center text-muted py-5">
                <i class="fa-solid fa-bed fa-3x mb-3"></i>
                <p>No rooms found. Click "Add Room" to create one.</p>
            </div>
        @endif
    </div>

    <!-- ================= ADD ROOM PANEL ================= -->
    <div class="side-panel-overlay" id="roomOverlay" onclick="closeroompanel()"></div>
    <div class="side-panel" id="roomPanel">
        <div class="side-panel-header">
            <h5 class="mb-0"><i class="fa-solid fa-plus me-2"></i>Add Room</h5>
            <button type="button" class="btn-close" onclick="closeroompanel()"></button>
        </div>
        <div class="side-panel-body">
            <form id="addRoomForm" method="POST" action="{{ route('admin.room.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Room Number</label>
                    <input type="text" name="room_no" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Room Type</label>
                    <input type="text" name="type" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bedding</label>
                    <input type="text" name="bedding" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Room Image</label>
                    <input type="file" name="image" accept="image/*" class="form-control">
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fa-solid fa-check me-1"></i> Save Room
                    </button>
                    <button type="button" class="btn btn-outline-secondary flex-fill" onclick="closeroompanel()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= EDIT ROOM PANEL ================= -->
    <!-- ================= EDIT ROOM MODAL ================= -->
    <div class="modal fade" id="editRoomModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-pen me-2"></i>Edit Room
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="editRoomForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">

                        <!-- Current Image -->
                        <div class="mb-3" id="editImagePreviewWrap">
                            <label class="form-label">Current Image</label>

                            <img id="editImagePreview" class="current-img-preview" src="" alt="Current room image">
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Room Number</label>
                            <input type="text" name="room_no" id="edit_room_no" class="form-control" required>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Room Type</label>
                            <input type="text" name="type" id="edit_type" class="form-control" required>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Bedding</label>
                            <input type="text" name="bedding" id="edit_bedding" class="form-control" required>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" id="edit_price" class="form-control">
                        </div>


                        <div class="mb-3">
                            <label class="form-label">
                                Replace Image
                            </label>

                            <input type="file" name="image" accept="image/*" class="form-control">
                        </div>


                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>


                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check"></i>
                            Update Room
                        </button>

                    </div>


                </form>

            </div>
        </div>
    </div>

    <!-- ================= BULK UPDATE PANEL ================= -->
    <div class="side-panel-overlay" id="bulkOverlay" onclick="closebulkpanel()"></div>
    <div class="side-panel" id="bulkPanel">
        <div class="side-panel-header">
            <h5 class="mb-0"><i class="fa-solid fa-tags me-2"></i>Bulk Update Prices</h5>
            <button type="button" class="btn-close" onclick="closebulkpanel()"></button>
        </div>
        <div class="side-panel-body">
            <form id="bulkUpdateForm" method="POST" action="{{ route('admin.room.bulk_update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Room Type</label>
                    <select name="type" id="bulkType" class="form-select" onchange="showOldPrice()" required>
                        <option value="">Select Type</option>
                        @foreach($rooms->pluck('type')->unique() as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Price</label>
                    <input type="text" id="oldPriceDisplay" class="form-control" disabled placeholder="--">
                </div>

                <div class="mb-3">
                    <label class="form-label">New Price</label>
                    <input type="number" step="0.01" name="new_price" class="form-control" required>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fa-solid fa-check me-1"></i> Update Prices
                    </button>
                    <button type="button" class="btn btn-outline-secondary flex-fill" onclick="closebulkpanel()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        const editImageInput = document.querySelector('#editRoomForm input[name="image"]');

        if (editImageInput) {
            editImageInput.addEventListener('change', function () {

                if (!this.files.length) return;

                const reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('editImagePreview').src = e.target.result;
                    document.getElementById('editImagePreviewWrap').style.display = 'block';
                };

                reader.readAsDataURL(this.files[0]);
            });
        }
        // Price map for bulk update (type -> price), kept from existing logic
        const priceMap = @json($priceMap ?? []);

        /* ================= ADD ROOM PANEL ================= */
        function openroompanel() {
            document.getElementById('roomPanel').classList.add('active');
            document.getElementById('roomOverlay').classList.add('active');
        }

        function closeroompanel() {
            document.getElementById('roomPanel').classList.remove('active');
            document.getElementById('roomOverlay').classList.remove('active');
        }

        /* ================= BULK UPDATE PANEL ================= */
        function openbulkpanel() {
            document.getElementById('bulkPanel').classList.add('active');
            document.getElementById('bulkOverlay').classList.add('active');
        }

        function closebulkpanel() {
            document.getElementById('bulkPanel').classList.remove('active');
            document.getElementById('bulkOverlay').classList.remove('active');
        }

        function showOldPrice() {
            const type = document.getElementById('bulkType').value;
            const display = document.getElementById('oldPriceDisplay');
            if (type && priceMap[type] !== undefined) {
                display.value = priceMap[type];
            } else {
                display.value = '';
            }
        }
        // ==================delete================
        function deleteRoom(id) {

    Swal.fire({
        title: 'Are you sure?',
        text: "This room will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {

            let form = document.createElement('form');

            form.method = 'POST';
            form.action = `/admin/room/${id}`;

            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;

            document.body.appendChild(form);
            form.submit();

        }

    });

}

        /* ================= EDIT ROOM PANEL ================= */
        function editRoom(id, roomNo, type, bedding, price, image) {

            const form = document.getElementById('editRoomForm');

            let url = "{{ route('admin.room.update', ':id') }}";

            form.action = url.replace(':id', id);


            document.getElementById('edit_room_no').value = roomNo;
            document.getElementById('edit_type').value = type;
            document.getElementById('edit_bedding').value = bedding;
            document.getElementById('edit_price').value = price;


            const preview = document.getElementById('editImagePreview');
            const previewWrap = document.getElementById('editImagePreviewWrap');


            if (image) {

                preview.src = image;
                previewWrap.style.display = "block";

            } else {

                preview.src = "";
                previewWrap.style.display = "none";

            }


            const modal = new bootstrap.Modal(
                document.getElementById('editRoomModal')
            );

            modal.show();

        }

        /* ================= SORTING ================= */
        function sortRoomCards() {
            const sortValue = document.getElementById('sortRooms').value;
            const container = document.getElementById('roomCardsContainer');
            const cards = Array.from(container.children);

            cards.sort((a, b) => {
                if (sortValue === 'price_asc') {
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                } else if (sortValue === 'price_desc') {
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                } else if (sortValue === 'room_no_asc') {
                    return a.dataset.roomNo.localeCompare(b.dataset.roomNo, undefined, { numeric: true });
                } else if (sortValue === 'room_no_desc') {
                    return b.dataset.roomNo.localeCompare(a.dataset.roomNo, undefined, { numeric: true });
                }
                return 0;
            });

            cards.forEach(card => container.appendChild(card));
        }

        /* ================= SWEETALERT FLASH MESSAGES ================= */
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `@foreach($errors->all() as $error){{ $error }}<br>@endforeach`
            });
        @endif

    </script>

</body>

</html>