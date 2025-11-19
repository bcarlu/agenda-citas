<?php session_start();?>
<?php $titulo = "Categorias";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<?php
$usuario = $_SESSION['username'];
if (isset($usuario)) {
?>

<body class="categorias">
    <?php include 'navbar.php';?>
    <?php include 'navsesion.php';?>
    <div class="container">
        
        <div class="row">
            <div class="col text-center py-5">
                <h3>Categorias</h3>
            </div>
        </div>

        <!--Se listan los servicios de la categoria-->
        <?php listaCategorias();?>

    </div>

<?php
//Cierre del if
}else {
    echo "<div class='container'><h3 class='alert alert-danger text-center'>:( no has ingresado tus datos, por favor <a href='./'>inicia sesión</a> :)</h3></div>";
}
?>
</body>
