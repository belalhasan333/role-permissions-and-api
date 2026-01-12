<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forgot Password</title>

    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/assets/css/style.css') }}">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">

                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">

                            <h3 class="card-title mb-3">Forgot Password</h3>

                            @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email"
                                        class="form-control p_input @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    Send Password Reset Link
                                </button>

                                <p class="text-center mt-3">
                                    <a href="{{ route('login') }}">Back to Login</a>
                                </p>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('Backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>
</body>

</html>
