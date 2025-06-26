@extends('layouts.dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card sensor-dashboard">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-white"><i class="fa-regular fa-user me-3"></i>     {{ $iot_idUser->name }}</h5>
                <div class="badge bg-white text-primary">{{ $iot_idUser->iot_id }}</div>
            </div>
        </div>
    </div>
    <!-- Historical Data Table -->
    <div class="col-md-12 col-lg-12 order-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bx bx-history me-2"></i>{{ __('label.riwayat_data') }}</h5>
                <div class="d-flex">

                    <a href="{{ route('export.data.user', $iot_idUser->iot_id) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-2">
                        <i class='bx bx-download me-1'></i> {{ __('label.export') }}
                    </a>
                    <button id="refreshButton" class="btn btn-sm btn-outline-info d-flex align-items-center me-2">
                        <i class='bx bx-refresh me-1'></i> {{ __('label.refresh') }}
                    </button>
                    <select id="dataLimit" class="form-select form-select-sm me-2">
                        <option value="5">5 Data</option>
                        <option value="10" selected>10 Data</option>
                        <option value="20">20 Data</option>
                        <option value="50">50 Data</option>
                        <option value="50">100 Data</option>

                    </select>
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
                                <th>{{ __('label.wind_speed') }}</th>
                                <th>{{ __('label.rainfall') }}</th>
                                <th>{{ __('label.light_intensity') }}</th>
                                <th>{{ __('label.ph_level') }}</th>
                                <th>{{ __('label.soil_moisture') }}</th>
                                <th>{{ __('label.ec') }}</th>
                                <th>{{ __('label.tds1') }}</th>
                                <th>{{ __('label.soil_temp') }}</th>
                                <th>{{ __('label.pressure') }}</th>
                                <th>{{ __('label.feromon') }}</th>
                                <th>{{ __('label.nitrogen1') }}</th>
                                <th>{{ __('label.phosphorus1') }}</th>
                                <th>{{ __('label.potasium1') }}</th>
                            </tr>
                        </thead>
                        <tbody id="sensorDataBody">
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item['timestamp'] }}</td>
                                    <td>{{ $item['temperature'] }}</td>
                                    <td>{{ $item['humidity'] }}</td>
                                    <td>{{ $item['windspeed'] }}</td>
                                    <td>{{ $item['rainfall'] }}</td>
                                    <td>{{ $item['light_intensity'] }}</td>
                                    <td>{{ $item['ph'] }}</td>
                                    <td>{{ $item['soil_moisture'] }}</td>
                                    <td>{{ $item['ec'] }}</td>
                                    <td>{{ $item['tds'] }}</td>
                                    <td>{{ $item['soil_temp'] }}</td>
                                    <td>{{ $item['pressure'] }}</td>
                                    <td>{{ $item['feromon'] }}</td>
                                    <td>{{ $item['Nitrogen_Level'] }}</td>
                                    <td>{{ $item['Phosphorus_Level'] }}</td>
                                    <td>{{ $item['Potassium_Level'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center pagination-sm">
                        @php
                            // Tentukan batas halaman yang akan ditampilkan
                            $maxPagesToShow = 5;
                            $halfMaxPages = floor($maxPagesToShow / 2);

                            // Tentukan halaman awal dan akhir yang akan ditampilkan
                            $startPage = max($currentPage - $halfMaxPages, 1);
                            $endPage = min($currentPage + $halfMaxPages, $totalPages);

                            // Jika halaman pertama lebih besar dari 1, tampilkan halaman pertama dan tanda "..."
                            if ($startPage > 1) {
                                $startPage = max($currentPage - $halfMaxPages, 1);
                            }

                            // Jika halaman terakhir kurang dari total halaman, tampilkan "..."
                            if ($endPage < $totalPages) {
                                $endPage = min($currentPage + $halfMaxPages, $totalPages);
                            }
                        @endphp

                        {{-- Previous Button --}}
                        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ url('/history?page=' . ($currentPage - 1)) }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo; {{ __('label.previous') }} </span>
                            </a>
                        </li>

                        {{-- Pages --}}
                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                <a class="page-link" href="{{ url('/history?page=' . $i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Next Button --}}
                        <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ url('/history?page=' . ($currentPage + 1)) }}" aria-label="Next">
                                <span aria-hidden="true">{{ __('label.next') }} &raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>


            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
<style>
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

@endpush
