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
        $idServicio = filter_input(INPUT_POST,"id-servicio",FILTER_SANITIZE_NUMBER_INT);
        $idCuenta = $_SESSION['id_cuenta'] ?? 0;

        // Verificar los campos obligatorios
        if ($idServicio === null || $idServicio === false) {
            http_response_code(400);
            header("location: ../../servicios_admin.php?error=servicio_no_existe");
            exit;
        }

        // Confirmar que el servicio pertenezca a la cuenta
        $stmtServicio = $pdo->prepare("SELECT id_cuenta FROM t_servicios WHERE id=?");
        $stmtServicio->execute([$idServicio]);
        $servicio = $stmtServicio->fetch(PDO::FETCH_ASSOC);
        
        if($servicio === false || $servicio["id_cuenta"] != $idCuenta) {
            http_response_code(400);
            header("location: ../../servicios_admin.php?error=servicio_no_existe");
            exit;
        }

        // Validar si el servicio ya ha sido asignado a alguna cita
        $sqlServicioCita = "SELECT s.id 
            FROM t_servicios s
            WHERE s.id=?
            AND EXISTS (SELECT 1 FROM t_citas c WHERE s.id=c.id_serv)
        ";
        $stmtServicioCita = $pdo->prepare($sqlServicioCita);
        $stmtServicioCita->execute([$idServicio]);
        $servicioCita = $stmtServicioCita->rowCount();

        // Si el servicio no se ha asignado a alguna cita se hace borrado fisico
        if($servicioCita === 0){
            $sqlEliminar = "DELETE FROM t_servicios WHERE id=?";
            $stmtEliminar = $pdo->prepare($sqlEliminar);
            $stmtEliminar->execute([$idServicio]);
            $servicioEliminado = $stmtEliminar->rowCount();
        }

        // Si el servicio ya ha sido asignado a alguna cita se realiza borrado logico
        if($servicioCita > 0){
            $sqlEliminar = "UPDATE t_servicios SET id_estado=3, actualizado_en=NOW() WHERE id=?";
            $stmtEliminar = $pdo->prepare($sqlEliminar);
            $stmtEliminar->execute([$idServicio]);
            $servicioEliminado = $stmtEliminar->rowCount();
        } 

        // Redireccionar a la lista de servicios
        if ($servicioEliminado > 0) {            
            header('location: ../../servicios_admin.php?servicio=eliminado');
            exit;
        } else {
            echo "Error al eliminar el servicio, por favor intenta de nuevo. <a href='../../servicios_admin.php'>Volver</a>";
        }
    } catch (\Throwable $th) {
        error_log("Error al eliminar servicio: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor. por favor intenta de nuevo. <a href='../../servicios_admin.php'>Volver</a> o informa al administrador.";
    }
}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
}