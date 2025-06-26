@extends('layouts.dashboard')

@section('content')
<div class="row">
    <!-- Sensor Utama -->
    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Sensor Monitoring 🚀</h5>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><i class='bx bx-cool'></i> Suhu: <span class="fw-medium">30.2°C</span></p>
                                <p class="mb-1"><i class='bx bx-droplet'></i> Kelembapan: <span class="fw-medium">54%</span></p>
                                <p class="mb-1"><i class='bx bx-line-chart'></i> EC: <span class="fw-medium">213ppm</span></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><i class='bx bx-test-tube'></i> pH: <span class="fw-medium">7.2</span></p>
                                <p class="mb-1"><i class='bx bx-line-chart'></i> TDS: <span class="fw-medium">1588ppm</span></p>
                            </div>
                        </div>
                        <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Sensor -->
    <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
            @foreach ([
                ['icon' => 'bx-droplet', 'color' => 'text-danger', 'label' => 'Suhu', 'value' => '30.2°C', 'status' => 'panas', 'statusColor' => 'text-dangger'],
                ['icon' => 'bx-droplet', 'color' => 'text-info', 'label' => 'Kelembapan', 'value' => '54%', 'status' => 'Sedang', 'statusColor' => 'text-warning']
            ] as $stat)
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class='bx {{ $stat['icon'] }} fs-1 {{ $stat['color'] }}'></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">{{ $stat['label'] }}</span>
                        <h3 class="card-title mb-2">{{ $stat['value'] }}</h3>
                        <small class="{{ $stat['statusColor'] }} fw-semibold"><i class='bx bx-up-arrow-alt'></i> {{ $stat['status'] }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Grafik Sensor -->
    <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Rata-rata Pembacaan Sensor</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        7 Hari Terakhir
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);">24 Jam Terakhir</a>
                        <a class="dropdown-item" href="javascript:void(0);">30 Hari Terakhir</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="sensorChart"></div>
            </div>
        </div>
    </div>

    <!-- Sensor Tambahan -->
    <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
            @foreach ([
                ['icon' => 'bx-test-tube', 'color' => 'text-success', 'label' => 'pH Air', 'value' => '7.2', 'status' => 'Optimal', 'statusColor' => 'text-success'],
                ['icon' => 'bx-line-chart', 'color' => 'text-warning', 'label' => 'TDS', 'value' => '1539ppm', 'status' => 'Normal', 'statusColor' => 'text-success'],
                ['icon' => 'bx-line-chart', 'color' => 'text-warning', 'label' => 'EC', 'value' => '213ppm', 'status' => 'Normal', 'statusColor' => 'text-success']
            ] as $sensor)
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class='bx {{ $sensor['icon'] }} fs-1 {{ $sensor['color'] }}'></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">{{ $sensor['label'] }}</span>
                        <h3 class="card-title mb-2">{{ $sensor['value'] }}</h3>
                        <small class="{{ $sensor['statusColor'] }} fw-semibold"><i class='bx bx-down-arrow-alt'></i> {{ $sensor['status'] }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Deteksi Kesehatan Tanaman -->
    <div class="col-12 col-lg-8 order-2 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>CNN-YOLO Plant Health Detection</h5>
                <button class="btn btn-sm btn-outline-primary">
                    <i class='bx bx-camera'></i> Capture
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="position-relative">
                            <img src="{{ asset('hama_padi/static/saved_images/IMG_20250412_104605.jpg') }}" class="img-fluid rounded mb-3" alt="YOLO Detection">
                            <div class="detection-results">
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">Luka Bakar Daun</span>
                                <span class="badge bg-warning position-absolute top-0 end-0 m-2">65%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="health-analysis">
                            <h6>Health Analysis Report:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class='bx bx-check-circle text-success'></i> Pertumbuhan daun optimal</li>
                                <li class="mb-2"><i class='bx bx-x-circle text-danger'></i> Deteksi kekurangan nitrogen (35% confidence)</li>
                                <li class="mb-2"><i class='bx bx-alert text-warning'></i> Potensi serangan kutu daun</li>
                            </ul>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success" style="width: 65%">Health Score</div>
                            </div>
                            <small class="text-muted">Terakhir update: 5 menit lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi Sistem -->
    <div class="col-4 col-md-4 col-lg-4 order-3 order-md-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rekomendasi Sistem</h5>
                @foreach ([
                    ['icon' => 'bx-water', 'color' => 'alert-warning', 'message' => 'TSP/SP36 (Fosfor/P) (+150ml)'],
                    ['icon' => 'bx-check', 'color' => 'alert-success', 'message' => 'Level pH dalam batas normal'],
                    ['icon' => 'bx-bug', 'color' => 'alert-danger', 'message' => 'Lakukan pest control segera!']
                ] as $recommendation)
                <div class="alert {{ $recommendation['color'] }} mb-3">
                    <i class='bx {{ $recommendation['icon'] }}'></i> {{ $recommendation['message'] }}
                </div>
                @endforeach
                <div class="text-center">
                    <button class="btn btn-primary">
                        <i class='bx bx-refresh'></i> Refresh Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Pembacaan -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Riwayat Pembacaan Sensor (7 Hari Terakhir)</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);">Lihat Semua</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Suhu (°C)</th>
                                <th>Kelembapan (%)</th>
                                <th>pH</th>
                                <th>TDS (ppm)</th>
                                <th>EC (ppm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dummyData = [
                                    ['2024-04-14 08:00', 28.0, 65, 6.5, 1013, 157],
                                    ['2024-04-14 08:15', 28.2, 64, 6.6, 1067, 161],
                                    ['2024-04-14 08:30', 28.4, 63, 6.7, 1116, 164],
                                    ['2024-04-14 08:45', 28.6, 62, 6.8, 1175, 168],
                                    ['2024-04-14 09:00', 28.8, 61, 6.8, 1224, 172],
                                    ['2024-04-14 09:15', 29.0, 60, 6.9, 1273, 177],
                                    ['2024-04-14 09:30', 29.2, 60, 7.0, 1312, 183],
                                    ['2024-04-14 09:45', 29.3, 59, 7.0, 1364, 186],
                                    ['2024-04-14 10:00', 29.5, 58, 7.0, 1403, 192],
                                    ['2024-04-14 10:15', 29.7, 57, 7.1, 1452, 198],
                                    ['2024-04-14 10:30', 29.8, 56, 7.1, 1490, 203],
                                    ['2024-04-14 10:45', 30.0, 55, 7.2, 1539, 208],
                                    ['2024-04-14 11:00', 30.2, 54, 7.2, 1588, 213]
                                ];
                            @endphp

                            @foreach ($dummyData as $data)
                            <tr>
                                <td>{{ $data[0] }}</td>
                                <td>{{ $data[1] }}</td>
                                <td>{{ $data[2] }}</td>
                                <td>{{ $data[3] }}</td>
                                <td>{{ $data[4] }}</td>
                                <td>{{ $data[5] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endpush

@push('script')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
    // Generate dates for last 7 days
    const dates = [];
    for (let i = 6; i >= 0; i--) {
        const d = new Date();
        d.setDate(d.getDate() - i);
        dates.push(d.toISOString().split('T')[0]);
    }

    const sensorChartOptions = {
        chart: {
            type: 'line',
            height: 300,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true
                }
            }
        },
        series: [
            {
                name: 'Suhu (°C)',
                data: [28.1, 28.3, 28.0, 28.5, 28.2, 28.4, 28.7]
            },
            {
                name: 'Kelembapan (%)',
                data: [65, 63, 67, 62, 64, 66, 63]
            },
            {
                name: 'pH',
                data: [6.5, 6.6, 6.7, 6.8, 6.75, 6.9, 6.8]
            },
            {
                name: 'TDS (ppm)',
                data: [345, 350, 340, 355, 360, 350, 345]
            },
            {
                name: 'EC (ppm)',
                data: [342, 348, 338, 353, 358, 352, 343]
            }
        ],
        stroke: {
            curve: 'smooth',
            width: [3, 3, 3, 3, 3]
        },
        colors: ['#FF4560', '#00E396', '#775DD0', '#00BFFF', '#008FFB'],
        markers: {
            size: 5,
            hover: {
                size: 7
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function (value, { series, seriesIndex, dataPointIndex, w }) {
                    if (seriesIndex === 2) { // pH
                        return value.toFixed(2);
                    }
                    return value.toFixed(1);
                }
            }
        },
        grid: {
            borderColor: '#e7e7e7',
            row: {
                colors: ['#f8f8f8', 'transparent']
            }
        },
        xaxis: {
            categories: dates,
            labels: {
                formatter: function(value) {
                    return new Date(value).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short'
                    });
                }
            }
        },
        yaxis: [
            {
                title: {
                    text: 'Suhu (°C)'
                },
                min: 27,
                max: 30
            },
            {
                opposite: true,
                title: {
                    text: 'Kelembapan (%)'
                },
                min: 60,
                max: 70
            }
        ]
    };

    const sensorChart = new ApexCharts(document.querySelector("#sensorChart"), sensorChartOptions);
    sensorChart.render();
</script>
@endpush
