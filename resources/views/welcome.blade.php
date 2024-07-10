@extends('layouts.app')
@section('content')

<!-- ======= Hero Section ======= -->
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>Shuffle Bootstrap Template - Index</title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="{{asset('assets/img/favicon.png')}}" rel="icon">
<link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{asset('assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
<link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="{{asset('assets/css/style1.css')}}" rel="stylesheet">

</head>
  <section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">

          <!-- Slide 1 -->
          <div class="carousel-item active" style="background-image: url(assets/img/slide/slide-1.jpg);">
            @if (Route::has('login'))
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">Leave Management System</h2>
                <p class="animate__animated animate__fadeInUp">Effortless leave management, empowered productivity.</p>
                @auth
                    <a href="{{ url('/home') }}" class="btn-get-started animate__animated animate__fadeInUp scrollto">Login</a>
                    {{-- <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a> --}}
                @else
                    <a href="{{ route('login') }}" class="btn-get-started animate__animated animate__fadeInUp scrollto">Login</a>
                @endauth
              </div>
            </div>
            @endif
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item" style="background-image: url(assets/img/slide/slide-2.jpg);">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">LMS</h2>
                <p class="animate__animated animate__fadeInUp">Empowering your team with seamless leave management, one day at a time.</p>
                <a href="{{ route('login') }}" class="btn-get-started animate__animated animate__fadeInUp scrollto">Login</a>
              </div>
            </div>
          </div>
        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-double-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-double-right" aria-hidden="true"></span>
        </a>

      </div>
    </div>
  </section>
  <!-- End Hero -->
        </div>
          <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
@endsection

