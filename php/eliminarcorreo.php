<?php

session_start();

if (isset($_GET['seccion']) and isset($_GET['correo']) and isset($_SESSION['usuario'])) {
    $seccion = $_GET['seccion'];
    $correo = $_GET['correo'];
    $usuario = $_SESSION['usuario'];

    $archivo_origen = "../data/$usuario/$seccion/$correo";

    if ($seccion == 'eliminados') {
        if (unlink($archivo_origen)) {
            header('location: ../bandeja.php');
        } else {
            header('location: ../bandeja.php?err=eliminar');
        }
    } else {

        $archivo_destino = "../data/$usuario/eliminados/$correo";

        if (!file_exists("../data/$usuario/eliminados")) {
            if (!mkdir("../data/$usuario/eliminados", 0755, true)) {
                header('location: ../bandeja.php?err=carpeta');
                die();
            }
        }

        if (rename($archivo_origen, $archivo_destino)) {
            header('location: ../bandeja.php');
        } else {
            header('location: ../bandeja.php?err=mover');
        }
    }
}

die();
