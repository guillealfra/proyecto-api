<?php
class DbConexion {
    /** @var PDO */
    private $conexion;

    public function __construct() {
        $hostname = getenv('DB_HOST');
        $username = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        $database = getenv('DB_NAME');
        $port = getenv('DB_PORT');

        try {
            $dsn = "pgsql:host=$hostname;port=$port;dbname=$database";
            $this->conexion = new PDO($dsn, $username, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            exit("Error al conectar a la DB: " . $e->getMessage());
        }
    }

    /**
     * @return PDO
     */
    public function getConexion() {
        return $this->conexion;
    }

    public function __destruct() {
        $this->conexion = null;
    }
}
?>