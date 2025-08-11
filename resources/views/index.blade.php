<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Page</title>

    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/OVO.svg') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

    <style>
      .p-scroll {
        max-height: 5em;
        overflow-y: auto;
        line-height: 1.5em;
      }
    </style>
  </head>

  <body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
      <div id="main" class="layout-horizontal">
        <header class="mb-1 sticky-top">
          <div class="header-top">
            <div class="container">
              <div class="logo">
                @foreach ($config as $data)
                  @if ($data->type == 2)
                    @php
                      $path = Storage::url('apps/' . $data->value);
                    @endphp
                    @if ($data->name == 'app_logo')
                      <a href="{{ route('dashboard.voters') }}">
                        <img src="{{ $path }}" alt="Logo" style="height: 40px">
                      </a>
                    @endif
                  @endif
                @endforeach
              </div>
              @foreach ($config as $data)
                @if ($data->type == 0)
                  @if ($data->value)
                    <h3>{{ $data->value }}</h3>
                  @endif
                @endif
              @endforeach
              <div class="header-top-right">
                <div class="text">
                  <h6 class="mb-0">Voters :
                    <span class="badge bg-primary">{{ Auth::user()->nama_pemilih }}</span>
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </header>

        <div class="content-wrapper container">

          <div class="page-heading">

          </div>
          <div class="page-content">
            <div class="container">
              <div class="alert alert-light-danger">
                <h4 class="alert-heading">Perhatian!</h4>
                <p class="mb-0">Pilihlah dengan bijak, setelah memilih tidak bisa diubah kembali.</p>
              </div>
              <div class="row">
                @foreach ($kandidat as $data)
                  @php
                    $path = Storage::url('kandidat/' . $data->foto_kandidat);
                  @endphp
                  <div class="col-sm-12 col-md-3 col-lg">
                    <div class="card h-100">
                      <img src="{{ url($path) }}" class="card-img-top" alt="Foto {{ $data->nama_kandidat }}" style="height: 300px; object-fit: cover;">
                      <div class="card-body p-2">
                        <h5 class="card-title text-center">{{ $data->nama_kandidat }}</h5>
                        <div class="row p-2">
                          <div class="col-6">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#detail{{ $data->id }}">Lihat Visi Misi</button>
                          </div>
                          <div class="col-6">
                            <form action="{{ route('voting.post') }}" method="POST" class="vote-form">
                              @csrf
                              <input type="hidden" name="kandidat_id" value="{{ $data->id }}">
                              <button type="button" class="btn btn-primary w-100 btn-vote" data-nama-kandidat="{{ $data->nama_kandidat }}">Pilih</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  {{-- Modal Detail --}}
                  <div class="modal modal-borderless fade" id="detail{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="detail{{ $data->id }}Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                      <div class="modal-content">
                        {{-- <div class="modal-header">
                          <h5 class="modal-title" id="detail{{ $data->id }}Title">{{ $data->nama_kandidat }}</h5>
                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                          </button>
                        </div> --}}
                        <div class="modal-body">
                          <img src="{{ $path }}" class="d-flex img-fluid mx-auto rounded" alt="Foto Paslon" style="height: 200px">
                          <h4 class="modal-title my-2 text-center">{{ $data->nama_kandidat }}</h4>
                          <div class="my-2">
                            <h5 class="modal-title">Visi</h5>
                            <p>{!! $data->visi !!}</p>
                          </div>
                          <div class="my-2">
                            <h5 class="modal-title">Misi</h5>
                            <p>{!! $data->misi !!}</p>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                            <form action="{{ route('voting.post') }}" method="POST" class="vote-form">
                              @csrf
                              <input type="hidden" name="kandidat_id" value="{{ $data->id }}">
                              <button type="button" class="btn btn-primary btn-vote" data-nama-kandidat="{{ $data->nama_kandidat }}">Pilih</button>
                            </form>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

        </div>

        <footer class="pt-5">
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
    <script src="{{ asset('assets/static/js/pages/horizontal-layout.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

    <script src="{{ asset('assets/static/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
      document.querySelectorAll('.btn-vote').forEach(button => {
        button.addEventListener('click', function() {
          const form = this.closest('.vote-form'); // Dapatkan form terdekat
          const candidateName = this.dataset.namaKandidat; // Ambil nama kandidat dari data-nama-kandidat di button pilih

          Swal.fire({
            title: `Benar ingin memilih ${candidateName}?`,
            text: 'Anda tidak bisa mengubah pilihan ini setelah menekan tombol "Ya".',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#435ebe',
            cancelButtonColor: '#d33',
            confirmButtonText: `Ya, pilih ${candidateName} !`,
            cancelButtonText: 'Batal',
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit(); // Kirim form jika konfirmasi
            }
          });
        });
      });
    </script>
    @if (session('success'))
      <script>
        Swal.fire({
          title: '{{ session('success') }}',
          html: `
            <div class="text-center">
              <h4>Terima kasih telah memilih</h4>
              <p>Anda akan diarahkan ke halaman login dalam 5 detik.</p>
            </div>          
          `,
          icon: 'success',
          allowOutsideClick: false,
          confirmButtonText: 'Ya, Lanjutkan',
          confirmButtonColor: '#435ebe',
          timer: 5000,
          timerProgressBar: true,
        }).then(() => {
          // Redirect ke halaman login setelah menutup alert
          window.location.href = "{{ route('logoutvoters') }}"; // Ganti dengan rute login yang sesuai
        });
      </script>
    @endif

  </body>

</html>
