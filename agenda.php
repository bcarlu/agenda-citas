<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<body>
    <?php include_once'navbar.php';?>  
    <div class="text-center h4 alert-primary">Agenda disponible para <?php echo "<b>{$_GET['serv']}</b>"; ?></div>  
    <?php agendaDisponible(); ?>
</body>