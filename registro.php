<?php
$conexion = new mysqli("localhost", "root", "123456", "dbcashme");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            $sqlDireccion = "INSERT INTO usuarioDir (usuarioDireccionEstado, usuarioDireccionCP, usuarioDireccioncol, usuarioDireccionCalle, usuario_idUsuario) 
                                VALUES ('$estado', '$codigoPostal', '$colonia', '$calle', '$last_id')";

            if ($conexion->query($sqlDireccion) === TRUE) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var modal = document.createElement('div');
                            modal.innerHTML = `
                                <div id='successModal' class='modal'>
                                    <div class='modal-content'>
                                        <h4>Registro exitoso</h4>
                                        <p>Los datos han sido guardados correctamente.</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <a href='#!' class='modal-close waves-effect waves-green btn-flat'>Aceptar</a>
                                    </div>
                                </div>
                            `;
                            document.body.appendChild(modal);
                            var instance = M.Modal.init(document.getElementById('successModal'));
                            instance.open();
                            document.querySelector('.modal-close').addEventListener('click', function() {
                                window.location.href = 'loginUsuario.php';
                            });
                        });
                    </script>";
            } else {
                echo "Error: " . $sqlDireccion . "<br>" . $conexion->error;
            }
        } else {
            echo "Error: " . $sqlUsuario . "<br>" . $conexion->error;
        }

        $conexion->close();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashME - Finanzas personales</title>
    <!-- Links para usar materialize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- Links para usar google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Links para aplicar css expecificos para esta pestaña-->
    <link rel="preload" href="css/styles_04.css" as="style">
    <link href="css/styles_04.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <div class="nav-wrapper">
                <a href="index.html" class="brand-logo">CashME <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="35" height="35" stroke-width="1">
                    <path d="M15 11v.01"></path>
                    <path d="M5.173 8.378a3 3 0 1 1 4.656 -1.377"></path>
                    <path d="M16 4v3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342c-.336 .95 -.907 1.8 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3h0z"></path>
                  </svg></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a class="sombras" href="index.html">Inicio</a></li>
                <li><a class="sombras" href="registro.php">Registrarse</a></li>
                <li><a class="sombras" href="loginUsuario.php">   Iniciar Sesión</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <section class="form-container">
        <div class="container">
                <h2 style="color: #ea580c;">Registro de Usuario <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="55" height="55" stroke-width="1">
                <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z"></path>
                <path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741"></path>
                <path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path>
                </svg></h2>
            <form id="registroForm" method="POST">
                <div class="tabs-header">
                    <button type="button" class="tab-button active" onclick="showTab('personal')">Datos Personales</button>
                    <button type="button" class="tab-button" onclick="showTab('direccion')">Dirección</button>
                </div>

                <!-- Tab Datos Personales -->
                <div id="personal" class="tab active">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required>
                            <span class="error" id="nombre-error">Este campo es requerido</span>
                        </div>
                        <div class="form-group">
                            <label for="apellidoPaterno">Apellido Paterno:</label>
                            <input type="text" id="apellidoPaterno" name="apellidoPaterno" required>
                            <span class="error" id="apellidoPaterno-error">Este campo es requerido</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="apellidoMaterno">Apellido Materno:</label>
                            <input type="text" id="apellidoMaterno" name="apellidoMaterno" required>
                            <span class="error" id="apellidoMaterno-error">Este campo es requerido</span>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="tel" id="telefono" name="telefono" required>
                            <span class="error" id="telefono-error">Ingrese un número de teléfono válido</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        <span class="error" id="email-error">Ingrese un email válido</span>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" required>
                            <span class="error" id="password-error">La contraseña debe tener al menos 8 caracteres</span>
                        </div>
                        <div class="form-group">
            <form id="registroForm" novalidate>
                            <label for="confirmPassword">Confirmar Contraseña:</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" required>
                            <span class="error" id="confirmPassword-error">Las contraseñas no coinciden</span>
                        </div>
                    </div>
                    <button type="button" class="btn-next" onclick="validarYAvanzar()">Siguiente</button>
                </div>

                <!-- Tab Dirección -->
                <div id="direccion" class="tab">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="estado">Estado:</label>
                            <input type="text" id="estado" name="estado" required>
                            <span class="error" id="estado-error">Este campo es requerido</span>
                        </div>
                        <div class="form-group">
                            <label for="codigoPostal">Código Postal:</label>
                            <input type="text" id="codigoPostal" name="codigoPostal" required>
                            <span class="error" id="codigoPostal-error">Ingrese un código postal válido</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="colonia">Colonia o Delegación:</label>
                        <input type="text" id="colonia" name="colonia" required>
                        <span class="error" id="colonia-error">Este campo es requerido</span>
                    </div>
                    <div class="form-group">
                        <label for="calle">Calle y Número:</label>
                        <input type="text" id="calle" name="calle" required>
                        <span class="error" id="calle-error">Este campo es requerido</span>
                    </div>
                    <div class="buttons">              
                        <button type="submit" class="btn-submit">Guardar</button>
                        <button type="button" class="btn-clear" onclick="limpiarFormulario()">Limpiar</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="javascript/script_01.js"></script>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="img/logoEscom.png" alt="Logo de la empresa" class="footer-image">
            </div>
            <div class="footer-contact">
                <p>¿Necesitas ayuda?</p>
                <p>Contáctanos: contactoCashME@gmail.com</p>
            </div>
            <p>&copy; 2024-2025 CashME. Todos los derechos reservados.</p>
            <p><a href="loginAdmin.php" class="admin-link">¿Eres Administrador?</a></p>
        </div>
    </footer>
</body>
</html>