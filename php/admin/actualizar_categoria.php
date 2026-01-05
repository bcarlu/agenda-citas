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
        $nombreCategoria = filter_input(INPUT_POST,"nombre-categoria",FILTER_SANITIZE_SPECIAL_CHARS);
        $idCuenta = $_SESSION['id_cuenta'] ?? 0;

        // Verificar los campos obligatorios
        if ($idCategoria === null || $idCategoria === false || $nombreCategoria === null || $nombreCategoria === false) {
            http_response_code(400);
            $tipo = urlencode("error");
            $mensaje  = urlencode("Faltan campos obligatorios, por favor revisa tus datos.");
            header('location:/../../paginas/admin/editar_categoria.php?tipo=' . $tipo . '&mensaje=' . $mensaje . '&id_cat='. urlencode($idCategoria) .'&nom_cat='. urlencode($nombreCategoria) );
            exit;
        }

        // Obtener datos actuales de la categoria para compararlos y actualizar solo los campos modificados
        $stmtCategoria = $pdo->prepare("SELECT * FROM t_categorias WHERE id=?");
        $stmtCategoria->execute([$idCategoria]);
        $categoria = $stmtCategoria->fetch(PDO::FETCH_ASSOC);
        
        // Validar que la categoria pertenezca a la cuenta
        $categoriasDatos = obtenerCategorias();
        $idCategorias = array_column($categoriasDatos, 'id'); // obtener array solo con los ids
        $categoriaCuenta = in_array($idCategoria,$idCategorias); 

        // En caso de inconsistencia en categoria
        if ($categoriaCuenta === false) {
            http_response_code(400);
            error_log("Error al actualizar categoria: Categoria no encontrada o id de cuenta no corresponde");
            $tipo = urlencode("error");
            $mensaje  = urlencode("La categoria no existe.");
            header('location:/../../paginas/admin/categorias_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        }

        // Validar cuales campos fueron actualizados para solamente enviar estos en la consulta
        $camposActualizados = [];
        if (isset($categoria["nombre"]) && $categoria["nombre"] != $nombreCategoria) { $camposActualizados["nombre"] =  $nombreCategoria; }

        // si no hay campos para actualizar se redirige a la lista de categorias
        if (empty($camposActualizados)) {
            $tipo = urlencode("exito");
            $mensaje  = urlencode("No se hicieron cambios.");
            header('location:/../../paginas/admin/categorias_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        }

        //Si pasa todas las validaciones anteriores se actualiza la categoria
        $camposParaSet = [];
        foreach($camposActualizados as $campo => $valor){ // Se agregan los campos a actualizar en el array
            $camposParaSet[] = "$campo = :$campo";
        }
        $textoSet = implode(",", $camposParaSet); // Se convierte a string para pasar en la consulta

        $stmtActualizar = $pdo->prepare("UPDATE t_categorias SET $textoSet, actualizado_en=NOW() WHERE id=:id");
        foreach ($camposActualizados as $campo => $valor) { // Se asocia el valor a los campos dinamicamente
            $stmtActualizar->bindValue(":$campo", $valor);
        }
        $stmtActualizar->bindValue(':id', $idCategoria);
        $stmtActualizar->execute();
        $categoriaActualizada = $stmtActualizar->rowCount();
        
        if ($categoriaActualizada > 0) {  
            $tipo = urlencode("exito");
            $mensaje  = urlencode("Categoria actualizada con exito.");
            header('location:/../../paginas/admin/categorias_admin.php?tipo=' . $tipo . '&mensaje=' . $mensaje);
            exit;
        } else {
            echo "Error al actualizar la categoria, por favor intenta de nuevo. <a href='/paginas/admin/categorias_admin.php'>Volver</a>";
        }
    } catch (\Throwable $th) {
        error_log("Error al actualizar categoria: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor. por favor intenta de nuevo. <a href='/paginas/admin/categorias_admin.php'>Volver</a> o informa al administrador.";
    }
}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
}