<?php session_start();?>
<?php $titulo = "Agenda";?>
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
        <div class="text-center h3 alert-primary">
            <span>Agenda para <?php echo "<b>{$_GET['serv']}</b>"; ?></span>
        </div>  
        
        <div class='row'>
            <div class='col px-2 pb-2'>
                <?php agendaDisponible(); ?>
            </div>
        </div>
    </div> 

<?php
//Cierre del if
}else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='./'>inicia sesión</a> :)</h3></div> ";
}
?>
</body>