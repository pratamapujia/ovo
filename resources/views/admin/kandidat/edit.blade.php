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
                  <a href="{{ route('kelas.index') }}">Master Kandidat</a>
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
              <h5>Master Kandidat</h5>
            </div>
            <div class="ms-auto">
              <a href="{{ route('kandidat.index') }}" class="btn icon icon-left btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('kandidat.update', $kandidat->id) }}" class="form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="no_urut">Nomor Urut</label>
                  <input type="number" class="form-control @error('no_urut') is-invalid @enderror" name="no_urut" placeholder="Masukkan Nomor Urut" value="{{ old('no_urut', $kandidat->no_urut) }}">
                  @error('no_urut')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                  <label for="nama_kandidat" class="form-label">Nama Kandidat</label>
                  <input type="text" class="form-control" id="nama_kandidat" name="nama_kandidat" value="{{ old('nama_kandidat', $kandidat->nama_kandidat) }}" required>
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-5">
                <div class="form-group">
                  <label class="form-label" for="foto_kandidat">Foto Kandidat</label>
                  <input type="file" class="form-control @error('foto_kandidat') is-invalid @enderror" name="foto_kandidat" accept="image/*">

                  @if ($kandidat->foto_kandidat)
                    <img src="{{ asset('storage/kandidat/' . $kandidat->foto_kandidat) }}" alt="Foto Kandidat" class="img-thumbnail mt-2" style="max-width: 200px;">
                  @endif

                  @error('foto_kandidat')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                      <label for="visi" class="form-label">Visi</label>
                      <textarea class="form-control" id="visi" name="visi" rows="3" required>{{ old('visi', $kandidat->visi) }}</textarea>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                      <label for="misi" class="form-label">Misi</label>
                      <textarea class="form-control" id="misi" name="misi" rows="3" required>{{ old('misi', $kandidat->misi) }}</textarea>
                    </div>
                  </div>
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
