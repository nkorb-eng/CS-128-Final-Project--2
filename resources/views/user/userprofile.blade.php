<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .profile-avatar { width: 130px; height: 130px; object-fit: cover; border-radius: 50%; border: 3px solid #0d6efd; }
    </style>
</head>
<body>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-5 mt-4 border-0 shadow-sm rounded-3">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- USER HEADER & AVATAR DISPLAY -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            @if (!empty($user->avater))
                                <img src="{{ asset('storage/' . $user->avater) }}" class="profile-avatar shadow-sm" alt="User Avatar">
                            @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border shadow-sm mx-auto" style="width: 130px; height: 130px;">
                                    <i class="fa-solid fa-user text-secondary display-4"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="fw-bold text-dark mb-1">{{ $user->Username ?? 'Guest' }}</h3>
                        <p class="text-muted small">{{ $user->Email }}</p>
                    </div>

                    <hr class="text-muted mb-4">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold mb-1">Email Address</label>
                            <div class="p-2 border rounded bg-light">{{ $user->Email ?? 'guest@bluebird.com' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold mb-1">Phone Number</label>
                            <div class="p-2 border rounded bg-light">{{ $user->Phone ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold mb-1">Country</label>
                            <div class="p-2 border rounded bg-light">{{ $user->Country ?? 'Not set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold mb-1">Account Status</label>
                            <div class="p-2 border rounded bg-light"><span class="badge bg-success">Verified</span></div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary px-4 me-2"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Profile</a>
                        <a href="{{ route('user.password.edit') }}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-key me-2"></i>Change Password</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>