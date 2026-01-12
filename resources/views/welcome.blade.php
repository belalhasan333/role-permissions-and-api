<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Optional: Google Fonts - Instrument Sans (close match to original) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --bs-body-bg: #fdfdfc;
            --bs-body-color: #1b1b18;
            --primary-accent: #f53003;
            --primary-accent-dark: #f61500;
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #0a0a0a;
            --bs-body-color: #ededec;
        }

        body {
            font-family: 'Instrument Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
        }

        .btn-accent {
            background-color: #1b1b18;
            border-color: #1b1b18;
            color: white;
        }

        .btn-accent:hover {
            background-color: black;
            border-color: black;
        }

        .text-accent {
            color: var(--primary-accent);
        }

        .dark .text-accent {
            color: var(--primary-accent-dark);
        }

        .card-left {
            background: white;
            border: 1px solid #e3e3e0;
        }

        .dark .card-left {
            background: #161615;
            border-color: #3e3e3a;
            color: #ededec;
        }

        .illustration-bg {
            background: #fff2f2;
        }

        .dark .illustration-bg {
            background: #1d0002;
        }

        .timeline-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #fdfdfc;
            border: 1px solid #e3e3e0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .dark .timeline-dot {
            background: #161615;
            border-color: #3e3e3a;
        }

        .timeline-dot-inner {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #dbdbd7;
        }

        .dark .timeline-dot-inner {
            background: #3e3e3a;
        }

        .timeline-line {
            position: absolute;
            left: 6.5px;
            width: 1px;
            background: #e3e3e0;
            height: 100%;
        }

        .dark .timeline-line {
            background: #3e3e3a;
        }

        @media (min-width: 992px) {
            .card-left {
                border-top-left-radius: 0.5rem !important;
                border-bottom-left-radius: 0.5rem !important;
                border-top-right-radius: 0 !important;
            }

            .illustration-side {
                border-top-right-radius: 0.5rem !important;
                border-bottom-right-radius: 0.5rem !important;
                border-bottom-left-radius: 0 !important;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100 p-4 p-lg-5">

    <!-- Top right auth links -->
    @if (Route::has('login'))
        <header class="container-xl mb-4">
            <nav class="d-flex justify-content-end gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-outline-dark px-4 py-2">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary px-4 py-2">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-dark px-4 py-2">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        </header>
    @endif

    <main class="flex-grow-1 d-flex align-items-center">
        <div class="container-xl">
            <div class="row g-0 rounded overflow-hidden shadow" style="max-width: 1100px; margin: 0 auto;">

                <!-- Left - Content -->
                <div class="col-lg-7 card-left p-4 p-lg-5">

                    <h1 class="mb-3 fw-medium fs-3">Let's get started</h1>

                    <p class="text-secondary mb-4" style="font-size: 0.95rem;">
                        Laravel has an incredibly rich ecosystem.<br>
                        We suggest starting with the following.
                    </p>

                    <ul class="list-unstyled mb-4 position-relative ps-4">
                        <!-- Timeline line -->
                        <div class="timeline-line" style="top:1.6rem; bottom:1.6rem;"></div>

                        <li class="d-flex align-items-center gap-3 py-2 position-relative">
                            <div class="timeline-dot">
                                <div class="timeline-dot-inner"></div>
                            </div>
                            <div>
                                Read the
                                <a href="https://laravel.com/docs" target="_blank"
                                    class="text-accent text-decoration-underline text-decoration-underline-offset">
                                    Documentation <i class="bi bi-arrow-up-right ms-1" style="font-size:0.8rem;"></i>
                                </a>
                            </div>
                        </li>

                        <li class="d-flex align-items-center gap-3 py-2 position-relative">
                            <div class="timeline-dot">
                                <div class="timeline-dot-inner"></div>
                            </div>
                            <div>
                                Watch video tutorials at
                                <a href="https://laracasts.com" target="_blank"
                                    class="text-accent text-decoration-underline text-decoration-underline-offset">
                                    Laracasts <i class="bi bi-arrow-up-right ms-1" style="font-size:0.8rem;"></i>
                                </a>
                            </div>
                        </li>
                    </ul>

                    <div>
                        <a href="https://cloud.laravel.com" target="_blank" class="btn btn-accent px-4 py-2 fw-medium">
                            Deploy now
                        </a>
                    </div>

                </div>

                <!-- Right - Illustration -->
                <div class="col-lg-5 illustration-bg d-flex align-items-center justify-content-center p-4 p-lg-5">

                    <!-- You can keep your original SVG here -->
                    <!-- For demo I'm using placeholder text + Bootstrap icon -->
                    <div class="text-center">
                        <i class="bi bi-laravel display-1 text-accent mb-4 d-block"
                            style="font-size: 8rem; opacity: 0.9;"></i>
                        <div class="h3 fw-bold text-accent">Laravel</div>
                    </div>

                    <!--
                        Paste your original colorful SVG here if you want to keep it
                        <svg class="w-100" viewBox="0 0 438 104" ... > ... your SVG paths ... </svg>
                    -->

                </div>

            </div>
        </div>
    </main>

    <!-- Bootstrap JS + Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</body>

</html>
