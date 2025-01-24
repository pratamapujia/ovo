@extends('admin.layouts.index')

@section('title')
  <title>Form Tambah Data</title>
@endsection

@section('content')
  <div id="main-content">
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Form Tambah Data</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ route('kelas.index') }}">Master Kelas</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Form Tambah Data
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="flash-data" data-gagal="{{ Session::get('gagal') }}"></div>
      <div class="card">
        <div class="card-header">
          <div class="media d-flex align-items-center">
            <div class="me-3">
              <h5>Master Kelas</h5>
            </div>
            <div class="ms-auto">
              <a href="{{ route('kelas.index') }}" class="btn icon icon-left btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('kelas.store') }}" class="form" method="POST">
            @csrf
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="form-label" for="jurusan_id">Jurusan</label>
                  <select name="jurusan_id" id="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror">
                    <option value="">Pilih Jurusan</option>
                    @foreach ($jurusan as $data)
                      @if (old('jurusan_id') == $data->id)
                        <option value="{{ $data->id }}" selected>{{ $data->nama_jurusan }}</option>
                      @else
                        <option value="{{ $data->id }}">{{ $data->nama_jurusan }}</option>
                      @endif
                    @endforeach
                  </select>
                  @error('jurusan_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                  <label class="form-label" for="nama_kelas">Nama Kelas</label>
                  <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" placeholder="Masukkan Nama Kelas" value="{{ old('nama_kelas') }}">
                  @error('nama_kelas')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-6 mt-2">
                <button class="btn btn-primary icon icon-left btn-block">
                  <i class="fas fa-paper-plane"></i> Simpan
                </button>
              </div>
              <div class="col-6 mt-2">
                <button type="reset" class="btn btn-secondary icon icon-left btn-block">
                  <i class="fas fa-sync"></i> Reset
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
