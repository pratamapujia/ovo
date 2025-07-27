<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/OVO.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app.css') }}">
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
  </head>

  <body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
      <div id="sidebar">
        <div class="sidebar-wrapper active">
          <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
              <div class="logo">
                <a href="index.html"><img src="{{ asset('assets/static/images/logo/icon2.svg') }}" alt="Logo" srcset=""></a>
              </div>
              <div class="sidebar-toggler  x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
              </div>
            </div>
          </div>
          @include('admin.layouts.menu')
        </div>
      </div>
      <div id="main" class="layout-navbar navbar-fixed">
        <header>
          <nav class="navbar navbar-expand navbar-light navbar-top">
            <div class="container-fluid">
              <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
              </a>

              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="dropdown ms-auto">
                  <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                      <div class="user-name text-end me-3">
                        <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                        <p class="mb-0 text-sm text-gray-600">Administrator</p>
                      </div>
                      <div class="user-img d-flex align-items-center">
                        <div class="avatar avatar-md">
                          <img src="{{ asset('assets/static/images/faces/1.jpg') }}" />
                        </div>
                      </div>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                    <li>
                      <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}</h6>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('logoutadmin') }}"><i class="icon-mid bi bi-box-arrow-left me-2" style="color: red"></i>
                        Logout</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </nav>
        </header>

        @yield('content')

        <footer>
          <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
              <p>{{ Date('Y') }} &copy; ovo</p>
            </div>
            <div class="float-end">
              <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://github.com/pratamapujia">Riyan</a></p>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/my.js') }}"></script>
    @yield('script')

  </body>

</html>
