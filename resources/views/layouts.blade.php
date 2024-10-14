<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <style>
        .nav-link:hover {
            color: #61de6dd7 !important;
        }
    </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link rel="icon" href="{{ asset('assets/images/graha.png') }}" type="image/x-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- cdn fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">


</head>

<body class="index-page">

    <header id="header" class="header fixed-top">
        <div class="topbar d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center">
                        <a href="mailto:useryesa9@gmail.com">useryesa9@gmail.com</a>
                    </i>
                    <i class="bi bi-phone d-flex align-items-center ms-4"><span>+62 858-1011-6384</span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    <a href="https://www.instagram.com/nullablenone/" class="instagram"><i
                            class="bi bi-instagram"></i></a>
                    <a href="https://www.linkedin.com/in/muhamad-yesa/" class="linkedin"><i
                            class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="branding d-flex align-items-center">
            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="{{ route('polling.create') }}" class="logo d-flex align-items-center">
                    <h1 class="sitename">ngepolling</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{ route('polling.create') }}" class="nav-link">Beranda<br></a></li>
                        <li><a href="{{ route('polling.tentang') }}" class="nav-link">Tentang</a></li>
                        <li><a href="{{ route('polling.create') }}" class="nav-link">Buat Polling</a></li>
                        <li><a href="{{ route('polling.pollingTerbaru') }}" class="nav-link">Polling Terbaru</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

            </div>
        </div>
    </header>


    <main class="main">
        <br>
        <br>
        <br>
        <br>
        @yield('content')
    </main>
    <br>
    <br>
    <br>

    <footer id="footer" class="footer accent-background">

        <div class="container footer-top">
            <div class="row gy-4 justify-content-between">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="{{ route('polling.create') }}" class="logo d-flex align-items-center">
                        <span class="sitename">ngepolling</span>
                    </a>
                    <p>Website polling ini dirancang untuk memudahkan pengguna dalam memberikan suara dan berpartisipasi
                        dalam berbagai polling.</p>
                    <div class="social-links d-flex mt-4">
                        <a href="https://www.instagram.com/nullablenone/"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/muhamad-yesa/"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>


                <div class="col-lg-2 col-6 footer-links">
                    <h4>Link Cepat</h4>
                    <ul>
                        <li><a href="{{ route('polling.create') }}">Beranda</a></li>
                        <li><a href="{{ route('polling.tentang') }}">Tentang</a></li>
                        <li><a href="{{ route('polling.create') }}">Buat Polling</a></li>
                        <li><a href="{{ route('polling.pollingTerbaru') }}">Polling Terbaru</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Kontak</h4>
                    <p class="mt-4"><strong>Phone:</strong> <span>+62 858-1011-6384</span></p>
                    <p><strong>Email:</strong> <span>useryesa9@gmail.com</span></p>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">nullablenone</strong> <span>All Rights
                    Reserved</span>
            </p>
            <div class="credits">
                Designed by <a href="https://bootstrapmade.com/">nullablenone</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>



</body>

</html>
