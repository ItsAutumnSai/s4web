@extends('layouts.dashboard')

@section('content')
<div class="row justify-content-center">
    <!-- Third Row - Sensor Status and Historical Data -->
    <div class="col-md-6 col-lg-4 order-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bx bx-chip me-2"></i>Sensor Status</h5>
                <span class="badge bg-primary">8 Active</span>
            </div>
            <div class="card-body">
                <div class="sensor-status">
                    <div class="sensor-item online d-flex align-items-center py-2">
                        <i class='bx bx-thermometer fs-4 text-primary me-3'></i>
                        <div class="sensor-info flex-grow-1">
                            <span class="d-block fw-medium">Temperature Sensor</span>
                            <small class="text-muted">28.5°C • Updated 1 min ago</small>
                        </div>
                        <i class='bx bx-check-circle fs-4 text-success'></i>
                    </div>

                    <div class="sensor-item online d-flex align-items-center py-2">
                        <i class='bx bx-droplet fs-4 text-info me-3'></i>
                        <div class="sensor-info flex-grow-1">
                            <span class="d-block fw-medium">Humidity Sensor</span>
                            <small class="text-muted">65% • Updated 1 min ago</small>
                        </div>
                        <i class='bx bx-check-circle fs-4 text-success'></i>
                    </div>

                    <div class="sensor-item online d-flex align-items-center py-2">
                        <i class='bx bx-test-tube fs-4 text-success me-3'></i>
                        <div class="sensor-info flex-grow-1">
                            <span class="d-block fw-medium">pH Sensor</span>
                            <small class="text-muted">6.8 • Updated 5 mins ago</small>
                        </div>
                        <i class='bx bx-check-circle fs-4 text-success'></i>
                    </div>

                    <div class="sensor-item warning d-flex align-items-center py-2">
                        <i class='bx bx-wind fs-4 text-warning me-3'></i>
                        <div class="sensor-info flex-grow-1">
                            <span class="d-block fw-medium">Wind Sensor</span>
                            <small class="text-muted">12 km/h • Updated 15 mins ago</small>
                        </div>
                        <i class='bx bx-time-five fs-4 text-warning'></i>
                    </div>

                    <div class="sensor-item offline d-flex align-items-center py-2">
                        <i class='bx bx-cloud-rain fs-4 text-secondary me-3'></i>
                        <div class="sensor-info flex-grow-1">
                            <span class="d-block fw-medium">Rain Gauge</span>
                            <small class="text-muted">Offline • Last seen 2h ago</small>
                        </div>
                        <i class='bx bx-error-circle fs-4 text-danger'></i>
                    </div>
                </div>

                <button class="btn btn-outline-primary w-100 mt-3 d-flex align-items-center justify-content-center">
                    <i class='bx bx-cog me-1'></i> Manage Sensors
                </button>
            </div>
        </div>
    </div>

    <!-- Historical Data Table -->
    <div class="col-md-12 col-lg-8 order-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bx bx-history me-2"></i>Historical Sensor Data</h5>
                <div class="d-flex">
                    <button class="btn btn-sm btn-outline-primary me-2 d-flex align-items-center">
                        <i class='bx bx-filter me-1'></i> Filter
                    </button>
                    <button class="btn btn-sm btn-outline-primary d-flex align-items-center">
                        <i class='bx bx-download me-1'></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Timestamp</th>
                                <th>Temp (°C)</th>
                                <th>Humidity (%)</th>
                                <th>Soil Moisture</th>
                                <th>pH</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ([
                                ['2024-04-15 08:00', 26.5, 68, '45%', 6.7],
                                ['2024-04-15 08:15', 26.8, 67, '44%', 6.7],
                                ['2024-04-15 08:30', 27.1, 66, '43%', 6.8],
                                ['2024-04-15 08:45', 27.5, 65, '42%', 6.8],
                                ['2024-04-15 09:00', 28.0, 64, '41%', 6.8],
                                ['2024-04-15 09:15', 28.3, 63, '40%', 6.9],
                                ['2024-04-15 09:30', 28.5, 62, '39%', 6.9],
                                ['2024-04-15 09:45', 28.7, 61, '38%', 7.0],
                                ['2024-04-15 10:00', 29.0, 60, '37%', 7.0],
                                ['2024-04-15 10:15', 29.2, 59, '36%', 7.1],
                                ['2024-04-15 10:30', 29.5, 58, '35%', 7.1],
                                ['2024-04-15 10:45', 29.7, 57, '34%', 7.2],
                                ['2024-04-15 11:00', 30.0, 56, '33%', 7.2]
                            ] as $data)
                            <tr>
                                <td>{{ $data[0] }}</td>
                                <td>{{ $data[1] }}</td>
                                <td>{{ $data[2] }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                            <div class="progress-bar bg-info" style="width: {{ $data[3] }}"></div>
                                        </div>
                                        <small>{{ $data[3] }}</small>
                                    </div>
                                </td>
                                <td>{{ $data[4] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center pagination-sm">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
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
<script>
    // Environmental Trends Chart
    const environmentChartOptions = {
        series: [
            {
                name: "Temperature (°C)",
                data: [26.5, 26.8, 27.1, 27.5, 28.0, 28.3, 28.5, 28.7, 29.0, 29.2, 29.5, 29.7, 30.0],
                type: "line"
            },
            {
                name: "Humidity (%)",
                data: [68, 67, 66, 65, 64, 63, 62, 61, 60, 59, 58, 57, 56],
                type: "line"
            },
            {
                name: "Soil Moisture (%)",
                data: [45, 44, 43, 42, 41, 40, 39, 38, 37, 36, 35, 34, 33],
                type: "area"
            }
        ],
        chart: {
            height: "100%",
            type: "line",
            stacked: false,
            toolbar: {
                show: true,
                tools: {
                    download: false,
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
        labels: ["08:00", "08:15", "08:30", "08:45", "09:00", "09:15", "09:30", "09:45", "10:00", "10:15", "10:30", "10:45", "11:00"],
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
                seriesName: "Temperature",
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
                    text: "Temperature (°C)",
                    style: {
                        color: "#FF4560",
                        fontSize: '12px'
                    }
                },
                min: 25,
                max: 32
            },
            {
                seriesName: "Humidity",
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
                    text: "Humidity (%)",
                    style: {
                        color: "#00E396",
                        fontSize: '12px'
                    }
                },
                min: 50,
                max: 70
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
@endpush
