<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Page</title>
    <link rel="shortcut icon" href="assets/static/images/logo/OVO.svg" type="image/x-icon">
    <link rel="stylesheet" crossorigin href="{{ asset('assets') }}/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    <style>
      .p-scroll {
        max-height: 5em;
        overflow-y: auto;
        line-height: 1.5em;
      }
    </style>
  </head>

  <body>
    <script src="assets/static/js/initTheme.js"></script>
    <nav class="navbar navbar-light sticky-top" style="background-color: #F2F7FF">
      <div class="container-fluid">
        <img src="{{ asset('assets/static/images/logo/icon2.svg') }}" alt="Logo" style="height: 40px">
        {{-- <button onclick="window.print()" class="btn btn-primary">Print</button> --}}
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        @foreach ($pemilih as $d)
          <div class="col-3">
            <div class="card border border-primary">
              <div class="card-content">
                <div class="card-body">
                  <div class="card-title">
                    <div class="row">
                      <div class="col-12">
                        <h6>{{ $d->nama_pemilih }}</h6>
                      </div>
                      <div class="col-12">
                        <small>Kelas : {{ $d->kelas->nama_kelas }}</small>
                      </div>
                    </div>
                  </div>
                  <div class="card-text">
                    <div class="row">
                      <div class="col-5">
                        <p class="subtitle">NIS : {{ $d->nis }}</p>
                      </div>
                      <div class="col-7">
                        <p>Token : <span class="badge bg-light-primary">{{ $d->token }}</span></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <footer>
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
    <script src="{{ asset('assets') }}/compiled/js/app.js"></script>
  </body>

</html>
