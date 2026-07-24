@extends('extend.app')

@include('extend.navHead')

@section('content')
<!-- Quill WYSIWYG Editor CSS -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />

<style>
    .ql-editor-display {
        border: none !important;
        padding: 0 !important;
        overflow-y: visible !important;
        height: auto !important;
    }
</style>

<div style="padding-top: 80px; min-height: 85vh;" class="bg-light pb-5">
    
    <!-- ADMIN CONTROLLER -->
    @if (session('is_admin'))
      <div class="shadow-lg p-3 rounded-4 border border-secondary" 
           style="position: fixed; bottom: 24px; right: 24px; z-index: 10000; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(12px); color: #fff; width: 280px;">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="badge bg-primary text-uppercase px-2 py-1 small">Admin Mode</span>
          <small class="text-warning fw-bold"> Page Editor</small>
        </div>
        <p class="small text-white-50 mb-3" style="font-size: 0.85rem;">
            Edit display title, photo & text content for this {{ $detail->category }}.
        </p>
        <button class="btn btn-warning btn-sm fw-bold w-100 rounded-3" data-bs-toggle="modal" data-bs-target="#editDetailModal">
        Edit Display Info
        </button>
      </div>

      <!-- EDIT MODAL -->
      <div class="modal fade text-dark" id="editDetailModal" tabindex="-1" aria-hidden="true" style="z-index: 11000;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title fw-bold">
                Edit {{ $detail->category === 'room' ? 'Room Name' : 'Facility Name' }}
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.detail.update', $detail->id) }}" method="POST" enctype="multipart/form-data" id="editDetailForm">
              @csrf
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label fw-bold">
                    {{ $detail->category === 'room' ? 'Room Display Name' : 'Facility Name' }}
                  </label>
                  <input type="text" name="title" class="form-control" value="{{ $detail->title }}" required>
                  <small class="text-muted">Change the name shown on the website heading.</small>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Header / Banner Image</label>
                  <input type="file" name="image" class="form-control" accept="image/*">
                  <small class="text-muted">Upload a new photo to replace the display banner.</small>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Description (Rich Text)</label>
                  <div id="quill-editor" style="height: 220px; background: #fff;">
                    {!! $detail->description !!}
                  </div>
                  <input type="hidden" name="description" id="description_input">
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success fw-bold">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    @endif

    <!-- MAIN PAGE DISPLAY -->
    <div class="container my-4">
        <!-- Breadcrumb / Back Button -->
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm mb-4">
            Back to Homepage
        </a>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Header Banner Image -->
            <div style="height: 380px; width: 100%; background-color: #1e293b; overflow: hidden; position: relative;">
                @if ($detail->image)
                    <img src="{{ asset('storage/' . $detail->image) }}" class="w-100 h-100" style="object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-white opacity-50">
                        
                    </div>
                @endif
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.85));" class="p-4 text-white">
                    <span class="badge bg-primary text-uppercase px-3 py-2 mb-2">{{ $detail->category }}</span>
                    <h1 class="fw-bold m-0 display-5">{{ $detail->title }}</h1>
                </div>
            </div>

            <!-- Content Area -->
            <div class="card-body p-4 p-md-5">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <h4 class="fw-bold text-dark mb-3">About {{ $detail->title }}</h4>
                        
                        <!-- Rich Text Description -->
                        <div class="ql-editor ql-editor-display fs-5 text-secondary">
                            {!! $detail->description !!}
                        </div>
                    </div>

                    <!-- SIDEBAR: ROOM TYPE & BOOKING -->
                    <div class="col-lg-4">
                        <div class="bg-light p-4 rounded-4 border border-secondary border-opacity-10 shadow-sm">
                            @if ($detail->category === 'room')
                                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                    Room Specifications
                                </h5>

                                {{-- ROOM TYPE --}}
                                <div class="mb-3">
                                    <span class="text-muted small fw-bold text-uppercase d-block">Room Category / Type</span>
                                    <span class="fs-5 fw-bold text-dark">{{ $roomType ?? $detail->title }}</span>
                                </div>

                                {{-- STARTING PRICE --}}
                                @if(isset($startingPrice) && $startingPrice > 0)
                                    <div class="mb-4">
                                        <span class="text-muted small fw-bold text-uppercase d-block">Nightly Rate Starts At</span>
                                        <span class="fs-3 fw-bold text-success">${{ number_format($startingPrice, 2) }} <small class="fs-6 text-muted font-normal">/ night</small></span>
                                    </div>
                                @endif

                                <a href="{{ route('room.book', ['type' => $roomType ?? $detail->title]) }}" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                                    Book {{ $detail->title }}
                                </a>
                            @else
                                <h5 class="fw-bold text-dark mb-3">Facility Information</h5>
                                <p class="text-muted small">Available to all checked-in guests at Hotel BlueBird.</p>
                                <a href="{{ route('contact') }}" class="btn btn-outline-primary w-100 fw-bold">
                                    Inquire Front Desk
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quill JS Library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('quill-editor')) {
            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['clean']
                    ]
                }
            });

            var form = document.getElementById('editDetailForm');
            if (form) {
                form.onsubmit = function() {
                    var descInput = document.getElementById('description_input');
                    descInput.value = quill.root.innerHTML;
                };
            }
        }
    });
</script>

@include('extend.footer')
@endsection

@if (session('success'))
    <script>swal({ title: @json(session('success')), icon: 'success' });</script>
@endif