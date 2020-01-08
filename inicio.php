<?php session_start();?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<?php
$usuario = $_SESSION['username'];
if (isset($usuario)) {
?>

<body>
<?php include_once'navbar.php';?>
<?php include_once'navsesion.php';?>
    <div class="row">
        <div class="col-4 pr-2">
            <img src="img/avatar-usuario.png" alt="..." class="rounded-circle">
        </div>
        <div class="col">
            <small><?php echo $usuario;?></small>
        </div>    
    </div>
    <div class="row">
        <h3>Mis citas agendadas</h3>
        <ul>
            <li>Servicio: <?php citasUsuario();?></li>
        </ul>
    </div>
    <div class="row">
        <div class="col float right">
            <a href="categorias"><img src="img/icono-plus.png" alt="">Agendar</a>
        </div>
    </div>




<?php
//Cierre del if
}else {
    echo ":( no has ingresado tus datos, por favor <a href='./'>inicia sesión</a> :)";
}
?>
</body>