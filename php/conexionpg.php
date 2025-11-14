<?php
require __DIR__ . '/../vendor/autoload.php';

// Carga las variables del archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


// Esta clase utiliza el patrón singleton para crear la instancia de la conexión y PDO para los metodos.
class ConectorPG {
    private static ?ConectorPG $instancia = null; // Variable para instanciar la clase
    private ?PDO $conexion = null; // Variable de tipo PDO para la conexion

    private string $servername;
    private string $username;
    private string $password;
    private string $dbname;

    // Constructor privado para evitar que se creen instancias con "new"
    private function __construct() {
        // Se asignan los valores de conexion desde las variables de entorno
        $this->servername = $_ENV["PG_HOST"];
        $this->username = $_ENV["PG_USER"];
        $this->password = $_ENV["PG_PASSWORD"];
        $this->dbname = $_ENV["PG_DBNAME"];
    }

    // Obtener la instancia unica de la clase. Metodo singleton.
    public static function obtenerInstancia(): ConectorPG {
        if (self::$instancia === null) {
            self::$instancia = new ConectorPG(); // Crea una nueva instancia de la clase si no existe
        }
        return self::$instancia; // Retorna la instancia unica
    }

    public function conectar(): PDO {
        if ($this->conexion === null) {
            try {
                $dsn = "pgsql:host={$this->servername};dbname={$this->dbname}";
                // se definen las opciones para la gestión de errores, el formato de los resultados y la seguridad
                $opciones = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                $this->conexion = new PDO($dsn, $this->username, $this->password, $opciones);
            } catch (PDOException $e) {
                throw new PDOException("Error de conexión: " . $e->getMessage(), (int)$e->getCode());
            }
        }
        return $this->conexion;
    }
}