<?php
require __DIR__ . '/../vendor/autoload.php';

// Carga las variables del archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host=$_ENV["PG_HOST"];
$dbname=$_ENV["PG_DBNAME"];
$user=$_ENV["PG_USER"];
$password=$_ENV["PG_PASSWORD"];

// Connecting, selecting database
$dbconn = pg_connect("host=$host dbname=$dbname user=$user password=$password")
    or die('Could not connect: ' . pg_last_error());