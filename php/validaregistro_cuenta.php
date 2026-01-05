<?php
declare(strict_types=1);

// Aceptar unicamente peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo htmlspecialchars('Método no permitido', ENT_QUOTES);
    exit;
}

// Validacion de los inputs recibidos
$nombre = isset($_POST['nombre-usu-cuenta']) && !empty($_POST['nombre-usu-cuenta']) ? $_POST['nombre-usu-cuenta'] : null;
$apellidos = isset($_POST['apellidos-usu-cuenta']) && !empty($_POST['apellidos-usu-cuenta']) ? $_POST['apellidos-usu-cuenta'] : null;
$email = isset($_POST['email-usu-cuenta']) && !empty($_POST['email-usu-cuenta']) ? $_POST['email-usu-cuenta'] : null;
$celular = isset($_POST['celular-usu-cuenta']) && !empty($_POST['celular-usu-cuenta']) ? $_POST['celular-usu-cuenta'] : null;
$nombreEmpresa = isset($_POST['nombre-emp-cuenta']) && !empty($_POST['nombre-emp-cuenta']) ? $_POST['nombre-emp-cuenta'] : null;
$nitEmpresa = isset($_POST['nit-emp-cuenta']) && !empty($_POST['nit-emp-cuenta']) ? $_POST['nit-emp-cuenta'] : null;
$password = isset($_POST['password-usu-cuenta']) && !empty($_POST['password-usu-cuenta']) ? $_POST['password-usu-cuenta'] : null;

// Verificar los campos obligatorios
if ($nombre === null || $email === null || $password === null || $nombreEmpresa === null || $nitEmpresa === null) {
    http_response_code(400);
    $tipo = urlencode("error");
    $mensaje  = urlencode("Faltan campos obligatorios, por favor revisa tus datos.");
    header('location:../registro_cuenta.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
    exit;
}

try {
    //Encriptar la clave
    $passwordEnc = password_hash($password, PASSWORD_BCRYPT);

    // Importar conexion a la db
    include_once 'conexionpg.php';
    include_once 'funciones.php';
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
        header('location:../registro_cuenta.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
        exit;
    } else {
        // Crear cuenta
        $cuentaCreada = crearCuenta($nombreEmpresa, $nitEmpresa);
        if (!$cuentaCreada) {
            http_response_code(500);
            $tipo = urlencode("error");
            $mensaje  = urlencode("Error al crear la cuenta. Intenta de nuevo en un momento.");
            header('location:../registro_cuenta.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
            exit;
        }

        // Si se creo la cuenta, registrar nuevo usuario y redirigir a la pagina de login
        $idRol = 1; // Administrador
        $idCuenta = $cuentaCreada; // Id de la cuenta que se acaba de crear.
        $creado = crearUsuario($nombre, $apellidos, $email, $celular, $passwordEnc, $idRol, $idCuenta);
        if ($creado) {
            $tipo = urlencode("exito");
            $mensaje  = urlencode("Cuenta creada con éxito! Ahora puedes iniciar sesion.");
            header('location:../ingreso.php?tipo=' . $tipo . '&mensaje=' . $mensaje );
            exit;
        } else { // TODO: Si hay error creando el usuario salta al catch y por lo tanto no entra al else y no elimina la cuenta. Revisar como solucinar.
            $cuentaEliminada = eliminarCuenta($cuentaCreada); // En caso de error al crear el usuario se elimina la cuenta creada para evitar registros duplicados o huerfanos.
            if (!$cuentaEliminada) {
                error_log("Error al eliminar la cuenta despues de error creando usuario. Revisar bd para evitar duplicidad.");
            }
            http_response_code(500);
            $tipo = urlencode("error");
            $mensaje  = urlencode("Error al crear usuario de la cuenta. No se pudo crear la cuenta. Intentalo de nuevo por favor.");
            $timeout = 10000;
            header('location:../registro_cuenta.php?tipo=' . $tipo . '&mensaje=' . $mensaje . '&timeout=' . $timeout);
            exit;
        }
    }
} catch (\Throwable $e) {
    error_log("Error en el proceso de registro cuenta: " . $e->getMessage() . " con codigo: " .(int)$e->getCode() . " en linea: " . $e->getLine() . " en archivo: " . $e->getFile());
    http_response_code(500);
    $tipo = urlencode("error");
    $mensaje  = urlencode("Error interno del servidor. Intentalo nuevamente o informa al administrador.");
    $timeout = 5000;
    header('location:../registro_cuenta.php?tipo=' . $tipo . '&mensaje=' . $mensaje . '&timeout=' . $timeout);
    exit;
}