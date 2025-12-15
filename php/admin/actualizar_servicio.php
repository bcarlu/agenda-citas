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
        $id = filter_input(INPUT_POST,"id-servicio",FILTER_SANITIZE_NUMBER_INT);
        $nombre = filter_input(INPUT_POST,"nombre-servicio",FILTER_SANITIZE_SPECIAL_CHARS);
        $idCategoria = filter_input(INPUT_POST,"categoria-servicio",FILTER_SANITIZE_NUMBER_INT);
        $precio = filter_input(INPUT_POST,"precio-servicio",FILTER_SANITIZE_NUMBER_INT);
        $duracion = filter_input(INPUT_POST,"duracion-servicio",FILTER_SANITIZE_NUMBER_INT);
        $idCuenta = $_SESSION['id_cuenta'] ?? 0;

        // Verificar los campos obligatorios
        if ($nombre === null || $nombre === false || $idCategoria === null || $idCategoria === false || $precio === null || $precio === false || $duracion === null || $duracion === false) {
            http_response_code(400);
            header("location:/../../paginas/admin/editar_servicio.php?error=faltan_campos_obligatorios");
            exit;
        }

        // Obtener datos actuales del servicio para compararlos y actualizar solo los campos modificados
        $stmtServicio = $pdo->prepare("SELECT * FROM t_servicios WHERE id=?");
        $stmtServicio->execute([$id]);
        $servicio = $stmtServicio->fetch(PDO::FETCH_ASSOC);
        
        // Validar que la categoria pertenezca a la cuenta
        $categoriasDatos = obtenerCategorias();
        $idCategorias = array_column($categoriasDatos, 'id'); // obtener array solo con los ids
        $categoriaCuenta = in_array($idCategoria,$idCategorias); 

        // En caso de inconsistencia en servicio o categoria
        if (!$servicio || $servicio["id_cuenta"] != $idCuenta || $categoriaCuenta === false) {
            http_response_code(400);
            error_log("Error al actualizar servicio: Servicio no encontrado o id de cuenta no corresponde");
            header("location: ../../servicios_admin.php?error=servicio_no_existe");
            exit;
        }

        // Validar cuales campos fueron actualizados para solamente enviar estos en la consulta
        $camposActualizados = [];
        if ($servicio["nombre"] != $nombre) { $camposActualizados["nombre"] =  $nombre; }
        if ($servicio["id_cat"] != $idCategoria) { $camposActualizados["id_cat"] =  $idCategoria; }
        if ($servicio["precio"] != $precio) { $camposActualizados["precio"] =  $precio; }
        if ($servicio["duracion"] != $duracion) { $camposActualizados["duracion"] =  $duracion; }

        // si no hay campos para actualizar se redirige a la lista de servicios
        if (empty($camposActualizados)) {
            header('location: ../../servicios_admin.php?servicio=sin_cambios');
            exit;
        }

        //Si pasa todas las validaciones anteriores se actualiza el servicio
        $camposParaSet = [];
        foreach($camposActualizados as $campo => $valor){ // Se agregan los campos a actualizar en el array
            $camposParaSet[] = "$campo = :$campo";
        }
        $textoSet = implode(",", $camposParaSet); // Se convierte a string para pasar en la consulta

        $stmtActualizar = $pdo->prepare("UPDATE t_servicios SET $textoSet WHERE id=:id");
        foreach ($camposActualizados as $campo => $valor) { // Se asocia el valor a los campos dinamicamente
            $stmtActualizar->bindValue(":$campo", $valor);
        }
        $stmtActualizar->bindValue(':id', $id);
        $stmtActualizar->execute();
        $servicioActualizado = $stmtActualizar->rowCount();
        
        if ($servicioActualizado > 0) {            
            header('location: ../../servicios_admin.php?servicio=actualizado');
            exit;
        } else {
            echo "Error al actualizar el servicio, por favor intenta de nuevo. <a href='../../servicios_admin.php'>Volver</a>";
        }
    } catch (\Throwable $th) {
        error_log("Error al actualizar servicio: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor. por favor intenta de nuevo. <a href='../../servicios_admin.php'>Volver</a> o informa al administrador.";
    }
}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
}