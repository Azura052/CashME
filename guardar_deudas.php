<?php
session_start();

$conexion = mysqli_connect("localhost", "root", "123456", "dbcashme");

if (!$conexion) {
    die(json_encode(["success" => false, "error" => "Error de conexión: " . mysqli_connect_error()]));
}

// Leer los datos enviados en la solicitud
$data = json_decode(file_get_contents("php://input"), true);
$response = ["success" => false];

// Validar que el usuario esté definido
$usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

if (!empty($data['deudas']) && $usuario_id) {
    foreach ($data['deudas'] as $deuda) {
        // Validar y escapar los datos para prevenir inyección SQL
        $desc = mysqli_real_escape_string($conexion, $deuda['desc']);
        $monto = mysqli_real_escape_string($conexion, $deuda['monto']);
        $fecha = mysqli_real_escape_string($conexion, $deuda['fecha']);

        // Consulta para actualizar la base de datos
        $consulta = "UPDATE Deuda 
                     SET DeudaMonto = '$monto', DeudaFecha = '$fecha'
                     WHERE DeudaDesc = '$desc' AND usuario_idUsuario = '$usuario_id'";

        $resultado = mysqli_query($conexion, $consulta);

        // Manejar errores en la consulta
        if (!$resultado) {
            $response["success"] = false;
            $response["error"] = "Error en la consulta: " . mysqli_error($conexion);
            echo json_encode($response);
            exit; // Salir en caso de error
        }
    }

    // Si todas las consultas se ejecutaron correctamente
    $response["success"] = true;
} else {
    $response["error"] = "Datos inválidos o usuario no autenticado.";
}

// Devolver la respuesta como JSON
echo json_encode($response);
?>
