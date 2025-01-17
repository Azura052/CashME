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
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$desc = $data['desc'];
$monto = $data['monto'];
$fecha = $data['fecha'];

// Actualizar en la base de datos
$sql = "UPDATE Deuda SET DeudaDesc = '$desc', DeudaMonto = '$monto', DeudaFecha = '$fecha' WHERE idDeuda = '$id'";
if (mysqli_query($conexion, $sql)) {
    echo 'success';
} else {
    echo 'error';
}
?>
