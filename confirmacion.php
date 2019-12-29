<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<body>
    <?php include_once'navbar.php';?>

    <?php

    $categoria = $_GET['cat'];
    $servicio = $_GET['serv'];
    $hora = $_GET['hora'];
    $dia = $_GET['dia'];
    $mes = $_GET['mes'];
    ?>
    <div class="text-center alert alert-primary">
        <?php
        echo "<p>Su servicio <b>$servicio</b> será Agendado para el dia <b>$dia de $mes a las $hora</b>.</p>";
        echo "<p>Si la información es correcta por favor confirme su cita.</p>"
        ?>
    </div>
    
    <div class="text-center p-5">
        <button type="button" class="btn btn-success">Confirmar</button>
    </div>
    

</body>