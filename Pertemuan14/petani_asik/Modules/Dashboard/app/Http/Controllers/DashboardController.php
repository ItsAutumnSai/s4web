<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Dashboard\Models\SensorIot;
use Modules\Dashboard\Models\SensorKamera;
use Modules\Dashboard\Models\Lidar;
use App\Http\Controllers\RecommendationService;
use Illuminate\Support\Facades\Http;


class DashboardController extends Controller
{

    public function index(Request $request): View
    {
        set_time_limit(120);

        $iot_id = auth()->user()->iot_id;

        $days = $request->input('days', 3);

        $forecastData = $this->getForecastData($iot_id, 14); // Mengambil data prediksi cuaca selama 14 hari
        $forecastData2 = $this->getForecastData($iot_id, 1); // Mengambil data prediksi cuaca selama 1 hari
        if (is_string($forecastData2)) {
            $forecastData2 = json_decode($forecastData2, true); // true agar jadi array
        }
        if (isset($forecastData2['forecast']) && is_array($forecastData2['forecast'])) {
            $forecastData_first = collect($forecastData2['forecast'])->sortBy('timestamp')->first();
        }
        // dd($forecastData_first);

        $perPage = 50; // Jumlah data per halaman

        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $paginatedData = array_slice($forecastData['forecast'], $offset, $perPage);

        $totalData = count($forecastData['forecast']);
        $totalPages = ceil($totalData / $perPage);

        $sensorData = SensorIot::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->paginate(1);

        $sensorData2 = SensorKamera::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->paginate(1);

        $recommendationService = new RecommendationService();
        $recommendations = $recommendationService->getRecommendations($sensorData, $sensorData2);

        return view('dashboard::index', [
            'user' => $request->user(),
            'forecast' => $forecastData,
            'recommendations' => $recommendations,
            'sensorData' => $sensorData,
            'days' => $days,
            'forecastData' => $paginatedData,
            'forecastDatagraph' => $forecastData,
            'forecastData_first' => $forecastData_first,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'days' => $days,
        ]);
    }

    public function getDataPrediksi()
    {
        $iot_id = auth()->user()->iot_id;

        $sensorData = SensorIot::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->paginate(1);

        $sensorData2 = SensorKamera::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->paginate(1);

        $recommendationService = new RecommendationService();
        $recommendations = $recommendationService->getRecommendations($sensorData, $sensorData2);

        if (!$recommendations) {
            $recommendations = [
                [
                    'type' => 'info',
                    'icon' => 'bx bx-info-circle',
                    'title' => 'No Recommendations',
                    'message' => 'No recommendations are available at the moment.',
                ],
            ];
        }

        return response()->json([
            'recommendations' => $recommendations,

        ]);
    }

    private function getForecastData($iot_id, $days)
    {
        $response = Http::get(env('API_RNN') . "{$days}days.json");

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['iot_id']) && $data['iot_id'] === $iot_id) {
                return $data;
            }

            return [
                "iot_id" => $iot_id->iot_id,
                //"iot_id" => "jTZids5M",
                "days_forecasted" => $days,
                "forecast" => [
                    [
                        "confidence" => [
                            "Healthy" => 0,
                            "High Stress" => 0,
                            "Moderate Stress" => 0
                        ],
                        "date" => now(),
                        "forecast_type" => "current",
                        "humidity" => 0,
                        "light_intensity" => 0,
                        "nitrogen" => 0,
                        "ph" => 0,
                        "potassium" => 0,
                        "predicted_health" => "None",
                        "soil_moisture" => 0,
                        "soil_temp" => 0,
                        "temperature" => 0
                    ],
                ],
                "forecast_generated" => now()
            ];
        }

        return null;
    }

    public function getData(Request $request)
    {
        $iot_id = auth()->user()->iot_id;

        $sensorData = SensorIot::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($sensorData->isEmpty()) {
            $sensorData = collect([[
                'temperature' => 'NaN',
                'humidity' => 'NaN',
                'vpd' => 'NaN',
                'windspeed' => 'NaN',
                'rainfall' => 'NaN',
                'light_intensity' => 'NaN',
                'ph' => 'NaN',
                'soil_moisture' => 'NaN',
                'ec' => 'NaN',
                'tds' => 'NaN',
                'soil_temp' => 'NaN',
                'pressure' => 'NaN',
                'feromon' => 'NaN',
                'battery_level' => 'NaN',
                'signal_strength' => 'NaN',
                'nitrogen' => 'NaN',
                'fosfor' => 'NaN',
                'potassium' => 'NaN',
                'created_at' => now()->toDateTimeString(),
            ]]);
        }

        $data = $sensorData->map(function ($item) {
            return [
                'temperature' => $item->temperature,
                'humidity' => $item->humidity,
                'windspeed' => $item->windspeed,
                'rainfall' => $item->rainfall,
                'light_intensity' => $item->light_intensity,
                'ph' => $item->ph,
                'soil_moisture' => $item->soil_moisture,
                'ec' => $item->ec,
                'tds' => $item->tds,
                'soil_temp' => $item->soil_temp,
                'pressure' => $item->pressure,
                'feromon' => $item->feromon,
                'battery_level' => $item->battery_level,
                'signal_strength' => $item->signal_strength,
                'nitrogen' => $item->Nitrogen_Level,
                'fosfor' => $item->Phosphorus_Level,
                'potassium' => $item->Potassium_Level,
                'created_at' => $item->created_at->toDateTimeString(),
            ];
        });

        return response()->json([
            'data' => $data,
            'total_records' => $sensorData->count(),
        ]);
    }

    public function getDataKamera(Request $request)
    {
        $iot_id = auth()->user()->iot_id;

        $kameraData = SensorKamera::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->get();


        $data = $kameraData->map(function ($item) {
            return [
                'image_url' => $item->image,
                'penyakit' => $item->penyakit,
                'probabilitas' => $item->probabilitas,
                'created_at' => $item->created_at->toDateTimeString(),
            ];
        });

        return response()->json([
            'data' => $data,
            'total_records' => $kameraData->count(),
        ]);
    }

        public function getDataLidar(Request $request)
    {
        $iot_id = auth()->user()->iot_id;

        $LidarData = Lidar::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->get();


        $data = $LidarData->map(function ($item) {
            return [
                'distance' => $item->distance,
                'movement_detected' => $item->movement_detected == '1' ? 'ON' : 'OFF',
                'servo_position' => $item->servo_position,
                'created_at' => $item->created_at->toDateTimeString(),
            ];
        });

        return response()->json([
            'data' => $data,
            'total_records' => $LidarData->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
