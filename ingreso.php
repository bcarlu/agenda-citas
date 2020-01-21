<?php $titulo = "Ingreso";?>
<?php include_once'head.php';?>


<body>
    <div class="container">
                
        <!--Formulario de Login-->
        <form class="login-form" action="php/validalogin.php" method="post">
            <h2 class="text-center mb-5">Ingreso Luspa</h2>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Escriba su email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Escriba su clave">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>
        </form>
        
        
    </div>        
</body>
</html>