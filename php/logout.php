<?php

session_start();


$usuario = $_SESSION['usuario'];

$carpeta = '../data/' . $usuario;

if (file_exists($carpeta)) {
    $refarch = fopen($carpeta . '/status.txt', 'w');
    fwrite($refarch, 'inactivo');
    fclose($refarch);
}
$_SESSION = array();

header('location: ../index.php');
