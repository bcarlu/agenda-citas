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
    $resultado = mysqli_fetch_assoc($queryTablaEstet);

    echo $resultado['cantidad'];
}

function agendaDisponible(){
    require_once'conexion.php';
    

    $nombreServ = $_GET['serv'];
    $queryTablaServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$nombreServ'");
    $arrayTablaServ = mysqli_fetch_array($queryTablaServ);

    //Se almacena el id de categoria y se busca en la tabla esteticistas los que coincidan con id cat
    $idCat = $arrayTablaServ ['id_cat'];



    $anio = date("Y");
    $mes = date("m");
    $dia = date("d");
    
    //Consulta horas del dia
    $consultaHorasDia = mysqli_query($conexion,"SELECT * FROM t_horas_dia");


    while ($arregloHorasDia = mysqli_fetch_array($consultaHorasDia)) {
        $hora = $arregloHorasDia['nombre'];
        //Consulta numero de citas programadas por fecha y hora
        $consultaCitas = mysqli_query($conexion,"SELECT COUNT(id_cita) AS numCitas FROM t_citas WHERE anio ='$anio' AND mes ='$mes' AND dia='$dia' AND hora ='$hora' AND id_cat ='$idCat'");
        $resultado = mysqli_fetch_assoc($consultaCitas);
        echo "Citas para $dia de $mes a las $hora : " . (string) $resultado['numCitas'] . "<br>";
    }

    
    //Consulta numero de dias que tiene el mes actual
    $idDiasxMes = date("Ym");
    $consultaDiasxMes = mysqli_query($conexion,"SELECT * FROM t_diasxmes WHERE id_diasxmes ='$idDiasxMes'");
    $arregloDiasxMes = mysqli_fetch_array($consultaDiasxMes);
    echo "Dias de este mes: " . $arregloDiasxMes['num_diasxmes'] . "<br>";

    //Contar cuantos dias faltan para terminar el mes
    $lequedanAlMes = $arregloDiasxMes['num_diasxmes'] - $dia;
    echo "A este mes le quedan $lequedanAlMes dias.";

    
}