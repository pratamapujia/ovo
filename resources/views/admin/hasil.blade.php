@extends('admin.layouts.index')
@section('title')
  <title>Hasil Pemilu</title>
@endsection
@section('content')
  <div id="main-content">
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Hasil Pemilu</h3>
          </div>
        </div>
      </div>
      <section class="section">
        <div class="row">
          <div class="col-12">
            {{-- Cek apakah variabel $chartData tidak kosong --}}
            @if (!empty($chartData) && count($chartData) > 0)
              <div class="card">
                <div class="card-body">
                  <div id="chart-hasil"></div>
                </div>
              </div>
            @else
              {{-- Jika data kosong, tampilkan alert ini --}}
              <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Data Kosong!</h4>
                <p>Saat ini belum ada data hasil pemilu yang dapat ditampilkan.</p>
              </div>
            @endif
          </div>
        </div>
      </section>
    </div>
  </div>
@endsection
{{-- Script hanya akan di-load jika data chart tersedia --}}
@if (!empty($chartData) && count($chartData) > 0)
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
        chart: {
          type: "polarArea",
          width: "100%",
          height: "400px",
          toolbar: {
            show: true,
          },
        },
        fill: {
          opacity: 1
        },
        stroke: {
          width: 1,
          colors: undefined
        },
        yaxis: {
          show: false
        },
        plotOptions: {
          polarArea: {
            rings: {
              strokeWidth: 0
            },
            spokes: {
              strokeWidth: 0
            },
          }
        },
        dataLabels: {
          enabled: true,
          style: {
            fontSize: '24px',
          }
        },
        legend: {
          position: "top",
        },
      }

      const chart = new ApexCharts(document.querySelector("#chart-hasil"), optionsVisitorsProfile);
      chart.render();
    </script>
  @endsection
@endif
