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
    <div class="profile-card">
        <div class="text-center mb-4">
            <div class="avatar-circle">{{ strtoupper(substr($user->Username ?? 'G', 0, 1)) }}</div>
            <h3 class="mb-1">{{ $user->Username ?? 'Guest' }}</h3>
            <span class="pos-badge pos-badge-success">Active Member</span>
        </div>
        <hr class="text-muted mb-4">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="pos-label">Email Address</label>
                <div class="pf-field">{{ $user->Email ?? session('usermail') }}</div>
            </div>
            <div class="col-md-6">
                <label class="pos-label">Account ID</label>
                <div class="pf-field">#{{ $user->UserID ?? '—' }}</div>
            </div>
            <div class="col-md-6">
                <label class="pos-label">Total Bookings</label>
                <div class="pf-field">{{ $bookingCount }}</div>
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
