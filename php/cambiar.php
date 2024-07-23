<?php
session_start();

$usuario = $_POST['res'];
$file_path = "../data/$usuario/status.txt";

$lines = file($file_path, FILE_IGNORE_NEW_LINES);

if (count($lines) >= 2) {
    $lines[1] = session_id();
    $new_content = implode("\n", $lines);
    file_put_contents($file_path, $new_content);

    if (isset($_POST['recordar'])) {
        $expiration_time = time() + 2592000;
        setcookie('usuario', $usuario, $expiration_time, "/");
    }

    $_SESSION['usuario'] = $usuario;
    header('location: ../bandeja.php');
} else {
    echo "El archivo no tiene al menos dos líneas.";
}
