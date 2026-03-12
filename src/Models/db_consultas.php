<?php
require_once 'db_conexion.php';

class DbConsulta {
    /** @var PDO */
    private $conexion;

    public function __construct() {
        $db = new DbConexion();
        $this->conexion = $db->getConexion();
    }

    // SELECT que devuelve UNA fila
    public function selectUno($sql, $params = []) {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en selectUno: " . $e->getMessage());
            return null;
        }
    }

    // SELECT que devuelve VARIAS filas
    public function selectVarios($sql, $params = []) {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en selectVarios: " . $e->getMessage());
            return [];
        }
    }

    // INSERT, UPDATE, DELETE
    public function ejecutar($sql, $params = []) {
        try {
            $stmt = $this->conexion->prepare($sql);
            $resultado = $stmt->execute($params);
            return [
                'resultado' => $resultado,
                'ultimo_id' => $this->conexion->lastInsertId()
            ];
        } catch (PDOException $e) {
            error_log("Error en ejecutar: " . $e->getMessage());
            return [
                'resultado' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
?>