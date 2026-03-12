<?php
require_once("../Models/OpenWeatherService.php");
require_once("../Views/view.php");
require_once("../Models/ConsultasModel.php");


if (isset($_POST['buscar_button'])) {
    $ciudad = trim($_POST['ciudad_input']);
    
    $data = OpenWeatherService::buscarCiudad($ciudad);

    ConsultasModel::registrarConsulta($ciudad, 'simple');
    View::show("../Views/buscar_ciudad.php", $data);
}
?>