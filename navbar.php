<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <!--Se valida rol del usuario-->
    <?php $inicio = $_SESSION['id_rol'] === 1 ? "/inicio_admin.php" : "/inicio.php"; ?>
    <a class="navbar-brand" href=<?php echo $inicio; ?>><img src="/img/user.png" width="30" height="30" class="d-inline-block align-top" alt=""><small class="pl-2"><?php echo htmlspecialchars($_SESSION['nombre_usuario'], ENT_QUOTES); ?></small></a>
    
    <span>
    <?php setlocale(LC_TIME,'es_CO.utf8'); 
    echo strftime("%a %e %b"); ?>
    </span>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link float-right text-danger" href="/php/cerrarSesion.php">Cerrar sesion </a>
            </li>
                
        </ul>
    </div>
</nav>

   
