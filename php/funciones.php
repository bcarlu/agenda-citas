<?php



/*####FUNCION LISTA SERVICIOS####*/

function listaServiciosPG(){

    $idCat = isset($_GET['cat_id']) && !empty($_GET['cat_id']) ? (int)$_GET['cat_id'] : null;

    if ($idCat === null) {
        echo "Categoría no especificada.";
        return;
    }

    try {
        // Conectar a la base de datos
        include 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();
        
        // Obtener el id de la cuenta del cliente
        $cuenta = $_SESSION['id_cuenta'];
        
        // Obtener servicios de la categoría especificada
        $stmt = $pdo->prepare("SELECT * FROM t_servicios WHERE id_cat = :id_cat AND id_cuenta=:id_cuenta");
        $stmt->bindValue("id_cat", $idCat, PDO::PARAM_INT);
        $stmt->bindValue("id_cuenta", $cuenta, PDO::PARAM_INT);
        $stmt->execute();
        $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Validar si se encontraron servicios
        if (!$servicios) {
            echo "No se encontraron servicios para la categoría especificada.";
            return;
        }
    
        //Se listan los servicios de la categoria
        foreach ($servicios as $servicio) {
            echo '<a class="text-decoration-none text-dark" href="agenda.php?cat_id='.$servicio["id_cat"].'&serv='.$servicio["nombre"].'&serv_id='.$servicio["id"]. '&serv_duracion='.$servicio["duracion"].'">
                  <div class="row cat-unas mb-2 py-2 d-flex align-items-center justify-content-between">
                      
                  <div class="col">
                      <img src="img/cat-unas.png" alt="" class="img-fluid" height="70" width="70">
                  </div>
                  
                  <div class="col text-center">
                  <p class="h2 text-decoration-none">'.$servicio["nombre"].'</p>
                  </div>

                  
                  <div class="col text-right">
                      <i class="fas fa-angle-right fa-lg"></i>
                  </div> 
                  </div>
              </a>';
        } 
    } catch (\Throwable $th) {
        error_log("Error al obtener servicios: " . $th->getMessage());
        echo "Error interno del servidor: ";
    }
}

/*####INICIO FUNCION AGENDA ADISPONIBLE####*/

function agendaDisponiblePG(){

    // Definir id del servicio
    $idServicio = isset($_GET['serv_id']) && !empty($_GET['serv_id']) ? (int)$_GET['serv_id'] : null;

    // Se valida que el id del servicio no sea nulo
    if ($idServicio === null) {
        echo "Servicio no especificado.";
        return;
    }

    try {
        // Conectar a la base de datos
        include 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();

        // Obtener el id de la cuenta del cliente
        $cuenta = $_SESSION['id_cuenta'];

        // Obtener detalles del servicio
        $stmtServ = $pdo->prepare("SELECT * FROM t_servicios WHERE id = :id_servicio AND id_cuenta=:id_cuenta");
        $stmtServ->bindValue("id_servicio", $idServicio, PDO::PARAM_INT);
        $stmtServ->bindValue("id_cuenta", $cuenta, PDO::PARAM_INT);
        $stmtServ->execute();
        $servicio = $stmtServ->fetch(PDO::FETCH_ASSOC);

        // Validar si se encontraron servicios
        if (!$servicio) {
            echo "No se encontraron servicios para la categoría especificada.";
            return;
        }

        // Definir categoria y duracion del servicio
        $idCategoria = (int)$servicio["id_cat"];
        $duracionServicio = $servicio["duracion"]; // Duracion en horas
        $nombreServicio = $servicio["nombre"];        

        // Obtener esteticistas que atienden la categoria
        $stmtEstet = $pdo->prepare("SELECT id, nombre, id_cat FROM t_esteticistas WHERE id_cat = :id_categoria AND id_cuenta=:id_cuenta");
        $stmtEstet->bindValue("id_categoria", $idCategoria, PDO::PARAM_INT);
        $stmtEstet->bindValue("id_cuenta", $cuenta, PDO::PARAM_INT);
        $stmtEstet->execute();
        $esteticistas = $stmtEstet->fetchAll(PDO::FETCH_ASSOC);

        //Cantidad de dias a partir de hoy en los que se buscara disponibilidad
        $semana = array (
            array ("dia" => 0),
            array ("dia" => 1),
        );

    
        //HTML
        //Abro Container para los estilos
        echo "<div class='container'>";

        //Recorre arreglo dias
        foreach ($semana as $sem) {
            $numdia = $sem['dia'];

            //Se convierte el numero de dia para ser interpretado por strftime como fecha correctamente     
            $formatodia = mktime(0, 0, 0, date("m")  , date("d")+$numdia, date("Y"));
            $diacal = strftime("%a %d %b",$formatodia); // TODO: Cambiar todos los strftime a date para evitar problemas de compatibilidad.

            // Definir año y mes del dia 
            $anio = (int)date("Y", $formatodia); 
            $mes = (int)date("m", $formatodia);

            //Se recoge el dia de la fecha para enviarlo por get a la pag de confirmacion
            $d = (int)date("d", $formatodia);

            //Se imprime los dias del arreglo iniciando desde hoy
            echo "<div class='h3 font-weight-bold text-warning mt-5'> $diacal </div>";
                        
            //Mientras hallan esteticistas
            foreach($esteticistas as $esteticista){
                $esteticistaId = $esteticista['id'];
                $esteticistaNom = $esteticista['nombre'];

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
                    array("hora" => 17, "estado" => "disponible", "ampm" => "5 PM", "finampm1" => "6 PM", "finampm2" => ""),
                );

                //Recorre arreglo horas
                foreach ($arregloHoras as $horaDia) {
                    $h = $horaDia['hora'];
                    $e = $horaDia['estado'];                
                    $ampm = $horaDia['ampm'];
                    $citaFin1 = $horaDia['finampm1'];
                    $citaFin2 = $horaDia['finampm2'];

                    //Obtener citas de la esteticista
                    $stmtCitas = $pdo->prepare("SELECT hora, horafin FROM t_citas WHERE anio =:anio AND mes =:mes AND dia=:d AND id_cat =:id_categoria AND id_esteticista=:id_esteticista");
                    $stmtCitas->bindValue("anio", (int)$anio, PDO::PARAM_INT);
                    $stmtCitas->bindValue("mes", $mes, PDO::PARAM_INT);
                    $stmtCitas->bindValue("d", $d, PDO::PARAM_INT);
                    $stmtCitas->bindValue("id_categoria", $idCategoria, PDO::PARAM_INT);
                    $stmtCitas->bindValue("id_esteticista", $esteticistaId, PDO::PARAM_INT);
                    $stmtCitas->execute();
                    $citas = $stmtCitas->fetchAll(PDO::FETCH_ASSOC);

                    //Foreach citas de esteticista
                    foreach($citas as $cita){                    
                        $hinicio = $cita['hora'];
                        $hfin = $cita['horafin'];                    

                        //Define estado ocupado
                        //General
                        if ($h == $hinicio) {
                            $e = "ocupado";
                        }                    
                        if ($h > $hinicio and $h < $hfin) {
                            $e = "ocupado";
                        }                    
                        
                        //Para citas de 2 hora
                        if ($duracionServicio == 2) {                        
                            if ($h+1 == $hinicio) {
                                $e = "ocupado";
                            }                    
                        }                    
                    //Fin foreach citas de esteticista
                    }

                    //Para citas de 1 hora
                    if ($duracionServicio == 1) {
                        if ($h == 18) {
                            $e = "ocupado";
                        }
                    }

                    //Para citas de 2 hora
                    if ($duracionServicio == 2) {                        
                        if ($h == 17) {
                            $e = "ocupado";
                        }                    
                    }
                    
                    //Muestra horas disponibles
                    if ($e == "disponible" && $duracionServicio == 1) {
                        echo "<a href='confirmacion.php?cat=$idCategoria&id_serv=$idServicio&serv=$nombreServicio&est=$esteticistaId&nomEst=$esteticistaNom&hora=$h&dia=$d&mes=$mes&anio=$anio&duracion=$duracionServicio' type='button' class='btn btn-info rounded btn-sm mr-1 mb-1'>$ampm - $citaFin1</a>";
                    }
                    if ($e == "disponible" && $duracionServicio == 2) {
                        echo "<a href='confirmacion.php?cat=$idCategoria&id_serv=$idServicio&serv=$nombreServicio&est=$esteticistaId&nomEst=$esteticistaNom&hora=$h&dia=$d&mes=$mes&anio=$anio&duracion=$duracionServicio' type='button' class='btn btn-info rounded btn-sm mr-1 mb-1'>$ampm - $citaFin2</a>";
                    }

                //Fin foreach horas
                }
            //Fin while esteticistas
            }
        //Fin foreach dias
        }
        //HTML
        //Cierro container para los estilos
        echo "</div>";

    } catch (\Throwable $th) {
        error_log("Error al obtener servicio: " . $th->getMessage() . " en linea " . $th->getLine() . " en archivo " . $th->getFile());
        echo "Error interno del servidor.";
    }    
}

/*####FUNCION CITAS USUARIO#########*/

function citasxClientePG($idUsuario){  
    try {
        //Incluye y abre conexion
        include 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();
        // Definir usuario
        $usuario = $idUsuario ?? $_SESSION['id_usuario'];

        // Obtener fecha actual
        $a = (int)date("Y");
        $m = (int)date("m"); 
        $d = (int)date("d");

        //Consulta citas del cliente + datos de servicio y esteticista
        $sql = "SELECT c.dia, c.mes, c.anio, c.hora, c.horafin, 
                    e.nombre AS nombre_est, 
                    s.nombre AS nombre_serv, s.precio
                FROM t_citas c
                LEFT JOIN t_esteticistas e ON c.id_esteticista = e.id
                LEFT JOIN t_servicios s ON c.id_serv = s.id
                WHERE c.id_usuario = :usuario
                AND c.anio >= :a AND c.mes >= :m AND c.dia >= :d
                ORDER BY c.anio, c.mes, c.dia, c.hora;";
        $stmtCitasCliente = $pdo->prepare($sql);
        $stmtCitasCliente->bindValue("usuario", $usuario, PDO::PARAM_INT);
        $stmtCitasCliente->bindValue("a", $a, PDO::PARAM_STR);
        $stmtCitasCliente->bindValue("m", $m, PDO::PARAM_STR);
        $stmtCitasCliente->bindValue("d", $d, PDO::PARAM_STR);
        $stmtCitasCliente->execute();
        $citasCliente = $stmtCitasCliente->fetchAll(PDO::FETCH_ASSOC);
        
        //Si no tiene citas programadas
        if (!$citasCliente) {
            echo "Aun no tienes citas programadas!!";
        }

        // Crear formateador de fechas para español
        $formateadorFechaIdioma = new IntlDateFormatter(
            "es_CO",
            IntlDateFormatter::FULL, // Estilo para la fecha
            IntlDateFormatter::FULL, // Estilo para la hora
            'America/Bogota',        // Zona horaria de Colombia
            IntlDateFormatter::GREGORIAN,
            'E, d \'de\' MMM \'a las\' h:mm a ' // Patrón de formato personalizado Ej: lun, 1 de dic
        );

        // Formateador de precio
        $FormateadorPrecio = new NumberFormatter( 'es_CO', NumberFormatter::CURRENCY);
        $FormateadorPrecio->setPattern("$#,##0");

        //Si tiene citas programadas
        foreach ($citasCliente as $citas){            
            $fechaServicio = strtotime($citas['dia']."-".$citas['mes']."-".$citas['anio']." ".$citas['hora']." hours");
            $nomServicio = $citas['nombre_serv'];
            $precioServicio = (float)$citas['precio'];
            $nomEsteticista = $citas['nombre_est'];

            $fechaServicioFormateada = $formateadorFechaIdioma->format($fechaServicio);

            $precioFormateado = $FormateadorPrecio->formatCurrency($precioServicio, "COP");   

            //Muestra citas en pantalla  
            echo "<div class='mb-3 p-2 shadow-sm rounded bg-citas'>
                <b>$nomServicio</b><br>
                $fechaServicioFormateada <br>
                Con $nomEsteticista <br>
                $precioFormateado 
                </div>";   
        }
    } catch (\Throwable $th) {
        error_log("Error al obtener citas: " . $th->getMessage() . "en la linea: "  . $th->getLine() . "en el archivo: " . $th->getFile());
        echo "Error interno del servidor al obtener citas del cliente.";
    }
}

/*#### PANEL CITAS ############*/

/** Imprime tabla con las citas programadas
 * @return void Componente html con el listado de citas pendientes, o mensaje de error en caso de algun problema
 */
function listaCitas() {
    try {
        $citasDatos = obtenerCitas();
        
        if(count($citasDatos) > 0){            
            // Listado de citas            
            foreach ($citasDatos as $cita):
                $fecha_hora = date("d-M-Y gA", mktime($cita['hora'], 0, 0, $cita['mes'], $cita['dia'], $cita['anio']));
                $nombreServicio = $cita['nombre_serv'] ?? "-";
                $nombreCliente = $cita['nombre_cliente'] ?? "-";
                $celCliente = $cita['cel_cliente'] ?? "-";
                $nombreEsteticista = $cita['nombre_est'] ?? "-";
                echo "<tr>
                    <th scope='row'>". $fecha_hora ."</th>
                    <td>" . $nombreEsteticista . "</td>
                    <td>" . $nombreServicio . "</td>
                    <td>" . $nombreCliente . "</td>
                    <td>" . $celCliente . "</td>                        
                </tr>";
            endforeach;
        } else {
            echo "Por el momento no hay citas pendientes.";
        }
    } catch (\Throwable $th) {
        error_log("Error al obtener citas: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        echo "Error al obtener listado de citas.";
    }

}

/** Obtiene las citas programadas
 * @return array|false retorna array con el listado de citas pendientes, o false en caso de algun problema
 */
function obtenerCitas(): array|false {
    try {
        include_once 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();
        
        $citasDatos = []; // Para almacenar todas las citas encontradas.
        $cuenta = $_SESSION['id_cuenta'];
        $hoy = date("d");
        $cantidadDias = 2;


        // Consulta las citas programadas para n cantidad de dias.
        for ($i=0; $i < $cantidadDias; $i++) {
            $numdia = $hoy + $i;

            //Se establece el timestamp para obtener la fecha correcta y evitar errores cuando hay cambio de mes y de año.      
            $marcaDeTiempo = mktime(0, 0, 0, date("m"), $numdia, date("Y"));

            // Obtener año, mes y dia 
            $anio = (int)date("Y", $marcaDeTiempo); 
            $mes = (int)date("m", $marcaDeTiempo);
            $dia = (int)date("d", $marcaDeTiempo);

            $sql = "SELECT c.dia, c.mes, c.anio, c.hora, c.horafin, 
                e.nombre AS nombre_est, 
                s.nombre AS nombre_serv,
                u.nombre AS nombre_cliente,
                u.celular AS cel_cliente
            FROM t_citas c
            LEFT JOIN t_esteticistas e ON c.id_esteticista = e.id
            LEFT JOIN t_servicios s ON c.id_serv = s.id
            LEFT JOIN t_usuarios u ON c.id_usuario = u.id
            WHERE c.mes=:mes AND c.dia=:dia AND c.anio=:anio AND u.id_cuenta=:cuenta
            ORDER BY c.dia, c.mes, c.anio, c.hora;";
            $stmtCitas = $pdo->prepare($sql);
            $stmtCitas->bindValue("dia", $dia, PDO::PARAM_INT);
            $stmtCitas->bindValue("mes", $mes, PDO::PARAM_INT);
            $stmtCitas->bindValue("anio", $anio, PDO::PARAM_INT);
            $stmtCitas->bindValue("cuenta", $cuenta, PDO::PARAM_INT);
            $stmtCitas->execute();
            $citasCliente = $stmtCitas->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($citasCliente) > 0) {
                $citasDatos = array_merge($citasDatos, $citasCliente); // Se unen todas las citas de cada dia en un solo arreglo                
            }
        }
        return $citasDatos;
    } catch (\Throwable $th) {
        error_log("Error al obtener citas: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        return false;
    }
}

/*#### IMAGEN SERVICIO ############*/

function imagenServicio($categoria){

    //Se establece imagen segun categoria del servicio
    if ($categoria == 1) {
        $categoria = "img/card-nails.png";
        echo $categoria;
    }
    if ($categoria == 3) {
        $categoria =  "img/cera.jpg";
        echo $categoria;
    }
    if ($categoria == 2) {
        $categoria = "img/spa.jpg";
        echo $categoria;
    }
    
//Fin funcion imagenServicio
}

/** Lista las categorias de servicios
 * @return string Componente html con el listado de categorias, o mensaje de error en caso de algun problema
 */
function listaCategorias(){
    try {
        // Conectar a la base de datos
        include 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();      
        
        // Obtener el id de la cuenta del cliente
        $cuenta = $_SESSION['id_cuenta'];

        // Obtener todas las categorias que tengan al menos 1 servicio y 1 esteticista asociada
        $sql = "SELECT DISTINCT c.* 
        FROM t_categorias c 
        INNER JOIN t_servicios s ON s.id_cat = c.id
        INNER JOIN t_esteticistas e ON e.id_cat = c.id
        WHERE c.id_cuenta=:id_cuenta";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_cuenta', $cuenta, PDO::PARAM_INT);
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Validar si se encontraron categorias
        if (!$categorias) {
            echo "No se encontraron categorias.";
            return;
        }
    
        //Se listan las categorias
        foreach ($categorias as $categoria) {
            echo '<a class="text-decoration-none text-dark" href="servicios.php?cat='.$categoria["nombre"].'&cat_id='.$categoria["id"].'">
                <div class="row cat-unas mb-2 py-2 d-flex align-items-center justify-content-between">
                    <!--Imagen-->   
                    <div class="col">
                      <img src="img/cat-unas.png" alt="" class="img-fluid" height="70" width="70">
                    </div>
                    <!--Descripcion-->
                    <div class="col text-center">
                        <p class="h2 text-decoration-none">'.$categoria["nombre"].'</p>
                    </div>

                    <!--Icono-->
                    <div class="col text-right">
                        <i class="fas fa-angle-right fa-lg"></i>
                    </div> 
                </div>
            </a>';
        } 
    } catch (\Throwable $th) {
        error_log("Error al obtener categorias: " . $th->getMessage());
        echo "Error interno del servidor.";
    }
}

/** Crea usuario en la base de datos
 * @param $nombre
 * @param $apellidos (opcional)
 * @param $email Email del usuario
 * @param $celular (opcional)
 * @param $clavenc Password encriptado
 * @param $idRol Id del rol (Administrador, Cliente)
 * @param $idCuenta
 * @return int|array Id del usuario creado o false.
 */
function crearUsuario(string $nombre, ?string $apellidos, string $email, ?string $celular, string $clavenc, int $idRol, int $idCuenta): int|false {
    try {
        // Importar conexion a la db
        include_once'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();

        // Registrar nuevo usuario
        $stmt = $pdo->prepare('INSERT INTO t_usuarios (nombre,apellidos,email,celular,clave,id_rol,id_cuenta) VALUES (:nombre,:apellidos,:email,:celular,:clavenc,:id_rol,:id_cuenta)');
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':celular', $celular, PDO::PARAM_STR);
        $stmt->bindValue(':clavenc', $clavenc, PDO::PARAM_STR);
        $stmt->bindValue(':id_rol', $idRol, PDO::PARAM_INT);
        $stmt->bindValue(':id_cuenta', $idCuenta, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return (int)$pdo->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        error_log("Error al crear el usuario: " . $e->getMessage(), (int)$e->getCode());
        return false;
    }
}

/** Crea cuenta en la base de datos
 * @param $nombreEmpresa Nombre de la empresa
 * @param $nitEmpresa Nit o RUT de la empresa
 * @return int|array Id de la cuenta creada o false.
 */
function crearCuenta(?string $nombreEmpresa, ?string $nitEmpresa): int|false {
    try {
        // Importar conexion a la db
        include_once 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();

        // Crear uuid cuenta
        $filtro = "/\w/i"; // Busca solo letras (a-Z) y numeros (0-9)        
        $nomEmpArr = str_split($nombreEmpresa); // Convierte string en array
        $nitEmpArr = str_split($nitEmpresa);        
        $nomEmpLet = preg_grep($filtro, $nomEmpArr); // Obtiene solo letras o numeros
        $nitEmpLet = preg_grep($filtro, $nitEmpArr);        
        $nomEmpStr = join("",$nomEmpLet); // Convierte array en string
        $nitEmpStr = join("",$nitEmpLet);
        // Convierte a minusculas y obtiene las primeras 3 letras 
        $uuid = substr(strtolower($nomEmpStr),0,3) . "_". substr(strtolower($nitEmpStr),0,3);
        
        // Crear nueva cuenta
        $stmt = $pdo->prepare('INSERT INTO t_cuentas (nombre_empresa,nit_rut, uuid) VALUES (:nombre,:nit,:uuid)');
        $stmt->bindValue(':nombre', $nombreEmpresa, PDO::PARAM_STR);
        $stmt->bindValue(':nit', $nitEmpresa, PDO::PARAM_STR);
        $stmt->bindValue(':uuid', $uuid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return (int)$pdo->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        //error_log("Error al crear el cuenta: " . $e->getMessage(), (int)$e->getCode());
        error_log("Error al crear la cuenta: " . $e->getMessage() . "en la linea: "  . $e->getLine() . " en el archivo: " . $e->getFile());
        return false;
    }
}

function eliminarCuenta(int $idCuenta): bool {
    try {
        // Importar conexion a la db
        include_once 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();

        // Crear nueva cuenta
        $stmt = $pdo->prepare('DELETE FROM t_cuentas WHERE id = :id');
        $stmt->bindValue(':id', $idCuenta, PDO::PARAM_INT);        
        
        $cuentaEliminada = $stmt->execute();
        if ($cuentaEliminada) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        error_log("Error al eliminar la cuenta: " . $e->getMessage(), (int)$e->getCode());
        return false;
    }
}

/** Imprime tabla con los servicios creados
 * @return void Componente html con el listado de servicios creados
 */
function listaServiciosAdmin(): void {
    try {
        $serviciosDatos = obtenerServiciosAdmin();

        // Validar si se encontraron servicios
        if ($serviciosDatos > 0) {
            //Se listan los servicios de la categoria
            foreach ($serviciosDatos as $servicio) {
                echo "<tr>
                    <th scope='row'>". $servicio["id"] ."</th>
                    <td>" . $servicio["nombre"] . "</td>
                    <td>" . $servicio["nombre_cat"] . "</td>
                    <td>" . $servicio["precio"] . "</td>
                    <td>" . $servicio["duracion"] . '</td>
                    <td> 
                        <a type="button" class="btn btn-warning btn-sm" href="/paginas/admin/editar_servicio.php?id_serv='. urlencode($servicio["id"]) .'&nom_serv='. urlencode($servicio["nombre"]) .'&id_cat='. urlencode($servicio["id_cat"]) .'&nom_cat='. urlencode($servicio["nombre_cat"]) .'&precio='. urlencode($servicio["precio"]) .'&duracion='. urlencode($servicio["duracion"]) .'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        Editar
                        </a>
                        <!-- Boton modal eliminar servicio -->
                        <button type="button" class="btn btn-danger btn-sm btn-eliminar-servicio" data-toggle="modal" data-target="#modal-eliminar-servicio" data-idservicio="'. urlencode($servicio["id"]) .'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                        Eliminar
                        </button>
                    </td>                        
                </tr>';
            }
        }
    } catch (\Throwable $th) {
        error_log("Error al obtener servicios: " . $th->getMessage());
        echo "Error interno del servidor: ";
    }
}

/** Obtiene los servicios creados en la cuenta
 * @return array|false retorna array con el listado de servicios, o false en caso de algun problema
 */
function obtenerServiciosAdmin(): array|false {
    try {
        // Conectar a la base de datos
        include 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();      

        // Obtener el id de la cuenta del cliente
        $cuenta = $_SESSION['id_cuenta'];
        
        // Obtener servicios de la categoría especificada
        $stmt = $pdo->prepare("SELECT s.*,
        c.nombre AS nombre_cat
        FROM t_servicios s
        LEFT JOIN t_categorias c ON s.id_cat = c.id
        WHERE s.id_cuenta=:id_cuenta");
        $stmt->bindValue("id_cuenta", $cuenta, PDO::PARAM_INT);
        $stmt->execute();
        $servicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Validar si se encontraron servicios
        if (!$servicios) {
            return false;
        }
        return $servicios;
    } catch (\Throwable $th) {
        error_log("Error al obtener servicios: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        return false;
    }
}

/** Imprime tabla con las categorias creadas
 * @return void Componente html con el listado de categorias
 */
function listaCategoriasAdmin(): void {
    try {
        $categoriasDatos = obtenerCategorias();

        // Validar si se encontraron categorias
        if ($categoriasDatos > 0) {
            //Se listan los servicios de la categoria
            foreach ($categoriasDatos as $categoria) {
                echo "<tr>
                    <th scope='row'>". $categoria["id"] ."</th>
                    <td>" . $categoria["nombre"] . "</td>                       
                </tr>";
            }
        } else {
            echo "Aun no tienes categorias. Crea una.";
        }
    } catch (\Throwable $th) {
        error_log("Error al obtener categorias: " . $th->getMessage());
        echo "Error interno del servidor: ";
    }
}

/** Obtiene las categorias creadas en la cuenta
 * @return array|false retorna array con el listado de categorias, o false en caso de algun problema
 */
function obtenerCategorias(): array|false {
    try {
        // Conectar a la base de datos
        include_once 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();      
        
        // Obtener el id de la cuenta del cliente
        $cuenta = $_SESSION['id_cuenta'];

        // Obtener todas las categorias
        $stmt = $pdo->prepare("SELECT * FROM t_categorias WHERE id_cuenta=:id_cuenta");
        $stmt->bindValue(':id_cuenta', $cuenta, PDO::PARAM_INT);
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Validar si se encontraron categorias
        if (!$categorias) {            
            return false;
        }
        return $categorias;
    } catch (\Throwable $th) {
        error_log("Error al obtener categorias: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        return false;
    }
}

/** Obtiene las esteticistas creadas en la cuenta
 * @return array|false retorna array con el listado de esteticistas, o false en caso de algun problema
 */
function obtenerEsteticistas(): array|false {
    try {
        // Conectar a la base de datos
        include 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();      
        
        // Obtener el id de la cuenta del cliente
        $cuenta = $_SESSION['id_cuenta'];

        // Obtener todas las esteticistas
        $sql = "SELECT e.id, e.nombre,
                c.nombre AS nombre_cat            
        FROM t_esteticistas e
        LEFT JOIN t_categorias c ON e.id_cat = c.id
        WHERE e.id_cuenta=:id_cuenta";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_cuenta', $cuenta, PDO::PARAM_INT);
        $stmt->execute();
        $esteticistas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Validar si se encontraron categorias
        if (!$esteticistas) {            
            return false;
        }
        return $esteticistas;
    } catch (\Throwable $th) {
        error_log("Error al obtener categorias: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        return false;
    }
}

/** Imprime tabla con las categorias creadas
 * @return void Componente html con el listado de categorias
 */
function listaEsteticistasAdmin(): void {
    try {
        $esteticistasDatos = obtenerEsteticistas();

        // Validar si se encontraron categorias
        if ($esteticistasDatos > 0) {
            //Se listan los servicios de la categoria
            foreach ($esteticistasDatos as $esteticista) {
                echo "<tr>
                    <th scope='row'>". $esteticista["id"] ."</th>
                    <td>" . $esteticista["nombre"] . "</td> 
                    <td>" . $esteticista["nombre_cat"] . "</td>                      
                </tr>";
            }
        } else {
            echo "Aun no tienes esteticistas. Crea una.";
        }
    } catch (\Throwable $th) {
        error_log("Error al obtener categorias: " . $th->getMessage());
        echo "Error interno del servidor: ";
    }
}

/** Obtiene las horas disponibles en un rango de fechas para las esteticistas de la categoria del servicio solicitado y las imprime en componente HTML
 * @return void -> Imprime HTML con listado de esteticistas, fechas y horas disponibles, o mensaje de error en caso de algun problema
 */
function listaAgendaDisponible(){
    try {
        // Obtener id servicio solicitado, duracion y nombre
        $idServ = isset($_GET['serv_id']) && !empty($_GET['serv_id']) ? (int)$_GET['serv_id'] : null;
        $duracionServ = isset($_GET['serv_duracion']) && !empty($_GET['serv_duracion']) ? (int)$_GET['serv_duracion'] : null;
        $nombreServ = isset($_GET['serv']) && !empty($_GET['serv']) ? $_GET['serv'] : null;

        // Obtener id categoria
        $idCat = isset($_GET['cat_id']) && !empty($_GET['cat_id']) ? (int)$_GET['cat_id'] : null;

        // Validar que todos los datos necesarios se hayan recibido
        if ($idCat === null || $idServ === null || $duracionServ === null || $nombreServ === null) {
            echo "Categoría o id servicio o duracion o nombre servicio no especificada.";
            return;
        }

        // Obtener esteticistas de la categoria    
        $esteticistas = obtenerEsteticistasCategoria($idCat);

        // Validar si hay esteticistas en la categoria
        if (empty($esteticistas)) {
            echo "No hay esteticistas asignadas a la categoria del servicio solicitado.";
            exit;
        }

        // Establecer rango de fechas
        $cantidadDias = 2; // Por el momento se establecen manualmente, luego se pueden obtener dinamicamente.
        $rangoFechas = []; 
        for ($i=0; $i < $cantidadDias; $i++) { 
            $rangoFechas[] = date("d-m-Y", mktime(0, 0, 0, date("m")  , date("d")+$i, date("Y")));
        }
        // Crear formateador de fechas para español
        $formateadorFechaIdioma = new IntlDateFormatter(
            "es_CO",
            IntlDateFormatter::FULL, // Estilo para la fecha
            IntlDateFormatter::NONE, // Estilo para la hora (NONE para no incluir hora)
            'America/Bogota',        // Zona horaria de Colombia
            IntlDateFormatter::GREGORIAN,
            'E, d \'de\' MMM' // Patrón de formato personalizado Ej: lun, 1 de dic
        );

        // Establecer rango de horas laborales
        $rangoHoras = [8,9,10,11,12,13,14,15,16];

        // Foreach esteticista
        foreach ($esteticistas as $esteticista) {
            // Imprime nombre esteticista
            echo '<h3 class="h3 mt-3">'. $esteticista["nombre"] . '</h3>';
            // Foreach fechas
            foreach ($rangoFechas as $fecha) {                
                $ts = strtotime($fecha); // timestamp
                $fechaFormateada = $formateadorFechaIdioma->format($ts);
                // Definir año, mes y dia para enviarlo a la pag de confirmacion
                $anio = (int)date("Y", $ts); 
                $mes = (int)date("m", $ts);
                $d = (int)date("d", $ts);

                // Imprime fecha
                echo "<h5>". $fechaFormateada . "</h5>";
                
                // Calcular horas disponibles
                $horasDisponibles = calcularHorasDisponiblesEstet($esteticista["id"], $fecha, $rangoHoras, $duracionServ);
                
                // Imprime horas disponibles                
                if(count($horasDisponibles) > 0){
                    echo '<div class="btn-toolbar" role="toolbar">';
                    foreach($horasDisponibles as $hora) {                    
                        $tsHora = strtotime($fecha . " " . $hora . " hours" ); // Obtener hora                    
                        echo '<div class="btn-group mr-2" role="group" aria-label="First group"> ';
                            echo '<a href="confirmacion.php?cat='.$idCat.'&id_serv='.$idServ.'&serv='.$nombreServ.'&est='.$esteticista["id"].'&nomEst='.$esteticista["nombre"].'&hora='.$hora.'&dia='.$d.'&mes='.$mes.'&anio='.$anio.'&duracion='.$duracionServ.'" type="button" class="btn btn-outline-success"> ' . date("g:00 A", $tsHora) . '</a>';
                        echo '</div>';
                    }
                    echo '</div>'; 
                } else {
                    echo "<p>No hay horas disponibles en esta fecha!</p>";
                }
            }                
        }            
    } catch (\Throwable $th) {
        error_log("Error al obtener agenda disponible: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        echo "Error interno del servidor. No se pudo obtener la agenda disponible.";
    }
}

/** Calcula las horas disponibles de un esteticista en una fecha especifica segun la duracion del servicio 
 * @param int $idEsteticista -> id del esteticista
 * @param string $fecha -> fecha del dia que se desea consultar en formato "d-m-Y"
 * @param array<int> $rangoHoras -> rango de horas a calcular. Ejemplo: [8,9,10...]
 * @param int $duracionServicio -> duracion del servicio que se va a reservar en horas. Ejemplo 1
 * @return array<int>|false -> arreglo con el listado de horas disponibles del esteticista, o false en caso de error.
 */
function calcularHorasDisponiblesEstet(int $idEsteticista, string $fecha, array $rangoHoras, int $duracionServicio): array|false {
    try {
        $horasOcupadas = calcularHorasOcupadasEstet($idEsteticista, $fecha);
        $horasDisponibles = [];

        // Si no hay horas ocupadas se devuelve todo el rango de horas.
        if (empty($horasOcupadas)) {
           return $horasDisponibles[] = $rangoHoras;
        } 

        // Filtrar horas disponibles
        if ($duracionServicio === 1) { // Para servicios de 1 hora
           return $horasDisponibles = array_values(array_diff($rangoHoras, $horasOcupadas)); // array_values para devolver un nuevo array sin los indices del array_diff.
        } 
        
        if ($duracionServicio >= 2) { // Para servicios de 2 o mas horas se debe confirmar que las horas disponibles sean consecutivas para cubrir la duracion del servicio.
            $horasPosibles = array_values(array_diff($rangoHoras, $horasOcupadas));
            
            foreach ($rangoHoras as $horaV) {
                $hDisponible = 0;
                for ($i=0; $i < $duracionServicio; $i++) { 
                   if(in_array($horaV + $i,$horasPosibles)){ $hDisponible += 1;}
                }
                if ($hDisponible == $duracionServicio){ $horasDisponibles[] = $horaV;}
            }
        }
        return $horasDisponibles;
    } catch (\Throwable $th) {
       error_log("Error calculando horas disponibles esteticista: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        return false;
    }
}

/** Calcula las horas ocupadas de un esteticista segun la agenda programada en una fecha.
 * @param int $idEsteticista -> id del esteticista
 * @param string $fecha -> fecha del dia que se desea consultar en formato "d-m-Y"
 * @return array<int>|false -> arreglo con el listado de horas en las que la esteticista esta ocupada, o false en caso de error. 
 */
function calcularHorasOcupadasEstet(int $idEsteticista, string $fecha): array|false {
    try {
        $citasEsteticista = obtenerCitasEsteticista($idEsteticista, $fecha);
        $horasOcupadas = [];

        // Si no tiene citas se retorna array vacio lo que indica que todas las horas estan disponibles.
        if (count($citasEsteticista) == 0) {
            return $horasOcupadas = [];
        }
        
        //establecer horas ocupadas.
        foreach ($citasEsteticista as $cita) {            
            if ($cita["duracion"] > 1) { // si la cita dura 2 o mas horas
                for($i = 0; $i < $cita["duracion"]; $i++) { // Se marcan las horas siguientes como ocupadas
                    $horasOcupadas[] = $cita["hora"] + $i;
                }
            } else {
                $horasOcupadas[] = $cita["hora"];
            }
        }
        return $horasOcupadas;
    } catch (\Throwable $th) {
        error_log("Error obteniendo horas ocupadas esteticista: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        return false;
    }
}

/** Obtiene las citas programadas de un esteticista especifico 
 * @param int $idEsteticista -> id del esteticista
 * @param string $fecha -> fecha del dia que se desea consultar en formato "d-m-Y"
 * @return array|false -> retorna array con el listado de citas de la esteticista ordenadas por horas de menor a mayor (ASC), o false en caso de error
 */
function obtenerCitasEsteticista(int $idEsteticista, string $fecha): array|false {
    try {
        include_once 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();

        // Obtener año, mes y dia 
        $fecha = explode("-",$fecha);
        $anio = (int)$fecha[2]; 
        $mes = (int)$fecha[1]; 
        $dia = (int)$fecha[0]; 

        $idEsteticista = $idEsteticista;

        $citasEsteticista = []; // Inicializa array vacio

        // Obtener citas
        $sql = "SELECT hora, duracion
        FROM t_citas 
        WHERE id_esteticista=:id_esteticista AND dia=:dia AND mes=:mes AND anio=:anio 
        ORDER BY hora;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("id_esteticista", $idEsteticista, PDO::PARAM_INT);
        $stmt->bindValue("dia", $dia, PDO::PARAM_INT);
        $stmt->bindValue("mes", $mes, PDO::PARAM_INT);
        $stmt->bindValue("anio", $anio, PDO::PARAM_INT);
        $stmt->execute();
        $citasEsteticista = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $citasEsteticista;
    } catch (\Throwable $th) {
        error_log("Error al obtener citas del esteticista: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        return false;
    }
}

/** Obtiene las esteticistas de la categoria
 * @param int $idCategoria -> id de la categoria del servicio solicitado
 * @return array|false retorna array con el listado de esteticistas, o false en caso de algun problema
 */
function obtenerEsteticistasCategoria(int $idCategoria): array|false {
    try {
        // Conectar a la base de datos
        include 'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();      
        
        // Obtener el id de la cuenta del cliente
        $cuenta = $_SESSION['id_cuenta'];

        // Obtener todas las esteticistas de la categoria
        $sql = "SELECT id, nombre           
        FROM t_esteticistas 
        WHERE id_cuenta=:id_cuenta AND id_cat=:id_cat";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_cuenta', $cuenta, PDO::PARAM_INT);
        $stmt->bindValue(':id_cat', $idCategoria, PDO::PARAM_INT);
        $stmt->execute();
        $esteticistas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $esteticistas;
    } catch (\Throwable $th) {
        error_log("Error al obtener categorias: " . $th->getMessage() . "en la linea: "  . $th->getLine() . " en el archivo: " . $th->getFile());
        return false;
    }
}