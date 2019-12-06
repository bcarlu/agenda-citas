<?php



//Consulta a la base de datos
/*$selecTabla = "SELECT * FROM t_categorias";
$querySelecTabla = mysqli_query($conexion,$selecTabla);

while ($arraySelecTabla = mysqli_fetch_array($querySelecTabla)) {
    echo $arraySelecTabla['nombre'] . "<br />";
}
*/

function listaServicios(){
    require_once'conexion.php';
    
    $nombreCat = $_GET['cat'];
    $queryTablaCat = mysqli_query($conexion,"SELECT * FROM t_categorias WHERE nombre = '$nombreCat'");
    $arrayTablaCat = mysqli_fetch_array($queryTablaCat);

    $idCat = $arrayTablaCat['id_cat'];
    $queryTablaServ = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE id_cat = '$idCat'");
    
    while($arrayTablaServ = mysqli_fetch_array($queryTablaServ)){
        echo $arrayTablaServ['nombre'] . "<br>";
    }

}