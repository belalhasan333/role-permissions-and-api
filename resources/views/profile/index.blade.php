@extends('master')

@section('content')
    <div class="pagetitle">
        <h1>Profile</h1>
    </div>

    <section class="section profile">
        <div class="row">
            {{-- Toastr Notification Script --}}
            @push('styles')
                <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
            @endpush
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

                        @if (session('info'))
                            toastr.info("{{ session('info') }}", 'Info', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 3500
                            });
                        @endif

                        @if (session('warning'))
                            toastr.warning("{{ session('warning') }}", 'Warning', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 3500
                            });
                        @endif
                    });
                </script>
            @endpush

            {{-- LEFT COLUMN: PROFILE IMAGE --}}
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <div class="position-relative mb-4">
                            {{-- Profile Image --}}
                            <img id="mainProfilePreview"
                                src="{{ $user->profile_image ? asset('storage/profile/' . $user->profile_image) : asset('Backend/assets/images/faces/face15.jpg') }}"
                                alt="Profile" class="rounded-circle shadow" width="150" height="150"
                                style="object-fit: cover;">

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
                                @if ($user->profile_image)
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
                                    <img id="overviewProfileImg"
                                        src="{{ $user->profile_image ? asset('storage/profile/' . $user->profile_image) : asset('Backend/assets/images/faces/face15.jpg') }}"
                                        alt="Profile" class="rounded-circle shadow" width="140" height="140"
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
                                    <div class="mb-3"><label>Name</label><input type="text" class="form-control"
                                            name="name" value="{{ $user->name }}"></div>
                                    <div class="mb-3"><label>Email</label><input type="email" class="form-control"
                                            name="email" value="{{ $user->email }}"></div>
                                    <div class="mb-3"><label>Phone</label><input type="text" class="form-control"
                                            name="phone" value="{{ $user->phone }}"></div>
                                    <div class="mb-3"><label>Company</label><input type="text" class="form-control"
                                            name="company" value="{{ $user->company }}"></div>
                                    <div class="mb-3"><label>Job</label><input type="text" class="form-control"
                                            name="job" value="{{ $user->job }}"></div>
                                    <div class="mb-3"><label>Country</label><input type="text" class="form-control"
                                            name="country" value="{{ $user->country }}"></div>
                                    <div class="mb-3"><label>Address</label>
                                        <textarea class="form-control" name="address">{{ $user->address }}</textarea>
                                    </div>
                                    <div class="mb-3"><label>About</label>
                                        <textarea class="form-control" name="about">{{ $user->about }}</textarea>
                                    </div>
                                    <button class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>

                            {{-- CHANGE PASSWORD TAB --}}
                            <div class="tab-pane fade" id="password">
                                <form method="POST" action="{{ route('profile.password') }}">
                                    @csrf
                                    <div class="mb-3"><label>Current Password</label><input type="password"
                                            name="current_password" class="form-control"></div>
                                    <div class="mb-3"><label>New Password</label><input type="password" name="password"
                                            class="form-control"></div>
                                    <div class="mb-3"><label>Confirm New Password</label><input type="password"
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

@section('scripts')
    <script>
        function previewAndUpload(input) {
            const file = input.files[0];
            if (!file) return;

            // Preview
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('mainProfilePreview').src = e.target.result;
                let overviewImg = document.getElementById('overviewProfileImg');
                if (overviewImg) overviewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Ajax upload
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
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.profile_image_url) {
                        document.getElementById('mainProfilePreview').src = data.profile_image_url + '?t=' + Date.now();
                        let overviewImg = document.getElementById('overviewProfileImg');
                        if (overviewImg) overviewImg.src = data.profile_image_url + '?t=' + Date.now();
                        toastr.success('Profile image updated!', 'Success');
                    } else {
                        toastr.error('Could not update image.', 'Error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('Error uploading image.', 'Error');
                });
        }

        function deleteProfileImage() {
            if (!confirm('Delete this photo?')) return;

            fetch("{{ route('profile.image.delete') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE',
                        'Accept': 'application/json'
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('mainProfilePreview').src =
                            "{{ asset('Backend/assets/images/faces/face15.jpg') }}";
                        let overviewImg = document.getElementById('overviewProfileImg');
                        if (overviewImg) overviewImg.src = "{{ asset('Backend/assets/images/faces/face15.jpg') }}";
                        toastr.success('Profile image deleted!', 'Success');
                    } else {
                        toastr.error('Could not delete image.', 'Error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('Could not delete image.', 'Error');
                });
        }
    </script>
@endsection
