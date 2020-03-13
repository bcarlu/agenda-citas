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

        <!--CAT UÑAS-->
        <a class="text-decoration-none text-dark" href="servicios.php?cat=unas">
        <div class="row cat-unas mb-2 py-2 d-flex align-items-center justify-content-between">

            <!--Imagen-->
            <div class="col">
                <img src="img/cat-unas.png" alt="" class="img-fluid" height="70" width="70">
            </div>

            <!--Descripcion-->
            <div class="col text-center">
            <p class="h2 text-decoration-none">Uñas</p>
            </div>

            <!--Icono-->
            <div class="col text-right">
                <i class="fas fa-angle-right fa-lg"></i>
            </div>            
        </div>
        </a>
        
        <!--CAT CERA-->
        <a class="text-decoration-none text-dark" href="servicios.php?cat=cera">
        <div class="row cat-cera mb-2 py-2 d-flex align-items-center justify-content-between">

            <!--Imagen-->
            <div class="col">
                <img src="img/cat-cera.png" alt="" class="img-fluid" height="70" width="70">
            </div>

            <!--Descripcion-->
            <div class="col text-center">
            <p class="h2 text-decoration-none">Cera</p>
            </div>

            <!--Icono-->
            <div class="col text-right">
                <i class="fas fa-angle-right fa-lg"></i>
            </div>            
        </div>
        </a>
        
        <!--CAT SPA-->
        <a class="text-decoration-none text-dark" href="servicios.php?cat=spa">
        <div class="row cat-spa mb-2 py-2 d-flex align-items-center justify-content-between">

            <!--Imagen-->
            <div class="col">
                <img src="img/cat-spa.png" alt="" class="img-fluid" height="70" width="70">
            </div>

            <!--Descripcion-->
            <div class="col text-center">
            <p class="h2 text-decoration-none">Spa</p>
            </div>

            <!--Icono-->
            <div class="col text-right">
                <i class="fas fa-angle-right fa-lg"></i>
            </div>
        </div>
        </a>

    </div>

<?php
//Cierre del if
}else {
    echo "<div class='container'><h3 class='alert alert-danger text-center'>:( no has ingresado tus datos, por favor <a href='./'>inicia sesión</a> :)</h3></div>";
}
?>
</body>