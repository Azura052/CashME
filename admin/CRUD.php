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

// Eliminar usuario si se recibe la solicitud
if (isset($_GET['eliminar']) && isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);

    // Iniciar la transacción
    $conn->begin_transaction();

    try {
        // Tablas relacionadas
        $tables = ['Ingreso', 'Deuda', 'Adeudo', 'Inversion', 'Presupuesto', 'usuarioDir'];

        // Eliminar datos relacionados
        foreach ($tables as $table) {
            $sql = "DELETE FROM $table WHERE usuario_idUsuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idUsuario);
            $stmt->execute();
        }

        // Eliminar el usuario
        $sql = "DELETE FROM usuario WHERE idUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();

        // Confirmar transacción
        $conn->commit();
        $mensaje = "Usuario eliminado correctamente.";
            echo "<script>
            setTimeout(function() {
                var messageElement = document.querySelector('.card-panel');
                if (messageElement) {
                messageElement.style.display = 'none';
                }
            }, 10000);
            window.location.href = 'CRUD.php';
            </script>";
        } catch (Exception $e) {
        $conn->rollback();
        $mensaje = "Error al eliminar usuario: " . $e->getMessage();
        }
    }

    // Consulta para obtener los datos de los usuarios
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $sql = "SELECT idUsuario, usuarioNom, usuarioApePat, usuarioApeMat, usuarioTel, usuarioEmail, usuarioSesion FROM usuario WHERE usuarioNom LIKE ? OR usuarioApePat LIKE ? OR usuarioApeMat LIKE ? OR usuarioEmail LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchParam = '%' . $search . '%';
    $stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CashME - Finanzas personales</title>
        <!-- Materialize -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;700&family=Montserrat:wght@100;900&display=swap" rel="stylesheet">
        <!-- CSS personalizado -->
        <link rel="preload" href="../css/styles_06.css" as="style">
        <link href="../css/styles_06.css" rel="stylesheet">
    </head>
    <body>
        <nav>
        <div class="nav-wrapper">
            <a href="../cashme/index.html" class="brand-logo" style="display: flex; align-items: center; justify-content: center;">CashME <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="35" height="35" stroke-width="1">
            <path d="M15 11v.01"></path>
            <path d="M5.173 8.378a3 3 0 1 1 4.656 -1.377"></path>
            <path d="M16 4v3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342c-.336 .95 -.907 1.8 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3h0z"></path>
            </svg></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="CRUD.php">Inicio</a></li>
            <li><a id="cierre" href="logout_AD.php">Cerrar Sesión</a></li>
            </ul>
        </div>
        </nav>

        <div class="container" style="width: 100%;">
        <h5 class="center-align">Lista de Usuarios <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="45" height="45" stroke-width="1">
        <path d="M9 6l11 0"></path>
        <path d="M9 12l11 0"></path>
        <path d="M9 18l11 0"></path>
        <path d="M5 6l0 .01"></path>
        <path d="M5 12l0 .01"></path>
        <path d="M5 18l0 .01"></path>
        </svg></h5>

        <!-- Barra de búsqueda -->
        <form method="GET" action="CRUD.php">
            <div class="search-bar">
            <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Buscar usuario">
            <button type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="30" height="30" stroke-width="1"> <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path> <path d="M21 21l-6 -6"></path> </svg> 
            </button>
            </div>
        </form>
        <br>

        <!-- Botón para agregar usuario -->
        <a href="agregarUsuario.php" class="btn orange" style="display: flex; align-items: center; justify-content: left; width: 200px; height: 50px;">Agregar Usuario <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1">
        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
        <path d="M12 11l0 6"></path>
        <path d="M9 14l6 0"></path>
        </svg></a>
        <br>
        <br>

        <!-- Mostrar mensaje si existe -->
        <?php if (isset($mensaje)): ?>
            <div class="card-panel <?= strpos($mensaje, 'Error') === false ? 'green' : 'red' ?> white-text">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <table class="striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Ultimo inicio de sesión</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row["idUsuario"] ?></td>
                            <td><?= $row["usuarioNom"] ?></td>
                            <td><?= $row["usuarioApePat"] ?></td>
                            <td><?= $row["usuarioApeMat"] ?></td>
                            <td><?= $row["usuarioTel"] ?></td>
                            <td><?= $row["usuarioEmail"] ?></td>
                            <td><?= $row["usuarioSesion"] ?></td>
                            <td>
                                <a href="editarUsuario.php?id=<?= $row["idUsuario"] ?>" class="btn">Editar <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1"> <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path> <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path> <path d="M16 5l3 3"></path> </svg> </a>
                                <a href="?eliminar=1&id=<?= $row["idUsuario"] ?>" class="btn red">Eliminar <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1">
                                <path d="M4 7l16 0"></path>
                                <path d="M10 11l0 6"></path>
                                <path d="M14 11l0 6"></path>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8">No hay usuarios registrados</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
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
