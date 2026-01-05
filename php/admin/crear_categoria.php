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
        $nombre = isset($_POST['nombre-categoria']) && !empty($_POST['nombre-categoria']) ? $_POST['nombre-categoria'] : null;        
        $idCuenta = $_SESSION['id_cuenta'] ?? 0;

        // Verificar los campos obligatorios
        if ($nombre === null) {
            $tipo = urlencode("error");
            $mensaje  = urlencode("Faltan campos obligatorios, por favor revisa tus datos.");
            $urlRedireccion = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] . '?tipo=' . $tipo . '&mensaje=' . $mensaje : '/../../paginas/admin/nueva_categoria.php?tipo=' . $tipo . '&mensaje=' . $mensaje;
            header('location:' . $urlRedireccion);
            exit;
        }
        
        //Se crea categoria
        $datosCategoria = [$nombre, $idCuenta];
        $stmt = $pdo->prepare("INSERT INTO t_categorias (nombre, id_cuenta)
        VALUES (?, ?)");
        $stmt->execute($datosCategoria);
        $categoria = $stmt->rowCount();
        
        if ($categoria > 0) {
            $tipo = urlencode("exito");
            $mensaje  = urlencode("Categoria creda con éxito.");
            header('location:/../../paginas/admin/categorias_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        } else {
            echo "Error al crear categoria, por favor intenta de nuevo. <a href='../../paginas/admin/nueva_categoria.php'>Volver</a>";
        }
    } catch (\Throwable $th) {
        error_log("Error al crear categoria: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor. por favor intenta de nuevo. <a href='../../paginas/admin/nueva_categoria.php'>Volver</a> o informa al administrador.";
    }
}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
}