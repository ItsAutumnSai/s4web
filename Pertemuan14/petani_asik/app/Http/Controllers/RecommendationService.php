<?php

namespace App\Http\Controllers;

class RecommendationService
{
    public function getRecommendations($sensorData, $sensorData2)
    {
        $recommendations = [];
        $dangerRecommendations = [];  // Separate array for 'danger' recommendations
        $judulRekomendasi = [];

        foreach ($sensorData2 as $data2) {
            $penyakit = $data2->penyakit;
            $probabilitas = $data2->probabilitas;

            if ($penyakit == 'Hawar daun bakteri'){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-leaf',
                    'title' => 'Hawar daun bakteri',
                    'message' => '1) Semprot bakterisida berbahan aktif tembaga (contoh: Bubur Bordeaux). <br>
                                 2) Kurangi pemupukan nitrogen berlebihan. <br>
                                 3) Hindari genangan air di persawahan.'
                ];
                $judulRekomendasi[] = 'Hawar daun bakteri';
            }
            else if ($penyakit == 'Garis daun bakteri'){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-leaf',
                    'title' => 'Garis daun bakteri',
                    'message' => '1) Gunakan bakterisida berbahan tembaga atau streptomycin. <br>
                                  2) Hindari penyebaran melalui alat pertanian yang terkontaminasi.'
                ];
                $judulRekomendasi[] = 'Garis daun bakteri';
            }
            else if ($penyakit == 'Hawar malai bakteri'){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-leaf',
                    'title' => 'Hawar malai bakteri',
                    'message' => '1) Aplikasi bakterisida tembaga atau antibiotik tanaman.<br>
                                  2) Jaga kebersihan sawah dari sisa tanaman sakit.'
                ];
                $judulRekomendasi[] = 'Hawar malai bakteri';
            }
            else if ($penyakit == 'Penyakit blas (jamur)'){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-leaf',
                    'title' => 'Penyakit blas (jamur)',
                    'message' => '1) Semprot fungisida sistemik (contoh: tricyclazole, azoxystrobin). <br>
                                  2) Hindari kelembapan tinggi dengan pengairan berselang.'
                ];
                $judulRekomendasi[] = 'Penyakit blas (jamur)';
            }
            else if ($penyakit == 'Bercak coklat'){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-leaf',
                    'title' => 'Bercak coklat',
                    'message' => '1) Gunakan fungisida berbahan aktif mancozeb atau klorotalonil. <br>
                                  2) Perbaiki kondisi tanah dengan pupuk organik.'
                ];
                $judulRekomendasi[] = 'Bercak coklat';
            }
            else if ($penyakit == 'Pucuk mati'){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-leaf',
                    'title' => 'Pucuk mati',
                    'message' => '1) Semprot insektisida sistemik (contoh: karbofuran, fipronil). <br>
                                  2) Gunakan perangkap feromon untuk mengurangi populasi ngengat.'
                ];
                $judulRekomendasi[] = 'Pucuk mati';
            }
            else if ($penyakit == 'Embun bulu (jamur bulu halus)'){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-leaf',
                    'title' => 'Embun bulu (jamur bulu halus)',
                    'message' => '1) Fungisida sistemik seperti metalaksil atau fosetyl-Al. <br>
                                  2) Hindari penanaman terlalu rapat.'
                ];
                $judulRekomendasi[] = 'Embun bulu (jamur bulu halus)';
            }
            else if ($penyakit == 'Hama penggerek daun (Hispa)'){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-leaf',
                    'title' => 'Hama penggerek daun (Hispa)',
                    'message' => '1) Semprot insektisida (contoh: lambda-cyhalothrin atau imidakloprid). <br>
                                  2) Keluarkan hama manual dengan perangkap atau penyemprotan air.'
                ];
                $judulRekomendasi[] = 'Hama penggerek daun (Hispa)';
            }
            else if ($penyakit == 'Penyakit tungro (virus)'){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-leaf',
                    'title' => 'Penyakit tungro (virus)',
                    'message' => '1) Kendalikan wereng dengan insektisida (imidacloprid, pymetrozine). <br>
                                  2) Cabut dan musnahkan tanaman terinfeksi untuk mencegah penyebaran.'
                ];
                $judulRekomendasi[] = 'Penyakit tungro (virus)';
            }

        }

        foreach ($sensorData as $data) {
            $temperature = floatval($data->temperature);
            $humidity = floatval($data->humidity);
            $svp = 0.6108 * exp((17.27 * $temperature) / ($temperature + 237.3));
            $vpd = $svp * (1 - ($humidity / 100));


            if ($vpd >= 1.5 ){
                    $dangerRecommendations[] = [
                    'type' => 'danger',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-droplet',
                    'title' => 'VPD Tinggi',
                    'message' => '<b>Dampak:</b> Tanaman kehilangan air lebih cepat, Stres air mengganggu pertumbuhan dan fotosintesis, serta Meningkatkan risiko serangan hama seperti wereng dan penggerek batang <br>
                                  <b>Solusi:</b> 1) Pertahankan genangan air 2-3 cm dan gunakan irigasi berselang; 2) Kurangi pupuk nitrogen, prioritaskan pupuk kalium; 3) Pantau hama wereng/penggerek, gunakan insektisida (Pymetrozine/Dinotefuran); 4) Pilih varietas tahan kekeringan (Inpari 13/IR42) .'
                ];
                $judulRekomendasi[] = 'VPD Tinggi';
            }
            else if ($vpd <= 0.5 ){
                    $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'warning' type
                    'icon' => 'bx bx-droplet',
                    'title' => 'VPD Rendah',
                    'message' => '<b>Dampak:</b> Meningkatkan serangan penyakit seperti hawar daun bakteri (kresek), blas, dan busuk pelepah dan Pertumbuhan gulma lebih cepat <br>
                                  <b>Solusi:</b> 1) Kurangi genangan air, lakukan pengeringan sesaat; 2) Aplikasi fungisida/bakterisida: Tembaga untuk hawar daun, Seltima/Envoy untuk blas, Wuz 200/125 SC untuk busuk pelepah; 3)Kendalikan gulma dengan herbisida selektif (Serendy/Nugrass); 4) Berikan pupuk silika (ORINIT) untuk perkuat dinding sel.'
                                ];
                $judulRekomendasi[] = 'VPD Rendah';
            }

            // Optimal values for rice cultivation
            $optimalConditions = [
                'temperature' => ['min' => 22, 'max' => 28], // Temperature in °C
                'humidity' => ['min' => 70, 'max' => 85], // Humidity in %
                'windspeed' => ['max' => 3.6], // Wind speed in m/s
                'ph' => ['min' => 5.5, 'max' => 7.0], // pH of soil
                'soil_moisture' => ['min' => 70, 'max' => 85], // Soil moisture in %
                'ec' => ['min' => 800, 'max' => 1500],
                'tds' => ['max' => 500],
                'soil_temp' => ['min' => 27, 'max' => 34], // Soil temperature in °C
                'nitrogen' => ['min' => 20, 'max' => 50],
                'fosfor' => ['min' => 10, 'max' => 30],
                'potassium' => ['min' => 100, 'max' => 200],
            ];


            // Rekomendasi berdasarkan suhu
            if ($data->temperature < $optimalConditions['temperature']['min'] && !in_array('Suhu Dingin', $judulRekomendasi)) {
                $dangerRecommendations[] = [
                    'type' => 'warning',  // Prioritizing 'danger' type
                    'icon' => 'bx bx-sun',
                    'title' => 'Suhu Dingin',
                    'message' => 'Kurangi kelembaban, gunakan fungisida, dan pupuk silika.'
                ];
                $judulRekomendasi[] = 'Suhu Dingin';
            } elseif ($data->temperature > $optimalConditions['temperature']['max'] && !in_array('Suhu Panas', $judulRekomendasi)) {
                $dangerRecommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-sun',
                    'title' => 'Suhu Panas',
                    'message' => 'Fokus pada pengairan, pemupukan kalium, dan varietas tahan panas.'
                ];
                $judulRekomendasi[] = 'Suhu Panas';
            }

            // Rekomendasi berdasarkan kelembapan
            if ($data->humidity < $optimalConditions['humidity']['min'] && !in_array('Kelembapan Rendah', $judulRekomendasi)) {
                $dangerRecommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-droplet',
                    'title' => 'Kelembapan Rendah',
                    'message' => 'Tingkatkan pengairan, gunakan pupuk kalium, dan kendalikan hama.'
                ];
                $judulRekomendasi[] = 'Kelembapan Rendah';
            } elseif ($data->humidity > $optimalConditions['humidity']['max'] && !in_array('Kelembapan Tinggi', $judulRekomendasi)) {
                $dangerRecommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-droplet',
                    'title' => 'Kelembapan Tinggi',
                    'message' => 'Fokus pada pengurangan genangan air, fungisida, dan pemangkasan gulma.'
                ];
                $judulRekomendasi[] = 'Kelembapan Tinggi';
            }

            // Rekomendasi berdasarkan kecepatan angin
            if ($data->windspeed > $optimalConditions['windspeed']['max'] && !in_array('Perlindungan Angin Dibutuhkan', $judulRekomendasi)) {
                $dangerRecommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-wind',
                    'title' => 'Perlindungan Angin Dibutuhkan',
                    'message' => 'Kecepatan angin tinggi, pastikan tanaman terlindungi.'
                ];
                $judulRekomendasi[] = 'Perlindungan Angin Dibutuhkan';
            }

            $ph = (float) $data['ph'];

            // Rekomendasi berdasarkan pH tanah
            if ($ph < $optimalConditions['ph']['min'] && !in_array('pH Tanah Asam', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-leaf',
                    'title' => 'pH Tanah Asam',
                    'message' => 'Gunakan kapur pertanian (dolomit/kalsit), atau Berikan pupuk kandang/kompos, atau Gunakan SP-36 untuk fosfat'
                ];
                $judulRekomendasi[] = 'pH Tanah Asam';
            } elseif ($ph > $optimalConditions['ph']['max'] && !in_array('pH Tanah Basa', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-leaf',
                    'title' => 'pH Tanah Basa',
                    'message' => 'Gunakan Pupuk hijau/kompos untuk menurunkan pH, atau Gunakan ZA (amonium sulfat) atau urea'
                ];
                $judulRekomendasi[] = 'pH Tanah Basa';
            }

            // Rekomendasi berdasarkan kelembapan tanah
            if ($data->soil_moisture < $optimalConditions['soil_moisture']['min'] && !in_array('Kelembapan Tanah Kering', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'warning',
                    'icon' => 'bx bx-droplet',
                    'title' => 'Kelembapan Tanah Kering',
                    'message' => 'Berpotensi: Pertumbuhan terhambat, Hasil gabah berkurang, Serangan hama meningkat'

                ];
                $judulRekomendasi[] = 'Kelembapan Tanah Kering';
            }
            elseif ($data->soil_moisture > $optimalConditions['soil_moisture']['max'] && !in_array('Kelembapan Tanah Becek', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-dropletf',
                    'title' => 'Kelembapan Tanah Becek',
                    'message' => 'Berdampak: Akar busuk, Penyakit jamur meningkat, Tanaman mudah rebah'

                ];
                $judulRekomendasi[] = 'Kelembapan Tanah Becek';
            }

            // Rekomendasi berdasarkan EC tanah
            if ($data->ec < $optimalConditions['ec']['min'] && !in_array('EC rendah', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'warning',
                    'icon' => 'bx bx-water',
                    'title' => 'EC rendah',
                    'message' => 'Dampak: Daun pucat kekurangan hara dan Pertumbuhan lambat'

                ];
                $judulRekomendasi[] = 'EC rendah';
            }
            elseif ($data->ec > $optimalConditions['ec']['max'] && !in_array('EC tinggi', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-water',
                    'title' => 'EC tinggi',
                    'message' => 'Dampak: Ujung daun kuning/kering, Pertumbuhan kerdil, Hasil panen turun 30-50%'

                ];
                $judulRekomendasi[] = 'EC tinggi';
            }


            // Rekomendasi berdasarkan N
            if ($data->Nitrogen_Level < $optimalConditions['nitrogen']['min'] && !in_array('N rendah', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'warning',
                    'icon' => 'bx bx-bot',
                    'title' => 'N rendah',
                    'message' => 'Dampak: Daun kuning, pertumbuhan lambat, anakan sedikit'

                ];
                $judulRekomendasi[] = 'N rendah';
            }
            elseif ($data->Nitrogen_Level > $optimalConditions['nitrogen']['max'] && !in_array('N berlebihan', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-bot',
                    'title' => 'N berlebihan',
                    'message' => 'Dampak: Tanaman rentan rebah, daun terlalu lebat, mudah terserang hama/penyakit'

                ];
                $judulRekomendasi[] = 'N berlebihan';
            }

            // Rekomendasi berdasarkan P
            if ($data->Phosphorus_Level	 < $optimalConditions['fosfor']['min'] && !in_array('P rendah', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'warning',
                    'icon' => 'bx bx-bot',
                    'title' => 'P rendah',
                    'message' => 'Dampak: Akar lemah, pembungaan terlambat'

                ];
                $judulRekomendasi[] = 'P rendah';
            }
            elseif ($data->Phosphorus_Level > $optimalConditions['fosfor']['max'] && !in_array('P berlebihan', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-bot',
                    'title' => 'P berlebihan',
                    'message' => 'Dampak: Penyerapan hara lain terganggu (misal: defisiensi Zn atau Mg)'

                ];
                $judulRekomendasi[] = 'P berlebihan';
            }

            // Rekomendasi berdasarkan K
            if ($data->Potassium_Level < $optimalConditions['potassium']['min'] && !in_array('K rendah', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'warning',
                    'icon' => 'bx bx-bot',
                    'title' => 'K rendah',
                    'message' => 'Dampak: Akar lemah, pembungaan terlambat'

                ];
                $judulRekomendasi[] = 'K rendah';
            }
            elseif ($data->Potassium_Level > $optimalConditions['potassium']['max'] && !in_array('K berlebihan', $judulRekomendasi)) {
                $recommendations[] = [
                    'type' => 'danger',
                    'icon' => 'bx bx-bot',
                    'title' => 'K berlebihan',
                    'message' => 'Dampak: Bulir hampa, tanaman rentan stres '

                ];
                $judulRekomendasi[] = 'K berlebihan';
            }
        }

        // Combine 'danger' recommendations with others (danger recommendations will appear first)
        return array_merge($dangerRecommendations, $recommendations);
    }
}
