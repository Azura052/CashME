<?php
include 'conexion.php'; // Archivo donde se conecta a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idInversion'])) {
    $idInversion = intval($_POST['idInversion']);

    // Preparar la consulta de eliminación
    $consulta = "DELETE FROM inversion WHERE idInversion = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, 'i', $idInversion);

    if (mysqli_stmt_execute($stmt)) {
        // Redirigir a la página principal después de eliminar
        header('Location: inversiones.php?mensaje=Inversión eliminada correctamente');
        exit;
    } else {
        echo "Error al eliminar la inversión: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
