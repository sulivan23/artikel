<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ webInfo('JUDUL_WEB') }} - {{ $title }}</title>

  @yield('meta')

  <!-- Favicons -->
  <link href="{{ url('img/web/'.webInfo('FAVICON')) }}" rel="icon">
  <link href="{{ url('herobiz') }}/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('herobiz') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ url('herobiz') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ url('herobiz') }}/vendor/aos/aos.css" rel="stylesheet">
  <link href="{{ url('herobiz') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="{{ url('herobiz') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Variables CSS Files. Uncomment your preferred color scheme -->
  <link href="{{ url('herobiz') }}/css/variables-blue.css" rel="stylesheet">
  <!-- <link href="{{ url('herobiz') }}/css/variables-blue.css" rel="stylesheet"> -->
  <!-- <link href="{{ url('herobiz') }}/css/variables-green.css" rel="stylesheet"> -->
  <!-- <link href="{{ url('herobiz') }}/css/variables-orange.css" rel="stylesheet"> -->
  <!-- <link href="{{ url('herobiz') }}/css/variables-purple.css" rel="stylesheet"> -->
  <!-- <link href="{{ url('herobiz') }}/css/variables-red.css" rel="stylesheet"> -->
  <!-- <link href="{{ url('herobiz') }}/css/variables-pink.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="{{ url('herobiz') }}/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- =======================================================
  * Template Name: HeroBiz - v2.1.0
  * Template URL: https://bootstrapmade.com/herobiz-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="{{ url('') }}" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ url('img/web/'.webInfo('LOGO')) }}" alt="" style="width:50px;height:50px;">
        <h1>{{ webInfo('JUDUL_WEB') }}<span>.</span></h1>
      </a>

      <form action="{{ route('logout') }}" method="POST">
      @csrf
      <nav id="navbar" class="navbar">
        <ul>

          <li class="dropdown"><a href="{{ url('') }}"><span>Home</span></a>
          </li>
          <li class="dropdown"><a href="#"><span>Kategori</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              @foreach(category('1') as $catOne)
                @php $child = categoryByParent($catOne->category_id) @endphp
                @if($child->count() == 0) 
                <li>
                  <a href="{{ url('category/'.$catOne->category_name) }}">{{ $catOne->category_name }}</a>
                </li>
                @else
                  <li class="dropdown"><a href="{{ url('category/'.$catOne->category_name) }}"><span>{{ $catOne->category_name }}</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                      @foreach(category('2') as $catSec)
                        <ul>
                        @if($catSec->parent_category_id == $catOne->category_id)
                            @if(categoryByParent($catSec->category_id)->count() == 0)
                              <li><a href="{{ url('category/'.$catSec->category_name) }}">{{ $catSec->category_name }}</a></li>
                            @else
                              <li class="dropdown"><a href="{{ url('category/'.$catSec->category_name) }}"><span>{{ $catSec->category_name }}</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                                <ul>
                                  @foreach(category('3') as $catThird)
                                    @if($catThird->parent_category_id == $catSec->category_id)
                                      <li><a href="#">{{ $catThird->category_name }}</a></li>
                                    @endif
                                  @endforeach
                                </ul>
                              </li>
                            @endif
                        @endif
                        </ul>
                      @endforeach
                  </li>
                @endif
              @endforeach
               {{-- <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                </ul>
              </li> --}}
            </ul>
          </li>
          <li>
            <a class="nav-link scrollto" href="{{ url('home') }}">Dashboard</a>
          </li>
          @if(auth()->check())
          <li>
            <button class="nav-link scrollto btn btn-link">Logout</button>
          </li>
          @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle d-none"></i>
      </nav><!-- .navbar -->
      </form>

      @if(auth()->check() == false)
        <a class="btn-getstarted scrollto" href="{{ url('login') }}">Login</a>
      @else 
        <div class="">
          <img src="{{ url('img/user/'.auth()->user()->photo) }}" class="rounded-circle" style="height:30px;width:30px;">
          {{ auth()->user()->name }}
        </div>
      @endif

    </div>
  </header><!-- End Header -->

  @yield('content')

    <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-legal text-center">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div class="copyright">
            Copyright &copy; <strong><span>{{ webInfo('JUDUL_WEB')." ". date('Y') }}</span></strong>. All Rights Reserved.
          </div>
          <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
          </div>
        </div>

        <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
          <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>

      </div>
    </div>

  </footer><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ url('herobiz') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{ url('herobiz') }}/vendor/aos/aos.js"></script>
  <script src="{{ url('herobiz') }}/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="{{ url('herobiz') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="{{ url('herobiz') }}/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="{{ url('herobiz') }}/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="{{ url('herobiz') }}/js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/fontawesome.min.js" integrity="sha512-5qbIAL4qJ/FSsWfIq5Pd0qbqoZpk5NcUVeAAREV2Li4EKzyJDEGlADHhHOSSCw0tHP7z3Q4hNHJXa81P92borQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</body>

</html>