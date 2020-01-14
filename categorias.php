<?php session_start();?>
<?php include_once'head.php';?>

<?php
$usuario = $_SESSION['username'];
if (isset($usuario)) {
?>

<body class="categorias">
    <?php include_once'navbar.php';?>
    <?php include_once'navsesion.php';?>
    <div class="container">
        
        <div class="row">
            <div class="col text-center py-5">
                <h3>Categorias</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col">
            <a href="servicios.php?cat=unas"><img src="img/circle3498db.png" width="75" height="75" alt="..." class="rounded-circle">
            Uñas</a>
            </div>
            <div class="col">
            <a href="servicios.php?cat=cera"><img src="img/circlee74c3c.png" width="75" height="75" alt="..." class="rounded-circle">
            Cera</a>
            </div>
            <div class="col">
            <a href="servicios.php?cat=spa"><img src="img/circle9b59b6.png" width="75" height="75" alt="..." class="rounded-circle">
            Spa</a>
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