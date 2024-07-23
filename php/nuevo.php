<?php

session_start();



if (isset($_POST['usuario']) and isset($_POST['contenido']) and isset($_SESSION['usuario']) and isset($_POST['titulo'])) {
    $remitente = $_SESSION['usuario'];
    $destinatario = $_POST['usuario'];
    $titulo = $_POST['titulo'];


    if (isset($_POST['modo'])) {
        if (!file_exists("../data/$remitente/borradores")) {
            if (!mkdir("../data/$remitente/borradores", 0755, true)) {
                header('location: ../nuevo.php?err');
            }
        }
        if (isset($_GET['correo'])) {
            $unique = $_GET['correo'];
        } else {
            $unique = uniqid() . '.txt';
        }

        $refarch = fopen("../data/$remitente/borradores/" . $unique, 'w');
        fwrite($refarch, $remitente . PHP_EOL . $destinatario . PHP_EOL . $titulo . PHP_EOL .  $_POST['contenido']);
        fclose($refarch);
        header('location: ../bandeja.php?err=borrador');
        die();
    }

    $ruta = '../data/' . $destinatario;

    if (!file_exists($ruta)) {
        header('location: ../nuevo.php?err=noexiste');
    } else if ($remitente == $destinatario) {
        header('location: ../nuevo.php?err=mismousuario');
    } else {
        if (!file_exists($ruta . '/recibidos')) {
            if (!mkdir($ruta . '/recibidos', 0755, true)) {
                header('location: ../nuevo.php?err');
            }
        }

        $unique = uniqid();

        $refarch = fopen($ruta . '/recibidos/' . $unique . '.txt', 'w');
        fwrite($refarch, $remitente . PHP_EOL . $destinatario . PHP_EOL . $titulo . PHP_EOL .  $_POST['contenido']);
        fclose($refarch);

        if (!file_exists("../data/$remitente/enviados")) {
            if (!mkdir("../data/$remitente/enviados", 0755, true)) {
                header('location: ../nuevo.php?err');
            }
        }
        if (isset($_POST['datos'])) {
            $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $numCaracteres = strlen($caracteres);
            $cadenaAleatoria = '';

            for ($i = 0; $i < random_int(20, 50); $i++) {
                $linea = '';
                for ($j = 0; $j < random_int(20, 50); $j++) {
                    $indiceAleatorio = random_int(0, $numCaracteres - 1);
                    $linea .= $caracteres[$indiceAleatorio];
                }
                $cadenaAleatoria .= $linea . PHP_EOL;
            }

            $contenido = $cadenaAleatoria;
        } else {
            $contenido = $_POST['contenido'];
        }
        $refarch = fopen("../data/$remitente/enviados/$unique.txt", 'w');
        fwrite($refarch, $remitente . PHP_EOL . $destinatario . PHP_EOL . $titulo . PHP_EOL . $contenido);
        fclose($refarch);

        header('location: ../bandeja.php?err=ninguno');
    }
}

die();
