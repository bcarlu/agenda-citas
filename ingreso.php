<?php $titulo = "Ingreso";?>
<?php include_once'head.php';?>

<body>

    <?php include_once'navloginreg.php';?>
    <div class="container">        
        <div class="row" style="padding:50px 0px;">
            <div class="col">
                <h2>Bienvenido!</h2>
            </div>            
        </div>
        <!--Formulario de Login-->
        <form class="login-form" action="php/validalogin.php" method="post">
            <div class="form-group mb-5">
                Email
                <input type="email" class="form-control campo-input" id="email" aria-describedby="emailHelp" name="email">
            </div>
            <div class="form-group">
                Clave
                <input type="password" class="form-control campo-input" id="clave" name="clave">
            </div>
            <div class="form-group">
                <button type="submit" class="btn bt-ingresar btn-block mt-5">Ingresar</button>
            </div>
        </form>
        
        
    </div>        
</body>
</html>