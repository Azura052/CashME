<?php
    session_start();  // Asegúrate de iniciar la sesión aquí
    
    if (isset($_SESSION['user_id'])) {
        $usuario_id = $_SESSION['user_id'];
        // Usar $usuario_id en lugar de $user_id
    } else {
        // Si no hay sesión iniciada, redirige o muestra un error
        header("Location: loginUsuario.php");
        exit();
    }

    // Conectar a la base de datos
    $conexion = mysqli_connect("localhost", "root", "123456", "dbcashme");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idIngreso'])) {
    $idIngreso = intval($_POST['idIngreso']);

    // Preparar la consulta de eliminación
    $consulta = "DELETE FROM ingreso WHERE idIngreso = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, 'i', $idIngreso);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ingresos.php?mensaje=Eliminado correctamente');
        exit;
    } else {
        echo "Error al eliminar el registro: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conexion);
?>
