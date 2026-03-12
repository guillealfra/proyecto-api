<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Index</title>
	<meta name="index" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col items-center justify-center bg-[#1c1b22] min-h-screen gap-8" style="background-image: url('./img/bg1.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

	<p class="absolute top-6 right-6 hover:scale-120 transition rounded-xl p-4 text-white font-bold text-center leading-tight">
		Guillermo Alvarez Franganillo
	</p>

	<div class="flex items-center justify-center mb-6 text-5xl text-white font-bold">
		<h1 class="mb-6 text-9xl text-white font-bold">
			<span class="absolute text-white opacity-30 transform translate-x-2 translate-y-2 drop-shadow-lg">
      			{JOINHUB}
    		</span>
			{JOINHUB}
		</h1>
	</div>

	<div class="text-xl grid grid-cols-2 gap-3 w-[350px]">

		<a href="../Controllers/ConsultasController.php"
		class="aspect-square bg-white/10 backdrop-blur-sm border border-white/30 hover:bg-blue-300/40 hover:scale-110 transition rounded-xl p-4 flex items-center justify-center text-white font-bold text-center leading-tight">
			HISTORIAL
		</a>

		<a href="./Views/buscar_ciudad.php"
		class="aspect-square bg-white/10 backdrop-blur-sm border border-white/30 hover:bg-blue-300/40 hover:scale-110 transition rounded-xl p-4 flex items-center justify-center text-white font-bold text-center leading-tight">
			BUSCAR CIUDAD
		</a>

	</div>

</body>
</html>