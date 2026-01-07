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
        $id = filter_input(INPUT_POST,"id-esteticista",FILTER_SANITIZE_NUMBER_INT);
        $nombre = filter_input(INPUT_POST,"nombre-esteticista",FILTER_SANITIZE_SPECIAL_CHARS);
        $idCategoria = filter_input(INPUT_POST,"categoria-esteticista",FILTER_SANITIZE_NUMBER_INT);
        $idCuenta = $_SESSION['id_cuenta'] ?? 0;

        // Verificar los campos obligatorios
            if ($nombre === null || $nombre === false || $idCategoria === null || $idCategoria === false) {  
            $tipo = urlencode("error");
            $mensaje  = urlencode("Faltan campos obligatorios, por favor revisa tus datos.");
            $urlRedireccion = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] . '&tipo=' . $tipo . '&mensaje=' . $mensaje : '/../../paginas/admin/esteticistas_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje;
            header('location:' . $urlRedireccion);
            exit;
        }

        // Obtener datos actuales de la esteticista para compararlos y actualizar solo los campos modificados. Tambien se asegura que pertenezca a la cuenta.
        $stmtEstet = $pdo->prepare("SELECT * FROM t_esteticistas WHERE id=? AND id_cuenta=?");
        $stmtEstet->execute([$id, $idCuenta]);
        $esteticista = $stmtEstet->fetch(PDO::FETCH_ASSOC);
        
        // Validar que la categoria pertenezca a la cuenta
        $categoriasDatos = obtenerCategorias();
        $idCategorias = array_column($categoriasDatos, 'id'); // obtener array solo con los ids
        $categoriaCuenta = in_array($idCategoria,$idCategorias);

        // En caso de inconsistencia en esteticista o categoria
        if (!$esteticista || $esteticista["id_cuenta"] != $idCuenta || $categoriaCuenta === false) {
            error_log("Error al actualizar esteticista: Esteticista no encontrado o id de cuenta no corresponde");
            $tipo = urlencode("error");
            $mensaje  = urlencode("La esteticista no existe.");
            header('location:/../../paginas/admin/esteticistas_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        }

        // Validar cuales campos fueron actualizados para solamente enviar estos en la consulta
        $camposActualizados = [];
        if ($esteticista["nombre"] != $nombre) { $camposActualizados["nombre"] =  $nombre; }
        if ($esteticista["id_cat"] != $idCategoria) { $camposActualizados["id_cat"] =  $idCategoria; }

        // si no hay campos para actualizar se redirige a la lista de esteticistas
        if (empty($camposActualizados)) {
            $tipo = urlencode("exito");
            $mensaje  = urlencode("No se hicieron cambios.");
            header('location:/../../paginas/admin/esteticistas_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        }

        //Si pasa todas las validaciones anteriores se actualiza la esteticista
        $camposParaSet = [];
        foreach($camposActualizados as $campo => $valor){ // Se agregan los campos a actualizar en el array
            $camposParaSet[] = "$campo = :$campo";
        }
        $textoSet = implode(",", $camposParaSet); // Se convierte a string para pasar en la consulta

        $stmtActualizar = $pdo->prepare("UPDATE t_esteticistas SET $textoSet, actualizado_en=NOW() WHERE id=:id");
        foreach ($camposActualizados as $campo => $valor) { // Se asocia el valor a los campos dinamicamente
            $stmtActualizar->bindValue(":$campo", $valor);
        }
        $stmtActualizar->bindValue(':id', $id);
        $stmtActualizar->execute();
        $esteticistaActualizado = $stmtActualizar->rowCount();
        
        if ($esteticistaActualizado > 0) {  
            $tipo = urlencode("exito");
            $mensaje  = urlencode("Esteticista actualizada con exito.");
            header('location:/../../paginas/admin/esteticistas_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        } else {
            echo "Error al actualizar esteticista, por favor intenta de nuevo. <a href='/paginas/admin/esteticistas_admin.php'>Volver</a>";
        }
    } catch (\Throwable $th) {
        error_log("Error al actualizar esteticista: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor. por favor intenta de nuevo. <a href='/paginas/admin/esteticistas_admin.php'>Volver</a> o informa al administrador.";
    }
}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
}