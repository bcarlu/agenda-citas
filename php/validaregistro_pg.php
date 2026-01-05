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
$uuid = isset($_POST['id_cuenta']) && !empty($_POST['id_cuenta']) ? $_POST['id_cuenta'] : null; //  uuid de la cuenta

// Verificar los campos obligatorios
if ($nombre === null || $email === null || $clave === null || $uuid === null) {
    http_response_code(400);
    $tipo = urlencode("error");
    $mensaje  = urlencode("Faltan campos obligatorios, por favor revisa tus datos.");
    header('location:../registro.php?tipo=' . $tipo . '&mensaje=' . $mensaje . '&id_cuenta=' . $uuid );
    exit;
}

try {
    //Encriptar la clave
    $clavenc = password_hash($clave, PASSWORD_BCRYPT);

    // Importar conexion a la db
    include_once'conexionpg.php';
    include_once'funciones.php';
    $db = ConectorPG::obtenerInstancia();
    $pdo = $db->conectar();

    // Verificar si el email ya está registrado
    $stmt = $pdo->prepare('SELECT COUNT(email) FROM t_usuarios WHERE email=:email');
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $registrado = $stmt->fetch();

    if ($registrado && $registrado["count"] > 0) {
        // Email ya registrado
        http_response_code(409);
        $tipo = urlencode("error");
        $mensaje  = urlencode("El email suministrado ya esta registrado. Inicia sesion o intenta con otro email.");
        header('location:../registro.php?tipo=' . $tipo . '&mensaje=' . $mensaje . '&id_cuenta=' . $uuid );
        exit;
    } else {
        // Verificar que la cuenta exista
        $stmtCuenta = $pdo->prepare('SELECT id FROM t_cuentas WHERE uuid=:uuid');
        $stmtCuenta->bindValue(':uuid', $uuid, PDO::PARAM_STR);
        $stmtCuenta->execute();
        $cuenta = $stmtCuenta->fetch(PDO::FETCH_ASSOC);

        if($cuenta === false){ // Si la cuenta no existe
            http_response_code(409);
            error_log("Error: Usuario intentandose registrar en una cuenta inexistente. uuid cuenta:" . $uuid);
            echo "Error: id_cuenta no existe. Valida con tu administrador!";
            exit;
        }

        // Registrar nuevo usuario y redirigir a la pagina de login
        $idRol = 2; // Cliente
        $idCuenta = $cuenta["id"];
        $creado =crearUsuario($nombre, $apellidos, $email, $celular, $clavenc, $idRol, $idCuenta);
        if ($creado) {
            http_response_code(200);
            $tipo = urlencode("exito");
            $mensaje  = urlencode("Usuario registrado con éxito! Ahora puedes iniciar sesion.");
            header('location:../ingreso.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
            exit;
        } else {
            http_response_code(500);
            $tipo = urlencode("error");
            $mensaje  = urlencode("Error al crear usuario. Intentalo de nuevo.");
            header('location:../registro.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
            exit;
        }
    }
} catch (\Throwable $e) {
    error_log("Error en el proceso de registro: " . $e->getMessage(), (int)$e->getCode());
    http_response_code(500);
    $tipo = urlencode("error");
    $mensaje  = urlencode("Error interno del servidor. Intentalo nuevamente o informa al administrador.");
    $timeout = 5000;
    header('location:../registro.php?tipo=' . $tipo . '&mensaje=' . $mensaje . '&timeout=' . $timeout);
    exit;
}