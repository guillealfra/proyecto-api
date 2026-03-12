<?php
require_once('../Models/ConsultasModel.php');
require_once('../Views/view.php');

$data = ConsultasModel::listarConsultas();

View::show('../Views/historial.php', $data);
?>