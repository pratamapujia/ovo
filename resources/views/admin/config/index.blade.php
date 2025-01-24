@extends('admin.layouts.index')

@section('title')
  <title>Konfigurasi Apps</title>
@endsection

@section('content')
  <div id="main-content">
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Konfigurasi Apps</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Konfigurasi Apps
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content">
      {{-- Alert --}}
      <div class="flash-data" data-berhasil="{{ Session::get('pesan') }}"></div>
      {{-- End Alert --}}
      <form action="{{ route('config.update') }}" method="POST" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body">
            @csrf
            <div class="row">
              @foreach ($config as $data)
                <div class="col-6">
                  <div class="form-group">
                    <label class="form-label">{{ $data->label }}</label>
                    @if ($data->type == 0)
                      <!-- TEXT-->
                      <input type="text" name="{{ $data->name }}" class="form-control @error($data->name) is-invalid @enderror" value="{{ $data->value }}">
                      @error($data->name)
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                    @elseif ($data->type == 1)
                      <!-- TEXTAREA-->
                      <textarea name="{{ $data->name }}" class="form-control @error($data->name) is-invalid @enderror">{{ $data->value }}</textarea>
                      @error($data->name)
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                    @elseif ($data->type == 2)
                      <!-- FILE-->
                      @php
                        $path = Storage::url('apps/' . $data->value);
                      @endphp
                      <input type="file" name="{{ $data->name }}" class="form-control @error($data->name) is-invalid @enderror">
                      @if ($data->value)
                        <div class="avatar avatar-lg mt-2">
                          <img src="{{ url($path) }}" alt="avatar">
                        </div>
                      @endif
                      @error($data->name)
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                    @elseif ($data->type == 4)
                      <!-- DATE -->
                      <input type="date" name="{{ $data->name }}" class="form-control @error($data->name) is-invalid @enderror" value="{{ $data->value }}">
                      @error($data->name)
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                    @elseif ($data->type == 5)
                      <!-- TIME -->
                      <input type="time" name="{{ $data->name }}" class="form-control @error($data->name) is-invalid @enderror" value="{{ $data->value }}">
                      @error($data->name)
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
      </form>
    </div>
  </div>
@endsection
