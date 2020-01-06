<?php
session_start();
include_once'head.php';

$servicio = $_GET['serv'];

$usuario = $_SESSION['username'];

if (isset($usuario)) {
    
}