@extends('admin.layouts.index')
@section('title')
  <title>Welcome to OVO</title>
  <style>
    .hover:hover {
      transform: scale(1.01);
      box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
      transition: all .2s ease-in-out;
    }
  </style>
@endsection
@section('content')
  <div id="main-content">
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Layout Default</h3>
            <p class="text-subtitle text-muted">The default layout.</p>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Layout Default</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <section class="section">
        <div class="row">
          <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <div class="card hover">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-12 col-sm-4 col-md-4 col-lg-5 d-flex justify-content-start ">
                    <div class="stats-icon bg-primary mb-2">
                      <i class="fas fa-users"></i>
                    </div>
                  </div>
                  <div class="col-12 col-sm-8 col-md-8 col-lg-7">
                    <h6 class="text-muted font-semibold">Jumlah Kandidat</h6>
                    <h6 class="font-extrabold mb-0">{{ $jumlah_kandidat }} Calon</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <div class="card hover">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-12 col-sm-4 col-md-4 col-lg-5 d-flex justify-content-start ">
                    <div class="stats-icon purple mb-2">
                      <i class="fas fa-user"></i>
                    </div>
                  </div>
                  <div class="col-12 col-sm-8 col-md-8 col-lg-7">
                    <h6 class="text-muted font-semibold">Jumlah Pemilih</h6>
                    <h6 class="font-extrabold mb-0">{{ $jumlah_pemilih }} Voters</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="{{ route('sudah') }}">
              <div class="card hover">
                <div class="card-body px-4 py-4-5">
                  <div class="row">
                    <div class="col-12 col-sm-4 col-md-4 col-lg-5 d-flex justify-content-start ">
                      <div class="stats-icon bg-success mb-2">
                        <i class="fas fa-user-check"></i>
                      </div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-8 col-lg-7">
                      <h6 class="text-muted font-semibold">Sudah Memilih</h6>
                      <h6 class="font-extrabold mb-0">{{ $jumlah_sudah_memilih }} Voters</h6>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="{{ route('belum') }}">
              <div class="card hover">
                <div class="card-body px-4 py-4-5">
                  <div class="row">
                    <div class="col-12 col-sm-4 col-md-4 col-lg-5 d-flex justify-content-start ">
                      <div class="stats-icon bg-danger mb-2">
                        <i class="fas fa-user-slash"></i>
                      </div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-8 col-lg-7">
                      <h6 class="text-muted font-semibold">Belum Memilih</h6>
                      <h6 class="font-extrabold mb-0">{{ $jumlah_belum_memilih }} Voters</h6>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Hasil Pemilihan</h4>
            </div>
            <div class="card-body">
              <div id="chart-hasil"></div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
  <script>
    const hasilData = @json($chartData);

    // Ambil data kandidat dan suara
    const suaraData = hasilData.map(item => item.total_suara);
    const labelData = hasilData.map(item => item.nama_kandidat);

    let optionsVisitorsProfile = {
      series: suaraData,
      labels: labelData,
      colors: ["#435ebe", "#55c6e8", "#f1b44c", "#f46a6a"],
      chart: {
        type: "donut",
        width: "100%",
        height: "350px",
        toolbar: {
          show: true,
        },
      },
      legend: {
        position: "top",
      },
      plotOptions: {
        pie: {
          donut: {
            size: "50%",
          },
        },
      },
    }

    const chart = new ApexCharts(document.querySelector("#chart-hasil"), optionsVisitorsProfile);
    chart.render();
  </script>
@endsection
