<!DOCTYPE html>
<html lang="id">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#f8faff" />
    <title>Login Voters | E-Voting</title>

    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/OVO.svg') }}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

    <style>
      /* =========================================================
         0. BASE & KOMPATIBILITAS BROWSER
         ========================================================= */
      html {
        -webkit-text-size-adjust: 100%;
        -moz-text-size-adjust: 100%;
        text-size-adjust: 100%;
      }

      body {
        --blob-a: clamp(320px, 55vw, 700px);
        --blob-b: clamp(280px, 48vw, 600px);

        font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        min-height: 100vh;
        min-height: 100dvh; /* HP: tidak terpengaruh address-bar yang naik-turun */
        display: flex;
        flex-direction: column;
        background: #f8faff;
        position: relative;
        /* DULU "overflow: hidden" -> halaman tidak bisa di-scroll di layar pendek.
           Sekarang hanya sumbu X yang dikunci, scroll vertikal tetap jalan. */
        overflow-x: hidden;
      }

      /* =========================================================
         1. BACKGROUND MODERN & ELEGANT
         ========================================================= */
      body::before,
      body::after {
        content: '';
        /* fixed (bukan absolute) -> blob tidak melebarkan halaman,
           penyebab layar HP otomatis "zoom-out" dan navbar terpotong */
        position: fixed;
        z-index: -1;
        border-radius: 50%;
        -webkit-filter: blur(120px);
        filter: blur(120px);
        opacity: 0.5;
        pointer-events: none;
        will-change: transform;
      }

      body::before {
        width: var(--blob-a);
        height: var(--blob-a);
        background: linear-gradient(to right, #435ebe, #9543be);
        top: calc(var(--blob-a) * -0.36);
        left: calc(var(--blob-a) * -0.29);
        animation: floatBubble 20s infinite alternate ease-in-out;
      }

      body::after {
        width: var(--blob-b);
        height: var(--blob-b);
        background: linear-gradient(to right, #ffc107, #ff8c42);
        bottom: calc(var(--blob-b) * -0.33);
        right: calc(var(--blob-b) * -0.25);
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

      /* =========================================================
         2. NAVBAR
         ========================================================= */
      .simple-navbar {
        /* DULU position: fixed + padding-top 100px "tebakan" di konten.
           Sekarang ikut alur halaman -> tidak menimpa konten & hemat tinggi layar. */
        position: relative;
        z-index: 1000;
        width: 100%;
        padding: 0.75rem 0;
        flex-shrink: 0;
      }

      .simple-navbar .container {
        flex-wrap: nowrap;
        gap: 0.75rem;
      }

      .simple-navbar .logo {
        flex: 0 1 auto;
        min-width: 0;
      }

      .brand-logo {
        display: block;
        height: 64px;
        width: auto;
        max-width: 100%;
        object-fit: contain;
      }

      .clock-wrapper {
        flex: 0 1 auto;
        min-width: 0;
        margin-left: auto; /* tetap di kanan walau logo tidak ada */
      }

      .clock-badge {
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
        background: rgba(255, 255, 255, 0.7);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        color: #435ebe;
        font-weight: 700;
        font-size: clamp(0.78rem, 0.7rem + 0.5vw, 1rem);
        border-radius: 50px;
        border: 1px solid rgba(205, 220, 252, 0.5);
        padding: 4px 12px;
        padding: clamp(4px, 1vw, 8px) clamp(12px, 2vw, 18px);
      }

      /* =========================================================
         3. KONTEN & KARTU LOGIN
         ========================================================= */
      .main-content {
        flex: 1 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 1rem 1.5rem;
      }

      .login-card {
        background: rgba(255, 255, 255, 0.85);
        -webkit-backdrop-filter: blur(24px);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(67, 94, 190, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 1000px;
        min-width: 0;
        margin: 0 auto;
        z-index: 1;
      }

      .login-left {
        padding: 1.5rem;
        padding: clamp(1.25rem, 4vw, 3.5rem);
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
      }

      .welcome-title {
        font-size: 1.6rem;
        font-size: clamp(1.4rem, 1.1rem + 1.2vw, 2rem);
        line-height: 1.25;
        margin-bottom: 0.5rem;
      }

      .welcome-sub {
        margin-bottom: 1.5rem;
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
        max-height: 60vh; /* ilustrasi tidak lagi memaksa kartu jadi tinggi */
        object-fit: contain;
        -webkit-filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.15));
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.15));
        transition: transform 0.3s ease;
        z-index: 1;
      }

      /* Style untuk Toggle Switch Login Mode */
      .login-mode-toggle {
        background-color: #f1f5f9;
        border-radius: 50px;
        padding: 0.35rem;
        display: inline-flex;
        max-width: 100%;
        margin-bottom: 1.5rem;
      }

      .btn-toggle-mode {
        border-radius: 50px !important;
        padding: 0.5rem 1rem;
        padding: 0.5rem clamp(0.9rem, 4vw, 1.5rem);
        font-weight: 700;
        font-size: 0.9rem;
        white-space: nowrap;
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

      /* Pembungkus Kamera: ukurannya mengikuti TINGGI layar,
         jadi di laptop 1366x768 tidak lagi mendorong konten keluar layar */
      .scan-box {
        width: 100%;
        max-width: 300px;
        max-width: clamp(200px, 40vh, 300px);
        margin-left: auto;
        margin-right: auto;
      }

      #reader {
        width: 100%;
        min-height: 150px;
        border-radius: 16px;
        overflow: hidden;
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
      }

      #reader video {
        display: block;
        max-width: 100%;
        height: auto;
      }

      /* Menyembunyikan elemen link bawaan library di dalam canvas */
      #reader a {
        display: none !important;
      }

      .poster-wrap {
        margin-top: 1.5rem;
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

      /* Modal dengan efek kaca (sebelumnya inline style tanpa prefix -webkit => polos di Safari) */
      .glass-modal {
        background: rgba(255, 255, 255, 0.95);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
      }

      footer {
        flex-shrink: 0;
      }

      .footer-inner {
        padding-top: 1rem;
        padding-bottom: 1rem;
      }

      /* Aksesibilitas: fokus keyboard terlihat jelas */
      .btn-toggle-mode:focus-visible,
      .btn-login:focus-visible {
        outline: 3px solid rgba(67, 94, 190, 0.45);
        outline-offset: 2px;
      }

      /* Efek hover hanya untuk perangkat yang benar-benar punya mouse
         (di layar sentuh efek hover suka "menempel" setelah ditap) */
      @media (hover: hover) {
        .login-right:hover img {
          transform: scale(1.03) translateY(-5px);
        }

        .btn-login:hover {
          transform: translateY(-3px);
          box-shadow: 0 15px 30px rgba(67, 94, 190, 0.4);
        }
      }

      /* =========================================================
         4. RESPONSIVE: TABLET & HP
         (991.98px, bukan 991px, supaya tidak ada "celah" di lebar pecahan
          saat browser di-zoom)
         ========================================================= */
      @media (max-width: 991.98px) {
        .login-right {
          display: none;
        }

        /* Satu kolom: batasi lebar kartu supaya tidak melar di tablet */
        .login-card {
          max-width: 560px;
        }

        /* iOS Safari otomatis zoom saat input < 16px */
        #loginForm .form-control {
          font-size: 16px;
        }
      }

      @media (max-width: 767.98px) {
        .brand-logo {
          height: 48px;
        }
      }

      @media (max-width: 575.98px) {
        .simple-navbar {
          padding: 0.5rem 0;
        }

        .brand-logo {
          height: 40px;
        }

        /* Di HP hanya tampil jam; tanggal disembunyikan supaya navbar muat 1 baris */
        .clock-date {
          display: none;
        }

        .main-content {
          padding: 0.5rem 0.75rem 1rem;
        }

        .login-card {
          border-radius: 20px;
        }

        .btn-login {
          padding: 0.8rem 1.5rem;
        }

        /* blur besar + animasi berat di HP kelas menengah/bawah */
        body::before,
        body::after {
          -webkit-filter: blur(70px);
          filter: blur(70px);
        }
      }

      /* =========================================================
         5. LAYAR PENDEK (laptop 1366x768, Windows scaling 125%, HP landscape)
         ========================================================= */
      @media (max-height: 800px) {
        .simple-navbar {
          padding: 0.5rem 0;
        }

        .brand-logo {
          height: 48px;
        }

        .main-content {
          padding-top: 0.5rem;
          padding-bottom: 1rem;
        }

        .login-left {
          padding-top: 1.5rem;
          padding-bottom: 1.5rem;
        }

        .welcome-title {
          font-size: 1.5rem;
          margin-bottom: 0.25rem;
        }

        .welcome-sub {
          margin-bottom: 0.75rem;
        }

        .login-mode-toggle {
          margin-bottom: 0.75rem;
        }

        .scan-box {
          max-width: 240px;
          max-width: clamp(180px, 34vh, 260px);
        }

        .scan-hint-sub {
          display: none;
        }

        .poster-wrap {
          margin-top: 0.75rem;
        }

        /* Mode Manual: jarak antar field dirapatkan agar form juga muat tanpa scroll */
        #loginForm .row {
          gap: 0.625rem !important;
        }

        .login-right {
          padding: 1rem;
        }

        .login-right img {
          max-height: 48vh;
        }

        .footer-inner {
          padding-top: 0.5rem;
          padding-bottom: 0.5rem;
        }
      }

      @media (max-height: 800px) and (max-width: 767.98px) {
        .brand-logo {
          height: 40px;
        }
      }

      /* =========================================================
         6. PREFERENSI PENGGUNA & FALLBACK BROWSER LAMA
         ========================================================= */
      @media (prefers-reduced-motion: reduce) {
        body::before,
        body::after {
          animation: none;
        }

        .login-right img,
        .btn-login,
        .btn-toggle-mode {
          transition: none;
        }
      }

      /* Browser tanpa backdrop-filter (Firefox lama, dll): pakai latar lebih pekat agar teks tetap terbaca */
      @supports not ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
        .login-card {
          background: rgba(255, 255, 255, 0.96);
        }

        .clock-badge {
          background: rgba(255, 255, 255, 0.95);
        }

        .glass-modal {
          background: rgba(255, 255, 255, 0.99);
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
              <a href="/"><img src="{{ $data->value == null ? asset('assets/static/images/logo/icon2.svg') : $path }}" alt="Logo" class="brand-logo"></a>
            @endif
          @endforeach
        </div>
        <div class="clock-wrapper">
          <span class="clock-badge"><span id="clock"></span></span>
        </div>
      </div>
    </nav>

    <div class="main-content" id="app">
      <div class="login-card row g-0">
        <div class="col-lg-6 login-left">

          <div class="text-center">
            <h2 class="welcome-title fw-bolder text-dark">Selamat Datang! 👋</h2>
            <p class="welcome-sub text-muted small px-lg-3">Silakan masuk untuk mulai berpartisipasi dalam <br> <span class="text-primary fw-bold">{{ $config[0]->value }}</span> </p>

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
            <div class="scan-box position-relative mx-auto shadow-sm">
              <!-- Container Kamera -->
              <div id="reader"></div>
            </div>
            <p class="scan-hint mt-3 small text-primary fw-bold mb-0">Arahkan Kartu QR Code ke Kamera</p>
            <p class="scan-hint-sub text-muted small mt-1" style="font-size: 0.8rem;">Sistem akan memproses login secara otomatis.</p>
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
          <div class="poster-wrap text-center">
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
        <div class="modal-content glass-modal rounded-4 border-0 shadow-lg">
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
          <div class="modal-body p-3 p-md-4">
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
        <div class="modal-content glass-modal rounded-4 border-0 shadow-lg text-center">
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
      <div class="container text-center footer-inner">
        <p class="mb-0">{{ Date('Y') }} &copy; Online Voting. Crafted with <i class="bi bi-heart-fill text-danger mx-1"></i> by PPA</p>
      </div>
    </footer>

    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>

    {{-- Script Custom --}}
    <!-- LIBRARY HTML5 QR CODE -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" type="text/javascript"></script>

    <script>
      let html5QrCode;

      $(document).ready(function() {
        // --- LOGIKA SCANNER QR ---
        // Layar sentuh (HP/tablet) -> kamera belakang; laptop/PC -> webcam.
        // Jika perangkat tidak punya kamera belakang, browser otomatis memakai kamera yang tersedia.
        const isTouchDevice = window.matchMedia && window.matchMedia('(pointer: coarse)').matches;
        let lastReaderWidth = 0;

        function startScanner() {
          // Library QR gagal dimuat (CDN diblokir / offline) -> langsung ke mode manual
          if (typeof Html5Qrcode === 'undefined') {
            switchToManual();
            return;
          }

          // Inisialisasi library secara manual agar tampilannya bersih
          html5QrCode = new Html5Qrcode("reader");
          lastReaderWidth = document.getElementById('reader').clientWidth;

          const config = {
            fps: 10,
            // Kotak scan = 70% sisi terpendek video, jadi selalu muat di layar kecil maupun besar
            // (sebelumnya tetap 200px sehingga bisa lebih besar dari kamera di HP kecil)
            qrbox: function(viewfinderWidth, viewfinderHeight) {
              const size = Math.floor(Math.min(viewfinderWidth, viewfinderHeight) * 0.7);
              return {
                width: size,
                height: size
              };
            }
          };

          // Memulai scanner
          html5QrCode.start({
              facingMode: isTouchDevice ? "environment" : "user"
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

        // HP diputar / jendela diubah ukurannya: library mengunci lebar video saat kamera dimulai,
        // jadi kamera dimulai ulang supaya tampilannya pas lagi.
        let resizeTimer;
        $(window).on('resize orientationchange', function() {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(function() {
            if (!html5QrCode || !html5QrCode.isScanning) return;
            const w = document.getElementById('reader').clientWidth;
            if (Math.abs(w - lastReaderWidth) < 30) return; // abaikan perubahan kecil (mis. address-bar HP naik/turun)
            html5QrCode.stop().then(startScanner).catch(function() {});
          }, 500);
        });


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

        document.getElementById('clock').innerHTML = `<span class="clock-date small fw-normal text-primary me-1">${dateStr}</span> ${formattedTime}`;
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