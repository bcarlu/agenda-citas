<?php session_start();?>
<?php $titulo = "Confirmacion";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>
<?php
$usuario = $_SESSION['username'];
if (isset($usuario)) {
?>

<body>
    <?php include_once'navbar.php';?>
    <?php include_once'navsesion.php';?>
    <?php
    $categoria = $_GET['cat'];
    $servicio = $_GET['serv'];
    $hora = $_GET['hora'];
    $dia = $_GET['dia'];
    $mes = $_GET['mes'];
    $esteticista = $_GET['est'];
    ?>
        
    <div class="container bg-md-primary">
        <div class="card mx-auto alert alert-primary" style="width: 18rem;">
            <img src="img/manicure.jpeg" height="176" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title font-weight-bold"><?php echo $servicio;?></h5>
                <p class="card-text">Este es el detalle de la programación de su servicio, si los datos son correctos puede confirmar la agenda.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Servicio: <?php echo $servicio;?></li>
                <li class="list-group-item">Fecha: <?php echo $dia . " de " . $mes;?></li>
                <li class="list-group-item">Hora: <?php echo $hora;?></li>
                <li class="list-group-item">Esteticista: <?php echo $esteticista;?></li>
            </ul>
            <div class="card-body">
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