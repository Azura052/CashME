<?php
include 'conexion.php'; // Archivo donde se conecta a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idAdeudo'])) {
    $idAdeudo = intval($_POST['idAdeudo']);

    // Preparar la consulta de eliminación
    $consulta = "DELETE FROM adeudo WHERE idAdeudo = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, 'i', $idAdeudo);

    if (mysqli_stmt_execute($stmt)) {
        // Redirigir a la página principal después de eliminar
        header('Location: adeudos.php?mensaje=Adeudo eliminado correctamente');
        exit;
    } else {
        echo "Error al eliminar el adeudo: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
