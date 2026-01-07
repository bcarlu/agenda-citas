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
        $idEsteticista = filter_input(INPUT_POST,"id-esteticista",FILTER_SANITIZE_NUMBER_INT);
        $idCuenta = $_SESSION['id_cuenta'] ?? 0;

        // Verificar los campos obligatorios
        if ($idEsteticista === null || $idEsteticista === false) {
            $tipo = urlencode("error");
            $mensaje  = urlencode("El esteticista no existe.");
            header('location:/../../paginas/admin/esteticistas_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        }

        // Confirmar que el esteticista pertenezca a la cuenta
        $stmtEstet = $pdo->prepare("SELECT * FROM t_esteticistas WHERE id=? AND id_cuenta=?");
        $stmtEstet->execute([$idEsteticista, $idCuenta]);
        $esteticista = $stmtEstet->fetch(PDO::FETCH_ASSOC);
        
        if($esteticista === false) {
            $tipo = urlencode("error");
            $mensaje  = urlencode("El esteticista no existe.");
            header('location:/../../paginas/admin/esteticistas_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        }

        // Validar si el esteticista ya ha sido asignado a alguna cita
        $sqlEsteticistaCita = "SELECT COUNT(*) FROM t_citas WHERE id_esteticista=?";
        $stmtEsteticistaCita = $pdo->prepare($sqlEsteticistaCita);
        $stmtEsteticistaCita->execute([$idEsteticista]);
        $esteticistaCita = $stmtEsteticistaCita->fetchColumn();

        // Si el esteticista no se ha asignado a alguna cita se hace borrado fisico
        if($esteticistaCita === 0){
            $sqlEliminar = "DELETE FROM t_esteticistas WHERE id=?";
            $stmtEliminar = $pdo->prepare($sqlEliminar);
            $stmtEliminar->execute([$idEsteticista]);
            $esteticistaEliminado = $stmtEliminar->rowCount();
        }

        // Si el servicio ya ha sido asignado a alguna cita se realiza borrado logico
        if($esteticistaCita > 0){
            $sqlEliminar = "UPDATE t_esteticistas SET id_estado=3, actualizado_en=NOW() WHERE id=?";
            $stmtEliminar = $pdo->prepare($sqlEliminar);
            $stmtEliminar->execute([$idEsteticista]);
            $esteticistaEliminado = $stmtEliminar->rowCount();
        } 

        // Redireccionar a la lista de servicios
        if ($esteticistaEliminado > 0) {
            $tipo = urlencode("exito");
            $mensaje  = urlencode("Esteticista eliminado con éxito.");
            header('location:/../../paginas/admin/esteticistas_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        } else {
            echo "Error al eliminar el esteticista, por favor intenta de nuevo. <a href='/paginas/admin/esteticistas_admin.php'>Volver</a>";
        }
    } catch (\Throwable $th) {
        error_log("Error al eliminar esteticista: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor. por favor intenta de nuevo. <a href='/paginas/admin/esteticistas_admin.php'>Volver</a> o informa al administrador.";
    }
}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
}