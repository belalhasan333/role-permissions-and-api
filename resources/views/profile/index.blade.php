@extends('master')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endpush

@section('content')
    <div class="pagetitle">
        <h1>Profile</h1>
    </div>

    <section class="section profile">
        <div class="row">

            {{-- LEFT COLUMN: PROFILE IMAGE --}}
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <div class="position-relative mb-4">
                            {{-- Profile Image --}}
                            @php
                                use Illuminate\Support\Facades\Storage;

                                // Always check for the actual user's image and show it if available, otherwise fallback
                             $profileImgSrc =
                             $user->profile_photo &&
                             Storage::disk('public')->exists('profile/' . $user->profile_photo)
                             ? asset('storage/profile/' . $user->profile_photo)
                             : asset('backend/assets/images/faces/face15.jpg');
                            @endphp
                            <img id="mainProfilePreview" src="{{ $profileImgSrc }}" alt="Profile"
                                class="rounded-circle shadow" width="150" height="150" style="object-fit: cover;">

                            {{-- Upload & Delete Buttons --}}
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                {{-- UPLOAD --}}
                                <form id="uploadProfileForm" action="{{ route('profile.image.update') }}" method="POST"
                                    enctype="multipart/form-data" class="d-inline">
                                    @csrf
                                    <label for="profile_image_upload" class="btn btn-primary btn-sm rounded-pill px-4 py-2"
                                        style="cursor: pointer;">
                                        <i class="bi bi-upload me-1"></i> Change
                                    </label>
                                    <input type="file" id="profile_image_upload" name="profile_image" accept="image/*"
                                        style="display: none;" onchange="previewAndUpload(this);">
                                </form>

                                {{-- DELETE --}}
                                @if ($user->profile_photo && Storage::disk('public')->exists('profile/' . $user->profile_photo))
                                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-4 py-2"
                                        onclick="deleteProfileImage();">
                                        <i class="bi bi-trash me-1"></i> Remove
                                    </button>
                                @endif
                            </div>
                        </div>

                        <h2>{{ $user->name }}</h2>
                        <h3>{{ $user->job ?? 'Web Developer' }}</h3>

                        <div class="social-links mt-2">
                            <a href="{{ $user->twitter ?? '#' }}" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="{{ $user->facebook ?? '#' }}" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="{{ $user->instagram ?? '#' }}" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="{{ $user->linkedin ?? '#' }}" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: PROFILE DETAILS --}}
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">

                        {{-- TABS --}}
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#overview">Overview</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit">Edit
                                    Profile</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#password">Change Password</button></li>
                        </ul>

                        <div class="tab-content pt-2">

                            {{-- OVERVIEW TAB --}}
                            <div class="tab-pane fade show active" id="overview">
                                <h5 class="card-title mt-3">Profile Image</h5>
                                <div class="text-center mb-4">
                                    {{-- Display uploaded image or fallback --}}
                                    <img id="overviewProfileImg" src="{{ $profileImgSrc }}" alt="Profile"
                                        class="rounded-circle shadow" width="140" height="140"
                                        style="object-fit: cover;">
                                </div>

                                <h5 class="card-title">Profile Details</h5>
                                <div class="row mb-1">
                                    <div class="col-lg-3 fw-bold">Full Name</div>
                                    <div class="col-lg-9">{{ $user->name }}</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-lg-3 fw-bold">Email</div>
                                    <div class="col-lg-9">{{ $user->email }}</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-lg-3 fw-bold">Phone</div>
                                    <div class="col-lg-9">{{ $user->phone ?? '-' }}</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-lg-3 fw-bold">Company</div>
                                    <div class="col-lg-9">{{ $user->company ?? '-' }}</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-lg-3 fw-bold">Job</div>
                                    <div class="col-lg-9">{{ $user->job ?? '-' }}</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-lg-3 fw-bold">Country</div>
                                    <div class="col-lg-9">{{ $user->country ?? '-' }}</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-lg-3 fw-bold">Address</div>
                                    <div class="col-lg-9">{{ $user->address ?? '-' }}</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-lg-3 fw-bold">About</div>
                                    <div class="col-lg-9">{{ $user->about ?? 'No bio yet' }}</div>
                                </div>
                            </div>

                            {{-- EDIT PROFILE TAB --}}
                            <div class="tab-pane fade" id="edit">
                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    <div class="mb-3"><label for="name">Name</label><input type="text"
                                            class="form-control" id="name" name="name"
                                            value="{{ old('name', $user->name) }}"></div>
                                    <div class="mb-3"><label for="email">Email</label><input type="email"
                                            class="form-control" id="email" name="email"
                                            value="{{ old('email', $user->email) }}"></div>
                                    <div class="mb-3"><label for="phone">Phone</label><input type="text"
                                            class="form-control" id="phone" name="phone"
                                            value="{{ old('phone', $user->phone) }}"></div>
                                    <div class="mb-3"><label for="company">Company</label><input type="text"
                                            class="form-control" id="company" name="company"
                                            value="{{ old('company', $user->company) }}"></div>
                                    <div class="mb-3"><label for="job">Job</label><input type="text"
                                            class="form-control" id="job" name="job"
                                            value="{{ old('job', $user->job) }}"></div>
                                    <div class="mb-3"><label for="country">Country</label><input type="text"
                                            class="form-control" id="country" name="country"
                                            value="{{ old('country', $user->country) }}"></div>
                                    <div class="mb-3"><label for="address">Address</label>
                                        <textarea class="form-control" id="address" name="address">{{ old('address', $user->address) }}</textarea>
                                    </div>
                                    <div class="mb-3"><label for="about">About</label>
                                        <textarea class="form-control" id="about" name="about">{{ old('about', $user->about) }}</textarea>
                                    </div>
                                    <button class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>

                            {{-- CHANGE PASSWORD TAB --}}
                            <div class="tab-pane fade" id="password">
                                <form method="POST" action="{{ route('profile.password') }}">
                                    @csrf
                                    <div class="mb-3"><label for="current_password">Current Password</label><input
                                            type="password" id="current_password" name="current_password"
                                            class="form-control"></div>
                                    <div class="mb-3"><label for="password">New Password</label><input type="password"
                                            id="password" name="password" class="form-control"></div>
                                    <div class="mb-3"><label for="password_confirmation">Confirm New
                                            Password</label><input type="password" id="password_confirmation"
                                            name="password_confirmation" class="form-control"></div>
                                    <button class="btn btn-warning">Change Password</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}", 'Success', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3500
                });
            @endif
            @if (session('error'))
                toastr.error("{{ session('error') }}", 'Error', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3500
                });
            @endif
        });

        function previewAndUpload(input) {
            const file = input.files[0];
            if (!file) return;

            // Preview image for instant user feedback
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('mainProfilePreview').src = e.target.result;
                const overviewImg = document.getElementById('overviewProfileImg');
                if (overviewImg) overviewImg.src = e.target.result;
                // Update navbar and sidebar images instantly
                const navbarImg = document.getElementById('navbarProfileImg');
                if (navbarImg) navbarImg.src = e.target.result;
                const sidebarImg = document.getElementById('sidebarProfileImg');
                if (sidebarImg) sidebarImg.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Upload via AJAX and update image with new URL so always shows the latest uploaded file
            const formData = new FormData();
            formData.append('profile_image', file);

            fetch("{{ route('profile.image.update') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(resp => resp.json())
                .then(data => {
                    if (data.success && data.profile_photo_url) {
                        // When the upload is successful, set the new URL with a timestamp to prevent cache
                        let newImgUrl = data.profile_photo_url + '?t=' + Date.now();
                        document.getElementById('mainProfilePreview').src = newImgUrl;
                        const overviewImg = document.getElementById('overviewProfileImg');
                        if (overviewImg) overviewImg.src = newImgUrl;
                        // Update navbar and sidebar images
                        const navbarImg = document.getElementById('navbarProfileImg');
                        if (navbarImg) navbarImg.src = newImgUrl;
                        const sidebarImg = document.getElementById('sidebarProfileImg');
                        if (sidebarImg) sidebarImg.src = newImgUrl;
                        toastr.success('Profile image updated!', 'Success');
                    } else {
                        toastr.error('Could not update image.', 'Error');
                    }
                })
                .catch(() => toastr.error('Error uploading image.', 'Error'));
        }

        function deleteProfileImage() {
            if (!confirm('Delete this photo?')) return;

            fetch("{{ route('profile.image.delete') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE',
                        'Accept': 'application/json'
                    }
                })
                .then(resp => resp.json())
                .then(data => {
                    if (data.success) {
                        // Revert to fallback image after delete
                        const defaultImg = "{{ asset('backend/assets/images/faces/face15.jpg') }}";
                        document.getElementById('mainProfilePreview').src = defaultImg;
                        const overviewImg = document.getElementById('overviewProfileImg');
                        if (overviewImg) overviewImg.src = defaultImg;
                        // Update navbar and sidebar images
                        const navbarImg = document.getElementById('navbarProfileImg');
                        if (navbarImg) navbarImg.src = defaultImg;
                        const sidebarImg = document.getElementById('sidebarProfileImg');
                        if (sidebarImg) sidebarImg.src = defaultImg;
                        toastr.success('Profile image deleted!', 'Success');
                    } else {
                        toastr.error('Could not delete image.', 'Error');
                    }
                })
                .catch(() => toastr.error('Could not delete image.', 'Error'));
        }
    </script>
@endpush
