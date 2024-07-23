<?php
session_start();


if (isset($_POST['usuario'])  && isset($_POST['contra'])) {
    $usuario = $_POST['usuario'];
    $contra = $_POST['contra'];

    $carpeta = '../data/' . $usuario;

    if (file_exists($carpeta)) {
        $archivo = fopen($carpeta . '/data.txt', 'r');

        $usuarioarch = trim(fgets($archivo));
        $contraarch = fgets($archivo);
        fclose($archivo);

        $refarch = fopen($carpeta . '/status.txt', 'r');
        $status = trim(fgets($refarch));
        $sessionid = trim(fgets($refarch));
        fclose($refarch);

        if (password_verify($contra, $contraarch)) {
            if ($status == 'inactivo') {
                $_SESSION['usuario'] = $usuario;
                $refarch = fopen($carpeta . '/status.txt', 'w');
                fwrite($refarch, 'activo' . PHP_EOL . session_id());
                fclose($refarch);

                if (isset($_POST['recordar'])) {
                    $expiration_time = time() + 2592000;
                    setcookie('usuario', $usuario, $expiration_time, "/");
                    setcookie('contra', $contra, $expiration_time, "/");
                } else {
                    setcookie('usuario', '', time() - 3600, '/');
                    setcookie('contra', '', time() - 3600, '/');
                }
                header('location: ../bandeja.php');
            } else if ($status == 'activo') {
                $_SESSION['posible'] = $usuario;
                $_SESSION['recordar'] = (isset($_POST['recordar'])) ? 'si' : 'no';
                header('location: ../login.php');
            }
        } else {
            header('location: ../login.php?err=contraincorrecta');
        }
    } else {
        header('location: ../login.php?err=noexiste');
    }
}

die();
