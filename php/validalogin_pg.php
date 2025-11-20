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
    header("location:../ingreso.php?error=faltan_campos_obligatorios");
}

try {
    // Importar conexion a la db
    include_once'conexionpg.php';
    $db = ConectorPG::obtenerInstancia();
    $pdo = $db->conectar();

    // Verificar si el usuario existe
    $stmt = $pdo->prepare('SELECT * FROM t_usuarios WHERE email=:email LIMIT 1');
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
            header("location:../inicio.php");
            exit;
        } else {
            // Contraseña incorrecta recarga la pagina con mensaje de error
            header("Location:../ingreso.php?error=clave_incorrecta");
            exit;
        } 
    } else {
        // Usuario no registrado
        header("Location:../ingreso.php?error=usuario_no_registrado");
        exit;
    }
} catch (\Throwable $th) {
    error_log("Error en el proceso de ingreso: " . $e->getMessage(), (int)$e->getCode());
    http_response_code(500);
    header("location:../ingreso.php?error=error_interno");
    exit;
}
