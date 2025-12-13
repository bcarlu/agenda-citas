<?php
session_start();


$usuario = $_SESSION['username'];

if (isset($usuario)) {
    try {
        //Se incluye conexion a la bd
        include_once'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();
            
        // Definir variables GET para registrar la cita
        $idServicio = $_GET['id_serv'];
        $idEsteticista = $_GET['est'];
        $idCategoria = $_GET['cat'];
        $emailUsuario = $usuario;
        $anio = $_GET['anio'];
        $mes = $_GET['mes'];
        $dia = $_GET['dia'];
        $hora = $_GET['hora'];
        $duracionServicio = $_GET['duracion'];
        $horafin = $hora + $duracionServicio;

        // Definir nombre servicio para enviar a la pag agenda en caso de redireccionar
        $nombreServ = $_GET['serv'];

        // Validar citas duplicadas
        $stmtCitas = $pdo->prepare("SELECT id FROM t_citas WHERE id_esteticista=:idEsteticista AND anio=:anio AND mes=:mes AND dia=:dia AND hora=:hora AND horafin=:horafin");
        $stmtCitas->bindValue("idEsteticista", $idEsteticista, PDO::PARAM_INT);
        $stmtCitas->bindValue("anio", $anio, PDO::PARAM_INT);
        $stmtCitas->bindValue("mes", $mes, PDO::PARAM_INT);
        $stmtCitas->bindValue("dia", $dia, PDO::PARAM_INT);
        $stmtCitas->bindValue("hora", $hora, PDO::PARAM_INT);
        $stmtCitas->bindValue("horafin", $horafin, PDO::PARAM_INT);
        $stmtCitas->execute();
        $citas = $stmtCitas->fetch(PDO::FETCH_ASSOC);

        // Si el esteticista ya tiene cita en la fecha solicitada se regresa a la pagina de agenda para que escoja otra
        if ($citas) {            
            header("location: ../agenda.php?serv_id=$idServicio&serv=$nombreServ&agendado=si");
            exit;
        }
        //Si no se registra normalmente
        else {
            //Registra cita
            $datosCita = [$idServicio, $idCategoria, $idEsteticista, $emailUsuario, $anio, $mes, $dia, $hora, $duracionServicio, $horafin];
            $stmtRegCitas = $pdo->prepare("INSERT INTO t_citas (id_serv, id_cat, id_esteticista, email_cliente, anio, mes, dia, hora, duracion, horafin)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtRegCitas->execute($datosCita);
            $citaRegistrada = $stmtRegCitas->rowCount();
            
            if ($citaRegistrada > 0) {
                /*Se redirecciona a la pagina de enviar correo y debido a que se envian datos por GET con variables se utilizan comillas dobles*/
                //header("location: enviarcorreo.php?serv=$servicioEscogido&est=$esteticista&dia=$dia&mes=$mes&hora=$hora&horafin=$horafin&precio=$precio");

                // Por el momento se comenta la redireccion a la pagina de envio de correo para simplificar el proceso, y se redirige directamente a la pagina de inicio del usuario.
                header('location: ../inicio.php?agenda=exito');
                exit;
            } else {
                echo "Error al registrar la cita, por favor intenta de nuevo. <a href='../agenda.php?serv_id=$idServicio&serv=$nombreServ'>Volver</a>";
            }
            
            
        }
    } catch (\Throwable $th) {
        error_log("Error al registrar cita: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor. por favor intenta de nuevo. <a href='../agenda.php?serv_id=$idServicio&serv=$nombreServ'>Volver</a> o informa al administrador.";
    }
}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='../'>inicia sesión</a> :)</h3></div> ";
}
