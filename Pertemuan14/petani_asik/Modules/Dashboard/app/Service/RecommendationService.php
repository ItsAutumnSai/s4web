<?php

namespace App\Services;

class RecommendationService
{
    public function getRecommendations($sensorData)
    {
        $recommendations = [];
        $judulRekomendasi = [];

        foreach ($sensorData as $data) {
            // Rekomendasi berdasarkan suhu
            if ($data->temperature > 30 && !in_array('Irigasi Dibutuhkan', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-sun',
                    'title' => 'Irigasi Dibutuhkan',
                    'message' => 'Padi membutuhkan lebih banyak irigasi karena suhu yang tinggi.'
                ];
                $judulRekomendasi[] = 'Irigasi Dibutuhkan';
            } elseif ($data->temperature < 18 && !in_array('Perlindungan Dingin Dibutuhkan', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'warning',
                    'icon' => 'bx bx-thermometer',
                    'title' => 'Perlindungan Dingin Dibutuhkan',
                    'message' => 'Pertimbangkan untuk menambah pemanasan atau perlindungan dari suhu rendah.'
                ];
                $judulRekomendasi[] = 'Perlindungan Dingin Dibutuhkan';
            }

            // Rekomendasi berdasarkan kelembapan
            if ($data->humidity > 80 && !in_array('Kelembapan Tinggi', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'warning',
                    'icon' => 'bx bx-droplet',
                    'title' => 'Kelembapan Tinggi',
                    'message' => 'Kelembapan sangat tinggi, pastikan drainase cukup untuk mencegah pembusukan.'
                ];
                $judulRekomendasi[] = 'Kelembapan Tinggi';
            } elseif ($data->humidity < 40 && !in_array('Irigasi Dibutuhkan', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-water',
                    'title' => 'Irigasi Dibutuhkan',
                    'message' => 'Tambahkan irigasi untuk menjaga kelembapan tanah.'
                ];
                $judulRekomendasi[] = 'Irigasi Dibutuhkan';
            }

            // Rekomendasi berdasarkan kecepatan angin
            if ($data->windspeed > 27.0 && !in_array('Perlindungan Angin Dibutuhkan', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-wind',
                    'title' => 'Perlindungan Angin Dibutuhkan',
                    'message' => 'Angin kencang, pastikan tanaman padi terlindungi dari kerusakan.'
                ];
                $judulRekomendasi[] = 'Perlindungan Angin Dibutuhkan';
            }

            // Rekomendasi berdasarkan curah hujan
            if ($data->rainfall > 50 && !in_array('Curah Hujan Berat', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'warning',
                    'icon' => 'bx bx-cloud-rain',
                    'title' => 'Curah Hujan Berat',
                    'message' => 'Curah hujan tinggi, pastikan saluran drainase tidak tersumbat.'
                ];
                $judulRekomendasi[] = 'Curah Hujan Berat';
            }

            // Rekomendasi berdasarkan intensitas cahaya
            if ($data->light_intensity < 200 && !in_array('Intensitas Cahaya Rendah', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'warning',
                    'icon' => 'bx bx-sun',
                    'title' => 'Intensitas Cahaya Rendah',
                    'message' => 'Intensitas cahaya rendah, pertimbangkan untuk memperbaiki penataan tanam.'
                ];
                $judulRekomendasi[] = 'Intensitas Cahaya Rendah';
            }

            // Rekomendasi berdasarkan pH tanah
            if ($data->ph < 5.5 && !in_array('Penyesuaian pH Tanah Dibutuhkan', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-leaf',
                    'title' => 'Penyesuaian pH Tanah Dibutuhkan',
                    'message' => 'pH tanah terlalu asam, tambahkan kapur untuk menyeimbangkan pH.'
                ];
                $judulRekomendasi[] = 'Penyesuaian pH Tanah Dibutuhkan';
            } elseif ($data->ph > 7.5 && !in_array('Penyesuaian pH Tanah Dibutuhkan', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-leaf',
                    'title' => 'Penyesuaian pH Tanah Dibutuhkan',
                    'message' => 'pH tanah terlalu basa, tambahkan bahan pengasam tanah.'
                ];
                $judulRekomendasi[] = 'Penyesuaian pH Tanah Dibutuhkan';
            }

            // Rekomendasi berdasarkan kelembapan tanah
            if ($data->soil_moisture < 30 && !in_array('Kelembapan Tanah Rendah', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-droplet',
                    'title' => 'Kelembapan Tanah Rendah',
                    'message' => 'Tanah terlalu kering, perlu dilakukan penyiraman lebih banyak.'
                ];
                $judulRekomendasi[] = 'Kelembapan Tanah Rendah';
            }
        }

        return $recommendations;
    }
}
