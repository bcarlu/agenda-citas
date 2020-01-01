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
        echo ' <a href="agenda.php?serv=' . $arrayTablaServ['nombre'] . '"><img src="img/circle3498db.png" width="75" height="75" alt="..." class="rounded-circle">'
        . $arrayTablaServ['nombre'] . "<br>" . '</a>';
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
    
    /*********** CANTIDAD ESTETICISTAS ***************/
    //Se consulta la tabla de servicios y se buscan los registros que coincidan con el nombre recibido
    $nombreServ = $_GET['serv'];
    $queryTablaServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$nombreServ'");
    $arrayTablaServ = mysqli_fetch_array($queryTablaServ);

    /*Se almacena el id de categoria, se busca y se cuenta el numero de empleadas 
    en la tabla esteticistas para esa categoria*/
    $idCat = $arrayTablaServ ['id_cat'];
    $queryTablaEstet = mysqli_query($conexion,"SELECT COUNT(id_estet) AS cantidad FROM t_esteticistas WHERE id_cat = '$idCat'");
    $numEsteticistas = mysqli_fetch_assoc($queryTablaEstet);

    /*********** CITAS AGENDADAS ***************/
    $anio = date("Y");
    $mes = date("m");
    $buscarnMes = mysqli_fetch_array(mysqli_query($conexion,"SELECT * FROM t_meses WHERE id_mes = '$mes'"));
    $nombreMes = $buscarnMes['nombre'];
        
    $semana = array (
        array ("dia" => date("d")),
        array ("dia" => date("d")+1),
        array ("dia" => date("d")+2),
        array ("dia" => date("d")+3),
        array ("dia" => date("d")+4),
    );

    

    /*********** VALIDACION DE DATOS Y CONDICIONALES PARA CALCULAR DISPONIBILIDAD ***************/
    
    //Validar los dias de la semana
    foreach ($semana as $diasem) {
        $d = $diasem['dia'];
        echo "<div class='h5 alert-warning font-weight-bold text-center'> $d de $nombreMes </div>";

        
        
        //Consulta horas del dia
        $consultaHorasDia = mysqli_query($conexion,"SELECT * FROM t_horas_dia");

        //Consulta duracion del servicio escogido
        $duracionServicio = $arrayTablaServ ['id_duracion'];


        //Condicionales para presentar la disponibilidad        
        while ($arregloHorasDia = mysqli_fetch_array($consultaHorasDia)) {
            $hora = $arregloHorasDia['nombre'];
            //Consulta numero de citas programadas por fecha y hora
            $contarCitas = mysqli_query($conexion,"SELECT COUNT(id_cita) AS numCitas FROM t_citas WHERE anio ='$anio' AND mes ='$mes' AND dia='$d' AND hora ='$hora' AND id_cat ='$idCat'");
            $resultado = mysqli_fetch_assoc($contarCitas);  
            $duracionCita = mysqli_fetch_array(mysqli_query($conexion,"SELECT * FROM t_citas WHERE anio ='$anio' AND mes ='$mes' AND dia='$d' AND hora ='$hora' AND id_cat ='$idCat'"));
            

            /*if ($resultado['numCitas'] >= 1) {
                echo "La cita comienza a las $hora y termina a las " . ($duracionCita['hora']+$duracionCita['duracion']) . "<br>";
            }else{
                echo $hora . "<br>";
            }*/

            if ($duracionServicio < 2) {
                if ($resultado['numCitas'] < $numEsteticistas['cantidad']) {
                    echo "<a href='confirmacion.php?cat=$idCat&serv=$nombreServ&hora=$hora&dia=$d&mes=$nombreMes' type='button' class='btn btn-primary shadow p-3 mb-5 rounded-circle' style='height: 75px;width:75px;'><span class='text-center align-middle'>$hora</span></a>";
                }
            }
        }
        
    }
    

    
    //Consulta numero de dias que tiene el mes actual
    $idDiasxMes = date("Ym");
    $consultaDiasxMes = mysqli_query($conexion,"SELECT * FROM t_diasxmes WHERE id_diasxmes ='$idDiasxMes'");
    $arregloDiasxMes = mysqli_fetch_array($consultaDiasxMes);
    echo "Este mes es de: " . $arregloDiasxMes['num_diasxmes'] . " dias. <br>";

    //Calcula cuantos dias faltan para terminar el mes
    $lequedanAlMes = $arregloDiasxMes['num_diasxmes'] - date("d");
    echo "Faltan $lequedanAlMes dias para terminar el mes.<br>";

    for ($i=date("d"); $i <= $arregloDiasxMes['num_diasxmes']; $i++) { 
        echo "Ciclo 1 - $i <br>";
    }
    if ($i > $arregloDiasxMes['num_diasxmes']) {
        for ($i=1; $i<=5; $i++) { 
            echo "Ciclo 2 - $i <br>";
        }
    }
}