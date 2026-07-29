@extends('admin.layouts.index')
@section('title')
  <title>Hasil Pemilu</title>
@endsection

@section('content')
  @php
    use Carbon\Carbon;

    // Mengambil konfigurasi batas waktu dari database
    $voteDate = \App\Models\Config::where('name', 'vote_date')->value('value');
    $voteOpen = \App\Models\Config::where('name', 'vote_open')->value('value');
    $voteClosed = \App\Models\Config::where('name', 'vote_closed')->value('value');
    $appName = \App\Models\Config::where('name', 'app_name')->value('value') ?? 'Pemilu';

    $statusPemilihan = 'sudah_selesai'; // Nilai awal (fallback)
    $bukaTanggalStr = '';
    $tutupTanggalStr = '';

    if ($voteDate && $voteOpen && $voteClosed) {
        $startDateTime = Carbon::parse($voteDate . ' ' . $voteOpen);
        $endDateTime = Carbon::parse($voteDate . ' ' . $voteClosed);
        $now = Carbon::now();

        $bukaTanggalStr = $startDateTime->translatedFormat('d F Y, H:i');
        $tutupTanggalStr = $endDateTime->translatedFormat('d F Y, H:i');

        // Pengecekan 3 Kondisi Waktu
        if ($now->lt($startDateTime)) {
            $statusPemilihan = 'belum_dimulai';
        } elseif ($now->gt($endDateTime)) {
            $statusPemilihan = 'sudah_selesai';
        } else {
            $statusPemilihan = 'sedang_berlangsung';
        }
    }
  @endphp

  <div id="main-content">
    <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Hasil Pemilu</h3>
          </div>
        </div>
      </div>

      <section class="section mt-3">
        <div class="row">
          <div class="col-12">

            {{-- KONDISI 1: JIKA PEMILIHAN BELUM DIMULAI --}}
            @if ($statusPemilihan == 'belum_dimulai')
              <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-center p-4" style="background: linear-gradient(135deg, #fdf4ff 0%, #f3e8ff 100%);">
                <div class="me-4 d-none d-sm-block">
                  <div class="p-3 rounded-circle d-flex align-items-center justify-content-center" style="background-color: rgba(149, 67, 190, 0.15);">
                    <i class="bi bi-calendar-event" style="font-size: 2.5rem; color: #9543be;"></i>
                  </div>
                </div>
                <div>
                  <h4 class="fw-bold text-dark mb-1">Pemilihan Belum Dimulai! 📅</h4>
                  <p class="mb-0 text-secondary" style="font-size: 1.05rem;">
                    Sistem pemungutan suara saat ini belum dibuka. <br>
                    Pemilihan akan dimulai secara otomatis pada <strong>{{ $bukaTanggalStr }}</strong>.
                  </p>
                </div>
              </div>

              {{-- KONDISI 2: JIKA PEMILIHAN SEDANG BERLANGSUNG --}}
            @elseif ($statusPemilihan == 'sedang_berlangsung')
              <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-center p-4" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);">
                <div class="me-4 d-none d-sm-block">
                  <div class="bg-info bg-opacity-25 p-3 rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-clock-history text-info" style="font-size: 2.5rem;"></i>
                  </div>
                </div>
                <div>
                  <h4 class="fw-bold text-dark mb-1">Pemilihan Sedang Berlangsung! ⏳</h4>
                  <p class="mb-0 text-secondary" style="font-size: 1.05rem;">
                    Grafik hasil suara saat ini disembunyikan untuk menjaga objektivitas pemilih. <br>
                    Hasil akhir akan ditampilkan secara otomatis setelah batas waktu pemilihan berakhir pada <strong>{{ $tutupTanggalStr }}</strong>.
                  </p>
                </div>
              </div>

              {{-- KONDISI 3: JIKA PEMILIHAN SUDAH SELESAI --}}
            @else
              {{-- Cek apakah variabel $chartData tidak kosong --}}
              @if (!empty($chartData) && count($chartData) > 0)
                <div class="card shadow-sm rounded-4">
                  <div class="card-body p-4">
                    <div id="chart-hasil"></div>
                  </div>
                </div>
              @else
                {{-- Jika data kosong --}}
                <div class="alert alert-warning border-warning shadow-sm rounded-4 d-flex align-items-center p-4" role="alert">
                  <i class="bi bi-exclamation-triangle-fill text-warning fs-1 me-4"></i>
                  <div>
                    <h4 class="alert-heading text-dark fw-bold mb-1">Data Kosong!</h4>
                    <p class="mb-0 text-secondary">Saat ini belum ada data hasil pemilu yang dapat ditampilkan.</p>
                  </div>
                </div>
              @endif
            @endif

          </div>
        </div>
      </section>
    </div>
  </div>
@endsection

{{-- Script hanya akan di-load jika pemilihan SUDAH SELESAI dan data chart TERSEDIA --}}
@if (isset($statusPemilihan) && $statusPemilihan == 'sudah_selesai' && !empty($chartData) && count($chartData) > 0)
  @section('script')
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script>
      const judulPemilihan = "Hasil Akhir: {{ $appName }}";
      const hasilData = @json($chartData);

      // Ambil data suara dan label
      const suaraData = hasilData.map(item => item.total_suara);
      const labelData = hasilData.map(item => item.nama_kandidat);

      // Hitung total suara dan persentase
      const totalSuara = suaraData.reduce((total, suara) => total + suara, 0);
      const persentaseData = suaraData.map(suara => {
        return totalSuara > 0 ? parseFloat(((suara / totalSuara) * 100).toFixed(1)) : 0;
      });

      let optionsVisitorsProfile = {
        series: [{
          name: 'Perolehan Suara',
          data: persentaseData
        }],
        chart: {
          type: "bar",
          width: "100%",
          height: "450px",
          toolbar: {
            show: true
          },
        },
        title: {
          text: judulPemilihan,
          align: 'center',
          margin: 30,
          style: {
            fontSize: '20px',
            fontWeight: 'bold',
            color: '#2d3748'
          }
        },
        plotOptions: {
          bar: {
            borderRadius: 6,
            horizontal: false,
            columnWidth: '55%',
            distributed: true,
            dataLabels: {
              position: 'top'
            }
          }
        },
        dataLabels: {
          enabled: true,
          offsetY: -25,
          formatter: function(val) {
            return val + "%";
          },
          style: {
            fontSize: '15px',
            colors: ["#304758"]
          }
        },
        xaxis: {
          categories: labelData,
          position: 'bottom',
          labels: {
            style: {
              fontSize: '14px',
              fontWeight: 'bold',
            }
          },
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          }
        },
        yaxis: {
          title: {
            text: 'Persentase Suara (%)',
            style: {
              fontWeight: 'bold'
            }
          },
          max: 100
        },
        colors: ['#435ebe', '#ff7976', '#57ca22', '#ffc107', '#55c6e8', '#9543be'],
        legend: {
          show: false
        },
        tooltip: {
          y: {
            formatter: function(val, opts) {
              const index = opts.dataPointIndex;
              const suaraAsli = suaraData[index];
              return val + "%";
            }
          }
        }
      }

      const chart = new ApexCharts(document.querySelector("#chart-hasil"), optionsVisitorsProfile);
      chart.render();
    </script>
  @endsection
@endif
