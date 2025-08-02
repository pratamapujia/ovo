<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Page</title>
    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/OVO.svg') }}" type="image/x-icon">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    <style>
      .p-scroll {
        max-height: 5em;
        overflow-y: auto;
        line-height: 1.5em;
      }

      @media print {

        /* 1. Sembunyikan elemen yang tidak perlu dicetak */
        nav.navbar,
        footer {
          display: none !important;
        }

        /* 2. Aturan paling penting: cegah kartu terpotong antar halaman */
        .card {
          break-inside: avoid;
          /* Properti modern */
          page-break-inside: avoid;
          /* Properti lama untuk kompatibilitas */
          margin-bottom: 20px;
          /* Beri sedikit jarak antar kartu */
        }

        /* 3. Atur ulang layout agar sesuai kertas (opsional, tapi disarankan) */
        .container-fluid {
          padding: 0 !important;
        }

        /* 4. Sesuaikan kolom agar lebih pas di kertas (misal: 2 kolom) */
        .col-sm-6,
        .col-md-4,
        .col-lg-3 {
          width: 30% !important;
          /* Paksa jadi 2 kolom */
          float: left;
          /* Pastikan kolom tetap berdampingan */
        }
      }
    </style>
  </head>

  <body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <nav class="navbar navbar-light sticky-top" style="background-color: #F2F7FF">
      <div class="container-fluid">
        <img src="{{ asset('assets/static/images/logo/icon2.svg') }}" alt="Logo" style="height: 40px">
        <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer-fill"></i> Print</button>
      </div>
    </nav>

    <div class="container-fluid p-5">
      <div class="row">
        @forelse ($pemilih as $d)
          <div class="col-sm-6 col-md-4 col-lg-3">
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
        @empty
          <div class="col-12">
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
          <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
              by <a href="https://ahmadsaugi.com">Saugi</a> Develop Apps by <a href="https://github.com/shofwanhadif">Shofwan</a></p>
          </div>
        </div>
      </div>
    </footer>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
  </body>

</html>
