<?php
session_start();

// Verificar si el admin ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: loginAdmin.php");
    exit();
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "123456", "dbCashme");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioNom = $_POST['usuarioNom'];
    $usuarioApePat = $_POST['usuarioApePat'];
    $usuarioApeMat = $_POST['usuarioApeMat'];
    $usuarioTel = $_POST['usuarioTel'];
    $usuarioEmail = $_POST['usuarioEmail'];
    $usuarioContra = $_POST['usuarioContra'];
    $usuarioDireccionEstado = $_POST['usuarioDireccionEstado'];
    $usuarioDireccionCP = $_POST['usuarioDireccionCP'];
    $usuarioDireccioncol = $_POST['usuarioDireccioncol'];
    $usuarioDireccionCalle = $_POST['usuarioDireccionCalle'];
    $fechaRegistro = date('Y-m-d H:i:s');

    // Insertar datos en la tabla usuario
    $sqlUsuario = "INSERT INTO usuario (usuarioNom, usuarioApePat, usuarioApeMat, usuarioTel, usuarioEmail, usuarioContra, usuarioSesion)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtUsuario = $conn->prepare($sqlUsuario);
    $stmtUsuario->bind_param("sssssss", $usuarioNom, $usuarioApePat, $usuarioApeMat, $usuarioTel, $usuarioEmail, $usuarioContra, $fechaRegistro);

    if ($stmtUsuario->execute()) {
        $idUsuario = $stmtUsuario->insert_id; // Obtener el ID del usuario recién insertado

        // Insertar datos en la tabla usuarioDir
        $sqlDir = "INSERT INTO usuarioDir (usuario_idUsuario, usuarioDireccionEstado, usuarioDireccionCP, usuarioDireccioncol, usuarioDireccionCalle)
                   VALUES (?, ?, ?, ?, ?)";
        $stmtDir = $conn->prepare($sqlDir);
        $stmtDir->bind_param("issss", $idUsuario, $usuarioDireccionEstado, $usuarioDireccionCP, $usuarioDireccioncol, $usuarioDireccionCalle);

        if ($stmtDir->execute()) {
            $mensaje = "¡Usuario creado correctamente!";
        } else {
            $mensaje = "Error al insertar la dirección: " . $stmtDir->error;
        }
    } else {
        $mensaje = "Error al insertar el usuario: " . $stmtUsuario->error;
    }

    $stmtUsuario->close();
    $stmtDir->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashME - Actualizar Usuario</title>
    <!-- Materialize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;700&family=Montserrat:wght@100;900&display=swap" rel="stylesheet">
    <!-- CSS personalizado -->
    <link rel="preload" href="../css/styl_07.css" as="style">
    <link href="../css/styl_07.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="../cashme/index.html" class="brand-logo">CashME <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="35" height="35" stroke-width="1">
                <path d="M15 11v.01"></path>
                <path d="M5.173 8.378a3 3 0 1 1 4.656 -1.377"></path>
                <path d="M16 4v3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342c-.336 .95 -.907 1.8 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3h0z"></path>
                </svg></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="CRUD.php">Inicio</a></li>
                <li><a href="logout_AD.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h5 class="center-align">Editar Usuario</h5>

        <?php if ($mensaje): ?>
            <p class="center-align white-text"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

            <form action="" method="POST">
                <div class="form-grid">
                    <h3 class="center-align">Información General</h3>
                    <div class="input-field">
                        <label for="usuarioNom" class="formi">Nombre</label>
                        <input type="text" name="usuarioNom" id="usuarioNom" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioApePat" class="formi">Apellido Paterno</label>
                        <input type="text" name="usuarioApePat" id="usuarioApePat" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioApeMat" class="formi">Apellido Materno</label>
                        <input type="text" name="usuarioApeMat" id="usuarioApeMat" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioTel" class="formi">Teléfono</label>
                        <input type="text" name="usuarioTel" id="usuarioTel" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioEmail" class="formi">Email</label>
                        <input type="email" name="usuarioEmail" id="usuarioEmail" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioContra" class="formi">Contraseña</label>
                        <input type="password" name="usuarioContra" id="usuarioContra" required>
                    </div>
                </div>
                <h3 class="center-align">Información de Dirección</h3>
                <div class="input-field">
                    <label for="usuarioDireccionEstado" class="formi">Estado</label>
                    <input type="text" name="usuarioDireccionEstado" id="usuarioDireccionEstado" required>
                </div>
                <div class="input-field">
                    <label for="usuarioDireccionCP" class="formi">Código Postal</label>
                    <input type="text" name="usuarioDireccionCP" id="usuarioDireccionCP" required>
                </div>
                <div class="input-field">
                    <label for="usuarioDireccioncol" class="formi">Colonia</label>
                    <input type="text" name="usuarioDireccioncol" id="usuarioDireccioncol" required>
                </div>
                <div class="input-field">
                    <label for="usuarioDireccionCalle" class="formi">Calle</label>
                    <input type="text" name="usuarioDireccionCalle" id="usuarioDireccionCalle" required>
                </div>
                <button type="submit" class="btn">Crear Usuario</button>
            </form>
    </div>
    <br>
    <br>
    <br>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="../img/logoEscom.png" alt="Logo de la empresa" class="footer-image">
            </div>
            <div class="footer-contact">
                <p>¿Necesitas ayuda?</p>
                <p>Contáctanos: contactoCashME@gmail.com</p>
            </div>
            <p>&copy; 2024-2025 CashME. Todos los derechos reservados.</p> 
        </div>
    </footer>
</body>
</html>
