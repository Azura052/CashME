<?php
//TODO:checar si esta bien la conexion a la base de datos para ver si se guardan los datos
$conexion = mysqli_connect("localhost", "root", "123456", "dbcashme");

$data = json_decode(file_get_contents('php://input'), true);

$idDeuda = $data['idDeuda'];

$query = "DELETE FROM Deuda WHERE idDeuda = '$idDeuda'";
$result = mysqli_query($conexion, $query);

echo json_encode(['success' => $result]);
?>
