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
            <div class="alert alert-light-danger border-danger shadow-sm rounded-4 d-flex" role="alert">
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
                          <button type="button" class="btn-vote-primary w-100 btn-vote" data-nama-kandidat="{{ $data->nama_kandidat }}">
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
            <div class="modal fade" id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                  <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pt-0 px-4 pb-4">
                    <!-- BAGIAN YANG DIUBAH: Header Kandidat -->
                    <div class="candidate-header text-center mb-4 p-4">
                      <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $path }}" class="img-candidate shadow" alt="Foto Paslon">
                      </div>
                      <h3 class="fw-bold text-dark mb-1">{{ $data->nama_kandidat }}</h3>
                      <span class="badge-elegant">Kandidat Utama</span>
                    </div>

                    <div class="row g-3">
                      <div class="col-md-6">
                        <div class="visi-misi-box h-100">
                          <span class="visi-misi-title"><i class="bi bi-lightbulb-fill me-2"></i>Visi</span>
                          <div class="content-text">
                            {!! $data->visi !!}
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="visi-misi-box h-100">
                          <span class="visi-misi-title"><i class="bi bi-list-check me-2"></i>Misi</span>
                          <div class="content-text">
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
