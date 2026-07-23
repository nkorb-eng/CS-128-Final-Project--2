<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <style>
        body { background-color: #f4f6f9; padding: 30px; }
        .profile-card { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card profile-card p-5 mt-4">

                    <h3 class="fw-bold text-dark mb-4">Edit Profile</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.profile.update') }}">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Username</label>
                                <input type="text" name="Username" class="form-control" value="{{ old('Username', $user->Username) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="Email" class="form-control" value="{{ old('Email', $user->Email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="text" name="Phone" class="form-control" value="{{ old('Phone', $user->Phone) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Country</label>
                                <input type="text" name="Country" class="form-control" value="{{ old('Country', $user->Country) }}">
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary px-4 me-2"><i class="fa-solid fa-check me-2"></i>Save Changes</button>
                            <a href="{{ route('user.userprofile') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>
</html>
