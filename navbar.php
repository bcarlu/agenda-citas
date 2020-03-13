<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="inicio"><img src="img/user.png" width="30" height="30" class="d-inline-block align-top" alt=""><small class="pl-2"><?php nombreCliente($usuario); ?></small></a>
    
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
                <a class="nav-link float-right text-danger" href="php/cerrarSesion.php">Cerrar sesion </a>
            </li>
                
        </ul>
    </div>
</nav>

   