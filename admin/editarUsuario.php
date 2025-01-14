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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link rel="preload" href="../css/styles_07.css" as="style">
    <link href="../css/styles_07.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="../cashme/index.html" class="brand-logo">CashME</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="CRUD.php">Inicio</a></li>
                <li><a href="logout_AD.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h5 class="center-align">Editar Usuario</h5>

        <?php if ($mensaje): ?>
            <p class="center-align green-text"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <?php if ($usuario): ?>
            <form action="" method="POST">
                <input type="hidden" name="idUsuario" value="<?= $usuario['idUsuario'] ?>">
                <div class="input-field">
                    <label for="usuarioNom">Nombre</label>
                    <input type="text" name="usuarioNom" id="usuarioNom" value="<?= htmlspecialchars($usuario['usuarioNom']) ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioApePat">Apellido Paterno</label>
                    <input type="text" name="usuarioApePat" id="usuarioApePat" value="<?= htmlspecialchars($usuario['usuarioApePat']) ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioApeMat">Apellido Materno</label>
                    <input type="text" name="usuarioApeMat" id="usuarioApeMat" value="<?= htmlspecialchars($usuario['usuarioApeMat']) ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioTel">Teléfono</label>
                    <input type="text" name="usuarioTel" id="usuarioTel" value="<?= htmlspecialchars($usuario['usuarioTel']) ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioEmail">Email</label>
                    <input type="email" name="usuarioEmail" id="usuarioEmail" value="<?= htmlspecialchars($usuario['usuarioEmail']) ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioContra">Contraseña</label>
                    <input type="text" name="usuarioContra" id="usuarioContra" value="<?= htmlspecialchars($usuario['usuarioContra']) ?>" required>
                </div>
                <h5>Información de Dirección</h5>
                <div class="input-field">
                    <label for="usuarioDireccionEstado">Estado</label>
                    <input type="text" name="usuarioDireccionEstado" id="usuarioDireccionEstado" value="<?= htmlspecialchars($usuarioDir['usuarioDireccionEstado'] ?? '') ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioDireccionCP">Código Postal</label>
                    <input type="text" name="usuarioDireccionCP" id="usuarioDireccionCP" value="<?= htmlspecialchars($usuarioDir['usuarioDireccionCP'] ?? '') ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioDireccioncol">Colonia</label>
                    <input type="text" name="usuarioDireccioncol" id="usuarioDireccioncol" value="<?= htmlspecialchars($usuarioDir['usuarioDireccioncol'] ?? '') ?>" required>
                </div>
                <div class="input-field">
                    <label for="usuarioDireccionCalle">Calle</label>
                    <input type="text" name="usuarioDireccionCalle" id="usuarioDireccionCalle" value="<?= htmlspecialchars($usuarioDir['usuarioDireccionCalle'] ?? '') ?>" required>
                </div>
                <button type="submit" class="btn">Actualizar</button>
                <button type="button" class="btn grey" onclick="window.location.href='CRUD.php'">Cancelar</button>
            </form>
        <?php else: ?>
            <p class="red-text">Usuario no encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
