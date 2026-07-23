<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <style>
        body { padding: 34px; }
        .profile-card { max-width: 720px; margin: 0 auto; background:#fff; border:1px solid var(--bb-border); border-radius: var(--bb-radius); box-shadow: var(--bb-shadow); padding: 40px; }
        .avatar-circle { width: 110px; height: 110px; background: var(--bb-primary); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px; font-size:44px; font-family: var(--bb-serif); }
        .pf-field { border:1px solid var(--bb-border); border-radius: var(--bb-radius-sm); padding: 12px 14px; background:#fbfcfe; }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card profile-card p-5 mt-4">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="text-center mb-4">
                        <div class="avatar-circle">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h3 class="fw-bold text-dark">{{ $user->Username ?? 'Guest' }}</h3>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold mb-1">Email Address</label>
                            <div class="p-2 border rounded bg-light">{{ $user->Email }}</div>
                        </div>
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
                            <div class="p-2 border rounded bg-light">Verified</div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary px-4 me-2"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Profile</a>
                        <a href="{{ route('user.password.edit') }}" class="btn btn-outline-danger px-4"><i class="fa-solid fa-key me-2"></i>Change Password</a>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <label class="pos-label">Account Status</label>
                <div class="pf-field">Verified</div>
            </div>
        </div>
        <div class="text-center mt-5">
            <button class="btn btn-primary px-4 me-2"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Profile</button>
            <button class="btn btn-danger px-4"><i class="fa-solid fa-key me-2"></i>Change Password</button>
        </div>
    </div>
</body>
</html>
