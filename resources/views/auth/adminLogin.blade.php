<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin</title>

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
        /* Base background yang lembut */
        background: #f8faff;
        position: relative;
        overflow: hidden;
        /* Mencegah scrollbar horizontal karena elemen background */
      }

      /* Membuat elemen background "Aurora" yang bercahaya */
      body::before,
      body::after {
        content: '';
        position: absolute;
        z-index: -1;
        /* Tempatkan di belakang konten */
        border-radius: 50%;
        filter: blur(120px);
        /* Efek blur yang sangat kuat untuk kelembutan */
        opacity: 0.5;
        /* Transparansi agar tidak terlalu mencolok */
      }

      /* Cahaya di pojok kiri atas (Warna Biru/Ungu) */
      body::before {
        width: 700px;
        height: 700px;
        background: linear-gradient(to right, #435ebe, #9543be);
        top: -250px;
        left: -200px;
        animation: floatBubble 20s infinite alternate ease-in-out;
      }

      /* Cahaya di pojok kanan bawah (Warna Hangat/Kuning) */
      body::after {
        width: 600px;
        height: 600px;
        background: linear-gradient(to right, #ffc107, #ff8c42);
        bottom: -200px;
        right: -150px;
        animation: floatBubble 15s infinite alternate-reverse ease-in-out;
      }

      /* Animasi halus agar background terasa hidup */
      @keyframes floatBubble {
        0% {
          transform: translate(0, 0) scale(1);
        }

        100% {
          transform: translate(50px, 50px) scale(1.05);
        }
      }

      /* --- END BACKGROUND --- */


      /* Navbar dengan efek kaca */
      .simple-navbar {
        padding: 1rem 0;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
      }

      /* Container Utama */
      .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 100px;
        padding-bottom: 60px;
      }

      /* Kartu Login dengan efek Glassmorphism */
      .login-card {
        /* Mengubah warna solid menjadi putih transparan */
        background: rgba(255, 255, 255, 0.85);
        /* Menambahkan efek blur pada background di belakang kartu */
        backdrop-filter: blur(24px);
        /* Border tipis semi-transparan untuk mempertegas tepi kaca */
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 24px;
        /* Shadow yang lebih lembut dan luas untuk kesan melayang */
        box-shadow: 0 20px 60px rgba(67, 94, 190, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 1000px;
        margin: 20px;
        z-index: 1;
        /* Pastikan di atas elemen background */
      }

      .login-left {
        padding: 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }

      .login-right {
        /* Background sisi kanan dibuat sedikit lebih transparan agar menyatu */
        background: rgba(236, 242, 255, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
      }

      /* Hiasan tambahan di sisi kanan */
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

      .btn-login {
        border-radius: 50px;
        padding: 0.9rem 2rem;
        font-weight: 700;
        font-size: 1rem;
        /* Gradient yang lebih kaya */
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

      /* Clock Badge Modern */
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
          /* Kurangi intensitas background di HP */
        }
      }
    </style>
  </head>

  <body>
    <nav class="simple-navbar">
      <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
          <a href="/">
            <img src="{{ asset('assets/static/images/logo/icon2.svg') }}" alt="Logo" style="height: 45px">
          </a>
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
          <div class="mb-3 mb-lg-5 text-center">
            <h2 class="fw-bolder text-dark mb-2">Selamat Datang! 👋</h2>
            <p class="text-muted lead mb-0 fs-6">Halaman login untuk admin</p>
          </div>

          <div class="flash-data" data-gagal="{{ Session::get('error') }}"></div>

          <form method="POST" action="{{ route('login.admin') }}">
            @csrf
            <div class="row gap-3">
              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label class="form-label fw-bold text-primary">Email</label>
                  <div class="position-relative">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email admin" value="{{ old('email') }}">
                    <div class="form-control-icon">
                      <i class="bi bi-at"></i>
                    </div>
                  </div>
                  @error('email')
                    <div class="text-danger small mt-1 ps-3">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label class="form-label fw-bold text-primary">Password</label>
                  <div class="position-relative">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" />
                    <div class="form-control-icon">
                      <i class="bi bi-lock"></i>
                    </div>
                  </div>
                  @error('password')
                    <div class="text-danger small mt-1 ps-3">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-12 mt-2 mt-lg-5">
                <button type="submit" class="btn btn-login btn-primary w-100 text-white">
                  Masuk Sekarang <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                </button>
              </div>
            </div>
          </form>
        </div>

        <div class="col-lg-6 login-right">
          <div class="text-center">
            <img src="{{ asset('assets/static/images/gif/clip-voting2.gif') }}" alt="Voting Illustration" class="img-fluid rounded-3">
          </div>
        </div>
      </div>
    </div>

    <footer>
      <div class="container">
        <p class="mb-0">{{ Date('Y') }} &copy; E-Voting System. Crafted with <i class="bi bi-heart-fill text-danger mx-1"></i> by PPA</p>
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

      // Cek Modal
      $(document).ready(function() {
        // Flash Data Error (SweetAlert)
        const flashData = $('.flash-data').data('gagal');
        if (flashData) {
          Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak',
            html: flashData,
            confirmButtonColor: '#435ebe',
            confirmButtonText: 'Coba Lagi',
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
