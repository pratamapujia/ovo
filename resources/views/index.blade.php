<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Voting | Pilih Kandidat</title>

    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/OVO.svg') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/static/css/my.css') }}">

    <style>
      /* --- OPTIMASI ANIMASI CARD --- */
      /* Mematikan efek animasi naik pada seluruh card saat di-hover */
      .candidate-card {
        transition: none !important;
        transform: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05) !important;
      }

      .candidate-card:hover {
        transform: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05) !important;
      }

      /* Wrapper Foto agar gambar yang membesar tidak keluar jalur */
      .candidate-img-wrapper {
        overflow: hidden;
        border-radius: 12px 12px 0 0;
      }

      /* Efek Zoom in halus HANYA pada foto kandidat saat card di hover */
      .candidate-img-wrapper img {
        transition: transform 0.4s ease-in-out !important;
      }

      .candidate-card:hover .candidate-img-wrapper img {
        transform: scale(1.08) !important;
      }

      /* --- OPTIMASI TYPOGRAPHY --- */
      /* Typography khusus untuk Visi (Lebih elegan) */
      .visi-text {
        font-family: 'Merriweather', 'Georgia', serif;
        /* Font serif untuk kesan berwibawa/kutipan */
        font-size: 1.15rem;
        line-height: 1.8;
        color: #2c3e50;
      }

      /* Typography khusus untuk Misi (Rapi dan mudah dibaca) */
      .misi-text {
        font-family: 'Nunito', 'Segoe UI', sans-serif;
        font-size: 1.05rem;
        line-height: 1.7;
        color: #4a5568;
      }

      /* Memperbaiki tampilan list/ul/ol yang di-generate oleh editor di dalam misi */
      .misi-text ul,
      .misi-text ol {
        padding-left: 1.5rem;
        margin-bottom: 0;
      }

      .misi-text li {
        margin-bottom: 0.5rem;
      }

      /* --- EFEK ANIMASI BUTTON MODAL KONFIRMASI --- */

      /* Efek Berdenyut (Pulse) Halus untuk Tombol Utama */
      @keyframes pulse-soft {
        0% {
          box-shadow: 0 0 0 0 rgba(67, 94, 190, 0.4);
        }

        70% {
          box-shadow: 0 0 0 12px rgba(67, 94, 190, 0);
        }

        100% {
          box-shadow: 0 0 0 0 rgba(67, 94, 190, 0);
        }
      }

      /* Transisi Hover untuk Tombol Submit */
      .btn-animated-primary {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
        animation: pulse-soft 2.5s infinite;
      }

      .btn-animated-primary:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 10px 25px rgba(67, 94, 190, 0.35) !important;
        animation: none;
        /* Matikan denyut saat di-hover */
      }

      .btn-animated-primary:active {
        transform: translateY(1px) scale(0.98);
      }

      /* Transisi Hover untuk Tombol Batal */
      .btn-animated-secondary {
        transition: all 0.3s ease !important;
      }

      .btn-animated-secondary:hover {
        background-color: #e2e8f0 !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05) !important;
      }
    </style>
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

              <!-- Ikon -->
              <div class="me-3 mt-1 text-primary fs-5">
                <i class="fas fa-info-circle"></i>
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
                <!-- Wrapper Foto -->
                <div class="candidate-img-wrapper">
                  <img src="{{ url($path) }}" alt="Foto {{ $data->nama_kandidat }}" loading="lazy" class="img-fluid">
                  <div class="card-badge">Kandidat {{ $data->no_urut }}</div>
                </div>

                <div class="card-body d-flex flex-column flex-grow-1 p-4">
                  <h5 class="candidate-name text-center mb-4">{{ $data->nama_kandidat }}</h5>

                  <div class="mt-auto">
                    <div class="row g-2">
                      <div class="col-12">
                        <!-- Mengganti icon bootstrap dengan SVG Document -->
                        <button type="button" class="btn-detail-outline w-100 mb-2 d-inline-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal"
                          data-bs-target="#detail{{ $data->id }}">
                          <i class="fas fa-file-alt"></i>
                          Lihat Visi Misi
                        </button>
                      </div>
                      <div class="col-12">
                        <button type="button" class="btn-vote-primary w-100 btn-vote d-inline-flex align-items-center justify-content-center gap-2" data-id-kandidat="{{ $data->id }}"
                          data-nama-kandidat="{{ $data->nama_kandidat }}" data-foto-kandidat="{{ url($path) }}">
                          <i class="fas fa-check-circle"></i>
                          Vote
                        </button>
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
                    <!-- Header Kandidat -->
                    <div class="candidate-header text-center mb-4 p-4">
                      <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $path }}" class="img-candidate shadow" alt="Foto Paslon">
                      </div>
                      <h3 class="fw-bold text-dark mb-1">{{ $data->nama_kandidat }}</h3>
                      <span class="badge-elegant">Kandidat Utama</span>
                    </div>

                    <div class="row g-4">
                      <!-- Visi (Style Quotes & Centered) -->
                      <div class="col-12">
                        <div class="position-relative p-4 rounded-4 text-center shadow-sm" style="background: linear-gradient(to right, #f4f7ff, #ffffff, #f4f7ff); border: 1px solid #e0e7ff;">

                          <!-- Menggunakan SVG Quote Kiri Atas -->
                          <div class="position-absolute text-primary" style="top: -15px; left: 15px; opacity: 0.1;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                              <path
                                d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z" />
                            </svg>
                          </div>

                          <!-- Label Visi dengan SVG Lightbulb -->
                          <div class="mb-3">
                            <span class="badge bg-primary rounded-pill px-4 py-2 fs-6 shadow-sm d-inline-flex align-items-center gap-1">
                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                  d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13h-5a.5.5 0 0 1-.46-.302l-.761-1.77a1.964 1.964 0 0 0-.453-.618A5.984 5.984 0 0 1 2 6zm3 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1-.5-.5z" />
                              </svg>
                              Visi
                            </span>
                          </div>

                          <!-- Konten Visi Menerapkan Typography Baru -->
                          <blockquote class="blockquote mb-0 px-md-5 position-relative z-1">
                            <div class="visi-text fst-italic fw-medium">
                              {!! $data->visi !!}
                            </div>
                          </blockquote>

                          <!-- Menggunakan SVG Quote Kanan Bawah -->
                          <div class="position-absolute text-primary" style="bottom: -15px; right: 15px; opacity: 0.1; transform: rotate(180deg);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" viewBox="0 0 16 16">
                              <path
                                d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z" />
                            </svg>
                          </div>
                        </div>
                      </div>

                      <!-- Misi -->
                      <div class="col-12">
                        <div class="visi-misi-box h-100 p-4 rounded-4 shadow-sm" style="background-color: #fafbfc; border: 1px solid #e0e7ff;">

                          <!-- Label Misi dengan SVG List -->
                          <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <span class="badge bg-danger rounded-pill px-4 py-2 fs-6 shadow-sm me-3 d-inline-flex align-items-center gap-1">
                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                  d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
                              </svg>
                              Misi
                            </span>
                          </div>

                          <!-- Konten Misi Menerapkan Typography Baru -->
                          <div class="content-text misi-text text-secondary">
                            {!! $data->misi !!}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Konfirmasi Vote - Tipe Minimalis Modern -->
            <div class="modal fade" id="modalKonfirmasiVote" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 28px; background: #ffffff;">

                  <!-- Tombol Close Simpel -->
                  <div class="position-absolute w-100 d-flex justify-content-end p-3" style="z-index: 10;">
                    <button type="button" class="btn-close bg-light rounded-circle p-2 shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body p-5 text-center">
                    <!-- Badge Info -->
                    <div class="mb-4">
                      <span class="badge rounded-pill px-3 py-2" style="background-color: #f1f5f9; color: #64748b; font-weight: 600; letter-spacing: 0.5px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="me-1 mb-1" viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                          <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                        </svg>
                        Tinjauan Pilihan
                      </span>
                    </div>

                    <!-- Foto Bentuk Squircle (Kotak sudut membulat elegan) -->
                    <div class="position-relative d-inline-block mb-4 candidate-img-wrapper">
                      <img src="" id="konfirmasiFoto" alt="Foto Kandidat">
                    </div>

                    <!-- Tipografi Nama Besar & Bersih -->
                    <p class="text-muted mb-1 small">Anda memilih kandidat:</p>
                    <h2 class="fw-bolder text-dark mb-4" id="konfirmasiNama" style="letter-spacing: -0.5px;">Nama Kandidat</h2>

                    <!-- Garis Pemisah Halus -->
                    <hr style="border-color: #e2e8f0; border-width: 2px; opacity: 0.5; width: 60%; margin: 0 auto 1.5rem auto;">

                    <!-- Pesan Teks Murni (Tanpa Kotak Alert) -->
                    <p class="mb-0 text-muted small px-3" style="line-height: 1.6;">
                      Pastikan pilihan Anda sudah tepat. Suara yang telah masuk ke dalam sistem <strong class="text-dark">tidak dapat dibatalkan atau diubah</strong> kembali.
                    </p>
                  </div>

                  <!-- Footer dengan Tombol Beranimasi -->
                  <div class="modal-footer border-0 p-4 pt-0 px-5 pb-5 justify-content-center">
                    <form action="{{ route('voting.post') }}" method="POST" id="formKonfirmasiVote" class="w-100 d-flex gap-3 m-0 flex-column flex-sm-row">
                      @csrf
                      <input type="hidden" name="kandidat_id" id="konfirmasiId">

                      <button type="button" class="btn btn-light rounded-pill py-3 px-4 fw-bold text-secondary flex-grow-1 btn-animated-secondary" data-bs-dismiss="modal"
                        style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        Batal
                      </button>

                      <button type="submit" class="btn btn-primary rounded-pill py-3 px-4 fw-bold flex-grow-1 d-flex justify-content-center align-items-center gap-2 btn-animated-primary"
                        id="btnSubmitVote" style="background-color: #435ebe; border: none;">
                        <span id="textSubmitVote">Ya, Kirim Suara</span>
                        <span id="loadingSubmitVote" class="d-none">
                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                      </button>
                    </form>
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
          // 1. Ambil data dari tombol yang diklik
          const candidateId = this.dataset.idKandidat;
          const candidateName = this.dataset.namaKandidat;
          const candidatePhoto = this.dataset.fotoKandidat;

          // 2. Suntikkan data tersebut ke dalam Modal Konfirmasi
          document.getElementById('konfirmasiId').value = candidateId;
          document.getElementById('konfirmasiNama').textContent = candidateName;
          document.getElementById('konfirmasiFoto').src = candidatePhoto;

          // 3. Tampilkan Modal Bootstrap
          var modalKonfirmasi = new bootstrap.Modal(document.getElementById('modalKonfirmasiVote'));
          modalKonfirmasi.show();
        });
      });

      // Efek loading tombol saat form konfirmasi disubmit agar tidak di-spam click
      document.getElementById('formKonfirmasiVote').addEventListener('submit', function() {
        const btnSubmit = document.getElementById('btnSubmitVote');
        const textSubmit = document.getElementById('textSubmitVote');
        const loadingSubmit = document.getElementById('loadingSubmitVote');

        btnSubmit.disabled = true;
        textSubmit.textContent = 'Memproses...';
        loadingSubmit.classList.remove('d-none');
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
