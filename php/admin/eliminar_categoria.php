<?php
declare(strict_types=1);
session_start();
include_once'../funciones.php';

// Aceptar unicamente peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo htmlspecialchars('Método no permitido', ENT_QUOTES);
    exit;
}

// Variables de sesion
$usuario = $_SESSION['username'];
$idRolUsuario = $_SESSION['id_rol'];

if (isset($usuario) && $idRolUsuario === 1) {
    try {
        //Se incluye conexion a la bd
        include_once'../conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();
            
        // Validacion de los inputs recibidos
        $idCategoria = filter_input(INPUT_POST,"id-categoria",FILTER_SANITIZE_NUMBER_INT);
        $idCuenta = $_SESSION['id_cuenta'] ?? 0;

        // Verificar los campos obligatorios
        if ($idCategoria === null || $idCategoria === false) {
            $tipo = urlencode("error");
            $mensaje  = urlencode("La categoria no existe.");
            header('location:/../../paginas/admin/categorias_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        }

        // Validar que la categoria pertenezca a la cuenta
        $categoriasDatos = obtenerCategorias();
        $idCategorias = array_column($categoriasDatos, 'id'); // obtener array solo con los ids
        $categoriaCuenta = in_array($idCategoria,$idCategorias); 

        // En caso de inconsistencia en categoria
        if ($categoriaCuenta === false) {
            error_log("Error al eliminar categoria: Categoria no encontrada o id de cuenta no corresponde");
            $tipo = urlencode("error");
            $mensaje  = urlencode("La categoria no existe.");
            header('location:/../../paginas/admin/categorias_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        }

        // Validar si la categoria ya ha sido asignada a algun servicio o esteticista
        $sqlCategoria = "SELECT c.id 
            FROM t_categorias c
            WHERE c.id=?
            AND (
                EXISTS (SELECT 1 FROM t_servicios s WHERE c.id=s.id_cat)
                OR 
                EXISTS (SELECT 1 FROM t_esteticistas e WHERE c.id=e.id_cat)
            )";
        $stmtCategoriaServEstet = $pdo->prepare($sqlCategoria);
        $stmtCategoriaServEstet->execute([$idCategoria]);
        $categoriaServEstet = $stmtCategoriaServEstet->rowCount();

        // Si la categoria tiene servicios o esteticistas asociados se emite alerta para desasociarlos primero
        if($categoriaServEstet > 0){
            $tipo = urlencode("error");
            $mensaje  = urlencode("La categoria esta asociada a un servicio o esteticista. Primero debes desasociarla.");
            $timeout = 10000;
            header('location:/../../paginas/admin/categorias_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje . '&timeout=' . $timeout);
            exit;
        }

        // Si la categoria no tiene servicios o esteticistas asociados se hace borrado fisico
        if($categoriaServEstet === 0){
            $sqlEliminar = "DELETE FROM t_categorias WHERE id=?";
            $stmtEliminar = $pdo->prepare($sqlEliminar);
            $stmtEliminar->execute([$idCategoria]);
            $categoriaEliminada = $stmtEliminar->rowCount();
        }

        // Redireccionar a la lista de categorias
        if ($categoriaEliminada > 0) { 
            $tipo = urlencode("exito");
            $mensaje  = urlencode("Categoria eliminada con éxito.");
            header('location:/../../paginas/admin/categorias_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        } else {
            echo "Error al eliminar el categoria, por favor intenta de nuevo. <a href='/paginas/admin/categorias_admin.php'>Volver</a>";
        }
    } catch (\Throwable $th) {
        error_log("Error al eliminar categoria: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor. por favor intenta de nuevo. <a href='/paginas/admin/categorias_admin.php'>Volver</a> o informa al administrador.";
    }
}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
}