@extends('admin.layouts.index')

@section('title')
  <title>Kandidat</title>
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
            <h3>Master Kandidat</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Master Kandidat</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <section class="section">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('kandidat.create') }}" class="btn icon icon-left btn-primary">
              <i class="fas fa-plus"></i> Tambah Kandidat
            </a>
          </div>
          <div class="card-body">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th>No</th>
                  <th data-sortable="false">Foto</th>
                  <th>Nama Kandidat</th>
                  <th>Visi</th>
                  <th>Misi</th>
                  <th data-sortable="false" width="12%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($kandidat as $data)
                  @php
                    $path = Storage::url('kandidat/' . $data->foto_kandidat);
                  @endphp
                  <tr>
                    <td>{{ $data->no_urut }}</td>
                    <td>
                      <div class="avatar avatar-md">
                        @if (!empty($data->foto_kandidat))
                          <img src="{{ url($path) }}" alt="Avatar">
                        @else
                          <img src="{{ asset('assets/static/images/none.png') }}" alt="">
                        @endif
                      </div>
                    </td>
                    <td>{{ $data->nama_kandidat }}</td>
                    <td>{!! $data->visi !!}</td>
                    <td>{!! $data->misi !!}</td>
                    <td>
                      <a href="{{ route('kandidat.edit', $data->id) }}" class="btn icon icon-left btn-sm btn-warning">
                        <li class="fas fa-edit"></li> Edit
                      </a>
                      <form action="{{ route('kandidat.destroy', $data->id) }}" method="POST" class="d-inline">
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
@endsection
@section('script')
  <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/static/js/pages/simple-datatables.js') }}"></script>
@endsection
