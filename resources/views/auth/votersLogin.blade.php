<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Voters</title>

    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/OVO.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    <style>
      .header-top {
        background-color: #F2F7FF !important;
      }
    </style>
  </head>

  <body>
    <div id="app">
      <div id="main" class="layout-horizontal">
        <nav>
          <div class="header-top">
            <div class="container">
              <div class="logo">
                <a href="/"><img src="{{ asset('assets/static/images/logo/icon2.svg') }}" alt="Logo" style="height: 40px" /></a>
              </div>
              <div class="user-menu d-flex">
                <div class="user-name text-end me-3">
                  <h6 class="mb-0 text-gray-600">
                    <span class="badge bg-primary">
                      <div id="clock"></div>
                    </span>
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </nav>

        <div class="content-wrapper container m-auto">
          <div class="page-content">
            <div class="container">
              <div class="row mb-5">
                <div class="col-5 pt-md-5 mb-3 text-center text-md-start">
                  <h3 class="text-uppercase">Selamat Datang "Voters"</h3>
                  @foreach ($config as $data)
                    @if ($data->type == 0)
                      @if ($data->value)
                        <h5>Mari Kita Sukseskan {{ $data->value }}</h5>
                      @endif
                    @endif
                  @endforeach
                  <div class="flash-data" data-gagal="{{ Session::get('error') }}"></div>
                  <form method="POST" action="{{ route('login.voters') }}" class="mt-3">
                    @csrf
                    <div class="row">
                      <h5 class="text-center">Masuk untuk mulai memilih</h5>
                      <div class="col-6">
                        <div class="form-group position-relative has-icon-left">
                          <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" placeholder="Masukkan NIS" value="{{ old('nis') }}">
                          <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                          </div>
                          @error('nis')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group position-relative has-icon-left">
                          <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Token"
                            oninput="this.value = this.value.toUpperCase();" />
                          <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                          </div>
                          @error('password')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                      </div>
                      <p class="pt-2"><small class="text-danger">*Pastikan voters sudah mendapat token dari panitia</small></p>
                    </div>
                  </form>
                </div>
                <div class="col-7 d-flex">
                  <div class="m-auto">
                    <img src="{{ asset('assets/static/images/bg/clip-voting.gif') }}" alt="GIF" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer class="fixed-bottom">
          <div class="container">
            <div class="footer clearfix mb-0 text-muted">
              <div class="float-start">
                <p>{{ Date('Y') }} &copy; Online Voting</p>
              </div>
              <div class="float-end">
                <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                  by <a href="https://ahmadsaugi.com">Saugi</a> Develop Apps by <a href="https://github.com/shofwanhadif">Shofwan</a></p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/my.js') }}"></script>
    <script>
      function updateClock() {
        const now = new Date();
        const options = {
          year: 'numeric',
          month: '2-digit',
          day: '2-digit',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit',
          hour12: false
        };
        const formattedTime = now.toLocaleString('id-ID', options);
        document.getElementById('clock').innerText = formattedTime;
      }

      setInterval(updateClock, 1000);
      updateClock();
    </script>
  </body>

</html>
