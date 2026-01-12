<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/css/vendor.bundle.base.css') }}">

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('Backend/assets/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">

                            <h3 class="card-title text-left mb-3">Register</h3>

                            {{-- ✅ Laravel Default Register Form --}}
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                {{-- Name --}}
                                <div class="form-group">
                                    <label>Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control p_input @error('name') is-invalid @enderror" required
                                        autofocus>
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control p_input @error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input type="password" name="password"
                                        class="form-control p_input @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="form-group">
                                    <label>Confirm Password *</label>
                                    <input type="password" name="password_confirmation" class="form-control p_input"
                                        required>
                                </div>

                                {{-- Submit --}}
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block enter-btn">
                                        Register
                                    </button>
                                </div>

                                {{-- Login Link --}}
                                <p class="sign-up text-center mt-3">
                                    Already have an account?
                                    <a href="{{ route('login') }}"> Login</a>
                                </p>

                            </form>
                            {{-- ✅ End Register Form --}}
                            <div class="d-flex mt-3">
                                <a href="{{ url('/auth/facebook') }}" class="btn btn-facebook col mr-2">
                                    <i class="mdi mdi-facebook"></i> Facebook
                                </a>

                                <a href="{{ url('/auth/google') }}" class="btn btn-google col">
                                    <i class="mdi mdi-google-plus"></i> Google
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor JS -->
    <script src="{{ asset('Backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/misc.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/settings.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/todolist.js') }}"></script>

</body>

</html>
