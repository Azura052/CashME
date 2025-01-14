<?php
include 'conexion.php'; // Archivo donde se conecta a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPresupuesto'])) {
    $idPresupuesto = intval($_POST['idPresupuesto']);

    // Preparar la consulta de eliminación
    $consulta = "DELETE FROM presupuesto WHERE idPresupuesto = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, 'i', $idPresupuesto);

    if (mysqli_stmt_execute($stmt)) {
        // Redirigir a la página principal después de eliminar
        header('Location: presupuestos.php?mensaje=Presupuesto eliminado correctamente');
        exit;
    } else {
        echo "Error al eliminar el presupuesto: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
