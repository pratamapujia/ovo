@extends('admin.layouts.index')

@section('title')
  <title>Form Tambah User</title>
@endsection

@section('content')
  <div id="main-content">
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Form Tambah User</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ route('user.index') }}">Master User</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Form Tambah User
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
              <h5>Master User</h5>
            </div>
            <div class="ms-auto">
              <a href="{{ route('user.index') }}" class="btn icon icon-left btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('user.store') }}" class="form" method="POST">
            @csrf
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label class="form-label" for="name">Nama</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Masukkan Nama" value="{{ old('name') }}">
                  @error('name')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label class="form-label" for="email">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan Email" value="{{ old('email') }}">
                  @error('email')
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
