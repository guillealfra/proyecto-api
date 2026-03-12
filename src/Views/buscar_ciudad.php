<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Ciudad</title> 
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
<body class="flex flex-col relative gap-8 p-6 bg-[#1c1b22] min-h-screen" style="background-image: url('../img/bg1.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <a href="../index.php" class="absolute top-6 left-6 bg-white/10 backdrop-blur-sm border border-white/30 hover:bg-red-400/40 hover:scale-120 transition rounded-xl p-4 text-white font-bold text-center leading-tight">
		INICIO
	</a>

    <h1 class="flex items-center justify-center mb-6 text-5xl text-white font-bold">
        <span class="absolute text-white opacity-30 transform translate-x-1 translate-y-1 drop-shadow-lg">
      		BUSCAR CIUDAD
    	</span>
        BUSCAR CIUDAD
    </h1>
    
    <div class="w-96 mx-auto flex flex-col gap-4">
        <form method="POST" class="flex flex-col gap-4" action="../Controllers/BuscarCiudadController.php" autocomplete="off">
            <input type="text" placeholder="Ciudad que quieres buscar" name="ciudad_input" class="backdrop-blur-sm border-1 border-gray-100 px-3 py-2 text-white rounded focus:outline-none focus:ring-3 focus:ring-gray-200" required>
            <br>
            <button type="submit" name="buscar_button" class="bg-white/10 backdrop-blur-sm border border-white/30 hover:bg-green-500/40 hover:scale-120 transition rounded-xl p-4 text-white font-bold text-center leading-tight">
                BUSCAR
            </button>
        </form>
    </div>
    
    <?php if (isset($data) && count($data) > 0): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 w-full max-w-2xl mx-auto">
            <?php foreach ($data as $ciudad): ?>
                <a href="../Controllers/TiempoController.php?lat=<?=$ciudad['lat']?>&lon=<?=$ciudad['lon']?>&ciudad=<?=urlencode($ciudad['name'])?>" 
                class="bg-white/10 backdrop-blur-sm border border-white/30 hover:bg-blue-300/40 hover:scale-110 transition rounded-xl p-4 flex flex-col gap-1 text-white">
                    <span class="text-xl font-bold"><?= $ciudad['name'] ?></span>
                    <span class="text-sm text-gray-300"><?= $ciudad['state'] ?? '' ?></span>
                    <span class="text-sm text-gray-300"><?= $ciudad['country'] ?></span>
                    <span class="text-xs text-gray-300 mt-1"><?= round($ciudad['lat'], 2) ?>, <?= round($ciudad['lon'], 2) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>