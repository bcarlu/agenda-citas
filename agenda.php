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

    <div class="text-center h4 alert-primary">Agenda disponible para <?php echo "<b>{$_GET['serv']}</b>"; ?></div>  
    
    <?php agendaDisponible(); ?>

<?php
//Cierre del if
}else {
    echo ":( no has ingresado tus datos, por favor <a href='./'>inicia sesión</a> :)";
}
?>
</body>