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

    // Obtener el saldo de deudas del usuario
    $query_saldo = "SELECT SUM(DeudaMonto) as deudaSaldo FROM Deuda WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $deudaSaldo = $row_saldo['deudaSaldo'];
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
                <li><a id="cierre" href="logout.php">  Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>
    
    <section id="tabla-resumen">
        <div>
            <div class="texto">
                <h5 class="center-align">Deudas <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="45" height="45" stroke-width="1">
                <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2m4 -14h6m-6 4h6m-2 4h2"></path>
                </svg></h5>
                <div>
                    <form method="POST" action="">
                        <label for="DeudaDesc">Descripción de la Deuda</label>
                        <input type="text" class="ingresar" id="DeudaDesc" name="DeudaDesc" required>

                        <label for="DeudaMonto">Monto de la Deuda</label>
                        <input type="number" class="ingresar" id="DeudaMonto" name="DeudaMonto" required>

                        <label for="DeudaFecha">Fecha de la Deuda</label>
                        <input type="date" class="ingresar" id="DeudaFecha" name="DeudaFecha" required>

                        <div>
                            <button type="button" class="clear" onclick="limpiarFormulario()">Limpiar</button>
                            <button type="submit" class="save">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        <br>
        <br>
        <br>
        <!-- Tabla Deudas -->
        <div>
            <h5 class="left-align headings">Deudas - Saldo: <?php echo $deudaSaldo; ?></h5>
        </div>
        <table class="tablaDeudas">
        <thead>
            <tr>
                <th><b>Descripción</b></th>
                <th><b>Monto (MXN)</b></th>
                <th><b>Fecha</b></th>
                <th><b>Acciones</b></th>
            </tr>
        </thead>
        <tbody id="tabla-deudas">
        <?php
        $consulta = "SELECT * FROM Deuda WHERE usuario_idUsuario = '$usuario_id'";
        $resultado = mysqli_query($conexion, $consulta);
        while ($mostrar = mysqli_fetch_array($resultado)) {
        ?>
        <tr data-id="<?php echo $mostrar['idDeuda']; ?>">
            <td class="desc" contenteditable="false"><?php echo $mostrar['DeudaDesc']; ?></td>
            <td class="monto" contenteditable="false"><?php echo $mostrar['DeudaMonto']; ?></td>
            <td class="fecha" contenteditable="false"><?php echo $mostrar['DeudaFecha']; ?></td>
            <td>
                <button class="editar" type="button">Editar</button>
                <button class="guardar" type="button" style="display:none;">Guardar</button>
                <button class="eliminar" type="button">Eliminar</button>
            </td>
        </tr>
        <?php
        }
        ?>
        </tbody>
        </table>
        </section>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Escapar y validar los datos recibidos
            $DeudaDesc = mysqli_real_escape_string($conexion, $_POST['DeudaDesc']);
            $DeudaMonto = $_POST['DeudaMonto'];
            $DeudaFecha = $_POST['DeudaFecha'];
        
            // Validar que el monto sea positivo y numérico
            if (!is_numeric($DeudaMonto) || $DeudaMonto <= 0) {
                die("<p style='color: red;'>El monto debe ser un número positivo.</p>");
            }
        
            // Inserción en la tabla de deudas
            $sql = "INSERT INTO Deuda (DeudaDesc, DeudaMonto, DeudaFecha, usuario_idUsuario) 
                    VALUES ('$DeudaDesc', '$DeudaMonto', '$DeudaFecha', '$usuario_id')";
        
            // Ejecutar la consulta e informar al usuario
            if (mysqli_query($conexion, $sql)) {
                echo "<script>window.location.href='deudas.php';</script>";
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

        <!-- FOOTER -->
    <br>
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