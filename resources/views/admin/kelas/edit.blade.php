@extends('admin.layouts.index')

@section('title')
  <title>Edit Data</title>
@endsection

@section('content')
  <div id="main-content">
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Form Edit Data</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ route('kelas.index') }}">Master Kelas</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Form Edit Data
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
          <form action="{{ route('kelas.update', $kelas->id) }}" class="form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="nama_kelas">Nama Kelas</label>
                  <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" placeholder="Nama Kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
                  @error('nama_kelas')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="jurusan_id">Jurusan</label>
                  <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach ($jurusan as $item)
                      <option value="{{ $item->id }}" {{ $item->id == $kelas->jurusan_id ? 'selected' : '' }}>{{ $item->nama_jurusan }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-6 mt-2">
                <button class="btn btn-primary icon icon-left btn-block">
                  <i class="fas fa-paper-plane"></i> Update
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
