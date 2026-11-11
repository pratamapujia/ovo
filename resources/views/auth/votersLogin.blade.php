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

      .login-right img {
        max-width: 100%;
        height: auto;
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.15));
        transition: transform 0.3s ease;
        z-index: 1;
      }

      .login-right:hover img {
        transform: scale(1.03) translateY(-5px);
      }

      /* Style untuk Toggle Switch Login Mode */
      .login-mode-toggle {
        background-color: #f1f5f9;
        border-radius: 50px;
        padding: 0.35rem;
        display: inline-flex;
        margin-bottom: 1.5rem;
      }

      .btn-toggle-mode {
        border-radius: 50px !important;
        padding: 0.5rem 1.5rem;
        font-weight: 700;
        font-size: 0.9rem;
        border: none;
        color: #64748b;
        background: transparent;
        transition: all 0.3s ease;
      }

      .btn-toggle-mode.active {
        background-color: #435ebe;
        color: white;
        box-shadow: 0 4px 10px rgba(67, 94, 190, 0.3);
      }

      /* Style Khusus Pembungkus Kamera */
      #reader {
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
      }

      /* Menyembunyikan elemen link bawaan library di dalam canvas */
      #reader a {
        display: none !important;
      }

      .btn-login {
        border-radius: 50px;
        padding: 0.9rem 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #435ebe 0%, #2a4094 100%);
        border: none;
        box-shadow: 0 10px 20px rgba(67, 94, 190, 0.3);
        transition: all 0.3s ease;
      }

      .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(67, 94, 190, 0.4);
      }

      .clock-badge {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        color: #435ebe;
        font-weight: 700;
        border-radius: 50px;
        border: 1px solid rgba(205, 220, 252, 0.5);
        padding: clamp(4px, 1vw, 8px) clamp(12px, 2vw, 18px);
      }

      @media (max-width: 991px) {
        .login-right {
          display: none;
        }

        .login-left {
          padding: 2rem 1.5rem;
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
              <a href="/"><img src="{{ $data->value == null ? asset('assets/static/images/logo/icon2.svg') : $path }}" alt="Logo" style="height: 64px"></a>
            @endif
          @endforeach
        </div>
        <div class="clock-wrapper">
          <span class="clock-badge"><i class="bi bi-clock me-1"></i> <span id="clock"></span></span>
        </div>
      </div>
    </nav>

    <div class="main-content" id="app">
      <div class="login-card row g-0">
        <div class="col-lg-6 login-left">

          <div class="text-center">
            <h2 class="fw-bolder text-dark mb-2">Selamat Datang! 👋</h2>
            <p class="text-muted small px-3 mb-4">Silakan masuk untuk mulai berpartisipasi dalam </br> <span class="text-primary fw-bold">{{ $config[0]->value }}</span> </p>

            <!-- Toggle Switch Login Mode -->
            <div class="login-mode-toggle shadow-sm">
              <button type="button" class="btn btn-toggle-mode active" id="btnModeScan">
                <i class="bi bi-qr-code-scan me-1"></i> Scan QR
              </button>
              <button type="button" class="btn btn-toggle-mode" id="btnModeManual">
                <i class="bi bi-keyboard me-1"></i> Manual
              </button>
            </div>
          </div>

          <div class="flash-data" data-gagal="{{ Session::get('error') }}" data-success="{{ Session::get('success') }}" data-voted="{{ Session::get('voted') }}"></div>

          <!-- AREA 1: SCANNER QR -->
          <div id="areaScanQR" class="text-center px-lg-3">
            <div class="position-relative mx-auto shadow-sm" style="max-width: 300px;">
              <!-- Container Kamera -->
              <div id="reader"></div>
            </div>
            <p class="mt-3 small text-primary fw-bold mb-0">Arahkan Kartu QR Code ke Kamera Laptop</p>
            <p class="text-muted small mt-1" style="font-size: 0.8rem;">Sistem akan memproses login secara otomatis.</p>
          </div>

          <!-- AREA 2: FORM MANUAL (Disembunyikan secara default) -->
          <div id="areaManual" class="d-none">
            <form method="POST" action="{{ route('login.voters') }}" id="loginForm">
              @csrf
              <div class="row gap-3">
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label class="form-label fw-bold text-primary">Nomor Induk Siswa</label>
                    <div class="position-relative">
                      <input type="text" name="nis" id="inputNis" class="form-control @error('nis') is-invalid @enderror" placeholder="Masukkan NIS Anda" value="{{ old('nis') }}">
                      <div class="form-control-icon"><i class="bi bi-person-badge"></i></div>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label class="form-label fw-bold text-primary">Token Akses</label>
                    <div class="position-relative">
                      <input type="text" name="password" id="inputPassword" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Token Unik"
                        oninput="this.value = this.value.toUpperCase();" />
                      <div class="form-control-icon"><i class="bi bi-shield-lock-fill"></i></div>
                    </div>
                  </div>
                </div>

                <div class="col-12 mt-2">
                  <button type="submit" id="btnSubmit" class="btn btn-login btn-primary w-100 text-white">
                    <span id="btnText">Masuk Sekarang</span>
                    <span id="btnLoading" class="d-none"><span class="spinner-border spinner-border-sm me-2"></span> Memproses...</span>
                  </button>
                </div>
              </div>
            </form>
          </div>

          <!-- Tombol Lihat Poster -->
          <div class="mt-4 text-center">
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

    <!-- Modal Notifikasi Sudah Memilih -->
    <div class="modal fade" id="modalSudahMemilih" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <!-- Menggunakan efek glassmorphism yang senada dengan tema -->
        <div class="modal-content rounded-4 border-0 shadow-lg text-center" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
          <div class="modal-header border-0 pb-0 justify-content-end">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4 pt-0">
            <!-- Icon/Ilustrasi -->
            <div class="mb-4">
              <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: rgba(67, 94, 190, 0.1); color: #435ebe;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                  <path fill-rule="evenodd"
                    d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z" />
                </svg>
              </div>
            </div>

            <h4 class="fw-bolder text-dark mb-3">Hak Suara Telah Digunakan! 🎉</h4>
            <p class="text-muted mb-0 px-2">
              Terima kasih atas partisipasi Anda. Sistem kami mencatat bahwa Anda <strong>sudah melakukan pemilihan</strong>. Setiap pemilih hanya dapat menggunakan hak suaranya satu kali untuk
              menjaga transparansi data.
            </p>
          </div>
          <div class="modal-footer border-0 justify-content-center pb-4 mt-2">
            <!-- Tombol senada dengan btn-login -->
            <button type="button" class="btn btn-login btn-primary rounded-pill px-5 fw-bold text-white" data-bs-dismiss="modal">
              Mengerti & Kembali
            </button>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <div class="container text-center py-3">
        <p class="mb-0">{{ Date('Y') }} &copy; Online Voting. Crafted with <i class="bi bi-heart-fill text-danger mx-1"></i> by PPA</p>
      </div>
    </footer>

    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>

    {{-- Script Custom --}}
    <!-- LIBRARY HTML5 QR CODE -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
      let html5QrCode;

      $(document).ready(function() {
        // --- LOGIKA SCANNER QR ---
        function startScanner() {
          // Inisialisasi library secara manual agar tampilannya bersih
          html5QrCode = new Html5Qrcode("reader");

          const config = {
            fps: 10,
            qrbox: {
              width: 200,
              height: 200
            }
          };

          // Memulai scanner (facingMode: user untuk kamera depan/laptop)
          html5QrCode.start({
              facingMode: "user"
            }, config, onScanSuccess)
            .catch((err) => {
              console.error("Camera Error:", err);
              Swal.fire({
                icon: 'warning',
                title: 'Kamera Tidak Ditemukan',
                text: 'Pastikan Anda telah memberikan izin akses kamera pada browser. Mengalihkan ke mode manual...',
                confirmButtonColor: '#435ebe'
              }).then(() => {
                switchToManual();
              });
            });
        }

        function stopScanner() {
          if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop().catch(err => console.error("Gagal menghentikan scanner", err));
          }
        }

        function onScanSuccess(decodedText) {
          stopScanner(); // Matikan kamera sesaat setelah terbaca

          // Asumsi format QR adalah "NIS:TOKEN" (contoh: "123456:ABCD12")
          const dataQR = decodedText.split(':');

          if (dataQR.length === 2) {
            Swal.fire({
              title: 'QR Code Terbaca!',
              html: 'Memproses login otomatis...',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });

            // Isi form manual yang disembunyikan
            $('#inputNis').val(dataQR[0]);
            $('#inputPassword').val(dataQR[1]);

            // Submit form
            $('#loginForm').submit();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Format QR Tidak Valid',
              text: 'QR Code yang dipindai tidak dikenali oleh sistem.',
              confirmButtonText: 'Coba Lagi',
              confirmButtonColor: '#435ebe'
            }).then(() => {
              startScanner(); // Hidupkan kamera lagi jika gagal
            });
          }
        }

        // --- LOGIKA TOGGLE UI ---
        function switchToManual() {
          stopScanner();
          $('#btnModeScan').removeClass('active');
          $('#btnModeManual').addClass('active');
          $('#areaScanQR').addClass('d-none');
          $('#areaManual').removeClass('d-none');
        }

        function switchToScan() {
          $('#btnModeManual').removeClass('active');
          $('#btnModeScan').addClass('active');
          $('#areaManual').addClass('d-none');
          $('#areaScanQR').removeClass('d-none');
          startScanner();
        }

        $('#btnModeManual').click(switchToManual);
        $('#btnModeScan').click(switchToScan);

        // Mulai kamera otomatis saat halaman dimuat
        startScanner();


        // (Logika bawaan jam dan flash message SweetAlert tetap jalan)
        $('#loginForm').on('submit', function() {
          $('#btnSubmit').prop('disabled', true);
          $('#btnText').addClass('d-none');
          $('#btnLoading').removeClass('d-none');
        });

        const gagal = $('.flash-data').data('gagal');
        if (gagal) {
          Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak',
            html: gagal,
            confirmButtonColor: '#435ebe'
          });
        }
      });
    </script>
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
          weekday: 'long',
          day: 'numeric',
          month: 'long'
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
        // Cek apakah ada session 'voted' (sudah memilih)
        const voted = $('.flash-data').data('voted');
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
            toast: true,
            position: 'top',
            icon: 'success',
            title: success,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
        }
        if (voted) {
          // Menampilkan modal Bootstrap dengan opsi statis agar fokus dibaca
          var modalVoted = new bootstrap.Modal(document.getElementById('modalSudahMemilih'), {
            keyboard: false,
            backdrop: 'static'
          });
          modalVoted.show();
        }
      });
    </script>
  </body>

</html>
