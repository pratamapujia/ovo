<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Page - Cetak ID Card Pemilih</title>
    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/OVO.svg') }}" type="image/x-icon">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

    <style>
      .p-scroll {
        max-height: 5em;
        overflow-y: auto;
        line-height: 1.5em;
      }

      /* Memaksa browser merender warna background dan border */
      body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }

      /* --- PENGATURAN FLEXBOX UNTUK KARTU (LENTUR & OTOMATIS) --- */
      .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
      }

      /* --- UKURAN KARTU LAYAR/SCREEN --- */
      .id-card-wrapper {
        width: 220px;
        height: 360px;
        flex: 0 0 auto;
        border-width: 2px !important;
        border-radius: 12px;
        overflow: hidden;
      }

      .id-card-header {
        background-color: #435ebe;
        color: white;
        text-align: center;
        padding: 10px;
        font-weight: bold;
        font-size: 13px;
        letter-spacing: 1px;
      }

      /* --- PENGATURAN KHUSUS CETAK (PRINT) --- */
      @media print {
        @page {
          /* Hapus ukuran spesifik, biarkan pengguna memilih Landscape/Portrait di browser.
             Kita set margin super minim: 5mm (setengah sentimeter) keliling agar muat banyak. */
          margin: 10mm !important;
        }

        nav.navbar,
        footer {
          display: none !important;
        }

        body {
          background-color: white !important;
        }

        .container-fluid {
          padding: 0 !important;
        }

        .card-container {
          gap: 3mm !important;
          /* Jarak antar kartu dibuat dinamis menggunakan milimeter */
          justify-content: center !important;
        }

        /* UKURAN OPTIMAL KARTU UNTUK KEDUA ORIENTASI */
        .id-card-wrapper {
          /* Lebar dan tinggi kartu dikunci di angka presisi (58x95mm).
             Angka ini dihitung secara matematis agar pas dengan sisa margin 5mm di kertas F4.
             - Portrait: Muat 3 berjejer (ke samping), muat 3-4 baris ke bawah.
             - Landscape: Muat 5 berjejer (ke samping), muat 2 baris ke bawah. */
          width: 58mm !important;
          height: 70mm !important;
          box-shadow: none !important;
          border: 2px solid #435ebe !important;

          /* ATURAN ANTI-TERPOTONG (PENTING!) */
          break-inside: avoid !important;
          page-break-inside: avoid !important;

          /* Mencegah kartu memanjang sendiri */
          flex: 0 0 auto !important;
        }

        /* Menyesuaikan teks & gambar agar tidak tumpah dari kartu saat dicetak */
        .qr-image {
          width: 90px !important;
          height: 90px !important;
          margin-bottom: 5px !important;
        }

        .text-nama {
          font-size: 12px !important;
          margin-bottom: 2px !important;
        }

        .text-kelas {
          font-size: 11px !important;
          margin-bottom: 8px !important;
        }

        .box-kredensial {
          padding: 2px !important;
        }

        .text-kredensial {
          font-size: 10px !important;
        }
      }
    </style>
  </head>

  <body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <!-- Navbar Standar -->
    <nav class="navbar navbar-light sticky-top shadow-sm" style="background-color: #F2F7FF">
      <div class="container-fluid">
        <img src="{{ asset('assets/static/images/logo/icon2.svg') }}" alt="Logo" style="height: 40px">
        <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer-fill me-1"></i> Print ID Card</button>
      </div>
    </nav>

    <div class="container-fluid p-2">
      <div class="card-container">

        @forelse ($pemilih as $d)
          <div class="card border-primary id-card-wrapper shadow-sm mb-0">
            <div class="id-card-header">
              KARTU PEMILIH
            </div>

            <!-- Body Kartu Pusatkan di Tengah -->
            <div class="card-content text-center d-flex flex-column h-100">
              <div class="card-body p-2 d-flex flex-column justify-content-center align-items-center h-100">

                <div class="w-100 text-center">
                  <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $d->nis }}:{{ $d->token }}&margin=0" alt="QR Code"
                    class="img-fluid border border-secondary p-1 rounded bg-white qr-image" style="width: 120px; height: 120px; object-fit: contain; margin: 0 auto; margin-bottom: 10px;">
                </div>

                <div class="w-100">
                  <h5 class="fw-bolder text-dark text-uppercase text-nama" style="line-height: 1.1;">
                    {{ $d->nama_pemilih }}
                  </h5>
                  <p class="text-muted text-kelas">
                    Kelas: <strong class="text-primary">{{ $d->kelas->nama_kelas }}</strong>
                  </p>
                </div>

                <div class="rounded w-100 box-kredensial" style="background-color: #f8faff; border: 1px dashed #435ebe; padding: 10px;">
                  <div class="d-flex justify-content-center align-items-center" style="margin-bottom: 2px;">
                    <span class="text-muted text-kredensial">NIS :</span>
                    <strong class="text-dark fs-6 text-kredensial">{{ $d->nis }}</strong>
                  </div>
                  <hr class="m-0 border-secondary opacity-25" style="margin-top: 2px; margin-bottom: 2px;">
                  <div class="d-flex justify-content-center align-items-center" style="margin-top: 2px;">
                    <span class="text-muted text-kredensial">Token :</span>
                    <strong class="text-primary fs-6 text-kredensial">{{ $d->token }}</strong>
                  </div>
                </div>

              </div>
            </div>
          </div>
        @empty
          <div class="w-100">
            <div class="alert alert-danger text-center">
              Tidak ada data pemilih yang ditemukan untuk kelas ini.
            </div>
          </div>
        @endforelse

      </div>
    </div>

    <footer>
      <div class="container">
        <div class="footer clearfix mb-0 text-muted">
          <div class="float-start">
            <p>{{ Date('Y') }} &copy; Online Voting</p>
          </div>
        </div>
      </div>
    </footer>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
  </body>

</html>
