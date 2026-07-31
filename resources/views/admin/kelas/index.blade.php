@extends('admin.layouts.index')
@section('title')
  <title>Kelas</title>
  <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
  <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/table-datatable.css') }}">
@endsection
@section('content')
  <div id="main-content">
    {{-- 1. Tangkap Notifikasi Pesan Sukses/Gagal Standar (Untuk SweetAlert) --}}
    <div class="flash-data" data-berhasil="{{ Session::get('pesan') }}"></div>
    <div class="flash-data" data-gagal="{{ Session::get('gagal') }}"></div>

    {{-- 2. Tangkap Notifikasi Error Khusus dari Import Excel --}}
    @if (session()->has('pesan_alert'))
      @php
        $pesan = session('pesan_alert');
      @endphp
      <div class="alert alert-{{ $pesan['type'] }} alert-dismissible fade show shadow-sm" role="alert">
        <h5 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle"></i> {{ $pesan['title'] }}</h5>
        <p>{{ $pesan['body'] }}</p>

        {{-- Jika ada detail error baris Excel, tampilkan sebagai daftar --}}
        @if (isset($pesan['details']))
          <hr>
          <ul class="mb-0 text-start" style="font-size: 0.9rem;">
            @foreach ($pesan['details'] as $detail)
              <li>{!! $detail !!}</li>
            @endforeach
          </ul>
        @endif

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Master Kelas</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Master Kelas</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <section class="section">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('kelas.create') }}" class="btn icon icon-left btn-primary">
              <i class="fas fa-plus"></i> Tambah Data
            </a>
            <div class="float-end">
              <button type="button" class="btn icon icon-left btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-import"></i> Import
              </button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Kelas</th>
                  <th>Jurusan</th>
                  <th data-sortable="false">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($kelas as $data)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->nama_kelas }}</td>
                    <td>{{ $data->jurusan->nama_jurusan }}</td>
                    <td>
                      <a href="{{ route('kelas.edit', $data->id) }}" class="btn icon icon-left btn-sm btn-warning">
                        <li class="fas fa-edit"></li> Edit
                      </a>
                      <form action="{{ route('kelas.destroy', $data->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="_method" value="delete">
                        <button type="button" class="btn icon icon-left btn-danger btn-sm btn-delete">
                          <li class="fas fa-trash"></li> Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>

  {{-- Modal Import Excel Kelas --}}
  <div class="modal fade text-left" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title text-white" id="importModalLabel">
            <i class="fas fa-file-import me-2"></i> Import Excel Kelas
          </h5>
          <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('kelas.import') }}" method="POST" enctype="multipart/form-data" id="formImportKelas">
          @csrf
          <div class="modal-body">

            {{-- Bagian Penjelasan Petunjuk Pengisian --}}
            <div class="alert alert-light-info color-info border-info mb-4" role="alert">
              <h6 class="alert-heading fw-bold mb-2"><i class="fas fa-info-circle"></i> Petunjuk Pengisian Data:</h6>
              <p class="mb-2" style="font-size: 0.9rem;">Pastikan baris pertama (header) file Excel Anda persis seperti format berikut:</p>
              <ul style="font-size: 0.9rem;" class="mb-0">
                <li><strong>nama_kelas</strong> : Wajib diisi (Maksimal 10 karakter) dan tidak boleh duplikat.</li>
                <li><strong>nama_jurusan</strong> : Wajib diisi. Pastikan penulisan nama jurusan persis dengan data Jurusan yang sudah ada di sistem.</li>
              </ul>
            </div>
            {{-- End Penjelasan --}}

            <div class="form-group">
              <label for="input_excel" class="fw-bold">Pilih File Excel (.xls, .xlsx)</label>
              <input type="file" class="form-control mt-2" name="input_excel" id="input_excel" accept=".xls, .xlsx" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Import Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/static/js/pages/simple-datatables.js') }}"></script>
  <script>
    const formImportKelas = document.getElementById('formImportKelas');
    if (formImportKelas) {
      formImportKelas.addEventListener('submit', function() {
        // Menutup modal import agar tidak menumpuk dengan loading
        var importModal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
        if (importModal) {
          importModal.hide();
        }

        // Menampilkan SweetAlert Loading
        Swal.fire({
          title: 'Mengimpor Data Kelas...',
          html: '<span class="text-muted small">Mohon tunggu sebentar, sistem sedang memvalidasi dan menyimpan data Anda.</span>',
          allowOutsideClick: false,
          showConfirmButton: false,
          customClass: {
            popup: 'rounded-4'
          },
          didOpen: () => {
            Swal.showLoading();
          }
        });
      });
    }
  </script>
@endsection
