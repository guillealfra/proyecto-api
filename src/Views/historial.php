<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de consultas</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex flex-col relative gap-8 p-6 bg-[#1c1b22] min-h-screen" style="background-image: url('../img/bg1.jpg'); background-size: repeat; background-position: center; background-repeat: no-repeat;">

    <a href="../index.php" class="absolute top-6 left-6 bg-white/20 backdrop-blur-sm border border-white/30 hover:bg-white/30 hover:scale-120 transition rounded-xl p-4 text-white font-bold text-center leading-tight">
        INICIO
    </a>

    <h1 class="flex items-center justify-center mb-6 text-5xl text-white font-bold">
        <span class="absolute text-white opacity-30 transform translate-x-2 translate-y-2 drop-shadow-lg">
            HISTORIAL
        </span>
        HISTORIAL
    </h1>

    <div class="flex flex-col gap-3 max-w-4xl mx-auto w-full">
        <?php if (isset($data) && count($data) > 0): ?>
            <?php foreach ($data as $consulta): ?>
                <div class="bg-white/10 backdrop-blur-sm border border-white/30 rounded-xl p-4 flex justify-between items-center text-white">
                    <div class="flex flex-col gap-1">
                        <span class="text-xl font-bold"><?= $consulta['ciudad'] ?></span>
                        <span class="text-sm text-gray-300 capitalize"><?= $consulta['descripcion'] ?? '-' ?></span>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="text-2xl font-bold"><?= $consulta['temp'] ? round($consulta['temp']).'°C' : '-' ?></span>
                        <span class="text-xs text-gray-300"><?= $consulta['tipo'] ?></span>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <span class="text-sm text-gray-300"><?= date('d/m/Y H:i', strtotime($consulta['fecha'])) ?></span>
                        <span class="text-xs text-gray-400"><?= $consulta['lat'] ? round($consulta['lat'], 2).', '.round($consulta['lon'], 2) : '-' ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-xl p-6 text-white text-center">
                NO HAY CONSULTAS REGISTRADAS TODAVIA
            </div>
        <?php endif; ?>
    </div>

</body>
</html>