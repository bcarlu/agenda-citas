<?php
declare(strict_types=1);

// Aceptar unicamente peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo htmlspecialchars('Método no permitido', ENT_QUOTES);
    exit;
}

// Validacion de los inputs recibidos
$nombre = isset($_POST['nombre-reg']) && !empty($_POST['nombre-reg']) ? $_POST['nombre-reg'] : null;
$apellidos = isset($_POST['apellidos-reg']) && !empty($_POST['apellidos-reg']) ? $_POST['apellidos-reg'] : null;
$email = isset($_POST['email-reg']) && !empty($_POST['email-reg']) ? $_POST['email-reg'] : null;
$celular = isset($_POST['celular-reg']) && !empty($_POST['celular-reg']) ? $_POST['celular-reg'] : null;
$clave = isset($_POST['clave-reg']) && !empty($_POST['clave-reg']) ? $_POST['clave-reg'] : null;

// Verificar los campos obligatorios
if ($nombre === null || $email === null || $clave === null) {
    http_response_code(400);
    header("location:../registro.php?error=faltan_campos_obligatorios");
}

try {
    //Encriptar la clave
    $clavenc = password_hash($clave, PASSWORD_BCRYPT);

    // Importar conexion a la db
    include_once'conexionpg.php';
    include_once'crearUsuario.php';
    $db = ConectorPG::obtenerInstancia();
    $pdo = $db->conectar();

    // Verificar si el email ya está registrado
    $stmt = $pdo->prepare('SELECT COUNT(email) FROM t_clientes WHERE email=:email');
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $registrado = $stmt->fetch();

    if ($registrado && $registrado["count"] > 0) {
        // Email ya registrado
        http_response_code(409);
        header("location:../registro.php?error=email_ya_registrado");
    } else {
        // Registrar nuevo usuario y redirigir a la pagina de login
        $creado =crearUsuario($nombre, $apellidos, $email, $celular, $clavenc);
        if ($creado) {
            header("location:../ingreso.php?registro=exitoso?nombre=$nombre");
        } else {
            http_response_code(500);
            header("location:../registro.php?error=error_al_crear_usuario");
        }
    }
} catch (\Throwable $e) {
    error_log("Error en el proceso de registro: " . $e->getMessage(), (int)$e->getCode());
    http_response_code(500);
    header("location:../registro.php?error=error_interno");
}