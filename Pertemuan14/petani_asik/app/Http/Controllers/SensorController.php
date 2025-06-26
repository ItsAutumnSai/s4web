<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Modules\Dashboard\Models\sensoriot;
use Illuminate\Support\Facades\DB;
use Modules\Dashboard\Models\Lidar;



class SensorController extends Controller
{

    public function getDataLidar($iot_id)
    {
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



    public function cekDanBersihkanDataSensor()
    {
        $jumlahData = DB::table('sensor_iots')->count();

        if ($jumlahData >= 1000) {
            // Hapus semua data
            DB::table('sensor_iots')->delete();

            // Reset AUTO_INCREMENT (hanya untuk MySQL/MariaDB)
            DB::statement("ALTER TABLE sensor_iots AUTO_INCREMENT = 1");
        }
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'iot_id' => 'required|string',
            'iot_token' => 'required|string',
            // Validasi data sensor
            'temperature' => 'nullable|numeric',
            'humidity' => 'nullable|numeric',
            'windspeed' => 'nullable|numeric',
            'rainfall' => 'nullable|numeric',
            'light_intensity' => 'nullable|integer',
            'ph' => 'nullable|numeric',
            'soil_moisture' => 'nullable|numeric',
            'ec' => 'nullable|numeric',
            'tds' => 'nullable|numeric',
            'soil_temp' => 'nullable|numeric',
            'pressure' => 'nullable|numeric',
            'feromon' => 'nullable|integer',
            'battery_level' => 'nullable|integer',
            'signal_strength' => 'nullable|integer',
            'Nitrogen_Level' => 'nullable|numeric',
            'Phosphorus_Level' => 'nullable|numeric',
            'Potassium_Level' => 'nullable|numeric',
        ]);

        // Verifikasi iot_id dan token terhadap tabel users
        $user = User::where('iot_id', $validated['iot_id'])
                    ->where('iot_token', $validated['iot_token'])
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Simpan data ke tabel sensor_iots
        $sensor = SensorIot::create([
            'iot_id' => $validated['iot_id'],
            'temperature' => $validated['temperature'] ?? null,
            'humidity' => $validated['humidity'] ?? null,
            'windspeed' => $validated['windspeed'] ?? null,
            'rainfall' => $validated['rainfall'] ?? null,
            'light_intensity' => $validated['light_intensity'] ?? null,
            'ph' => $validated['ph'] ?? null,
            'soil_moisture' => $validated['soil_moisture'] ?? null,
            'ec' => $validated['ec'] ?? null,
            'tds' => $validated['tds'] ?? null,
            'soil_temp' => $validated['soil_temp'] ?? null,
            'pressure' => $validated['pressure'] ?? null,
            'feromon' => $validated['feromon'] ?? null,
            'battery_level' => $validated['battery_level'] ?? null,
            'signal_strength' => $validated['signal_strength'] ?? null,
            'Nitrogen_Level' => $validated['Nitrogen_Level'] ?? null,
            'Phosphorus_Level' => $validated['Phosphorus_Level'] ?? null,
            'Potassium_Level' => $validated['Potassium_Level'] ?? null,
        ]);

        // Cek dan bersihkan jika perlu
        $this->cekDanBersihkanDataSensor();
        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $sensor], 201);
    }
}
