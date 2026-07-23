<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Voters | E-Voting</title>

    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/OVO.svg') }}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

    <style>
      /* --- BACKGROUND MODERN & ELEGANT --- */
      body {
        font-family: 'Nunito', sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: #f8faff;
        position: relative;
        overflow: hidden;
      }

      body::before,
      body::after {
        content: '';
        position: absolute;
        z-index: -1;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.5;
      }

      body::before {
        width: 700px;
        height: 700px;
        background: linear-gradient(to right, #435ebe, #9543be);
        top: -250px;
        left: -200px;
        animation: floatBubble 20s infinite alternate ease-in-out;
      }

      body::after {
        width: 600px;
        height: 600px;
        background: linear-gradient(to right, #ffc107, #ff8c42);
        bottom: -200px;
        right: -150px;
        animation: floatBubble 15s infinite alternate-reverse ease-in-out;
      }

      @keyframes floatBubble {
        0% {
          transform: translate(0, 0) scale(1);
        }

        100% {
          transform: translate(50px, 50px) scale(1.05);
        }
      }

      /* Navbar & Main Content */
      .simple-navbar {
        padding: 1rem 0;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
      }

      .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 100px;
        padding-bottom: 60px;
      }

      /* Login Card */
      .login-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(67, 94, 190, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 1000px;
        margin: 20px;
        z-index: 1;
      }

      .login-left {
        padding: 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }

      .login-right {
        background: rgba(236, 242, 255, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
      }

      .login-right::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(67, 94, 190, 0.05);
        border-radius: 50%;
        top: -50px;
        right: -50px;
        z-index: 0;
      }

      .login-right img {
        max-width: 100%;
        height: auto;
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.15));
        transition: transform 0.3s ease;
        z-index: 1;
        position: relative;
      }

      .login-right:hover img {
        transform: scale(1.03) translateY(-5px);
      }

      /* Buttons */
      .btn-login {
        border-radius: 50px;
        padding: 0.9rem 2rem;
        font-weight: 700;
        font-size: 1rem;
        background: linear-gradient(135deg, #435ebe 0%, #2a4094 100%);
        border: none;
        box-shadow: 0 10px 20px rgba(67, 94, 190, 0.3);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      }

      .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(67, 94, 190, 0.4);
        background: linear-gradient(135deg, #5672d8 0%, #3451b3 100%);
      }

      .btn-login:disabled {
        background: #6c757d;
        box-shadow: none;
        transform: none;
        cursor: not-allowed;
      }

      /* Clock Badge */
      .clock-badge {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        color: #435ebe;
        font-weight: 700;
        padding: 8px 18px;
        border-radius: 50px;
        border: 1px solid rgba(205, 220, 252, 0.5);
        font-family: 'Courier New', monospace;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      }

      /* Footer */
      footer {
        padding-bottom: 1rem;
        text-align: center;
        font-size: 0.9rem;
        color: #6c757d;
      }

      /* Responsive */
      @media (max-width: 991px) {
        .login-right {
          display: none;
        }

        .login-left {
          padding: 2rem 1.5rem;
        }

        body::before,
        body::after {
          opacity: 0.3;
        }
      }
    </style>
  </head>

  <body>
    <nav class="simple-navbar">
      <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
          @foreach ($config as $data)
            @if ($data->type == 2 && $data->name == 'app_logo')
              @php $path = Storage::url('apps/' . $data->value); @endphp
              <a href="/">
                <img src="{{ $path }}" alt="Logo" style="height: 45px">
              </a>
            @endif
          @endforeach
        </div>
        <div class="clock-wrapper">
          <span class="clock-badge">
            <i class="bi bi-clock me-1"></i> <span id="clock"></span>
          </span>
        </div>
      </div>
    </nav>

    <div class="main-content" id="app">
      <div class="login-card row g-0">
        <div class="col-lg-6 login-left">
          <div class="mb-3 mb-lg-4 text-center">
            <h2 class="fw-bolder text-dark mb-2">Selamat Datang! 👋</h2>
            @foreach ($config as $data)
              @if ($data->type == 0 && $data->value)
                <p class="text-muted lead mb-0 fs-6">Silakan masuk untuk mulai berpartisipasi dalam <span class="text-primary fw-semibold">{{ $data->value }}</span></p>
              @endif
            @endforeach
          </div>

          <div class="flash-data" data-gagal="{{ Session::get('error') }}"></div>
          <div class="flash-data" data-success="{{ Session::get('success') }}"></div>

          <form method="POST" action="{{ route('login.voters') }}" id="loginForm">
            @csrf
            <div class="row gap-3">
              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label class="form-label fw-bold text-primary">Nomor Induk Siswa</label>
                  <div class="position-relative">
                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" placeholder="Masukkan NIS Anda" value="{{ old('nis') }}">
                    <div class="form-control-icon">
                      <i class="bi bi-person-badge"></i>
                    </div>
                  </div>
                  @error('nis')
                    <div class="text-danger small mt-1 ps-3">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label class="form-label fw-bold text-primary">Token Akses</label>
                  <div class="position-relative">
                    <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Token Unik"
                      oninput="this.value = this.value.toUpperCase();" />
                    <div class="form-control-icon">
                      <i class="bi bi-shield-lock-fill"></i>
                    </div>
                  </div>
                  @error('password')
                    <div class="text-danger small mt-1 ps-3">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-12 mt-3">
                <button type="submit" id="btnSubmit" class="btn btn-login btn-primary w-100 text-white">
                  <span id="btnText">Masuk Sekarang <i class="bi bi-arrow-right-circle-fill ms-2"></i></span>
                  <span id="btnLoading" class="d-none">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...
                  </span>
                </button>
              </div>
            </div>
          </form>

          <div class="mt-4 text-center">
            <p class="small text-muted px-3 mb-2">
              <i class="bi bi-info-circle-fill me-1 text-danger"></i>
              Gunakan NIS dan Token yang telah diberikan oleh panitia pemilihan.
            </p>
            <!-- Penambahan Tombol Manual untuk Poster -->
            @if (isset($kandidat) && $kandidat->count() > 0)
              <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-4 fw-bold mt-2" data-bs-toggle="modal" data-bs-target="#modalKandidat">
                <i class="bi bi-image me-1"></i> Lihat Poster Kandidat
              </button>
            @endif
          </div>
        </div>

        <div class="col-lg-6 login-right">
          <div class="text-center">
            <img src="{{ asset('assets/static/images/gif/clip-voting2.gif') }}" alt="Voting Illustration" class="img-fluid rounded-3">
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalKandidat" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
          <div class="modal-header border-0 pb-0">
            <div class="d-flex align-items-center">
              @foreach ($config as $data)
                @if ($data->type == 0)
                  <h5 class="modal-title fw-bold text-primary mb-0">📢 {{ $data->value }}</h5>
                @endif
              @endforeach
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <div class="row g-4 justify-content-center">
              @foreach ($config as $data)
                @if ($data->type == 2 && $data->name == 'poster')
                  <div class="col-12 col-md-10">
                    <div class="card border-0 shadow-sm overflow-hidden rounded-4">
                      @php $path = Storage::url('apps/' . $data->value); @endphp
                      <img src="{{ url($path) }}" class="img-fluid" alt="Poster Pengumuman">
                    </div>
                  </div>
                @endif
              @endforeach
            </div>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Mengerti & Tutup</button>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <div class="container">
        <p class="mb-0">{{ Date('Y') }} &copy; Online Voting. Crafted with <i class="bi bi-heart-fill text-danger mx-1"></i> by PPA</p>
      </div>
    </footer>

    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>

    {{-- Script Custom --}}
    <script>
      // Jam Realtime
      function updateClock() {
        const now = new Date();
        const options = {
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit',
          hour12: false
        };
        const formattedTime = now.toLocaleTimeString('id-ID', options);
        const dateStr = now.toLocaleDateString('id-ID', {
          weekday: 'short',
          day: 'numeric',
          month: 'short'
        });

        document.getElementById('clock').innerHTML = `<span class="small fw-normal text-primary me-1">${dateStr}</span> ${formattedTime}`;
      }
      setInterval(updateClock, 1000);
      updateClock();

      $(document).ready(function() {
        // Efek loading form untuk mencegah double click/spam saat server lambat
        $('#loginForm').on('submit', function() {
          $('#btnSubmit').prop('disabled', true);
          $('#btnText').addClass('d-none');
          $('#btnLoading').removeClass('d-none');
        });

        // Flash Data Error (SweetAlert)
        const gagal = $('.flash-data').data('gagal');
        const success = $('.flash-data').data('success');
        if (gagal) {
          Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak',
            html: gagal,
            confirmButtonColor: '#435ebe',
            confirmButtonText: 'Coba Lagi',
            buttonsStyling: false,
            customClass: {
              confirmButton: 'btn btn-primary rounded-pill px-4'
            }
          });
        }
        if (success) {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            html: success,
            confirmButtonColor: '#435ebe',
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: {
              confirmButton: 'btn btn-primary rounded-pill px-4'
            }
          });
        }
      });
    </script>
  </body>

</html>
