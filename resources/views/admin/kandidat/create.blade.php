@extends('admin.layouts.index')

@section('title')
  <title>Form Tambah Kandidat</title>
@endsection

@section('content')
  <div id="main-content">
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Form Tambah Kandidat</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ route('kandidat.index') }}">Master Kandidat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Form Tambah Kandidat
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
              <a href="{{ route('kandidat.index') }}" class="btn icon icon-left btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('kandidat.store') }}" class="form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-2">
                <div class="form-group">
                  <label class="form-label" for="no_urut">Nomor Urut</label>
                  <input type="number" class="form-control @error('no_urut') is-invalid @enderror" name="no_urut" placeholder="Masukkan Nomor Urut" value="{{ old('no_urut') }}">
                  @error('no_urut')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-5">
                <div class="form-group">
                  <label class="form-label" for="nama_kandidat">Nama Kandidat</label>
                  <input type="text" class="form-control @error('nama_kandidat') is-invalid @enderror" name="nama_kandidat" placeholder="Masukkan Nama Kandidat" value="{{ old('nama_kandidat') }}">
                  @error('nama_kandidat')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-5">
                <div class="form-group">
                  <label class="form-label" for="foto_kandidat">Foto Kandidat</label>
                  <input type="file" class="form-control @error('foto_kandidat') is-invalid @enderror" name="foto_kandidat" value="{{ old('foto_kandidat') }}">
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
                      <label class="form-label" for="visi">Visi</label>
                      <textarea type="text" class="form-control @error('visi') is-invalid @enderror" name="visi" value="{{ old('visi') }}"></textarea>
                      @error('visi')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                      <label class="form-label" for="misi">Misi</label>
                      <textarea type="text" class="form-control @error('misi') is-invalid @enderror" name="misi" value="{{ old('misi') }}"></textarea>
                      @error('misi')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
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
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
