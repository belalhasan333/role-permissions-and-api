<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Email Verification</title>

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
                    <div class="card col-lg-5 mx-auto">
                        <div class="card-body px-5 py-5">

                            <h3 class="card-title text-left mb-3">
                                Verify Your Email Address
                            </h3>

                            {{-- Success message --}}
                            @if (session('resent'))
                                <div class="alert alert-success">
                                    A fresh verification link has been sent to your email address.
                                </div>
                            @endif

                            <p class="mb-3">
                                Before proceeding, please check your email for a verification link.
                            </p>

                            <p>
                                If you did not receive the email,
                            </p>

                            {{-- ✅ Laravel Default Verification Resend --}}
                            <form method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0">
                                    Click here to request another
                                </button>
                            </form>

                            <hr>

                            <div class="text-center mt-3">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="btn btn-outline-danger btn-sm">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
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
