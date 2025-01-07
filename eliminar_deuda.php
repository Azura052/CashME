<?php
// Inicia la sesión si trabajas con $_SESSION
session_start();

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "123456", "dbcashme");

$data = json_decode(file_get_contents("php://input"), true);
$response = ["success" => false];

if (!empty($data['id'])) {
    $id = intval($data['id']); // Convertir el ID a entero para seguridad

    $consulta = "DELETE FROM Deuda WHERE idDeuda = $id";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $response["success"] = true;
    } else {
        $response["error"] = "Error en la consulta: " . mysqli_error($conexion);
    }
} else {
    $response["error"] = "ID de deuda no proporcionado.";
}

echo json_encode($response);
?>
