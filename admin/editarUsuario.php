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
    $idUsuario = $_POST['idUsuario'];
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

    // Actualizar datos del usuario
    $sqlUsuario = "UPDATE usuario 
                   SET usuarioNom = ?, usuarioApePat = ?, usuarioApeMat = ?, usuarioTel = ?, usuarioEmail = ?, usuarioContra = ? 
                   WHERE idUsuario = ?";
    $stmtUsuario = $conn->prepare($sqlUsuario);
    $stmtUsuario->bind_param("ssssssi", $usuarioNom, $usuarioApePat, $usuarioApeMat, $usuarioTel, $usuarioEmail, $usuarioContra, $idUsuario);

    if ($stmtUsuario->execute()) {
        // Actualizar datos de la dirección
        $sqlDir = "UPDATE usuarioDir 
                   SET usuarioDireccionEstado = ?, usuarioDireccionCP = ?, usuarioDireccioncol = ?, usuarioDireccionCalle = ? 
                   WHERE usuario_idUsuario = ?";
        $stmtDir = $conn->prepare($sqlDir);
        $stmtDir->bind_param("ssssi", $usuarioDireccionEstado, $usuarioDireccionCP, $usuarioDireccioncol, $usuarioDireccionCalle, $idUsuario);

        if ($stmtDir->execute()) {
            $mensaje = "¡Los datos se han actualizado correctamente!";
        } else {
            $mensaje = "Error al actualizar la dirección: " . $stmtDir->error;
        }
    } else {
        $mensaje = "Error al actualizar los datos del usuario: " . $stmtUsuario->error;
    }

    $stmtUsuario->close();
    $stmtDir->close();
}

// Consultar los datos para mostrarlos en el formulario
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];

    $sql = "SELECT * FROM usuario WHERE idUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    $sqlDir = "SELECT * FROM usuarioDir WHERE usuario_idUsuario = ?";
    $stmtDir = $conn->prepare($sqlDir);
    $stmtDir->bind_param("i", $idUsuario);
    $stmtDir->execute();
    $resultDir = $stmtDir->get_result();
    $usuarioDir = $resultDir->fetch_assoc();

    $stmt->close();
    $stmtDir->close();
}

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
            <a href="CRUD.php" class="brand-logo" style="display: flex; align-items: center; justify-content: center;">CashME <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="35" height="35" stroke-width="1">
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
        <h5 class="center-align">Editar Usuario <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="45" height="45" stroke-width="1"> <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path> <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path> <path d="M16 5l3 3"></path> </svg></h5>

        <?php if ($mensaje): ?>
            <p class="center-align white-text"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <?php if ($usuario): ?>
            <form action="" method="POST">
                <input type="hidden" name="idUsuario" value="<?= $usuario['idUsuario'] ?>">
                <div class="form-grid">
                <h3 class="center-align" >Información General</h3>
                    <div class="input-field">
                        <label for="usuarioNom" class="formi">Nombre</label>
                        <input type="text" name="usuarioNom" id="usuarioNom" value="<?= htmlspecialchars($usuario['usuarioNom']) ?>" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioApePat" class="formi">Apellido Paterno</label>
                        <input type="text" name="usuarioApePat" id="usuarioApePat" value="<?= htmlspecialchars($usuario['usuarioApePat']) ?>" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioApeMat" class="formi">Apellido Materno</label>
                        <input type="text" name="usuarioApeMat" id="usuarioApeMat" value="<?= htmlspecialchars($usuario['usuarioApeMat']) ?>" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioTel" class="formi">Teléfono</label>
                        <input type="text" name="usuarioTel" id="usuarioTel" value="<?= htmlspecialchars($usuario['usuarioTel']) ?>" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioEmail" class="formi">Email</label>
                        <input type="email" name="usuarioEmail" id="usuarioEmail" value="<?= htmlspecialchars($usuario['usuarioEmail']) ?>" required>
                    </div>
                    <div class="input-field">
                        <label for="usuarioContra" class="formi">Contraseña</label>
                        <input type="text" name="usuarioContra" id="usuarioContra" value="<?= htmlspecialchars($usuario['usuarioContra']) ?>" required>
                    </div>
                </div>
                <h3 class="center-align" >Información de Dirección</h3>
                <div class="input-field">
                    <label for="usuarioDireccionEstado" class="formi">Estado</label>
                    <input type="text" name="usuarioDireccionEstado" id="usuarioDireccionEstado" value="<?= htmlspecialchars($usuarioDir['usuarioDireccionEstado'] ?? '') ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioDireccionCP" class="formi">Código Postal</label>
                    <input type="text" name="usuarioDireccionCP" id="usuarioDireccionCP" value="<?= htmlspecialchars($usuarioDir['usuarioDireccionCP'] ?? '') ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioDireccioncol" class="formi">Colonia</label>
                    <input type="text" name="usuarioDireccioncol" id="usuarioDireccioncol" value="<?= htmlspecialchars($usuarioDir['usuarioDireccioncol'] ?? '') ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioDireccionCalle" class="formi">Calle</label>
                    <input type="text" name="usuarioDireccionCalle" id="usuarioDireccionCalle" value="<?= htmlspecialchars($usuarioDir['usuarioDireccionCalle'] ?? '') ?>" required>
                </div>
                <button type="submit" class="btn" style="display: flex; align-items: center; justify-content: center;">Actualizar <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1">
                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                <path d="M13.5 6.5l4 4"></path>
                <path d="M15 19l2 2l4 -4"></path>
                </svg></button>
                <button type="button" class="botoncito" onclick="window.location.href='CRUD.php'" style="display: flex; align-items: center; justify-content: center;">CANCELAR <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1" style="margin-left: 5px;">
                <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                <path d="M10 8l4 8"></path>
                <path d="M10 16l4 -8"></path>
                </svg></button>
            </form>
        <?php else: ?>
            <p class="red-text">Usuario no encontrado.</p>
        <?php endif; ?>
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
