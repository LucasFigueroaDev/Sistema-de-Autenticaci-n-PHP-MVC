<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno desde .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Definir constantes de la DB
define('DBHOST', $_ENV['DB_HOST']);
define('DBUSER', $_ENV['DB_USER']);
define('DBPASS', $_ENV['DB_PASS']);
define('DBNAME', $_ENV['DB_NAME']);

// Ruta para logs
define('LOG_PATH', __DIR__ . '/../../logs/');

// Crear carpeta de logs si no existe
if (!file_exists(LOG_PATH)) {
    mkdir(LOG_PATH, 0777, true);
}

/**
 * Función para abrir conexión a MySQL
 */
function connection($base = DBNAME)
{
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $conn = new mysqli(DBHOST, DBUSER, DBPASS, $base);
        $conn->set_charset('utf8mb4');
        return $conn;
    } catch (mysqli_sql_exception $e) {
        registerLog('error', "Error de conexión: " . $e->getMessage());
        return false;
    }
}

/**
 * Función para registrar logs
 */
function registerLog($tipo, $mensaje)
{
    $fecha = date('Y-m-d H:i:s');
    $logfile = LOG_PATH . strtolower($tipo) . '.log';
    file_put_contents($logfile, "[$fecha] $mensaje\n", FILE_APPEND);
}

function message($texto, $tipo = 'info', $bg = 'blue')
{
    // $tipo puede ser 'info', 'success', 'error'
    $color = match ($tipo) {
        'success' => 'green',
        'error' => 'red',
        default => 'blue',
    };

    echo "
    <div id='overlayMsg' style='
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    '>
        <div style=\"
            background: $bg;
            border: 2px solid $color;
            padding: 5px 20px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        \"><p style='font-size: 18px; font-weight: bold; color: #fff'>
            " . htmlspecialchars($texto) . "</p>
        </div>
    </div>

    <script>
        document.getElementById('overlayMsg').addEventListener('click', function() {
            this.style.display = 'none';
        });
    </script>
    ";
}

/**
 * Ejecuta una consulta SELECT segura con mysqli prepared statements.
 *
 * @param mysqli $idbase Conexión a la base de datos
 * @param string $sql Consulta SQL con placeholders `?`
 * @param array $params Array con los parámetros y sus tipos. Ej: ['s' => 'valor1', 'i' => 123, 'd' => 3.14, 'b' => true]
 * @return mysqli_result Resultado de la consulta
 * @throws Exception Si ocurre algún error
 */


function query($idbase, $sql, $tipos = '', $valores = [])
{
    $stmt = mysqli_prepare($idbase, $sql);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($idbase));
    }

    if (!empty($tipos) && !empty($valores)) {
        // bind_param requiere referencias
        $refs = [];
        foreach ($valores as $key => $value) {
            $refs[$key] = &$valores[$key];
        }
        array_unshift($refs, $tipos); // primero va la cadena de tipos
        call_user_func_array([$stmt, 'bind_param'], $refs);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        mysqli_stmt_close($stmt);
        throw new Exception("Error al obtener resultados: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    return $result;
}
