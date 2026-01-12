<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password</title>

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

                            <h3 class="card-title mb-3">Reset Password</h3>

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email"
                                        class="form-control p_input @error('email') is-invalid @enderror"
                                        value="{{ $email ?? old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>New Password *</label>
                                    <input type="password" name="password"
                                        class="form-control p_input @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password *</label>
                                    <input type="password" name="password_confirmation" class="form-control p_input"
                                        required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    Reset Password
                                </button>

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
