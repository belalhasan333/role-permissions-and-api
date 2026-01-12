<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>

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

                            <h3 class="card-title text-left mb-3">Login</h3>

                            {{-- ✅ Laravel Default Login Form --}}
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Email --}}
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control p_input @error('email') is-invalid @enderror" required
                                        autofocus>

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

                                {{-- Remember Me --}}
                                <div class="form-group d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="remember" class="form-check-input"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            Remember me
                                        </label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forgot-pass">
                                            Forgot password
                                        </a>
                                    @endif
                                </div>

                                {{-- Submit --}}
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block enter-btn">
                                        Login
                                    </button>
                                </div>

                            </form>
                            {{-- ✅ End Login Form --}}

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
