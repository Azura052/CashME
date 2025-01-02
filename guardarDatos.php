<?php
$conexion = new mysqli("localhost", "root", "123456", "dbcashme");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$apellidoPaterno = $_POST['apellidoPaterno'];
$apellidoMaterno = $_POST['apellidoMaterno'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$password = $_POST['password'];
$estado = $_POST['estado'];
$codigoPostal = $_POST['codigoPostal'];
$colonia = $_POST['colonia'];
$calle = $_POST['calle'];

        

        // Insertar en la tabla usuario
        $sqlUsuario = "INSERT INTO usuario (usuarioNom, usuarioApePat, usuarioApeMat, usuarioTel, usuarioEmail, usuarioContra, ingresoSaldo, ahorroSaldo, deudaSaldo) 
                        VALUES ('$nombre', '$apellidoPaterno', '$apellidoMaterno', '$telefono', '$email', '$password', 0, 0, 0)";

        if ($conexion->query($sqlUsuario) === TRUE) {
            $last_id = $conexion->insert_id;

            // Insertar en la tabla usuarioDireccion
            $sqlDireccion = "INSERT INTO usuarioDireccion (usuarioDireccionEstado, usuarioDireccionCP, usuarioDireccioncol, usuarioDireccionCalle, usuario_idUsuario) 
                                VALUES ('$estado', '$codigoPostal', '$colonia', '$calle', '$last_id')";

            if ($conexion->query($sqlDireccion) === TRUE) {
                echo "Registro exitoso";
            } else {
                echo "Error: " . $sqlDireccion . "<br>" . $conexion->error;
            }
        } else {
            echo "Error: " . $sqlUsuario . "<br>" . $conexion->error;
        }

        $conexion->close();
?>