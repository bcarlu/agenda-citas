<?php session_start();?>
<?php $titulo = "Agenda";?>
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
        <div class="text-center h3 alert-primary">
            <span>Agenda para <?php echo "<b>{$_GET['serv']}</b>"; ?></span>
        </div>  
        
        <div class='row'>
            <div class='col px-2 pb-2'>
                <?php agendaDisponible(); ?>
            </div>
        </div>
    </div> 

<?php

    //Si la peticion viene de la pagina confirmagenda y ya esta agendada la cita
    //if modal
    if ($_GET['agendado'] == "si") {
?>  
    <div class="modal" tabindex="-1" role="dialog" id="avisoAgendado">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alerta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Oh Oh! Lo sentimos alguien acaba de tomar esta cita, pero no te preocupes puedes escoger otra disponible ;)</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
            </div>
        </div>
    </div>
    <script> 
        $('#avisoAgendado').modal('show'); 
    </script>
    
<?php
    //Cierre if modal
    }

//Cierre del if sesion
}else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='./'>inicia sesión</a> :)</h3></div> ";
}
?>
</body>