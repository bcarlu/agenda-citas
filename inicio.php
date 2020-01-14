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
<div class="container">
    <div class="row">
        <div class="col-4 pr-2">
            <img src="img/avatar-usuario.png" alt="..." class="rounded-circle">
        </div>
        <div class="col">
            <small><?php echo $usuario;?></small>
        </div>    
    </div>
    <div class="row">
        <div class="col">
            <h3>Mis citas agendadas</h3>
        <!--Fin col-->
        </div>
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    </tr>
                    <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
        <!--Fin col-->
        </div>
    <!--Fin row-->
    </div> 
     
    <!--Boton agendar-->
   
        <a href="categorias" class="float-right btn btn-success rounded p-2">
        <span class="d-block display-4">+</span>
        <small class="d-block">Agendar</small></a>
  

<!--Fin container-->
</div>

<?php
//Cierre del if
}else {
    echo ":( no has ingresado tus datos, por favor <a href='./'>inicia sesión</a> :)";
}
?>
</body>