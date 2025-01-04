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

    // Obtener el saldo de gastos del usuario
    $query_saldo = "SELECT SUM(GastoMonto) as gastoSaldo FROM Gasto WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $gastoSaldo = $row_saldo['gastoSaldo'];
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
    <!-- Links para aplicar css específicos para esta pestaña-->
    <link rel="preload" href="css/styles_02.css" as="style">
    <link href="css/styles_02.css" rel="stylesheet">

</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="index.html" class="brand-logo">CashME</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a class="sombras" href="resumen.php">Resumen</a></li>
                <li><a class="sombras" href="ingresos.php">Ingresos</a></li>
                <li><a class="sombras" href="gastos.php">Gastos</a></li>
                <li><a class="sombras" href="deudas.php">Deudas</a></li>
                <li><a class="sombras" href="ahorros.php">Ahorros</a></li>
                <li><a id="cierre" href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>
    
    <section id="tabla-resumen">
        <div>
            <div class="texto">
                <h5 class="center-align">Gastos <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="45" height="45" stroke-width="1">
                <path d="M21 15h-2.5c-.398 0 -.779 .158 -1.061 .439c-.281 .281 -.439 .663 -.439 1.061c0 .398 .158 .779 .439 1.061c.281 .281 .663 .439 1.061 .439h1c.398 0 .779 .158 1.061 .439c.281 .281 .439 .663 .439 1.061c0 .398 -.158 .779 -.439 1.061c-.281 .281 -.663 .439 -1.061 .439h-2.5"></path>
                <path d="M19 21v1m0 -8v1"></path>
                <path d="M13 21h-7c-.53 0 -1.039 -.211 -1.414 -.586c-.375 -.375 -.586 -.884 -.586 -1.414v-10c0 -.53 .211 -1.039 .586 -1.414c.375 -.375 .884 -.586 1.414 -.586h2m12 3.12v-1.12c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-2"></path>
                <path d="M16 10v-6c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-4c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414v6m8 0h-8m8 0h1m-9 0h-1"></path>
                <path d="M8 14v.01"></path>
                <path d="M8 17v.01"></path>
                <path d="M12 13.99v.01"></path>
                <path d="M12 17v.01"></path>
                </svg></h5>
                <div>
                    <form method="POST" action="">
                        <label for="GastoDesc">Descripción del Gasto</label>
                        <input type="text" class="ingresar" id="GastoDesc" name="GastoDesc" required>

                        <label for="GastoMonto">Monto del Gasto</label>
                        <input type="number" class="ingresar" id="GastoMonto" name="GastoMonto" required>

                        <label for="GastoFecha">Fecha del Gasto</label>
                        <input type="date" class="ingresar" id="GastoFecha" name="GastoFecha" required>

                        <label for="GastoCobro">Forma de cobro del Gasto</label>
                        <input type="text" class="ingresar" id="GastoCobro" name="GastoCobro" required>
                        <br>
                        <div>
                            <button type="button" class="clear" onclick="limpiarFormulario()">Limpiar</button>
                            <button type="submit" class="save">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        <br>
        <br>
        <br> <!--Tabla Gastos-->
        <div>
            <h5 class="left-align headings">Gastos - Saldo: <?php echo $gastoSaldo; ?></h5>
        </div>
            <table class="highlight responsive-table">
                <tr>
                    <td><b>Descripción</b></td>
                    <td><b>Monto (MXN)</b></td>
                    <td><b>Fecha</b></td>
                    <td><b>Forma de cobro del gasto</b></td>
                <tr>
        <?php
            $consulta = "SELECT * FROM gasto WHERE usuario_idUsuario = '$usuario_id'"; 
            $resultado = mysqli_query($conexion, $consulta);
            
            while($mostrar = mysqli_fetch_array($resultado)) {
        ?>
            <tr>
                <td><?php echo $mostrar['GastoDesc']; ?></td>
                <td><?php echo $mostrar['GastoMonto']; ?></td>
                <td><?php echo $mostrar['GastoFecha']; ?></td>
                <td><?php echo $mostrar['GastoCobro']; ?></td>
            </tr>
        <?php 
            }
        ?>
            </table>
        </div>
    </section>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Escapar y validar los datos recibidos
            $GastoDesc = mysqli_real_escape_string($conexion, $_POST['GastoDesc']);
            $GastoMonto = $_POST['GastoMonto'];
            $GastoFecha = $_POST['GastoFecha'];
            $GastoCobro = mysqli_real_escape_string($conexion, $_POST['GastoCobro']);
        
            // Validar que el monto sea positivo y numérico
            if (!is_numeric($GastoMonto) || $GastoMonto <= 0) {
                die("<p style='color: red;'>El monto debe ser un número positivo.</p>");
            }
        
            // Inserción en la tabla de gastos
            $sql = "INSERT INTO Gasto (GastoDesc, GastoMonto, GastoFecha, GastoCobro, usuario_idUsuario) 
                    VALUES ('$GastoDesc', '$GastoMonto', '$GastoFecha', '$GastoCobro', '$usuario_id')";
        
            // Ejecutar la consulta e informar al usuario
            if (mysqli_query($conexion, $sql)) {
                echo "<script>window.location.href='gastos.php';</script>";
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
                    window.location.href = 'ingresos.php';
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
