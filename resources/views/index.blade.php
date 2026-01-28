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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
      body {
        background-color: #f2f7ff;
        font-family: 'Nunito', sans-serif;
      }

      /* Header Styling */
      .voting-header {
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 1rem 0;
        margin-bottom: 2rem;
        position: sticky;
        top: 0;
        z-index: 1000;
      }

      .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
      }

      /* Candidate Card Styling */
      .candidate-card {
        border: none;
        border-radius: 20px;
        background: #fff;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        height: 100%;
        position: relative;
      }

      .candidate-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(67, 94, 190, 0.15);
      }

      .candidate-img-wrapper {
        width: 100%;
        height: 280px;
        overflow: hidden;
        position: relative;
        background-color: #e9ecef;
      }

      .candidate-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        transition: transform 0.5s ease;
      }

      .candidate-card:hover .candidate-img-wrapper img {
        transform: scale(1.05);
      }

      .card-body {
        padding: 1.5rem;
        text-align: center;
      }

      .candidate-name {
        font-weight: 800;
        color: #25396f;
        margin-bottom: 1rem;
        font-size: 1.25rem;
      }

      /* Buttons */
      .btn-action-group {
        display: flex;
        gap: 10px;
        justify-content: center;
      }

      .btn-custom-outline {
        border: 2px solid #ffc107;
        color: #b48600;
        background: transparent;
        border-radius: 50px;
        font-weight: 600;
        padding: 0.5rem 1rem;
        transition: all 0.3s;
      }

      .btn-custom-outline:hover {
        background: #ffc107;
        color: #fff;
      }

      .btn-custom-primary {
        background: linear-gradient(45deg, #435ebe, #2a4094);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        box-shadow: 0 4px 15px rgba(67, 94, 190, 0.3);
        transition: all 0.3s;
      }

      .btn-custom-primary:hover {
        background: linear-gradient(45deg, #2a4094, #435ebe);
        box-shadow: 0 6px 20px rgba(67, 94, 190, 0.5);
        transform: scale(1.02);
      }

      /* Modal Styling */
      .modal-content {
        border-radius: 20px;
        border: none;
      }

      .visi-misi-box {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        height: 100%;
        border-left: 5px solid #435ebe;
      }

      .visi-misi-title {
        font-weight: bold;
        color: #435ebe;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
        display: block;
        text-align: center;
      }

      /* Responsive Fixes */
      @media (max-width: 576px) {
        .header-content {
          flex-direction: column;
          text-align: center;
        }

        .candidate-img-wrapper {
          height: 320px;
          /* Lebih tinggi di HP agar jelas */
        }
      }
    </style>
  </head>

  <body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">

      <header class="voting-header">
        <div class="container">
          <div class="header-content">
            <div class="d-flex align-items-center gap-3">
              @foreach ($config as $data)
                @if ($data->type == 2 && $data->name == 'app_logo')
                  @php $path = Storage::url('apps/' . $data->value); @endphp
                  <a href="{{ route('dashboard.voters') }}">
                    <img src="{{ $path }}" alt="Logo" style="height: 50px;">
                  </a>
                @endif
              @endforeach

              <div>
                @foreach ($config as $data)
                  @if ($data->type == 0 && $data->value)
                    <h4 class="m-0 fw-bold text-primary">{{ $data->value }}</h4>
                  @endif
                @endforeach
              </div>
            </div>

            <div class="user-info">
              <span class="text-muted small d-block d-md-inline">Halo, Voter!</span>
              <div class="badge bg-light-primary text-primary fs-6 px-3 py-2 rounded-pill border border-primary">
                <i class="bi bi-person-fill me-1"></i> {{ Auth::user()->nama_pemilih }}
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="content-wrapper container pb-5">

        <div class="row justify-content-center mb-4">
          <div class="col-lg-8">
            <div class="alert alert-light-danger border-danger shadow-sm rounded-4 d-flex align-items-center" role="alert">
              <i class="bi bi-exclamation-triangle-fill text-danger fs-3 me-3"></i>
              <div>
                <h5 class="alert-heading fw-bold mb-1">Penting!</h5>
                <p class="mb-0 text-muted">Gunakan hak pilih Anda dengan bijak. Pilihan tidak dapat diubah setelah tombol "Pilih" ditekan.</p>
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
              <div class="candidate-card h-100 d-flex flex-column">

                <div class="candidate-img-wrapper">
                  <img src="{{ url($path) }}" alt="Foto {{ $data->nama_kandidat }}" loading="lazy">
                </div>

                <div class="card-body d-flex flex-column flex-grow-1">
                  <h5 class="candidate-name">{{ $data->nama_kandidat }}</h5>

                  <div class="mt-auto">
                    <div class="row g-2">
                      <div class="col-12 col-sm-6">
                        <button type="button" class="btn btn-custom-outline w-100" data-bs-toggle="modal" data-bs-target="#detail{{ $data->id }}">
                          <i class="bi bi-file-text me-1"></i> Visi Misi
                        </button>
                      </div>
                      <div class="col-12 col-sm-6">
                        <form action="{{ route('voting.post') }}" method="POST" class="vote-form">
                          @csrf
                          <input type="hidden" name="kandidat_id" value="{{ $data->id }}">
                          <button type="button" class="btn btn-custom-primary w-100 btn-vote" data-nama-kandidat="{{ $data->nama_kandidat }}">
                            <i class="bi bi-check-circle-fill me-1"></i> Pilih
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Modal Detail --}}
            <div class="modal fade" id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content shadow-lg">
                  <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pt-0 px-4 pb-4">
                    <div class="text-center mb-4">
                      <img src="{{ $path }}" class="rounded-circle shadow mb-3" alt="Foto Paslon" style="width: 120px; height: 120px; object-fit: cover;">
                      <h3 class="fw-bold text-dark">{{ $data->nama_kandidat }}</h3>
                      <span class="badge bg-light-secondary text-secondary">Kandidat</span>
                    </div>

                    <div class="row g-3">
                      <div class="col-md-6">
                        <div class="visi-misi-box">
                          <span class="visi-misi-title"><i class="bi bi-lightbulb me-2"></i>Visi</span>
                          <div class="text-secondary small">
                            {!! $data->visi !!}
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="visi-misi-box">
                          <span class="visi-misi-title"><i class="bi bi-list-check me-2"></i>Misi</span>
                          <div class="text-secondary small">
                            {!! $data->misi !!}
                          </div>
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

      <footer class="mt-auto py-4 text-center text-muted small">
        <div class="container">
          <p class="mb-1">&copy; {{ Date('Y') }} E-Voting System.</p>
          <p>Crafted with <i class="bi bi-heart-fill text-danger mx-1"></i> by PPA</p>
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

          Swal.fire({
            title: 'Konfirmasi Pilihan',
            html: `Apakah Anda yakin memilih <b>${candidateName}</b>?<br><small class="text-danger">Pilihan tidak dapat diubah.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#435ebe',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya Yakin!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusConfirm: false
          }).then((result) => {
            if (result.isConfirmed) {
              // Efek loading saat submit
              Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
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
          title: 'Berhasil!',
          text: '{{ session('success') }}',
          icon: 'success',
          allowOutsideClick: false,
          confirmButtonText: 'OK',
          confirmButtonColor: '#435ebe',
          timer: 5000,
          timerProgressBar: true,
        }).then(() => {
          window.location.href = "{{ route('logoutvoters') }}";
        });
      </script>
    @endif

  </body>

</html>
