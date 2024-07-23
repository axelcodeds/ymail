<?php

if (isset($_POST['usuario']) && isset($_POST['contra']) && isset($_POST['confirmar'])) {
    $usuario = $_POST['usuario'];
    $contra = $_POST['contra'];
    $confirmar = $_POST['confirmar'];

    if (strlen($usuario) < 3) {
        header('location: ../signup.php?err=invalido');
        die();
    } else if ($contra != $confirmar) {
        header('location: ../signup.php?err=confirmar');
        die();
    } else if (strlen($contra) < 6) {
        header('location: ../signup.php?err=tam');
        die();
    }

    $nombreCarpeta = '../data/' . $usuario;

    if (!file_exists($nombreCarpeta)) {
        if (mkdir($nombreCarpeta, 0755, true)) {

            $refarch = fopen($nombreCarpeta . '/data.txt', 'a+');
            $hash = password_hash($contra, PASSWORD_DEFAULT);
            fwrite($refarch, $usuario . PHP_EOL . $hash);
            fclose($refarch);

            session_start();
            $_SESSION['usuario'] = $usuario;

            $refarch = fopen($nombreCarpeta . '/status.txt', 'w');
            fwrite($refarch, 'activo' . PHP_EOL . session_id());
            fclose($refarch);

            if (isset($_POST['recordar'])) {
                $expiration_time = time() + 2592000;
                setcookie('usuario', $usuario, $expiration_time, "/");
                setcookie('contra', $contra, $expiration_time, "/");
            }

            header('location: ../bandeja.php');
        } else {
            header('location: ../signup.php?err');
        }
    } else {
        header('location: ../login.php?aviso=usuarioexistente');
    }
}

die();
