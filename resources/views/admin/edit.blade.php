@extends('layouts.app') {{-- Use your template layout --}}

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Admin Profile</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                            @if($admin->profile_photo)
                                <img src="{{ asset('storage/' . $admin->profile_photo) }}" alt="Admin Image" class="rounded-circle img-thumbnail" width="120" height="120" style="object-fit: cover;">
                            @else
                                <img src="{{ asset('default-avatar.png') }}" alt="Default" class="rounded-circle img-thumbnail" width="120" height="120">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mobile_no" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile', $admin->mobile) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $admin->city) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $admin->state) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pincode" class="form-label">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" value="{{ old('pincode', $admin->pincode) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $admin->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>
@endsection