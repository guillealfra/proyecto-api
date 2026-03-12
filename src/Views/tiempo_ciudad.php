<?php
if (!isset($data)) {
    include_once("../index.php");
}

$id = $data['actual']['weather'][0]['id'];

$iconos = [
    2 => '🌩️',
    3 => '🌦️',
    5 => '🌧️',
    6 => '❄️',
    7 => '🌫️',
    800 => '☀️',
    801 => '🌤️',
    802 => '⛅',
    803 => '🌥️',
    804 => '☁️',
];

$icono = $iconos[$id] ?? $iconos[intval(substr($id, 0, 1))] ?? '🌡️';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiempo Ciudad</title> 
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex flex-col relative gap-8 p-6 bg-[#1c1b22] min-h-screen" style="background-image: url('../img/bg1.jpg'); background-size: repeat; background-position: center; background-repeat: no-repeat;">

    <a href="../Views/buscar_ciudad.php" class="absolute top-6 left-6 bg-white/10 backdrop-blur-sm border border-white/30 hover:bg-red-400/40 hover:scale-120 transition rounded-xl p-4 text-white font-bold text-center leading-tight">
        BUSCAR CIUDAD
    </a>

    <h1 class="flex items-center justify-center mb-6 text-5xl text-white font-bold">
        <span class="absolute text-white opacity-30 transform translate-x-1 translate-y-2 drop-shadow-lg">
            TIEMPO DE <?= strtoupper($data['ciudad']) ?>
        </span>
        TIEMPO DE <?= strtoupper($data['ciudad']) ?>
    </h1>

    <div class="grid grid-cols-4 gap-4">

        <!-- ----------- Datos actuales ----------- -->
        <div class="col-span-1 bg-white/10 backdrop-blur-sm border border-white/30 rounded-xl p-6 flex flex-col gap-4 text-white">

            <div class="flex items-center gap-3">
                <span class="text-6xl"><?= $icono ?></span>
                <span class="text-2xl font-bold capitalize"><?= $data['actual']['weather'][0]['description'] ?></span>
            </div>

            <div class="flex flex-col gap-1">
                <span class="text-6xl font-bold"><?= round($data['actual']['main']['temp']) ?>°C</span>
                <span class="text-sm text-gray-300">Sensación <?= round($data['actual']['main']['feels_like']) ?>°C</span>
            </div>

            <div class="flex flex-col gap-2 text-lg text-gray-200 mt-2">
                <div class="flex justify-between">
                    <span>💧 Humedad</span>
                    <span class="font-bold"><?= $data['actual']['main']['humidity'] ?>%</span>
                </div>
                <div class="flex justify-between">
                    <span>🌬️ Viento</span>
                    <span class="font-bold"><?= $data['actual']['wind']['speed'] ?> m/s</span>
                </div>
                <div class="flex justify-between">
                    <span>⬇️ Presión</span>
                    <span class="font-bold"><?= $data['actual']['main']['pressure'] ?> hPa</span>
                </div>
                <div class="flex justify-between">
                    <span>👁️ Visibilidad</span>
                    <span class="font-bold"><?= $data['actual']['visibility'] / 1000 ?> km</span>
                </div>
                <div class="flex justify-between">
                    <span>🌅 Amanecer</span>
                    <span class="font-bold"><?= date('H:i', $data['actual']['sys']['sunrise']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span>🌇 Atardecer</span>
                    <span class="font-bold"><?= date('H:i', $data['actual']['sys']['sunset']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span>🌡️ Mínima</span>
                    <span class="font-bold"><?= round($data['actual']['main']['temp_min']) ?>°C</span>
                </div>
                <div class="flex justify-between">
                    <span>🌡️ Máxima</span>
                    <span class="font-bold"><?= round($data['actual']['main']['temp_max']) ?>°C</span>
                </div>
                <div class="flex justify-between">
                    <span>☁️ Nubosidad</span>
                    <span class="font-bold"><?= $data['actual']['clouds']['all'] ?>%</span>
                </div>
            </div>
        </div>

        <!-- ----------- Datos semanales ----------- -->
        <div class="col-span-3 bg-white/10 backdrop-blur-sm border border-white/30 rounded-xl p-6 text-white">
             <?php
                $porDia = [];
                foreach ($data['semanal']['list'] as $entrada) {
                    $fecha = date('Y-m-d', $entrada['dt']);
                    $hora = date('H:i', $entrada['dt']);
                    if ($hora === '12:00') {
                        $porDia[$fecha] = $entrada;
                    }
                }
            ?>
            <div class="col-span-2 p-4 text-white flex flex-col gap-3">
                <h2 class="text-xl font-bold">Previsión semanal</h2>
                <canvas id="graficaSemanal"></canvas>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = <?= json_encode(array_map(fn($d) => date('D d/m', strtotime($d)), array_keys($porDia))) ?>;
    const temps = <?= json_encode(array_map(fn($d) => round($d['main']['temp']), array_values($porDia))) ?>;
    const humedades = <?= json_encode(array_map(fn($d) => $d['main']['humidity'], array_values($porDia))) ?>;

    new Chart(document.getElementById('graficaSemanal'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Temperatura (°C)',
                    data: temps,
                    borderColor: 'rgba(255, 180, 50, 1)',
                    backgroundColor: 'rgba(255, 180, 50, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Humedad (%)',
                    data: humedades,
                    borderColor: 'rgba(100, 180, 255, 1)',
                    backgroundColor: 'rgba(100, 180, 255, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { labels: { color: 'white' } }
            },
            scales: {
                x: { ticks: { color: 'white' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                y: {
                    ticks: { color: 'rgba(255, 180, 50, 1)' },
                    grid: { color: 'rgba(255,255,255,0.1)' },
                    position: 'left'
                },
                y1: {
                    ticks: { color: 'rgba(100, 180, 255, 1)' },
                    grid: { drawOnChartArea: false },
                    position: 'right'
                }
            }
        }
    });
</script>
</html>