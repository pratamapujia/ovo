@extends('admin.layouts.index')

@section('title')
  <title>Form Edit Pemilih</title>
@endsection

@section('content')
  <div id="main-content">
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Form Edit Pemilih</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ route('pemilih.index') }}">Master Pemilih</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Form Edit Pemilih
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
              <h5>Master Pemilih</h5>
            </div>
            <div class="ms-auto">
              <a href="{{ route('pemilih.index') }}" class="btn icon icon-left btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('pemilih.update', $pemilih->id) }}" class="form" method="POST">
            @csrf
            <input type="hidden" name="_method" value="put">
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <div class="form-group">
                  <label class="form-label" for="nis">NIS</label>
                  <input type="text" class="form-control @error('nis') is-invalid @enderror" name="nis" placeholder="Masukkan NIS" value="{{ old('nis', $pemilih->nis) }}">
                  @error('nis')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="form-group">
                  <label class="form-label" for="nama_pemilih">Nama</label>
                  <input type="text" class="form-control @error('nama_pemilih') is-invalid @enderror" name="nama_pemilih" placeholder="Masukkan Nama"
                    value="{{ old('nama_pemilih', $pemilih->nama_pemilih) }}">
                  @error('nama_pemilih')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="form-group">
                  <label class="form-label" for="kelas_id">Kelas</label>
                  <select name="kelas_id" id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $data)
                      <option value="{{ $data->id }}" {{ old('kelas_id', $pemilih->kelas_id) == $data->id ? 'selected' : '' }}>
                        {{ $data->nama_kelas }}
                      </option>
                      {{-- @if (old('kelas_id') == $data->id)
                        <option value="{{ $data->id }}" selected>{{ $data->nama_kelas }}</option>
                      @else
                        <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                      @endif --}}
                    @endforeach
                  </select>
                  @error('kelas_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
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
