<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Voting | Pilih Kandidat</title>

    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/OVO.svg') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/static/css/my.css') }}">

  </head>

  <body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">

      <header class="voting-header">
        <div class="container">
          <div class="header-content">
            <div class="d-flex align-items-center">
              @foreach ($config as $data)
                @if ($data->type == 2 && $data->name == 'app_logo')
                  @php $path = Storage::url('apps/' . $data->value); @endphp
                  @if ($data->value == null)
                    <a href="{{ route('dashboard.voters') }}">
                      <img src="{{ asset('assets/static/images/logo/OVO.svg') }}" alt="Logo" style="height: 50px;">
                    </a>
                  @else
                    <a href="{{ route('dashboard.voters') }}">
                      <img src="{{ $path }}" alt="Logo" style="height: 50px;">
                    </a>
                  @endif
                @endif
              @endforeach
            </div>
            <div class="d-flex align-items-center">
              @foreach ($config as $data)
                @if ($data->type == 0 && $data->value)
                  <h4 class="m-0 fw-bold text-primary">{{ $data->value }}</h4>
                @endif
              @endforeach
            </div>

            <div class="user-info">
              <div class="user-menu d-flex">
                <div class="user-name text-end me-3">
                  <div class="text-primary fw-bold">
                    {{ Auth::user()->nama_pemilih }}
                  </div>
                  <p class="mb-0 text-sm text-gray-600">Voter</p>
                </div>
                <div class="user-img d-flex align-items-center">
                  <div class="avatar avatar-lg">
                    <img src="https://ui-avatars.com/api/?background=435EBE&color=fff&name={{ Auth::user()->nama_pemilih }}" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="content-wrapper container pb-5">

        <div class="row justify-content-center mb-4">
          <div class="col-lg-8">
            <!-- Background menggunakan gradasi pastel biru (#eff4ff) ke pastel merah (#ffeded) -->
            <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-start p-4" role="alert" style="background: linear-gradient(0deg, #eff4ff 0%, #dad7ff 100%);">

              <!-- Ikon dengan efek gradasi warna biru ke merah -->
              <div class="me-3 mt-1">
                <i class="bi bi-info-circle-fill"
                  style="font-size: 1.8rem; background: -webkit-linear-gradient(135deg, #3b82f6, #ef4444); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
              </div>

              <!-- Teks -->
              <div>
                <h6 class="fw-bold mb-1" style="color: #2d3748;">Halo, {{ Auth::user()->nama_pemilih }}! 👋</h6>
                <p class="mb-0" style="color: #424242; font-size: 0.95rem; line-height: 1.6;">
                  Silakan tentukan kandidat pilihanmu. Gunakan hak suara ini sesuai dengan hati nurani dan keyakinan pribadimu. Kerahasiaan pilihanmu terjamin!
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4 justify-content-center">
          @foreach ($kandidat as $data)
            @php
              $path = Storage::url('kandidat/' . $data->foto_kandidat);
            @endphp
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
              <div class="candidate-card h-100 d-flex flex-column border-0">
                <!-- Wrapper Foto dengan Overlay Halus -->
                <div class="candidate-img-wrapper">
                  <img src="{{ url($path) }}" alt="Foto {{ $data->nama_kandidat }}" loading="lazy" class="img-fluid">
                  <div class="card-badge">Kandidat {{ $data->no_urut }}</div>
                </div>

                <div class="card-body d-flex flex-column flex-grow-1 p-4">
                  <h5 class="candidate-name text-center mb-4">{{ $data->nama_kandidat }}</h5>

                  <div class="mt-auto">
                    <div class="row g-2">
                      <div class="col-12">
                        <button type="button" class="btn-detail-outline w-100 mb-2" data-bs-toggle="modal" data-bs-target="#detail{{ $data->id }}">
                          <i class="bi bi-file-text me-1"></i> Lihat Visi Misi
                        </button>
                      </div>
                      <div class="col-12">
                        <form action="{{ route('voting.post') }}" method="POST" class="vote-form">
                          @csrf
                          <input type="hidden" name="kandidat_id" value="{{ $data->id }}">
                          <button type="button" class="btn-vote-primary w-100 btn-vote" data-nama-kandidat="{{ $data->nama_kandidat }}" data-foto-kandidat="{{ url($path) }}">
                            <i class="bi bi-check-circle-fill me-1"></i> Vote
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Modal Detail --}}
            <div class="row g-4">
              <!-- Visi (Style Quotes & Centered) -->
              <div class="col-12">
                <div class="position-relative p-4 rounded-4 text-center shadow-sm" style="background: linear-gradient(to right, #f4f7ff, #ffffff, #f4f7ff); border: 1px solid #e0e7ff;">

                  <!-- Ikon Quote Kiri Atas -->
                  <i class="bi bi-quote position-absolute text-primary" style="font-size: 5rem; top: -20px; left: 10px; opacity: 0.1;"></i>

                  <!-- Label Visi -->
                  <div class="mb-3">
                    <span class="badge bg-primary rounded-pill px-4 py-2 fs-6 shadow-sm">
                      <i class="bi bi-lightbulb-fill me-1"></i> Visi
                    </span>
                  </div>

                  <!-- Konten Visi -->
                  <blockquote class="blockquote mb-0 px-md-5 position-relative z-1">
                    <div class="fs-5 fst-italic text-dark fw-medium" style="line-height: 1.8;">
                      {!! $data->visi !!}
                    </div>
                  </blockquote>

                  <!-- Ikon Quote Kanan Bawah -->
                  <i class="bi bi-quote position-absolute text-primary" style="font-size: 5rem; bottom: -35px; right: 10px; opacity: 0.1; transform: rotate(180deg);"></i>
                </div>
              </div>

              <!-- Misi -->
              <div class="col-12">
                <div class="visi-misi-box h-100 p-4 rounded-4 shadow-sm" style="background-color: #fafbfc; border: 1px solid #e0e7ff;">

                  <!-- Label Misi -->
                  <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <span class="badge bg-danger rounded-pill px-4 py-2 fs-6 shadow-sm me-3">
                      <i class="bi bi-list-check me-1"></i> Misi
                    </span>
                    <span class="text-muted fw-semibold">Program Kerja & Langkah Konkret</span>
                  </div>

                  <!-- Konten Misi -->
                  <div class="content-text text-secondary" style="line-height: 1.7;">
                    {!! $data->misi !!}
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

      </div>

      <footer class="mt-auto py-4 text-center text-muted small">
        <div class="container">
          <p class="mb-1">&copy; {{ Date('Y') }} Online Voting.</p>
          <p>Crafted with <i class="bi bi-heart-fill text-danger mx-1"></i> by <span class="text-primary">PPA</span> </p>
        </div>
      </footer>
    </div>

    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
      document.querySelectorAll('.btn-vote').forEach(button => {
        button.addEventListener('click', function() {
          const form = this.closest('.vote-form');
          const candidateName = this.dataset.namaKandidat;
          const candidatePhoto = this.dataset.fotoKandidat; // Mengambil URL foto

          Swal.fire({
            title: 'Konfirmasi Pilihan',
            icon: 'question',
            html: `
              <div class="mt-3">
                <p class="mb-3 text-secondary">Anda akan memberikan suara untuk:</p>
                
                <!-- Menampilkan Foto Kandidat -->
                <div class="mb-3 position-relative d-inline-block">
                  <img src="${candidatePhoto}" alt="Foto ${candidateName}" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
                </div>
                
                <h3 class="text-primary fw-bold mb-4">${candidateName}</h3>
                
                <!-- Kotak Peringatan -->
                <div class="bg-light-warning border border-warning rounded-3 p-3 text-start">
                  <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-3 me-3"></i>
                    <p class="mb-0 text-dark small" style="line-height: 1.4;">
                      <strong>Perhatian:</strong> Pilihan yang sudah dikirim bersifat final dan <b>tidak dapat diubah kembali</b>.
                    </p>
                  </div>
                </div>
              </div>
            `,
            showCancelButton: true,
            reverseButtons: true,
            focusConfirm: false,
            buttonsStyling: false,
            confirmButtonText: '<i class="bi bi-check2-circle me-1"></i> Ya, Saya Yakin',
            cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
            customClass: {
              popup: 'rounded-4 shadow-lg border-0',
              title: 'fw-bold text-dark pt-3',
              confirmButton: 'btn btn-primary rounded-pill px-4 py-2 mx-2 fw-bold shadow-sm',
              cancelButton: 'btn btn-light rounded-pill px-4 py-2 mx-2 fw-bold text-secondary border'
            }
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: 'Memproses Suara...',
                html: '<span class="text-muted small">Mohon tunggu, suara Anda sedang diamankan.</span>',
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: {
                  popup: 'rounded-4'
                },
                didOpen: () => {
                  Swal.showLoading();
                }
              });
              form.submit();
            }
          });
        });
      });
    </script>

    @if (session('success'))
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Suara Berhasil Masuk!',
          html: '<p class="text-secondary mb-0">{{ session('success') }}</p><p class="small text-muted mt-3">Mengarahkan Anda keluar dari sistem...</p>',
          allowOutsideClick: false,
          showConfirmButton: true,
          confirmButtonText: '<i class="bi bi-check2-circle me-1"></i> Selesai',
          timer: 3500,
          timerProgressBar: true,
          buttonsStyling: false,
          customClass: {
            popup: 'rounded-4 shadow-lg border-0',
            title: 'fw-bold text-dark pt-3',
            confirmButton: 'btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm'
          }
        }).then(() => {
          // Transisi halus saat logout diproses
          Swal.fire({
            title: 'Keluar Sistem...',
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: {
              popup: 'rounded-4'
            },
            didOpen: () => {
              Swal.showLoading();
            }
          });
          window.location.href = "{{ route('logoutvoters') }}";
        });
      </script>
    @endif

  </body>

</html>
