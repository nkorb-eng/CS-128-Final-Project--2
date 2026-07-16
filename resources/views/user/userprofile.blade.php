<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <style>
        body { background-color: #f4f6f9; padding: 30px; }
        .profile-card { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .avatar-circle { width: 120px; height: 120px; background-color: #0d6efd; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 50px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card profile-card p-5 mt-4">
                    
                    <div class="text-center mb-4">
                        <div class="avatar-circle">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Guest User</h3>
                        <span class="badge bg-success px-3 py-2 rounded-pill">Active Member</span>
                    </div>

                    <hr class="text-muted mb-4">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold mb-1">Email Address</label>
                            <div class="p-2 border rounded bg-light">{{ session('usermail') ?? 'guest@bluebird.com' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold mb-1">Phone Number</label>
                            <div class="p-2 border rounded bg-light">+1 (234) 567-8900</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold mb-1">Country</label>
                            <div class="p-2 border rounded bg-light">United States</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold mb-1">Account Status</label>
                            <div class="p-2 border rounded bg-light">Verified</div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <button class="btn btn-outline-primary px-4 me-2"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Profile</button>
                        <button class="btn btn-outline-danger px-4"><i class="fa-solid fa-key me-2"></i>Change Password</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>