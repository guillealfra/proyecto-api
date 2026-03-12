<?php
require_once '../Models/db_consultas.php';

class ConsultasModel {
    public static function registrarConsulta($ciudad, $tipo, $lat = null, $lon = null, $temp = null, $descripcion = null) {
        $db = new DbConsulta();
        $db->ejecutar(
            "INSERT INTO consultas (ciudad, tipo, lat, lon, temp, descripcion) VALUES (?, ?, ?, ?, ?, ?)",
            [$ciudad, $tipo, $lat, $lon, $temp, $descripcion]
        );
    }

    public static function listarConsultas() {
        $db = new DbConsulta();
        return $db->selectVarios("SELECT * FROM consultas ORDER BY fecha DESC");
    }
}
?>