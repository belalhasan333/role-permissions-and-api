@extends('master')

@section('content')
    <div class="pagetitle">
        <h1>Profile</h1>
    </div>

    <section class="section profile">
        <div class="row">

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <div class="position-relative mb-4">
                            <img id="mainProfilePreview"
                                src="{{ $user->profile_image ? asset('storage/profile/' . $user->profile_image) : asset('Backend/assets/images/faces/face15.jpg') }}"
                                alt="Profile" class="rounded-circle shadow" width="150" height="150"
                                style="object-fit: cover;">

                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <!-- Upload -->
                                <form action="{{ route('profile.image.update') }}" method="POST"
                                    enctype="multipart/form-data" class="d-inline">
                                    @csrf
                                    <label for="profile_image_upload" class="btn btn-primary btn-sm rounded-pill px-4 py-2"
                                        title="Change Profile Photo" style="cursor: pointer;">
                                        <i class="bi bi-upload me-1"></i> Change
                                    </label>
                                    <input type="file" id="profile_image_upload" name="profile_image" accept="image/*"
                                        style="display: none;"
                                        onchange="previewImage(this, 'mainProfilePreview'); this.form.submit();">
                                </form>

                                @if ($user->profile_image)
                                    <!-- Delete -->
                                    <form action="{{ route('profile.image.delete') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4 py-2"
                                            title="Remove Photo" onclick="return confirm('Delete this photo?');">
                                            <i class="bi bi-trash me-1"></i> Remove
                                        </button>
                                    </form>
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

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">

                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#overview">Overview</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit">Edit
                                    Profile</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#password">Change Password</button></li>
                        </ul>

                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active" id="overview">
                                <h5 class="card-title mt-3">Profile Image</h5>
                                <div class="text-center mb-4">
                                    <img src="{{ $user->profile_image ? asset('storage/profile/' . $user->profile_image) : asset('Backend/assets/images/faces/face15.jpg') }}"
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

                            {{-- EDIT PROFILE --}}
                            <div class="tab-pane fade" id="edit">
                                <form method="POST" action="{{ route('profile.update') }}"
                                    enctype="multipart/form-data">
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

                            {{-- CHANGE PASSWORD --}}
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
        function previewImage(input, targetIds) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const ids = Array.isArray(targetIds) ? targetIds : [targetIds];
                    ids.forEach(id => {
                        const img = document.getElementById(id);
                        if (img) img.src = e.target.result;
                    });
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
