<?php session_start();?>
<?php $titulo = "Servicios";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<?php
$usuario = $_SESSION['username'];
if (isset($usuario)) {
?>

<body>
    <?php include_once'navbar.php';?>
    <?php include_once'navsesion.php';?>
    <div class="container">
    <div class="row">
        <div class="col text-center py-5">
            <h3 class="hcate">Servicios</h3>
        </div>
    </div>

    <div class="row text-center">
            <?php listaServicios();?>
    </div>
    </div> 
<?php
//Cierre del if
}else {
    echo ":( no has ingresado tus datos, por favor <a href='index.php'>inicia sesión</a> :)";
}
?>
</body>