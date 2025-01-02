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

    // Obtener el saldo de ahorros del usuario
    $query_saldo = "SELECT SUM(AhorroMonto) as ahorroSaldo FROM Ahorro WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $ahorroSaldo = $row_saldo['ahorroSaldo'];
?>
<!DOCTYPE html>
<html lang="en">
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
    <link rel="preload" href="css/styles_02.css" as="style">
    <link href="css/styles_02.css" rel="stylesheet">

</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="index.html" class="brand-logo">CashME <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="35" height="35" stroke-width="1">
                <path d="M15 11v.01"></path>
                <path d="M5.173 8.378a3 3 0 1 1 4.656 -1.377"></path>
                <path d="M16 4v3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342c-.336 .95 -.907 1.8 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3h0z"></path>
              </svg></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a class="sombras" href="resumen.php">Resumen</a></li>
            <li><a class="sombras" href="ingresos.php">Ingresos</a></li>
            <li><a class="sombras" href="gastos.php">Gastos</a></li>
            <li><a class="sombras" href="deudas.php">Deudas</a></li>
            <li><a class="sombras" href="ahorros.php">Ahorros</a></li>
            <li><a id="cierre" href="logout.php">   Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>
    
    <section id="tabla-resumen">
        <div>
            <div class="texto">
                <h5 class="center-align">Ahorros</h5>
                <div>
                    <form method="POST" action="">
                        <label for="AhorroDesc">Descripción del Ahorro</label>
                        <input type="text" class="ingresar" id="AhorroDesc" name="AhorroDesc" required>

                        <label for="AhorroMonto">Monto del Ahorro</label>
                        <input type="number" class="ingresar" id="AhorroMonto" name="AhorroMonto" required>

                        <label for="AhorroFecha">Fecha del Ahorro</label>
                        <input type="date" class="ingresar" id="AhorroFecha" name="AhorroFecha" required>

                        <div>
                        <button type="button" class="clear" onclick="limpiarFormulario()">Limpiar <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1">
                        <path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3"></path>
                        <path d="M18 13.3l-6.3 -6.3"></path>
                        </svg></button>
                        <button type="submit" class="save">Guardar <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1">
                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                        <path d="M14 4l0 4l-6 0l0 -4"></path>
                        </svg></button>
                        </div>
                    </form>
                </div>
            </div>
        <br>
        <br>
        <br> <!--Tabla Ahorros-->
        <div>
            <h5 class="left-align headings">Ahorros  - Saldo: <?php echo $ahorroSaldo; ?></h5>
        </div>
            <table class="highlight responsive-table">
                <tr>
                    <td><b>Descripción</b></td>
                    <td><b>Monto (MXN)</b></td>
                    <td><b>Fecha</b></td>
                <tr>
        <?php
            $consulta = "SELECT * FROM ahorro WHERE usuario_idUsuario = '$usuario_id'"; 
            $resultado = mysqli_query($conexion, $consulta);
            
            while($mostrar = mysqli_fetch_array($resultado)) {
        ?>
                <tr>
                    <td><?php echo $mostrar['AhorroDesc']; ?></td>
                    <td><?php echo $mostrar['AhorroMonto']; ?></td>
                    <td><?php echo $mostrar['AhorroFecha']; ?></td>
                </tr>
        <?php
            }            
        ?>
            </table>
        </div>
    </section>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $AhorroDesc = mysqli_real_escape_string($conexion, $_POST['AhorroDesc']);
        $AhorroMonto = $_POST['AhorroMonto'];
        $AhorroFecha = $_POST['AhorroFecha'];
    
        if (!is_numeric($AhorroMonto) || $AhorroMonto <= 0) {
            die("<p style='color: red;'>El monto debe ser un número positivo.</p>");
        }
    
        $sql = "INSERT INTO Ahorro (AhorroDesc, AhorroMonto, AhorroFecha, usuario_idUsuario) 
                VALUES ('$AhorroDesc', '$AhorroMonto', '$AhorroFecha', '$usuario_id')";
    
        if (mysqli_query($conexion, $sql)) {
            echo "<script>window.location.href='ahorros.php';</script>";
            exit();
        } else {
            echo "<p style='color: red;'>Error al guardar los datos: " . mysqli_error($conexion) . "</p>";
        }
    }    
    ?>

      <!-- Incluir el archivo externo -->
        <script src="javascript/script_02.js"></script>
        <script>
            document.getElementById('ingresoForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Evita el envío del formulario por defecto

                var formData = new FormData(this);

                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Recarga la página después de una inserción exitosa
                    window.location.href = 'ahorros.php';
                })
                .catch(error => console.error('Error:', error));
            });
        </script>

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
            </div>
        </footer>
</body>
</html>
