<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Page</title>

    <link rel="shortcut icon" href="{{ asset('assets') }}/static/images/logo/OVO.svg" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets') }}/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="{{ asset('assets') }}/compiled/css/iconly.css">
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
    <script src="{{ asset('assets') }}/static/js/initTheme.js"></script>
    <div id="app">
      <div id="main" class="layout-horizontal">
        <header class="mb-5">
          <div class="header-top">
            <div class="container">
              <div class="logo">
                @foreach ($config as $data)
                  @if ($data->type == 2)
                    @php
                      $path = Storage::url('apps/' . $data->value);
                    @endphp
                    @if ($data->value)
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

                <!-- Burger button responsive -->
                <a href="#" class="burger-btn d-block d-xl-none">
                  <i class="bi bi-justify fs-3"></i>
                </a>
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
                  <div class="col">
                    <div class="card">
                      <div class="card-content">
                        <div class="card-header">
                          <h4 class="card-title">{{ $data->nama_kandidat }}</h4>
                        </div>
                        <div class="d-flex">
                          <img src="{{ $path }}" alt="Foto Paslon" class="img-fluid mx-auto rounded" style="height: 120px">
                        </div>
                        <div class="card-body pt-4">
                          <div class="row">
                            <div class="col-6">
                              <h5 class="card-title">Visi</h5>
                              <p class="p-scroll">{{ $data->visi }}</p>
                            </div>
                            <div class="col-6">
                              <h5 class="card-title">Misi</h5>
                              <p class="p-scroll">{{ $data->misi }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <form action="{{ route('voting.post') }}" method="POST" class="vote-form">
                          @csrf
                          <input type="hidden" name="kandidat_id" value="{{ $data->id }}">
                          <button type="button" class="btn btn-primary w-100 btn-vote">{{ $data->nama_kandidat }}</button>
                        </form>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
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
      </div>
    </div>
    <script src="{{ asset('assets') }}/static/js/pages/horizontal-layout.js"></script>
    <script src="{{ asset('assets') }}/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="{{ asset('assets') }}/compiled/js/app.js"></script>

    <script src="{{ asset('assets') }}/static/js/pages/dashboard.js"></script>

    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
      document.querySelectorAll('.btn-vote').forEach(button => {
        button.addEventListener('click', function() {
          const form = this.closest('.vote-form'); // Dapatkan form terdekat
          const candidateName = this.textContent; // Ambil nama kandidat

          Swal.fire({
            title: `Benar ingin memilih ${candidateName}?`,
            text: 'Anda tidak bisa mengubah pilihan ini setelah menekan tombol "Ya".',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#435ebe',
            cancelButtonColor: '#d33',
            confirmButtonText: `Ya, pilih ${candidateName} !`,
            cancelButtonText: 'Batal'
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
