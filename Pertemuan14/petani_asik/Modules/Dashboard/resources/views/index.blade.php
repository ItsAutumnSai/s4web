@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
<div class="row justify-content-center">
    <!-- Main Sensor Dashboard -->
    <div class="col-lg-7 mb-4 order-0">
        <div class="card sensor-dashboard">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-white"><div class="spinner-grow text-danger small-spinner" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>   {{ __('label.realTimeEnvironmentalMonitoring') }}</h5>
                <div class="badge bg-white text-primary">{{ __('label.liveData') }}</div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Weather Sensors -->
                    <div class="col-md-6">
                        <div class="sensor-card weather-card h-100">
                            <div class="sensor-header d-flex align-items-center mb-3">
                                <i class='bx bx-cloud fs-2 text-info me-3'></i>
                                <h6 class="mb-0">{{ __('label.weatherConditions') }}</h6>
                            </div>
                            <div class="sensor-body">
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class="fa fa-temperature-quarter me-3"></i> {{ __('label.temperature') }}:</span>
                                    <span id="temperature" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-droplet me-2'></i>{{ __('label.humidity_1') }}:</span>
                                    <span id="humidity" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-cloud me-2'></i>VPD:</span>
                                    <span id="vpd" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-wind me-2'></i>{{ __('label.windSpeed') }}:</span>
                                    <span id="windspeed" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-cloud-rain me-2'></i>{{ __('label.rainfall_1') }}:</span>
                                    <span id="rainfall" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-sun me-2'></i>{{ __('label.lightIntensity') }}:</span>
                                    <span id="light_intensity" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class="bx bxs-thermometer" style="color: #000;"></i></i>{{ __('label.pressure_1') }}:</span>
                                    <span id="pressure" class="fw-bold">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Soil Sensors -->
                    <div class="col-md-6">
                        <div class="sensor-card soil-card h-100">
                            <div class="sensor-header d-flex align-items-center mb-3">
                                <i class='bx bx-leaf fs-2 text-success me-3'></i>
                                <h6 class="mb-0">{{ __('label.soilConditions') }}</h6>
                            </div>
                            <div class="sensor-body">
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-test-tube me-2'></i>{{ __('label.phLevel') }}:</span>
                                    <span id="ph" class="fw-bold">Loading...</span>

                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-line-chart me-2'></i>{{ __('label.soilMoisture') }}:</span>
                                    <span id="soil_moisture" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-atom me-2'></i>{{ __('label.ec_1') }}:</span>
                                    <span id="ec" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class="bx bx-droplet"></i>{{ __('label.tds') }}:</span>
                                    <span id="tds" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-layer me-2'></i>{{ __('label.soilTemp') }}:</span>
                                    <span id="soil_temp" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class="bx bx-badge-check me-2"></i></i>N:</span>
                                    <span id="nitrogen" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx  bx-test-tube me-2'></i>P:</span>
                                    <span id="phosphorus" class="fw-bold">Loading...</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class="bx bx-gas-pump me-2"></i></i>K:</span>
                                    <span id="potassium" class="fw-bold">Loading...</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Lidar detection --}}
                    <div class="col-md-6">
                        <div class="sensor-card air-card h-100">
                            <div class="sensor-header d-flex align-items-center mb-3">
                                <i class='bx bx-bug fs-2 text-primary me-3'></i>
                                <h6 class="mb-0">{{ __('label.pest') }}</h6>
                            </div>
                         <div class="lidar-stats">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="stat-box p-2 text-center bg-light rounded">
                                        <i class='bx bx-bug fs-3 text-info mb-1'></i>
                                        <div class="text-muted small">{{ __('label.deteksi') }}</div>
                                        <div id="hama" class="fw-bold fs-5">Loading...</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-box p-2 text-center bg-light rounded">
                                        <i class='bx bx-equalizer fs-3 text-danger mb-1'></i>
                                        <div class="text-muted small">{{ __('label.ultrasonic') }}</div>
                                        <div id="ultrasonic_status" class="fw-bold fs-5">Loading...</div>
                                    </div>
                                </div>
                            </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1" >
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1" >
                                    <span class="d-flex align-items-center"><i class='bx bx-gas-pump me-2'></i>{{ __('label.feromon') }}:</span>
                                    <span id="feromon" class="fw-bold">Loading...</span>
                                </div>
                        </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="col-md-6">
                        <div class="sensor-card status-card h-100">
                            <div class="sensor-header d-flex align-items-center mb-3">
                                <i class='bx bx-cog fs-2 text-warning me-3'></i>
                                <h6 class="mb-0">{{ __('label.systemStatus') }}</h6>
                            </div>
                            <div class="sensor-body">
                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class="fa-solid fa-battery-three-quarters me-2"></i> {{ __('label.batteryLevel') }}:</span>
                                    <span id="battery_level" class="fw-bold">Loading...</span>
                                </div>
                                <div class="status-item mb-3">
                                    <span id="battery_levelbar" class="fw-bold"></span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-signal-5 me-2'></i>{{ __('label.signalStrength') }}:</span>
                                    <span id="signal_strength" class="fw-bold">Loading...</span>
                                </div>
                                <div class="status-item mb-3">
                                    <span id="signal_strengthbar" class="fw-bold"></span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <span class="d-flex align-items-center"><i class='bx bx-time me-2'></i>{{ __('label.lastUpdate') }}:</span>
                                    <span id="last_update" class="fw-bold">Loading...</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side Column -->
    <div class="col-5 order-1">
        <div class="row g-3">

            <!-- YOLO Camera Detection -->
            <div class="col-12">
                <div class="card detection-card h-100">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                         <h5 class="card-title mb-0 text-white"><i class="bx bx-camera me-2"></i>{{ __('label.yoloPestDetection') }}</h5>
                        {{-- <i class="bx bx-info-circle fs-5"></i> --}}
                    </div>

                    <div class="card-body">
                        <div class="detection-image mb-3">
                           <!-- Loading Spinner (This will show while the image is being loaded) -->
                            <div id="loading-spinner-container" class="d-flex justify-content-center align-items-center" >
                                <div id="loading-spinner" class="spinner-border spinner-border-lg text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <!-- Placeholder image (this will be updated with AJAX data) -->
                            <img id="image" src="" class="img-fluid rounded d-block mx-auto" width="300" style="display: none;">

                            <div class="detection-overlay">
                                <span id="penyakit_up" class="badge bg-danger">Loading...</span>
                                <span id="probabilitas_up" class="badge bg-warning">Loading...</span>
                            </div>
                        </div>
                        <div class="detection-details">
                            <h6 class="fw-semibold mb-2">{{ __('label._detectionSummary') }}:</h6>
                            <ul class="detection-list list-unstyled mb-3">
                                <li class="text-danger mb-1 d-flex align-items-center" id="penyakit"> Loading...</li>
                                <li class="text-warning mb-1 d-flex align-items-center" id="probabilitas">Loading...</li>
                            </ul>
                            <div class="health-score">
                                @if(isset($forecastData_first['confidence']['Healthy']))
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-success">
                                            {{ __('label.plant_health_score') }}:
                                        </span>
                                        <span class="fw-bold text-end" id="planthealth">
                                            {{ number_format($forecastData_first['confidence']['Healthy'] * 100, 4) }}%
                                        </span>
                                    </div>

                                <div class="status-item mb-3">
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" style="width: {{ number_format($forecastData_first['confidence']['Healthy'] * 100, 4) }}%"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row - Charts and Recommendations -->
    <div class="col-lg-8 order-2 order-lg-3 mb-4 mt-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bx bx-line-chart me-2"></i> {{ __('label.trendprediction') }}</h5>

            </div>
            <div class="card-body">
                <div id="environmentChart" style="min-height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Recommendations -->
    <div class="col-lg-4 order-3 order-lg-2 mb-4 mt-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-white"><i class="bx bx-bell me-2"></i> {{ __('label.rekomendasi') }}</h5>
            </div>
            <div class="card-body recommendations-scroll" id="recommendations">
                <!-- Recommendations will be dynamically loaded here via AJAX -->
            </div>
        </div>
    </div>


    <!-- Prediction Table -->
    <div class="col-lg-12 mb-4 order-4">
        <div class="card sensor-dashboard">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-white"><i class="fa-solid fa-wand-magic-sparkles"></i>
                    {{ __('label.prediction') }}</h5>
                <div class="btn-group badge bg-white btn-group-sm me-2">
                    <a href="{{ url('/dashboard?days=1') }}" class="btn btn-outline-info @if($days == 1) active @endif">1d</a>
                    <a href="{{ url('/dashboard?days=3') }}" class="btn btn-outline-info @if($days == 3) active @endif">3d</a>
                    <a href="{{ url('/dashboard?days=7') }}" class="btn btn-outline-info @if($days == 7) active @endif">7d</a>
                    <a href="{{ url('/dashboard?days=14') }}" class="btn btn-outline-info @if($days == 14) active @endif">14d</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('label.timestamp') }}</th>
                                <th>{{ __('label.temp') }}</th>
                                <th>{{ __('label.humidity') }}</th>
                                <th>{{ __('label.light_intensity') }}</th>
                                <th>{{ __('label.ph_level') }}</th>
                                <th>{{ __('label.soil_moisture') }}</th>
                                <th>{{ __('label.soil_temp') }}</th>
                                <th>{{ __('label.nitrogen') }}</th>
                                <th>{{ __('label.potasium') }}</th>
                                <th>{{ __('label.kesimpulan') }}</th>
                            </tr>
                        </thead>
                        <tbody id="sensorDataBody">
                            @if($forecastData)
                                @foreach ($forecastData as $forecast)
                                    <tr>
                                        <td>{{ $forecast['date'] }}</td>
                                        <td>{{ number_format($forecast['temperature'], 2) }} °C</td>
                                        <td>{{ number_format($forecast['humidity'], 2) }} %</td>
                                        <td>{{ number_format($forecast['light_intensity'], 2) }} lux</td>
                                        <td>{{ number_format($forecast['ph'], 2) }}</td>
                                        <td>{{ number_format($forecast['soil_moisture'], 2) }} %</td>
                                        <td>{{ number_format($forecast['soil_temp'], 2) }} °C</td>
                                        <td>{{ number_format($forecast['nitrogen'], 2) }}</td>
                                        <td>{{ number_format($forecast['potassium'], 2) }}</td>
                                        <td>{{ $forecast['predicted_health'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="9">No data available</td></tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Pagination Controls -->
                    <nav aria-label="Page navigation" class="mt-3">
                        <ul class="pagination justify-content-center pagination-sm">
                            @php
                                $maxPagesToShow = 5;
                                $halfMaxPages = floor($maxPagesToShow / 2);

                                $startPage = max($currentPage - $halfMaxPages, 1);
                                $endPage = min($currentPage + $halfMaxPages, $totalPages);

                                if ($startPage > 1) {
                                    $startPage = max($currentPage - $halfMaxPages, 1);
                                }

                                if ($endPage < $totalPages) {
                                    $endPage = min($currentPage + $halfMaxPages, $totalPages);
                                }
                            @endphp

                            {{-- Previous Button --}}
                            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ url('/dashboard?days=' . $days . '&page=' . ($currentPage - 1)) }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo; {{ __('label.previous') }}</span>
                                </a>
                            </li>

                            {{-- Pages --}}
                            @for ($i = $startPage; $i <= $endPage; $i++)
                                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                    <a class="page-link" href="{{ url('/dashboard?days=' . $days . '&page=' . $i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Next Button --}}
                            <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ url('/dashboard?days=' . $days . '&page=' . ($currentPage + 1)) }}" aria-label="Next">
                                    <span aria-hidden="true">{{ __('label.next') }} &raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
<style>
    .recommendations-scroll {
        max-height: 350px;   /* Sesuaikan tinggi area rekomendasi */
        overflow-y: auto;    /* Menambahkan scrollbar vertikal jika konten lebih banyak dari batas tinggi */
    }

    .small-spinner {
    width: 1.2rem;
    height: 1.2rem;
    }

    .sensor-dashboard {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .sensor-card {
        border-radius: 8px;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        padding: 1rem;
    }

    .sensor-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .weather-card {
        background: linear-gradient(135deg, rgba(246, 249, 252, 0.9) 0%, rgba(238, 242, 245, 0.9) 100%);
        border-left: 4px solid #0dcaf0;
    }

    .soil-card {
        background: linear-gradient(135deg, rgba(243, 244, 229, 0.9) 0%, rgba(232, 233, 213, 0.9) 100%);
        border-left: 4px solid #198754;
    }

    .air-card {
        background: linear-gradient(135deg, rgba(230, 247, 255, 0.9) 0%, rgba(208, 235, 255, 0.9) 100%);
        border-left: 4px solid #0d6efd;
    }

    .status-card {
        background: linear-gradient(135deg, rgba(248, 249, 250, 0.9) 0%, rgba(233, 236, 239, 0.9) 100%);
        border-left: 4px solid #ffc107;
    }

    .sensor-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding-bottom: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .detection-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .detection-image {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .detection-overlay {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        display: flex;
        justify-content: space-between;
    }

    .detection-list li {
        padding: 0.25rem 0;
    }

    .lidar-visualization {
        height: 180px;
        background-color: #f8f9fa;
        border-radius: 8px;
        position: relative;
        margin-bottom: 1rem;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .lidar-grid {
        width: 100%;
        height: 100%;
        position: relative;
        background-image:
            linear-gradient(rgba(0, 0, 0, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
        background-size: 20px 20px;
    }

    .lidar-point {
        position: absolute;
        width: 12px;
        height: 12px;
        background-color: rgba(220, 53, 69, 0.7);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    .stat-box {
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .sensor-item {
        transition: all 0.3s ease;
        border-radius: 6px;
        padding: 0.5rem;
    }

    .sensor-item:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }

    .sensor-item.online {
        border-left: 3px solid #198754;
    }

    .sensor-item.warning {
        border-left: 3px solid #ffc107;
    }

    .sensor-item.offline {
        border-left: 3px solid #dc3545;
    }

    .alert {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .alert:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .table-hover tbody tr {
        transition: all 0.3s ease;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transform: translateX(3px);
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .progress {
        border-radius: 4px;
    }

    .progress-bar {
        border-radius: 4px;
    }
</style>
@endpush

@push('script')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
    // Environmental Trends Chart
    const environmentChartOptions = {
        series: [
        {
            name: "Stress (%)",
            data: @json($forecastDatagraph['forecast']).map(item => (item.confidence["High Stress"] + item.confidence["Moderate Stress"]) * 100),// Map High Stress and Moderate Stress
            type: "line"
        },
        {
            name: "Healthy (%)",
            data: @json($forecastDatagraph['forecast']).map(item => item.confidence.Healthy * 100), // Map Healty
            type: "line"
        }
    ],
        chart: {
            height: "100%",
            type: "line",
            stacked: false,
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
            },
            zoom: {
                enabled: true
            }
        },
        stroke: {
            width: [3, 3, 0],
            curve: "smooth"
        },
        plotOptions: {
            bar: {
                columnWidth: "50%"
            }
        },
        fill: {
            opacity: [1, 1, 0.2],
            type: ["solid", "solid", "gradient"],
            gradient: {
                shade: 'light',
                type: "vertical",
                shadeIntensity: 0.5,
                gradientToColors: ['#008FFB'],
                inverseColors: false,
                opacityFrom: 0.5,
                opacityTo: 0.1,
                stops: [0, 100]
            }
        },
        colors: ["#FF4560", "#00E396", "#008FFB"],
        labels: @json($forecastDatagraph['forecast']).map(item => item.date),
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
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(1) + (this.series.index === 2 ? '%' : '');
                    }
                    return y;
                }
            }
        },
        xaxis: {
            type: "category",
            labels: {
                style: {
                    colors: '#6c757d'
                }
            }
        },
        yaxis: [
            {
                seriesName: "Stress",
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#FF4560"
                },
                labels: {
                    style: {
                        colors: "#FF4560"
                    },
                    formatter: function(val) {
                        return val.toFixed(1);
                    }
                },
                title: {
                    text: "Stress (%)",
                    style: {
                        color: "#FF4560",
                        fontSize: '12px'
                    }
                },
                min: 0,  // Dynamic min value with margin
                max: 100   // Dynamic max value with margin
            },
            {
                seriesName: "Healthy",
                opposite: true,
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#00E396"
                },
                labels: {
                    style: {
                        colors: "#00E396"
                    },
                    formatter: function(val) {
                        return val.toFixed(0);
                    }
                },
                title: {
                    text: "Healthy (%)",
                    style: {
                        color: "#00E396",
                        fontSize: '12px'
                    }
                },
                min: 0,  // Dynamic min value with margin
                max: 100  // Dynamic max value with margin
            }
        ],
        legend: {
            position: "top",
            horizontalAlign: "center",
            offsetY: 0,
            markers: {
                radius: 12
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            }
        },
        grid: {
            borderColor: '#f1f1f1',
            strokeDashArray: 4,
            padding: {
                top: 20,
                right: 20,
                bottom: 0,
                left: 20
            }
        }
    };

    const environmentChart = new ApexCharts(document.querySelector("#environmentChart"), environmentChartOptions);
    environmentChart.render();

    // Initialize tooltips
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>


<script>
    function setErrorMessageForElements() {
        const errorMessage = 'Data tidak tersedia';
        const elements = [
            '#temperature', '#humidity', '#vpd', '#windspeed', '#rainfall',
            '#light_intensity', '#ph', '#soil_moisture','#npk', '#ec',
            '#soil_temp', '#pressure', '#feromon', '#air_quality_index',
            '#battery_level', '#signal_strength', '#last_update','#penyakit', '#probabilitas', '#penyakit_up',
            '#probabilitas_up', '#hama'
        ];

        elements.forEach(element => {
            $(element).html(errorMessage);
        });
    }

    function fetchData() {
        $.get('/datasensor', function(data) {
            var temperature = data.data[0].temperature;
            var humidity = data.data[0].humidity;
            let svp = 0.6108 * Math.exp((17.27 * parseFloat(temperature)) / (parseFloat(temperature) + 237.3));
            let vpd = svp * (1 - parseFloat(humidity) / 100);
            var windspeed = data.data[0].windspeed;
            var rainfall = data.data[0].rainfall;
            var light_intensity = data.data[0].light_intensity;
            var ph = data.data[0].ph;
            var soil_moisture = data.data[0].soil_moisture;
            var ec = data.data[0].ec;
            var tds = data.data[0].tds;
            var soil_temp = data.data[0].soil_temp;
            var pressure = data.data[0].pressure;
            var feromon = data.data[0].feromon;
            var battery_level = data.data[0].battery_level;
            var signal_strength = data.data[0].signal_strength;
            var nitrogen = data.data[0].nitrogen;
            var potassium = data.data[0].potassium;
            var fosfor = data.data[0].fosfor;
            var last_update = data.data[0].created_at;

            var temperatureText = temperature + ' °C ';
            var humidityText = humidity + '%';
            let vpdText = vpd.toFixed(2) + ' kPa';
            var windspeedText = windspeed + ' m/s';
            var rainfallText = rainfall + ' mm';
            var lightIntensityText = light_intensity + ' lux';
            var phText = ph;
            var soil_moistureText = soil_moisture + ' %';
            var nitrogenText = nitrogen + ' mg/kg';
            var potassiumText = potassium + ' mg/kg';
            var fosforText = fosfor + ' mg/kg';
            var ecText = ec + ' µS/cm';
            var tdsText = tds + ' ppm';
            var soil_tempText = soil_temp + ' °C ';
            var pressureText = pressure + ' Pa';
            var battery_levelText = battery_level + ' %';
            var signal_strengthText = signal_strength;
            var veromontext = '';

            var battery_levelforBar = battery_level + '%';
            var signal_strengthforBar = signal_strength + '%';

            var createdAtDate = new Date(last_update);

            var currentDate = new Date();

            var diffInMillis = currentDate - createdAtDate;

            var diffInSeconds = Math.floor(diffInMillis / 1000);
            var diffInMinutes = Math.floor(diffInSeconds / 60);
            var diffInHours = Math.floor(diffInMinutes / 60);
            var diffInDays = Math.floor(diffInHours / 24);

            var last_updateText = '';

             // If the difference is less than 1 minute, show "Now"
            if (diffInSeconds < 60) {
                last_updateText = '{{ __('label.now') }}';
            } else if (diffInDays > 0) {
                last_updateText = diffInDays + ' {{ __('label.day') }}';
            } else if (diffInHours > 0) {
                last_updateText = diffInHours + ' {{ __('label.hour') }}';
            } else if (diffInMinutes > 0) {
                last_updateText = diffInMinutes + ' {{ __('label.minute') }}';
            } else {
                last_updateText = diffInSeconds + ' {{ __('label.second') }}';
            }

            // Determine the badge class based on temperature
            if (temperature >= 28) {
                temperatureText += '<span class="badge bg-danger ms-2">{{ __('label.high') }}</span>';
            } else if (temperature <= 22) {
                temperatureText += '<span class="badge bg-warning ms-2">{{ __('label.low') }}</span>';
            } else {
                temperatureText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on humidity
            if (humidity >= 85) {
                humidityText += '<span class="badge bg-danger ms-2">{{ __('label.high') }}</span>';
            } else if (humidity <= 70) {
                humidityText += '<span class="badge bg-warning ms-2">{{ __('label.low') }}</span>';
            } else {
                humidityText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on VPD
            if (vpd >= 1.5) {
                vpdText += '<span class="badge bg-danger ms-2">{{ __('label.high') }}</span>';
            } else if (vpd <= 0.5) {
                vpdText += '<span class="badge bg-warning ms-2">{{ __('label.low') }}</span>';
            } else {
                vpdText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on Wine
            if (windspeed >= 3.6) {
                windspeedText += '<span class="badge bg-danger ms-2">{{ __('label.speed') }}</span>';
            }else {
                windspeedText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on ph
            if (ph > 7.0) {
                phText += '<span class="badge bg-danger ms-2">{{ __('label.basa') }}</span>';
            } else if (ph <= 5.5) {
                phText += '<span class="badge bg-warning ms-2">{{ __('label.asam') }}</span>';
            } else {
                phText += '<span class="badge bg-success ms-2">{{ __('label.netral') }}</span>';
            }

            // Determine the badge class based on soil moisture
            if (soil_moisture > 85) {
                soil_moistureText += '<span class="badge bg-danger ms-2">{{ __('label.basah') }}</span>';
            } else if (soil_moisture < 70) {
                soil_moistureText += '<span class="badge bg-warning ms-2">{{ __('label.kering') }}</span>';
            } else {
                soil_moistureText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on EC
            if (ec >= 1500) {
                ecText += '<span class="badge bg-danger ms-2">{{ __('label.high') }}</span>';
            } else if (ec <= 800) {
                ecText += '<span class="badge bg-warning ms-2">{{ __('label.low') }}</span>';
            } else {
                ecText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on TDS
            if (tds > 500) {
                tdsText += '<span class="badge bg-danger ms-2">{{ __('label.high') }}</span>';
            } else {
                tdsText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on temperature of Soil
            if (soil_temp >= 34) {
                soil_tempText += '<span class="badge bg-danger ms-2">{{ __('label.high') }}</span>';
            } else if (soil_temp <= 27) {
                soil_tempText += '<span class="badge bg-warning ms-2">{{ __('label.low') }}</span>';
            } else {
                soil_tempText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on nitrogen
            if (nitrogen >= 50) {
                nitrogenText += '<span class="badge bg-danger ms-2">{{ __('label.high') }}</span>';
            } else if (nitrogen <= 20) {
                nitrogenText += '<span class="badge bg-warning ms-2">{{ __('label.low') }}</span>';
            } else {
                nitrogenText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on potassium
            if (potassium >= 200) {
                potassiumText += '<span class="badge bg-danger ms-2">{{ __('label.high') }}</span>';
            } else if (potassium <= 100) {
                potassiumText += '<span class="badge bg-warning ms-2">{{ __('label.low') }}</span>';
            } else {
                potassiumText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on fosfor
            if (fosfor >= 30) {
                fosforText += '<span class="badge bg-danger ms-2">{{ __('label.high') }}</span>';
            } else if (fosfor <= 10) {
                fosforText += '<span class="badge bg-warning ms-2">{{ __('label.low') }}</span>';
            } else {
                fosforText += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            // Determine the badge class based on Feromon
            if (feromon < 1000) {
                veromontext += '<span class="badge bg-warning ms-2">{{ __('label.ganti') }}</span>';
            } else {
                veromontext += '<span class="badge bg-success ms-2">{{ __('label.normal') }}</span>';
            }

            $('#temperature').html(temperatureText);
            $('#humidity').html(humidityText);
            $('#vpd').html(vpdText);
            $('#windspeed').html(windspeedText);
            $('#rainfall').html(rainfallText);
            $('#light_intensity').html(lightIntensityText);
            $('#ph').html(phText);
            $('#soil_moisture').html(soil_moistureText);
            $('#ec').html(ecText);
            $('#tds').html(tdsText);
            $('#soil_temp').html(soil_tempText);
            $('#nitrogen').html(nitrogenText);
            $('#potassium').html(potassiumText);
            $('#phosphorus').html(fosforText);
            $('#pressure').html(pressureText);
            $('#feromon').html(veromontext);
            $('#battery_level').html(battery_levelText);
            $('#signal_strength').html(signal_strengthText);
            $('#last_update').html(last_updateText);

            $('#battery_levelbar').html(`
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: ${battery_levelforBar}"></div>
                </div>
            `);
            $('#signal_strengthbar').html(`
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-info" style="width: ${signal_strengthforBar}"></div>
                </div>
            `);


        }).fail(function() {
            setErrorMessageForElements();
        });
    }
    function fetchRecommendations(page = 1, days = 3) {
        $.get('/getRecommendations', { page: page, days: days }, function(response) {
            var recommendationHtml = '';
            var paginationHtml = '';

            response.recommendations.forEach(function(recommendation) {
                recommendationHtml += `
                    <div class="alert alert-${recommendation.type} d-flex align-items-start p-3 mb-3">
                        <i class="${recommendation.icon} fs-4 me-3"></i>
                        <div>
                            <strong class="d-block">${recommendation.title}</strong>
                            <p class="mb-0 small">${recommendation.message}</p>
                        </div>
                    </div>
                `;
            });

            $('#recommendations').html(recommendationHtml);

            if (response.totalPages > 1) {
                paginationHtml += `<nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center pagination-sm">`;

                paginationHtml += `
                    <li class="page-item ${response.currentPage == 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="fetchRecommendations(${response.currentPage - 1}, ${days})" aria-label="Previous">
                            <span aria-hidden="true">&laquo; Previous</span>
                        </a>
                    </li>`;

                for (let i = 1; i <= response.totalPages; i++) {
                    paginationHtml += `
                        <li class="page-item ${i == response.currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" onclick="fetchRecommendations(${i}, ${days})">${i}</a>
                        </li>
                    `;
                }

                paginationHtml += `
                    <li class="page-item ${response.currentPage == response.totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" onclick="fetchRecommendations(${response.currentPage + 1}, ${days})" aria-label="Next">
                            <span aria-hidden="true">Next &raquo;</span>
                        </a>
                    </li>
                </ul>
                </nav>`;
            } else {
                paginationHtml = '';
            }

            $('#pagination').html(paginationHtml);

        }).fail(function() {
            $('#recommendations').html('<p>No recommendations available.</p>');
            $('#pagination').html('');
        });

    }


  $(document).ready(function() {
        fetchData();
        fetchRecommendations();
        setInterval(fetchData, 5000);
        setInterval(fetchRecommendations, 5000);
    });
    setInterval(fetchData, 5000);
</script>

<script>

    function fetchData() {
        $.ajax({
            url: '/datayolo',
            method: 'GET',
            success: function(response) {
                var imageUrl = response.data[0].image_url;
                var penyakit = response.data[0].penyakit;
                var probabilitas = response.data[0].probabilitas;

                var penyakitText = '<i class="bx bx-bug me-2"></i> {{ __('label.diseases') }}: ' + penyakit;
                var probabilitasText = '<i class="bx bx-leaf me-2"></i> {{ __('label.probability') }}: ' + probabilitas + '%';
                var probabilitasTextup = probabilitas + '%';


                var imageSrc = "{{ asset('img/hama_padi/') }}/" + imageUrl;

                $('#loading-spinner').show();

                var imageElement = $('#image');
                imageElement.hide();
                imageElement.attr('src', '');

                imageElement.attr('src', imageSrc);

                imageElement.on('load', function() {
                    $('#loading-spinner').hide();
                    imageElement.show();
                });

                imageElement.on('error', function() {
                    $('#loading-spinner').hide();
                    alert('Failed to load image');
                });

                $('#penyakit').html(penyakitText);
                $('#probabilitas').html(probabilitasText);

                $('#penyakit_up').html(penyakit);
                $('#probabilitas_up').html(probabilitasTextup);
            },
            error: function() {
                $('#loading-spinner').hide();
                setErrorMessageForElements();
            }
        });
    }
    setInterval(fetchData, 300000);

    $(document).ready(function() {
        fetchData();
    });
</script>


<script>

    function fetchData2() {
        $.ajax({
            url: '/datalidar',
            method: 'GET',
            success: function(response) {
                var distance = response.data[0].distance;
                var movement_detected = response.data[0].movement_detected;
                var servo_position = response.data[0].servo_position;
                var created_at = response.data[0].created_at;

                var distance_text = distance + ' m';



                $('#hama').html(distance_text);

                if(hama != "None"){
                    movement_detected = "ON";
                } else {
                    movement_detected = "OFF";
                }

                $('#ultrasonic_status').html(movement_detected);
            },
            error: function() {
                setErrorMessageForElements();
            }
        });
    }
    setInterval(fetchData2, 300000);

    $(document).ready(function() {
        fetchData2();
    });
</script>


@endpush
