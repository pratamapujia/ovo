<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/icon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}" />
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
  </head>

  <body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="auth">
      <div class="row justify-content-center ">
        <div class="col-lg-4 col-12 mt-5">
          <div id="auth-center">
            <div class="text-center mb-5">
              <a href="index.html"><img src="{{ asset('assets/static/images/logo/icon2.svg') }}" alt="Logo" width="200"></a>
            </div>
            <h1 class="text-center">Login Admin.</h1>
            @if (Session::get('error'))
              <div class="alert alert-danger alert-dismissible show fade">
                <i class="fas fa-triangle-exclamation"></i> {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            <form action="{{ route('login.admin') }}" method="POST" class="p-4">
              @csrf
              <div class="form-group position-relative has-icon-left mb-4">
                <input type="email" name="email" class="form-control form-control-xl" placeholder="Email">
                <div class="form-control-icon">
                  <i class="bi bi-at"></i>
                </div>
              </div>
              <div class="form-group position-relative has-icon-left mb-4">
                <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                <div class="form-control-icon">
                  <i class="bi bi-key-fill"></i>
                </div>
              </div>
              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-2">Masuk</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
  </body>

</html>
