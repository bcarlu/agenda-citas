<?php session_start();?>
<?php $titulo = "Confirmacion";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>
<?php include_once'php/conexion.php';?>

<?php
$usuario = $_SESSION['username'];
if (isset($usuario)) {

    $categoria = $_GET['cat'];
    $servicio = $_GET['serv'];
    $hora = $_GET['hora'];
    $dia = $_GET['dia'];
    $mes = $_GET['mes'];
    $esteticista = $_GET['est'];
    
    //Busca el nombre del servicio
    $sqlNomEst = "SELECT * FROM t_esteticistas WHERE id_estet = '$esteticista'";
    $resultNomEst = $conn->query($sqlNomEst);
    $nomEst =  $resultNomEst->fetch_assoc();
    $nomEst = $nomEst['nombre'] . " " . $nomEst['apellidos'];
    $conn->close;
?>
     

  
<body>
    <?php include_once'navbar.php';?>
    <?php include_once'navsesion.php';?>
    
        
    <div class="container">
        <div class="card text-center mx-auto" style="width: 18rem;">
            <img src="<?php imagenServicio($categoria); ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $servicio;?></h5>
                <p class="card-text">Servicio: <?php echo $servicio;?> Fecha: <?php echo $dia . " de " . $mes;?> Hora: <?php echo $hora;?> Esteticista: <?php echo $nomEst;?></p>
                <a href="php/confirmagenda.php?serv=<?php echo $servicio;?>&est=<?php echo $esteticista;?>&anio=<?php echo date('Y');?>&mes=<?php echo $mes;?>&dia=<?php echo $dia;?>&hora=<?php echo $hora;?>" class="btn btn-success">Confirmar</a>
            </div>            
        </div>
    </div>

<?php
//Cierre del if
}else {
    echo ":( no has ingresado tus datos, por favor <a href='./'>inicia sesión</a> :)";
}
?>   
</body>