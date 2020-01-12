<?php


function listaServicios(){
    require_once'conexion.php';
    
    //Se consulta la tabla de categorias y se buscan los registros que coincidan con el nombre recibido
    $nombreCat = $_GET['cat'];
    $queryTablaCat = mysqli_query($conexion,"SELECT * FROM t_categorias WHERE nombre = '$nombreCat'");
    $arrayTablaCat = mysqli_fetch_array($queryTablaCat);

    //Se almacena el id de categoria y se busca en la tabla servicios los que coincidan con id cat
    $idCat = $arrayTablaCat['id_cat'];
    $queryTablaServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE id_cat = '$idCat'");
    
    //Se recorre la tabla de servicios y se listan los que pertenezcan a la cat
    while($arrayTablaServ = mysqli_fetch_array($queryTablaServ)){
        echo ' <a href="agenda.php?serv=' . $arrayTablaServ['nombre'] . '"><img src="img/circle3498db.png" width="75" height="75" alt="..." class="rounded"><br>'
        . $arrayTablaServ['nombre'] . " $:" . $arrayTablaServ['precio'] . "<br>" . '</a>';
    }

}

function listaEsteticistas(){
    require_once'conexion.php';
    
    //Se consulta la tabla de servicios y se buscan los registros que coincidan con el nombre recibido
    $nombreServ = $_GET['serv'];
    $queryTablaServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$nombreServ'");
    $arrayTablaServ = mysqli_fetch_array($queryTablaServ);

    //Se almacena el id de categoria y se busca en la tabla esteticistas los que coincidan con id cat
    $idCat = $arrayTablaServ ['id_cat'];
    $queryTablaEstet = mysqli_query($conexion,"SELECT * FROM t_esteticistas WHERE id_cat = '$idCat'");
    
    
    //Se recorre la tabla de esteticistas y se listan las que pertenezcan a la cat
    while($arrayTablaEstet = mysqli_fetch_array($queryTablaEstet)){
        echo $arrayTablaEstet['nombre'] . "<br>";
    }
}

function agendaDisponible(){
    require_once'conexion.php';
    
    
    //Selecciona la categoria del servicio
    $nombreServ = $_GET['serv'];
    $queryTablaServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$nombreServ'");
    $arrayTablaServ = mysqli_fetch_array($queryTablaServ);    
    $idCat = $arrayTablaServ ['id_cat'];


    //Calcula numero de esteticistas
    $queryTablaEstet = mysqli_query($conexion,"SELECT COUNT(id_estet) AS cantidad FROM t_esteticistas WHERE id_cat = '$idCat'");
    $numEsteticistas = mysqli_fetch_assoc($queryTablaEstet);
    

    //Valida mes
    $anio = date("Y");
    $mes = date("m");
    $buscarnMes = mysqli_fetch_array(mysqli_query($conexion,"SELECT * FROM t_meses WHERE id_mes = '$mes'"));
    $nombreMes = $buscarnMes['nombre'];
    

    //Arreglo de dias
    $semana = array (
        array ("dia" => date("d")),
        array ("dia" => date("d")+1),
        array ("dia" => date("d")+2),
        array ("dia" => date("d")+3),
        array ("dia" => date("d")+4),
    );
    
    //Recorre arreglo y selecciona dias
    foreach ($semana as $sem) {
        $d = $sem['dia'];
        echo "<div class='h5 alert-warning font-weight-bold text-center'> $d de $nombreMes </div>";
        
        //Genera horas dia
        $arregloHoras = array(
            array("hora" => 7, "estado" => "disponible"),
            array("hora" => 8, "estado" => "disponible"),
            array("hora" => 9, "estado" => "disponible"),
            array("hora" => 10, "estado" => "disponible"),
            array("hora" => 11, "estado" => "disponible"),
            array("hora" => 12, "estado" => "disponible"),
            array("hora" => 13, "estado" => "disponible"),
            array("hora" => 14, "estado" => "disponible"),
            array("hora" => 15, "estado" => "disponible"),
            array("hora" => 16, "estado" => "disponible"),
            array("hora" => 17, "estado" => "disponible"),
            array("hora" => 18, "estado" => "disponible"),
        );

        //Ciclo horas
        foreach ($arregloHoras as $horaDia) {
            $h = $horaDia['hora'];
            $e = $horaDia['estado'];
            
            //Selecciona esteticista
            $consultaEsteticista = mysqli_query($conexion,"SELECT * FROM t_esteticistas WHERE id_cat = '$idCat'");
            $resultadoEsteticista = mysqli_fetch_array($consultaEsteticista);
            $esteticistaId = $resultadoEsteticista['id_estet'];
            $esteticistaNom = $resultadoEsteticista['nombre'] . " " . $resultadoEsteticista['apellidos'];
            

            //Selecciona citas de esteticista
            $consultaCitasxE = mysqli_query($conexion,"SELECT * FROM t_citas WHERE anio ='$anio' AND mes ='$mes' AND dia='$d' AND id_cat ='$idCat' AND id_esteticista='$esteticistaId'");
            while($resultadoCitasxE = mysqli_fetch_array($consultaCitasxE)){
                $hinicio = $resultadoCitasxE['hora'];
                $hfin = $resultadoCitasxE['horafin'];

                if ($h == $hinicio) {
                    $e = "ocupado";
                }
                if ($h > $hinicio and $h < $hfin) {
                    $e = "ocupado";
                }
            }                       
            
            if ($e == "disponible") {
                echo "Dispo a las $h <br>";
            }

        //Fin ciclo horas
        } 

        
            

               

    //Fin foreach dias
    }


    /*### Validacion de datos ###*/


    //Recorre el arreglo dias
    /*foreach ($semana as $diasem) {
        $d = $diasem['dia'];
        echo "<div class='h5 alert-warning font-weight-bold text-center'> $d de $nombreMes </div>";

        //Consulta duracion del servicio escogido
        $duracionServicio = $arrayTablaServ ['id_duracion'];
        
        //Consulta horas del dia
        $consultaHorasDia = mysqli_query($conexion,"SELECT * FROM t_horas_dia");        
        
        //Condicionales para presentar la disponibilidad        
        while ($arregloHorasDia = mysqli_fetch_array($consultaHorasDia)) {
            $hora = $arregloHorasDia['nombre'];
            //Consulta numero de citas programadas por fecha y hora
            $contarCitas = mysqli_query($conexion,"SELECT COUNT(id_cita) AS numCitas FROM t_citas WHERE anio ='$anio' AND mes ='$mes' AND dia='$d' AND hora ='$hora' AND id_cat ='$idCat'");
            $resultado = mysqli_fetch_assoc($contarCitas);  
            $duracionCita = mysqli_fetch_array(mysqli_query($conexion,"SELECT * FROM t_citas WHERE anio ='$anio' AND mes ='$mes' AND dia='$d' AND hora ='$hora' AND id_cat ='$idCat'"));
         
            if ($duracionServicio < 2) {
                if ($resultado['numCitas'] < $numEsteticistas['cantidad']) {
                    echo "<a href='confirmacion.php?cat=$idCat&serv=$nombreServ&hora=$hora&dia=$d&mes=$nombreMes' type='button' class='btn btn-primary shadow p-3 mb-5 mr-3 rounded' style='height: 75px;width:75px;'><span class='text-center align-middle'>dispo: $hora</span></a>";
                }
            }
        //Fin while    
        }
    //Fin foreach    
    }*/
    
    //Consulta numero de dias que tiene el mes actual
    $idDiasxMes = date("Ym");
    $consultaDiasxMes = mysqli_query($conexion,"SELECT * FROM t_diasxmes WHERE id_diasxmes ='$idDiasxMes'");
    $arregloDiasxMes = mysqli_fetch_array($consultaDiasxMes);
    //echo "Este mes es de: " . $arregloDiasxMes['num_diasxmes'] . " dias. <br>";

    //Calcula cuantos dias faltan para terminar el mes
    $lequedanAlMes = $arregloDiasxMes['num_diasxmes'] - date("d");
    //echo "Faltan $lequedanAlMes dias para terminar el mes.<br>";

    
}

function citasUsuario(){
    require_once'conexion.php';
    $usuario = $_SESSION['username'];
    $consultaIdServicio = mysqli_query($conexion,"SELECT * FROM t_citas WHERE email_cliente='$usuario'");
    $resultadoIdServicio = mysqli_fetch_array($consultaIdServicio);
    $idServicio = $resultadoIdServicio['id_serv'];
    

    $consultaNombreServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE id_serv='$idServicio'");
    $resultadoNombreServ = mysqli_fetch_array($consultaNombreServ);
    $nomServicio = $resultadoNombreServ['nombre'];
    

}