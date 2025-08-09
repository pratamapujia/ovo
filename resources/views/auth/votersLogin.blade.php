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
                @foreach ($config as $data)
                  @if ($data->type == 2)
                    @php
                      $path = Storage::url('apps/' . $data->value);
                    @endphp
                    @if ($data->value)
                      <a href="/">
                        <img src="{{ $path }}" alt="Logo" style="height: 40px">
                      </a>
                    @endif
                  @endif
                @endforeach
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
                <div class="col-lg-5 col-12 pt-md-5 mb-5 text-lg-center text-md-start">
                  <h3 class="text-uppercase">Selamat Datang Voters</h3>
                  @foreach ($config as $data)
                    @if ($data->type == 0)
                      @if ($data->value)
                        <h5>Mari Kita Sukseskan {{ $data->value }}</h5>
                      @endif
                    @endif
                  @endforeach
                  <div class="flash-data" data-gagal="{{ Session::get('error') }}"></div>
                  <form method="POST" action="{{ route('login.voters') }}" class="mt-5">
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
                      <p class="pt-2"><span class="text-danger">*Pastikan voters sudah mendapat <b>NIS</b> dan <b>Token</b> dari panitia</span></p>
                    </div>
                  </form>
                </div>
                <div class="col-lg-7 col-12 d-flex">
                  <div class="m-auto">
                    <img src="{{ asset('assets/static/images/bg/clip-voting2.gif') }}" alt="GIF" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Modal Kandidat --}}
        <div class="modal fade" id="modalKandidat" tabindex="-1" aria-labelledby="modalKandidatLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalKandidatLabel">📜 Para Calon Ketua dan Wakil OSIS 📜</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="container-fluid">
                  <div class="row gy-4">
                    {{-- Lakukan perulangan untuk setiap data calon --}}
                    @forelse ($kandidat as $data)
                      <div class="col-md-3 col-lg">
                        <div class="card h-100">
                          @php
                            $path = Storage::url('kandidat/' . $data->foto_kandidat);
                          @endphp
                          <img src="{{ url($path) }}" class="card-img-top" alt="Foto {{ $data->nama_kandidat }}" style="height: 300px; object-fit: cover;">
                          <div class="card-body text-center">
                            <h5 class="card-title">{{ $data->nama_kandidat }}</h5>
                            <p class="card-text text-muted">"{!! $data->visi !!}"</p>
                            <p class="card-text text-muted">"{!! $data->misi !!}"</p>
                          </div>
                        </div>
                      </div>
                    @empty
                      <div class="col-12 text-center">
                        <p class="text-danger">Belum ada data calon yang tersedia saat ini.</p>
                      </div>
                    @endforelse
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
                  by <a href="https://github.com/shofwanhadif">Shofwan</a></p>
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

      $(document).ready(function() {
        // Cek apakah ada data calon sebelum menampilkan modal
        @if (isset($kandidat) && $kandidat->count() > 0)
          $('#modalKandidat').modal('show');
        @endif
      });
    </script>
  </body>

</html>
