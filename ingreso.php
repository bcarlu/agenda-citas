<?php $titulo = "Ingreso";?>
<?php include_once'head.php';?>

<body>

    <?php include_once'navloginreg.php';?>
    <div class="container">        
        <div class="row justify-content-md-center" style="padding:50px 0px;">            
            <div class="col-12 col-md-7 text-center mb-4">
                <h2>Bienvenido!</h2>
            </div>
            <div class="col-12 col-md-5">
                <!--Formulario de Login-->                
                <form class="login-form" action="php/validalogin_pg.php" method="post">
                    <div class="form-group">
                        Email
                        <input type="email" class="form-control campo-input" id="email" aria-describedby="emailHelp" name="email" required>
                    </div>
                    <div class="form-group">
                        Clave
                        <input type="password" class="form-control campo-input" id="clave" name="clave" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn bt-ingresar btn-block">Ingresar</button>
                    </div>
                </form>
            </div>          
        </div>
    </div>
</body>
</html>