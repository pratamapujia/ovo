@extends('admin.layouts.index')

@section('title')
  <title>Pemilih</title>
  <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
  <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/table-datatable.css') }}">
@endsection

@section('content')
  <div id="main-content">
    {{-- Alert --}}
    <div class="flash-data" data-berhasil="{{ Session::get('pesan') }}"></div>
    <div class="flash-data" data-gagal="{{ Session::get('gagal') }}"></div>
    {{-- End Alert --}}
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Master Pemilih</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Master Pemilih</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <section class="section">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('pemilih.create') }}" class="btn icon icon-left btn-primary">
              <i class="fas fa-plus"></i> Tambah Data
            </a>
            <div class="float-end">
              <button class="btn icon icon-left btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-import"></i> Excel
              </button>
              <a href="{{ route('pemilih.export') }}" target="_blank" onclick="printPage(event)" class="btn icon icon-left btn-danger">
                <i class="fas fa-print"></i> Print
              </a>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama Pemilih</th>
                  <th>Kelas</th>
                  <th>Token</th>
                  <th>Status</th>
                  <th data-sortable="false">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pemilih as $data)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->nis }}</td>
                    <td>{{ $data->nama_pemilih }}</td>
                    <td>{{ $data->kelas->nama_kelas }}</td>
                    <td>
                      <span class="badge bg-primary">{{ $data->token }}</span>
                    </td>
                    <td>
                      @if ($data->status == 1)
                        <span class="badge bg-success">Sudah Memilih</span>
                      @else
                        <span class="badge bg-danger">Belum Memilih</span>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('pemilih.edit', $data->id) }}" class="btn icon icon-left btn-sm btn-warning">
                        <li class="fas fa-edit"></li> Edit
                      </a>
                      <form action="{{ route('pemilih.destroy', $data->id) }}" method="POST" class="d-inline">
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

  {{-- Modal Import Excel --}}
  <div class="modal fade text-left" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabelModalLabel">Import Excel</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('pemilih.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="excel">Pilih File Excel</label>
              <input type="file" class="form-control" name="input_excel" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn icon icon-left btn-success" onclick="downloadTemplate()"> <i class="fas fa-file-download"></i> Unduh Template</button>
            <button type="submit" class="btn btn-primary">Import</button>
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
    function printPage(event) {
      event.preventDefault();
      const url = event.currentTarget.href;
      const printWindow = window.open(url, '_blank');
      printWindow.onload = function() {
        printWindow.print();
      };
    }

    function downloadTemplate() {
      window.location.href = "/download-template";
    }
  </script>
@endsection
