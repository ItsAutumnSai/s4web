<?php

namespace Modules\History\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\History\Models\Historyiot;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $iot_id = auth()->user()->iot_id;

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
                'timestamp' => 'NaN',
                'temperature' => 'NaN',
                'humidity' => 'NaN',
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
                'Nitrogen_Level' => 'NaN',
                'Phosphorus_Level' => 'NaN',
                'Potassium_Level' => 'NaN',
            ]]);
        }

        $data = $sensorData->map(function ($item) {
            return [
                'timestamp' => isset($item['created_at']) ? $item['created_at'] : 'NaN',
                'temperature' => $item['temperature'] ?? 'NaN',
                'humidity' => $item['humidity'] ?? 'NaN',
                'windspeed' => $item['windspeed'] ?? 'NaN',
                'rainfall' => $item['rainfall'] ?? 'NaN',
                'light_intensity' => $item['light_intensity'] ?? 'NaN',
                'ph' => $item['ph'] ?? 'NaN',
                'soil_moisture' => $item['soil_moisture'] ?? 'NaN',
                'ec' => $item['ec'] ?? 'NaN',
                'tds' => $item['tds'] ?? 'NaN',
                'soil_temp' => $item['soil_temp'] ?? 'NaN',
                'pressure' => $item['pressure'] ?? 'NaN',
                'feromon' => $item['feromon'] ?? 'NaN',
                'Nitrogen_Level' => $item['Nitrogen_Level'] ?? 'NaN',
                'Phosphorus_Level' => $item['Phosphorus_Level'] ?? 'NaN',
                'Potassium_Level' => $item['Potassium_Level'] ?? 'NaN',
            ];
        });

        $totalRecords = Historyiot::where('iot_id', $iot_id)->count();
        $totalPages = ceil($totalRecords / $limit);

        return view('history::index', [
            'user' => $request->user(),
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'data' => $data,
            'sensorData' => $sensorData,
        ]);
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('history::create');
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
        return view('history::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('history::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}


    public function exportData(Request $request)
    {
        $iot_id = auth()->user()->iot_id;

        $data = Historyiot::where('iot_id', $iot_id)->get();

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
        $userName = auth()->user()->name;

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
}
