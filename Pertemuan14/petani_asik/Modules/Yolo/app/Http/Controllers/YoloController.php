<?php

namespace Modules\Yolo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use ZipArchive;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Modules\Yolo\Models\HistoryYolo;

class YoloController extends Controller
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

        $sensorData = HistoryYolo::where('iot_id', $iot_id)
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($limit)
            ->get();

        if ($sensorData->isEmpty()) {
            $sensorData = collect([[
                'timestamp' => 'NaN',
                'penyakit' => 'NaN',
                'probabilitas' => 'NaN',
                'image' => 'NaN',
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

        $totalRecords = HistoryYolo::where('iot_id', $iot_id)->count();
        $totalPages = ceil($totalRecords / $limit);

        return view('yolo::index', [
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
        return view('yolo::create');
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
        return view('yolo::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('yolo::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}


    public function exportDataYolo()
    {

        $iot_id = auth()->user()->iot_id;

        $data = HistoryYolo::where('iot_id', $iot_id)->get();

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
            $sheet->setCellValue("A$row", $item->created_at)
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
        $userName = auth()->user()->name;

        $excelFileName = "{$currentDateTime}_Riwayat_Yolo_{$userName}.xlsx";

        $excelFilePath = storage_path("app/public/{$excelFileName}");

        $writer->save($excelFilePath);
        return response()->download($excelFilePath)->deleteFileAfterSend(true);


    }
}
