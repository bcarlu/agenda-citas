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

function contarEsteticistas(){
    require_once'conexion.php';
    
    //Se consulta la tabla de servicios y se buscan los registros que coincidan con el nombre recibido
    $nombreServ = $_GET['serv'];
    $queryTablaServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$nombreServ'");
    $arrayTablaServ = mysqli_fetch_array($queryTablaServ);

    /*Se almacena el id de categoria, se busca y se cuenta el numero de empleadas 
    en la tabla esteticistas para esa categoria*/
    $idCat = $arrayTablaServ ['id_cat'];
    $queryTablaEstet = mysqli_query($conexion,"SELECT COUNT(id_estet) AS cantidad FROM t_esteticistas WHERE id_cat = '$idCat'");
    $numEsteticistas = mysqli_fetch_assoc($queryTablaEstet);
    
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
    
    $semana = array (
        array ("dia" => date("d")),
        array ("dia" => date("d")+1),
        array ("dia" => date("d")+2),
    );

    foreach ($semana as $diasem) {
        $d = $diasem['dia'];
        echo "$d-$mes <br>";
        //Consulta horas del dia
        $consultaHorasDia = mysqli_query($conexion,"SELECT * FROM t_horas_dia");
        while ($arregloHorasDia = mysqli_fetch_array($consultaHorasDia)) {
            $hora = $arregloHorasDia['nombre'];
            //Consulta numero de citas programadas por fecha y hora
            $consultaCitas = mysqli_query($conexion,"SELECT COUNT(id_cita) AS numCitas FROM t_citas WHERE anio ='$anio' AND mes ='$mes' AND dia='$d' AND hora ='$hora' AND id_cat ='$idCat'");
            $resultado = mysqli_fetch_assoc($consultaCitas);
            if ($numEsteticistas['cantidad'] > $resultado['numCitas']) {
                echo "$hora <br>";
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
    echo "Faltan $lequedanAlMes dias para terminar el mes.";

    
}