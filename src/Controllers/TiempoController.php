<?php
require_once('../Views/view.php');
require_once('../Models/OpenWeatherService.php');
require_once("../Models/ConsultasModel.php");

$ciudad = $_GET['ciudad'] ?? 'DESCONOCIDA';
$lat = $_GET['lat'] ?? null;
$lon = $_GET['lon'] ?? null;

$data['actual'] = OpenWeatherService::tiempoActualCiudad($lat, $lon);
$data['semanal'] = OpenWeatherService::tiempoSemanalCiudad($lat, $lon);
$data['ciudad'] = $ciudad;

ConsultasModel::registrarConsulta($ciudad, 'complejo', $lat, $lon, $data['actual']['main']['temp'], $data['actual']['weather'][0]['description']);

View::show('../Views/tiempo_ciudad.php', $data);
?>