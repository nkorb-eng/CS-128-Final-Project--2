@extends('extend.app')

@include('extend.navHead')

@section('content')

<div class="container border border-5 rounded-3" style="margin-top: 160px">
    <form action="" method="POST">
        @csrf
        <H2>Contact Info</H2>
        <div class="mb-3">
            <label class="form-label fw-semibold">Full Name</label>
            <input type="text" name="Name" class="form-control" placeholder="Enter full name" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email Address</label>
            <input type="email" name="Email" class="form-control" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Phone Number</label>
            <input type="text" name="Phone" class="form-control" placeholder="+855 123 456 789" required>
        </div>
        <div class="text-center pb-3">
            <button type="submit" class="btn btn-success px-5 py-2 fw-bold">Submit</button>
        </div>
    </form>
</div>

@endsection