<?php

namespace Modules\Data\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\History\Models\Historyiot;
use Illuminate\View\View;
use Modules\Dashboard\Models\SensorIot;
use Modules\Dashboard\Models\SensorKamera;
use Modules\Dashboard\Models\Lidar;
use App\Http\Controllers\RecommendationService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use Modules\Yolo\Models\HistoryYolo;
use ZipArchive;
use Illuminate\Support\Facades\Http;


class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = User::all();

        return view('data::index', compact('users'))->with([
            'user' => $request->user(),
        ]);
    }

    public function monitoring(Request $request, $iot_id): View
    {
        $iot_idUser = User::where('iot_id', $iot_id)->first();

        if (!$iot_idUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $days = $request->input('days', 3);

        $forecastData = $this->getForecastData($iot_idUser, 14); // Mengambil data prediksi cuaca selama 14 hari
        $forecastData2 = $this->getForecastData($iot_idUser, 1); // Mengambil data prediksi cuaca selama 1 hari
        if (is_string($forecastData2)) {
            $forecastData2 = json_decode($forecastData2, true); // true agar jadi array
        }
        if (isset($forecastData2['forecast']) && is_array($forecastData2['forecast'])) {
            $forecastData_first = collect($forecastData2['forecast'])->sortBy('timestamp')->first();
        }
        // dd($forecastData_first);
        $perPage = 50;

        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $paginatedData = array_slice($forecastData['forecast'], $offset, $perPage);

        $totalData = count($forecastData['forecast']);
        $totalPages = ceil($totalData / $perPage);

        $sensorData = SensorIot::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get();
        $sensorData2 = SensorKamera::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get();

        $recommendationService = new RecommendationService();
        $recommendations = $recommendationService->getRecommendations($sensorData, $sensorData2);

        return view('data::monitoring', compact('iot_idUser'))->with([
            'user' => $request->user(),
            'recommendations' => $recommendations,
            'iot_id' => $iot_idUser,
            'days' => $days,
            'forecastData' => $paginatedData,
            'forecastDatagraph' => $forecastData,
            'forecastData_first' => $forecastData_first,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'days' => $days,
        ]);
    }

    public function Historyiot(Request $request, $iot_id): View
    {
        $iot_idUser = User::where('iot_id', $iot_id)->first();

        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $skip = ($page - 1) * $limit;

        $sensorData = Historyiot::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($limit)
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
                'Nitrogen_Level' => 'NaN',
                'Phosphorus_Level' => 'NaN',
                'Potassium_Level' => 'NaN',
            ]]);
        }

        $data = $sensorData->map(function ($item) {
            return [
                'timestamp' => isset($item->created_at) ? $item->created_at->format('Y-m-d H:i:s') : 'NaN',
                'temperature' => $item->temperature ?? 'NaN',
                'humidity' => $item->humidity ?? 'NaN',
                'windspeed' => $item->windspeed ?? 'NaN',
                'rainfall' => $item->rainfall ?? 'NaN',
                'light_intensity' => $item->light_intensity ?? 'NaN',
                'ph' => $item->ph ?? 'NaN',
                'soil_moisture' => $item->soil_moisture ?? 'NaN',
                'ec' => $item->ec ?? 'NaN',
                'tds' => $item->tds ?? 'NaN',
                'soil_temp' => $item->soil_temp ?? 'NaN',
                'pressure' => $item->pressure ?? 'NaN',
                'feromon' => $item->feromon ?? 'NaN',
                'battery_level' => $item->battery_level ?? 'NaN',
                'signal_strength' => $item->signal_strength ?? 'NaN',
                'Nitrogen_Level' => $item->Nitrogen_Level ?? 'NaN',
                'Phosphorus_Level' => $item->Phosphorus_Level ?? 'NaN',
                'Potassium_Level' => $item->Potassium_Level ?? 'NaN',
            ];
        });

        $totalRecords = Historyiot::where('iot_id', $iot_id)->count();
        $totalPages = ceil($totalRecords / $limit);

        return view('data::historyiot', compact('iot_idUser'))->with([
            'user' => $request->user(),
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'data' => $data,
            'sensorData' => $sensorData,
        ]);
    }

    public function historyyolo(Request $request, $iot_id): View
    {
        $iot_idUser = User::where('iot_id', $iot_id)->first();

        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $skip = ($page - 1) * $limit;

        $sensorData = HistoryYolo::where('iot_id', $iot_idUser->iot_id)
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($limit)
            ->get();

        if ($sensorData->isEmpty()) {
            $sensorData = collect([[
                'timestamp' => 'NaN',
                'penyakit' => 'NaN',
                'probabilitas' => 'NaN',
                'image' => 'NaN'
            ]]);
        }

        $data = $sensorData->map(function ($item) {
            return [
                'timestamp' => isset($item->created_at) ? $item->created_at->format('Y-m-d H:i:s') : 'NaN',
                'penyakit' => $item->penyakit ?? 'NaN',
                'probabilitas' => $item->probabilitas ?? 'NaN',
                'image' => $item->image ?? 'NaN',
            ];
        });

        $totalRecords = HistoryYolo::where('iot_id', $iot_idUser->iot_id)->count();
        $totalPages = ceil($totalRecords / $limit);

        return view('data::historyyolo', compact('iot_idUser'))->with([
            'user' => $request->user(),
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'data' => $data,
            'sensorData' => $sensorData,
        ]);
    }

    private function getForecastData($iot_idUser, $days)
    {
        $response = Http::get(env('API_RNN') . "{$days}days.json");

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['iot_id']) && $data['iot_id'] === $iot_idUser->iot_id) {
                return $data;
            }

            return [
                "iot_id" => $iot_idUser->iot_id,
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data::create');
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
        return view('data::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('data::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function getData(Request $request)
    {
        $iot_id = $request->input('iot_id');

        if (!$iot_id) {
            $iot_id = auth()->user()->iot_id;
        }

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

    public function getKamera(Request $request)
    {

        $iot_id = $request->input('iot_id');

        if (!$iot_id) {
            $iot_id = auth()->user()->iot_id;
        }

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


    public function getLidar(Request $request)
    {

        $iot_id = $request->input('iot_id');

        if (!$iot_id) {
            $iot_id = auth()->user()->iot_id;
        }

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

    public function exportDataUser(Request $request, $iot_id)
    {
        $iot_idUser = User::where('iot_id', $iot_id)->first();

        if (!$iot_idUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $data = Historyiot::where('iot_id', $iot_idUser->iot_id)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Timestamp')
            ->setCellValue('B1', 'Temperature (°C)')
            ->setCellValue('C1', 'Humidity (%)')
            ->setCellValue('D1', 'Wind Speed (m/s)')
            ->setCellValue('E1', 'Rainfall (mm)')
            ->setCellValue('F1', 'Light Intensity (lux)')
            ->setCellValue('G1', 'pH Level')
            ->setCellValue('H1', 'Soil Moisture (%)')
            ->setCellValue('I1', 'EC (µS/cm)')
            ->setCellValue('J1', 'TDS (ppm)')
            ->setCellValue('K1', 'Soil Temp (°C)')
            ->setCellValue('L1', 'Pressure (Pa)')
            ->setCellValue('M1', 'Feromon')
            ->setCellValue('N1', 'Nitrogen Level (mg/kg)')
            ->setCellValue('O1', 'Phosphorus Level (mg/kg)')
            ->setCellValue('P1', 'Potassium Level (mg/kg)');


        $sheet->getStyle('A1:P1')->getFont()->setBold(true);
        $sheet->getStyle('A1:P1')->getFont()->setSize(12);
        $sheet->getStyle('A1:P1')->getFont()->setName('Calibri');
        $sheet->getStyle('A1:P1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:P1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:P1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->created_at->format('Y-m-d H:i:s'))
                ->setCellValue('B' . $row, $item->temperature)
                ->setCellValue('C' . $row, $item->humidity)
                ->setCellValue('D' . $row, $item->windspeed)
                ->setCellValue('E' . $row, $item->rainfall)
                ->setCellValue('F' . $row, $item->light_intensity)
                ->setCellValue('G' . $row, $item->ph)
                ->setCellValue('H' . $row, $item->soil_moisture)
                ->setCellValue('I' . $row, $item->ec)
                ->setCellValue('J' . $row, $item->tds)
                ->setCellValue('K' . $row, $item->soil_temp)
                ->setCellValue('L' . $row, $item->pressure)
                ->setCellValue('M' . $row, $item->feromon)
                ->setCellValue('N' . $row, $item->Nitrogen_Level)
                ->setCellValue('O' . $row, $item->Phosphorus_Level)
                ->setCellValue('P' . $row, $item->Potassium_Level);

            $row++;
        }

        foreach (range('A', 'P') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->getStyle('A2:P' . $row)->getFont()->setSize(11);
        $sheet->getStyle('A2:P' . $row)->getFont()->setName('Calibri');


        $writer = new Xlsx($spreadsheet);
        $currentDateTime = Carbon::now()->format('Y-m-d_H-i-s');
        $userName = $iot_idUser->name;

        $filename = "{$currentDateTime}_Riwayat_Sensor_{$userName}.xlsx";

        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]
        );
    }

    public function exportDataYoloUser(Request $request, $iot_id)
    {
        $iot_idUser = User::where('iot_id', $iot_id)->first();

        if (!$iot_idUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $data = HistoryYolo::where('iot_id', $iot_idUser->iot_id)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Timestamp')
            ->setCellValue('B1', 'Disease')
            ->setCellValue('C1', 'Probability (%)');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getStyle('A1:C1')->getFont()->setSize(12);
        $sheet->getStyle('A1:C1')->getFont()->setName('Calibri');
        $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:C1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:C1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue("A$row", $item->created_at->format('Y-m-d H:i:s'))
                ->setCellValue("B$row", $item->penyakit)
                ->setCellValue("C$row", $item->probabilitas);
            $row++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->getStyle('A2:C' . $row)->getFont()->setSize(11);
        $sheet->getStyle('A2:C' . $row)->getFont()->setName('Calibri');
        $sheet->getStyle('A2:C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:C' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $writer = new Xlsx($spreadsheet);

        $currentDateTime = Carbon::now()->format('Y-m-d_H-i-s');
        $userName = $iot_idUser->name;
        $excelFilePath = storage_path("app/public/{$currentDateTime}_Riwayat_Yolo_{$userName}.xlsx");

        $writer->save($excelFilePath);
        return response()->download($excelFilePath)->deleteFileAfterSend(true);
    }
}
