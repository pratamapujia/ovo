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
          <div class="col-6">
            <div class="card">
              <div class="card-body">
                <div id="chart-hasil"></div>
              </div>
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
        type: "pie",
        width: "100%",
        height: "500px",
        toolbar: {
          show: true,
        },
      },
      dataLabels: {
        enabled: true,
        style: {
          fontSize: '24px',
        }
      },
      legend: {
        position: "bottom",
      },
      // plotOptions: {
      //   pie: {
      //     donut: {
      //       size: "30%",
      //     },
      //   },
      // },
    }

    const chart = new ApexCharts(document.querySelector("#chart-hasil"), optionsVisitorsProfile);
    chart.render();
  </script>
@endsection
