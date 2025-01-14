<?php
include 'conexion.php'; // Archivo donde se conecta a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDeuda'])) {
    $idDeuda = intval($_POST['idDeuda']);

    // Preparar la consulta de eliminación
    $consulta = "DELETE FROM deuda WHERE idDeuda = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, 'i', $idDeuda);

    if (mysqli_stmt_execute($stmt)) {
        // Redirigir a la página principal después de eliminar
        header('Location: deudas.php?mensaje=Deuda eliminada correctamente');
        exit;
    } else {
        echo "Error al eliminar la deuda: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
