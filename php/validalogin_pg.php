<?php
session_start();
require_once'conexionpg.php';

// Aceptar unicamente peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo htmlspecialchars('Método no permitido', ENT_QUOTES);
    exit;
}

// Validacion de los inputs recibidos
$email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : null;
$clave = isset($_POST['clave']) && !empty($_POST['clave']) ? $_POST['clave'] : null;

// Verificar los campos obligatorios
if ($email === null || $clave === null) {
    http_response_code(400);
    $tipo = urlencode("error");
    $mensaje  = urlencode("Faltan campos obligatorios, por favor revisa tus datos.");
    header('location:../ingreso.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
    exit;
}

try {
    // Importar conexion a la db
    include_once'conexionpg.php';
    $db = ConectorPG::obtenerInstancia();
    $pdo = $db->conectar();

    // Verificar si el usuario existe
    $sql = 'SELECT u.*, c.uuid
        FROM t_usuarios u
        LEFT JOIN t_cuentas c ON c.id = u.id_cuenta
        WHERE u.email=:email LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && count($usuario) > 0) {
        // Verificar que la contraseña sea correcta
        if (password_verify($clave, $usuario["clave"])) {
            //Se almacena el email del usuario para la sesion y se redirige a la pagina de inicio
            $_SESSION['username'] = $usuario["email"];
            $_SESSION['id_usuario'] = $usuario["id"];
            $_SESSION['nombre_usuario'] = $usuario["nombre"] ?? "";
            $_SESSION['id_rol'] = $usuario["id_rol"];
            $_SESSION['id_cuenta'] = $usuario["id_cuenta"];
            $_SESSION['uuid_cuenta'] = $usuario["uuid"];

            if ($usuario["id_rol"] == 1) { // Redirige al panel de administracion
               header("location:../inicio_admin.php");
               exit;
            }
            if ($usuario["id_rol"] == 2) { // Redirige al panel de cliente
               header("location:../inicio.php");
               exit;
            }
        } else {
            // Contraseña incorrecta recarga la pagina con mensaje de error
            $tipo = urlencode("error");
            $mensaje  = urlencode("Clave o usuario incorrectos. Revisa e intenta de nuevo.");
            header('location:../ingreso.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
            exit;
        } 
    } else {
        // Usuario no registrado
        $tipo = urlencode("error");
        $mensaje  = urlencode("Clave o usuario incorrectos. Revisa e intenta de nuevo.");
        header('location:../ingreso.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
        exit;
    }
} catch (\Throwable $e) {
    error_log("Error en el proceso de ingreso: " . $e->getMessage() . " con codigo: " .(int)$e->getCode() . " en linea: " . $e->getLine() . " en archivo: " . $e->getFile());
    http_response_code(500);
    $tipo = urlencode("error");
    $mensaje  = urlencode("Error interno del servidor. Intenta de nuevo o informa al administrador.");
    header('location:../ingreso.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
    exit;
}
