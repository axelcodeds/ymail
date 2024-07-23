<?php

session_start();

function eliminarCarpeta($carpeta) {
    if (is_dir($carpeta)) {
        $objetos = scandir($carpeta);
        foreach ($objetos as $objeto) {
            if ($objeto != "." && $objeto != "..") {
                $rutaCompleta = $carpeta . "/" . $objeto;
                if (is_dir($rutaCompleta)) {
                    eliminarCarpeta($rutaCompleta); // Llamada recursiva para subcarpetas
                } else {
                    unlink($rutaCompleta); // Eliminar archivo
                }
            }
        }
        rmdir($carpeta); // Eliminar carpeta vacía
        echo "La carpeta '$carpeta' ha sido eliminada.";
    } else {
        echo "La carpeta '$carpeta' no existe.";
    }
}

// Ejemplo de uso
$carpeta = '../data/' . $_SESSION['usuario'];
eliminarCarpeta($carpeta);

$_SESSION = array();

header('location: ../index.php');
