<?php



/*####FUNCION LISTA SERVICIOS####*/

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
        echo '<div class="col py-2"><a href="agenda.php?serv=' . $arrayTablaServ['nombre'] . '"><img src="img/circle3498db.png" width="75" height="75" alt="..." class="rounded"><br>'
        . $arrayTablaServ['nombre'] . "<br> $" . $arrayTablaServ['precio'] .'</a></div>';
    }

}




/*####FUNCION LISTA ESTETICISTAS####*/

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



/*####INICIO FUNCION AGENDA ADISPONIBLE####*/

function agendaDisponible(){
    require_once'conexion.php';
    
    
    //Selecciona la categoria y duracion del servicio escogido
    $nombreServ = $_GET['serv'];
    $queryTablaServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$nombreServ'");
    $arrayTablaServ = mysqli_fetch_array($queryTablaServ);    
    $idCat = $arrayTablaServ ['id_cat'];
    $duracionSerEsco = $arrayTablaServ ['id_duracion'];


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
    
    //HTML
    //Abro Container para los estilos
    echo "<div class='container'>";

    //Recorre arreglo y selecciona dias
    foreach ($semana as $sem) {
        $d = $sem['dia'];        

        echo "<div class='h3 font-weight-bold text-warning mt-5'> $d de $nombreMes </div>";
        
        //Selecciona esteticista
        $consultaEsteticista = mysqli_query($conexion,"SELECT * FROM t_esteticistas WHERE id_cat = '$idCat'");
        while($resultadoEsteticista = mysqli_fetch_array($consultaEsteticista)){
            $esteticistaId = $resultadoEsteticista['id_estet'];
            $esteticistaNom = $resultadoEsteticista['nombre'] . " " . $resultadoEsteticista['apellidos'];
            echo "<div class='font-weight-bold pt-3'> $esteticistaNom </div><br>";
            
            //Genera horas dia
            $arregloHoras = array(
                array("hora" => 7, "estado" => "disponible", "ampm" => "7 AM", "finampm1" => "8 AM", "finampm2" => "9 AM"),
                array("hora" => 8, "estado" => "disponible", "ampm" => "8 AM", "finampm1" => "9 AM", "finampm2" => "10 AM"),
                array("hora" => 9, "estado" => "disponible", "ampm" => "9 AM", "finampm1" => "10 AM", "finampm2" => "11 AM"),
                array("hora" => 10, "estado" => "disponible", "ampm" => "10 AM", "finampm1" => "11 AM", "finampm2" => "12 PM"),
                array("hora" => 11, "estado" => "disponible", "ampm" => "11 AM", "finampm1" => "12 PM", "finampm2" => "1 PM"),
                array("hora" => 12, "estado" => "disponible", "ampm" => "12 PM", "finampm1" => "1 PM", "finampm2" => "2 PM"),
                array("hora" => 13, "estado" => "disponible", "ampm" => "1 PM", "finampm1" => "2 PM", "finampm2" => "3 PM"),
                array("hora" => 14, "estado" => "disponible", "ampm" => "2 PM", "finampm1" => "3 PM", "finampm2" => "4 PM"),
                array("hora" => 15, "estado" => "disponible", "ampm" => "3 PM", "finampm1" => "4 PM", "finampm2" => "5 PM"),
                array("hora" => 16, "estado" => "disponible", "ampm" => "4 PM", "finampm1" => "5 PM", "finampm2" => "6 PM"),
                array("hora" => 17, "estado" => "disponible", "ampm" => "5 PM", "finampm1" => "6 PM"),
                array("hora" => 18, "estado" => "disponible", "ampm" => "6 PM"),
            );

            //Ciclo horas
            foreach ($arregloHoras as $horaDia) {
                $h = $horaDia['hora'];
                $e = $horaDia['estado'];
                $ampm = $horaDia['ampm'];
                $citaFin1 = $horaDia['finampm1'];
                $citaFin2 = $horaDia['finampm2'];

                //Selecciona citas de esteticista
                $consultaCitasxE = mysqli_query($conexion,"SELECT * FROM t_citas WHERE anio ='$anio' AND mes ='$mes' AND dia='$d' AND id_cat ='$idCat' AND id_esteticista='$esteticistaId'");
                while($resultadoCitasxE = mysqli_fetch_array($consultaCitasxE)){
                    $hinicio = $resultadoCitasxE['hora'];
                    $hfin = $resultadoCitasxE['horafin'];                    

                    //Define estado ocupado
                    //General
                    if ($h == $hinicio) {
                        $e = "ocupado";
                    }                    
                    if ($h > $hinicio and $h < $hfin) {
                        $e = "ocupado";
                    }                    
                    
                    //Para citas de 2 hora
                    if ($duracionSerEsco == 2) {                        
                        if ($h+1 == $hinicio) {
                            $e = "ocupado";
                        }                    
                    }                    
                //Fin while citas de esteticista
                }

                //Para citas de 1 hora
                if ($duracionSerEsco == 1) {
                    if ($h == 18) {
                        $e = "ocupado";
                    }
                }

                //Para citas de 2 hora
                if ($duracionSerEsco == 2) {                        
                    if ($h == 17) {
                        $e = "ocupado";
                    }
                    if ($h == 18) {
                        $e = "ocupado";
                    }                    
                }
                
                //Muestra horas disponibles
                if ($e == "disponible" && $duracionSerEsco == 1) {
                    echo "<a href='confirmacion.php?cat=$idCat&serv=$nombreServ&est=$esteticistaId&hora=$h&dia=$d&mes=$mes' type='button' class='btn btn-info rounded btn-sm mr-1 mb-1'>$ampm - $citaFin1</a>";
                }
                if ($e == "disponible" && $duracionSerEsco == 2) {
                    echo "<a href='confirmacion.php?cat=$idCat&serv=$nombreServ&est=$esteticistaId&hora=$h&dia=$d&mes=$mes' type='button' class='btn btn-info rounded btn-sm mr-1 mb-1'>$ampm - $citaFin2</a>";
                }

            //Fin foreach horas
            } 
        
        //Fin while esteticistas
        }               

    //Fin foreach dias
    }
    
    
    //Consulta # dias del mes
    $idDiasxMes = date("Ym");
    $consultaDiasxMes = mysqli_query($conexion,"SELECT * FROM t_diasxmes WHERE id_diasxmes ='$idDiasxMes'");
    $arregloDiasxMes = mysqli_fetch_array($consultaDiasxMes);
    //echo "Este mes es de: " . $arregloDiasxMes['num_diasxmes'] . " dias. <br>";

    //Calcula dias para fin mes
    $lequedanAlMes = $arregloDiasxMes['num_diasxmes'] - date("d");
    //echo "Faltan $lequedanAlMes dias para terminar el mes.<br>";

    //HTML
    //Cierro container para los estilos
    echo "</div>";
    
}



/*####FUNCION CITAS USUARIO#########*/

function citasxCliente(){
    require_once'conexion.php';  
    $usuario = $_SESSION['username'];

    //Genera horas dia
    $arregloHoras = array(
        array("hora" => 7, "ampm" => "7:00 AM"),
        array("hora" => 8, "ampm" => "8:00 AM"),
        array("hora" => 9, "ampm" => "9:00 AM"),
        array("hora" => 10, "ampm" => "10:00 AM"),
        array("hora" => 11, "ampm" => "11:00 AM"),
        array("hora" => 12, "ampm" => "12:00 PM"),
        array("hora" => 13, "ampm" => "1:00 PM"),
        array("hora" => 14, "ampm" => "2:00 PM"),
        array("hora" => 15, "ampm" => "3:00 PM"),
        array("hora" => 16, "ampm" => "4:00 PM"),
        array("hora" => 17, "ampm" => "5:00 PM"),
        array("hora" => 18, "ampm" => "6:00 PM"),
    );

    //While citas cliente
    $consultaCitasxCliente = mysqli_query($conexion,"SELECT * FROM t_citas WHERE email_cliente='$usuario'");

    //Si no tiene citas programadas
    if (mysqli_num_rows($consultaCitasxCliente) == 0) {
        echo "Aun no tienes citas programadas!!";
    }

    //Si tiene citas programadas   
    while ($resultadoCitasxCliente = mysqli_fetch_array($consultaCitasxCliente)){

        $idServicio = $resultadoCitasxCliente['id_serv'];
        $fechaServicio = $resultadoCitasxCliente['dia']."-".$resultadoCitasxCliente['mes']."-".$resultadoCitasxCliente['anio'];
        $esteticista = $resultadoCitasxCliente['id_esteticista'];
        $horaServicio = $resultadoCitasxCliente['hora'];
        foreach ($arregloHoras as $ah) {
            if ($horaServicio == $ah['hora']) {
                $hCita = $ah['ampm'];
            }
        }    
            
        //Valida nombre y precio del servicio
        $consultaNombreServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE id_serv='$idServicio'");
        $resultadoNombreServ = mysqli_fetch_array($consultaNombreServ);
        $nomServicio = $resultadoNombreServ['nombre'];
        $precioServicio = $resultadoNombreServ['precio'];

        //Valida esteticista
        $esteticistaServ = mysqli_query($conexion,"SELECT * FROM t_esteticistas WHERE id_estet='$esteticista'");
        $resultadoEsteticistaServ = mysqli_fetch_array($esteticistaServ);
        $nomEsteticista = $resultadoEsteticistaServ['nombre']." ".$resultadoEsteticistaServ['apellidos'];

        //Muestra citas en pantalla
        echo "<div class='bg-light mb-3 p-2'>$nomServicio $fechaServicio $hCita $precioServicio $nomEsteticista </div>";

    //Fin while citas cliente    
    }
}




/*####DURACION SERVICIO ESCOGIDO############*/

function duracionServicioEscogido(){
    require_once'conexion.php';

    //Selecciona duracion del servicio escogido
    $nombreServ = $_GET['serv'];
    $queryTablaServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$nombreServ'");
    $arrayTablaServ = mysqli_fetch_array($queryTablaServ);    
    $duracionSerEsco = $arrayTablaServ ['id_duracion'];
    
    echo "<span>Agenda para <b>{$_GET['serv']}</b></span><br>";
        
        if ($duracionSerEsco == 1) {
           echo "<span>$duracionSerEsco hora</span>";
        }
        elseif ($duracionSerEsco > 1) {
            echo "<span>$duracionSerEsco horas</span>";
        }
}



/*#### NOMBRE CLIENTE ############*/

function nombreCliente($usuario){
    require_once'conexion.php';

    $consultaNombreCliente = mysqli_query($conexion,"SELECT * FROM t_clientes WHERE email = '$usuario'");
    $resultadoNomCli = mysqli_fetch_array($consultaNombreCliente);
    $nombreCliente = $resultadoNomCli['nombre'] . " " . $resultadoNomCli['apellidos'];
    return $nombreCliente;
}



/*#### PANEL CITAS ############*/

function panelCitas(){
    require_once'conexion.php';

    //mes actual
    $mes = date('m');

    //Array semana
    $semana = array (
        array ("dia" => date("d")),
        array ("dia" => date("d")+1),
        array ("dia" => date("d")+2),
        array ("dia" => date("d")+3),
        array ("dia" => date("d")+4),
    );
    
    //foreach dias
    foreach ($semana as $dia) {
        $d = $dia['dia'];

        //Muestra dia y mes
        //setlocale(LC_TIME,'esp_esp'); //Para un servidor web sobre Windows
        setlocale(LC_TIME, 'es_CO.utf8'); // Para un servidor web sobre Linux

        echo "<h4 class='btn btn-warning mt-3'>". strftime("%a %e de %b de %Y", strtotime("$d-$mes-2020")) . "</h4>";


        //Selecciona esteticista
        $consultaEst = "SELECT * FROM t_esteticistas";
        $resultadoEst = $conn->query($consultaEst);
        
        //While Esteticista
        while ($rowEst = $resultadoEst->fetch_assoc()) {
            
            //Nombre esteticista
            $idEst = $rowEst['id_estet'];            

            //Inicio tabla citas
             echo '<table class="table table-bordered">
                  <thead>
                    <tr class="table-primary">
                        <th colspan="4">'.$rowEst['nombre']." ".$rowEst['apellidos'].'</th>
                    </tr>
                    <tr>
                      <th scope="col">Hora</th>
                      <th scope="col">Servicio</th>
                      <th scope="col">Cliente</th>
                      <th scope="col">Celular</th>
                    </tr>
                  </thead>';

            //Selecciona cita
            $consultaCita = "SELECT * FROM t_citas WHERE mes='$mes' AND dia='$d' AND id_esteticista='$idEst'";
            $resultadoCita = $conn->query($consultaCita);
            

            //While cita
            while ($rowCita = $resultadoCita->fetch_assoc()) {
                //Cliente
                $idC = $rowCita['email_cliente'];
                $consultaC = $conn->query("SELECT * FROM t_clientes WHERE email='$idC'");
                $resultadoC = $consultaC->fetch_assoc();
                $nomC = $resultadoC['nombre']. " " .$resultadoC['apellidos'];
                $telC = $resultadoC['celular'];

                //Servicio
                $idSer = $rowCita['id_serv'];
                $consultaSer = $conn->query("SELECT * FROM t_servicios WHERE id_serv='$idSer'");
                $resultadoSer = $consultaSer->fetch_assoc();
                $nomSer = $resultadoSer['nombre'];

               
                echo "<tbody>
                        <tr>
                          <th scope='row'>".$rowCita['hora']."</th>
                          <td>" . $nomSer . "</td>
                          <td>" . $nomC . "</td>
                          <td>" . $telC . "</td>
                        </tr>
                     </tbody>";

            //Fin while cita
            }

            //Fin tabla
            echo '</table>';

        //Fin while Esteticista    
        }
    
    //fin foreach dias    
    }

//Fin funcion panelCitas    
}