<?php
session_start();


$usuario = $_SESSION['username'];
$idRolUsuario = $_SESSION['id_rol'];

if (isset($usuario) && $idRolUsuario === 1) {
    try {
        //Se incluye conexion a la bd
        include_once'../conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();
            
        // Validacion de los inputs recibidos
        $nombre = isset($_POST['nombre-servicio']) && !empty($_POST['nombre-servicio']) ? $_POST['nombre-servicio'] : null;
        $idCategoria = isset($_POST['categoria-servicio']) && !empty($_POST['categoria-servicio']) ? $_POST['categoria-servicio'] : null;
        $precio = isset($_POST['precio-servicio']) && !empty($_POST['precio-servicio']) ? $_POST['precio-servicio'] : null;
        $duracion = isset($_POST['duracion-servicio']) && !empty($_POST['duracion-servicio']) ? $_POST['duracion-servicio'] : null;
        $idCuenta = $_SESSION['id_cuenta'] ?? 0;

        // Verificar los campos obligatorios
        if ($nombre === null || $idCategoria === null || $precio === null || $duracion === null) {
            http_response_code(400);
            header("location:/../../paginas/admin/nuevo_servicio.php?error=faltan_campos_obligatorios");
            exit;
        }
        
        //Se crea servicio
        $datosServicio = [$nombre, $idCategoria, $precio, $duracion, $idCuenta];
        $stmt = $pdo->prepare("INSERT INTO t_servicios (nombre, id_cat, precio, duracion, id_cuenta)
        VALUES (?, ?, ?, ?, ?)");
        $stmt->execute($datosServicio);
        $servicio = $stmt->rowCount();
        
        if ($servicio > 0) {            
            header('location: ../../servicios_admin.php?servicio=exito');
            exit;
        } else {
            echo "Error al crear el servicio, por favor intenta de nuevo. <a href='../../paginas/admin/nuevo_servicio.php'>Volver</a>";
        }
    } catch (\Throwable $th) {
        error_log("Error al crear servicio: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor. por favor intenta de nuevo. <a href='../../paginas/admin/nuevo_servicio.php'>Volver</a> o informa al administrador.";
    }
}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
}