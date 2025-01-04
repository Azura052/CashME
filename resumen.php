<?php
    session_start(); // Inicia la sesión

    // Verifica si el usuario está logueado, si no, redirige al login
    if (!isset($_SESSION['user_id'])) {
        header("Location: loginUsuario.php");
        exit;
    }

    $usuario_id = $_SESSION['user_id']; // Obtiene el ID del usuario desde la sesión

    // Conectar a la base de datos
    $conexion = mysqli_connect("localhost", "root", "123456", "dbcashme");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Obtener el saldo de ingresos del usuario
    $query_saldo = "SELECT SUM(IngresoMonto) as ingresoSaldo FROM Ingreso WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $ingresoSaldo = $row_saldo['ingresoSaldo'];
    // Obtener el saldo de ahorros del usuario
    $query_saldo = "SELECT SUM(AhorroMonto) as ahorroSaldo FROM Ahorro WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $ahorroSaldo = $row_saldo['ahorroSaldo'];
    // Obtener el saldo de deudas del usuario
    $query_saldo = "SELECT SUM(DeudaMonto) as deudaSaldo FROM Deuda WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $deudaSaldo = $row_saldo['deudaSaldo'];
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
    <!-- Links para aplicar css basicos-->
    <link rel="preload" href="css/styles_01.css" as="style">
    <link href="css/styles_01.css" rel="stylesheet">
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
        <br> 
            <div class="texto">
                <h5 class="center-align">Resumen <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="55" height="55" stroke-width="1">
                <path d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
                <path d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
                <path d="M5 8h4"></path>
                <path d="M9 16h4"></path>
                <path d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z"></path>
                <path d="M14 9l4 -1"></path>
                <path d="M16 16l3.923 -.98"></path>
                </svg></h5>
                <p>Si deseas conocer sobre tus movimientos de este mes, puedes consultarlos generando un resumen.</p>
            </div>
            <div class="botones-reporte">
            <button class="boton-reporte">Reporte Mensual <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" 
            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1"> 
            <path d="M12 20h-6a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12v5"></path> <path d="M13 16h-7a2 2 0 0 0 -2 2"></path> 
            <path d="M15 19l3 3l3 -3"></path> <path d="M18 22v-9"></path> </svg> </button>
            <button class="boton-reporte">Reporte Quincenal <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" 
            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1"> 
            <path d="M12 20h-6a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12v5"></path> <path d="M13 16h-7a2 2 0 0 0 -2 2"></path> 
            <path d="M15 19l3 3l3 -3"></path> <path d="M18 22v-9"></path></svg> </button>
            </div>
        <br> <!--Tabla Ingresos-->
        <div>
            <h5 class="left-align headings">Ingresos  - Saldo: <?php echo $ingresoSaldo; ?></h5>
        </div>
            <table class="highlight responsive-table">
                <tr>
                    <td><b>Descripción</b></td>
                    <td><b>Monto (MXN)</b></td>
                    <td><b>Fecha</b></td>
                <tr>
        <?php
            $consulta = "SELECT * FROM ingreso WHERE usuario_idUsuario = '$usuario_id'"; 
            $resultado = mysqli_query($conexion, $consulta);
            
            while($mostrar = mysqli_fetch_array($resultado)) {
        ?>
            <tr>
                <td><?php echo $mostrar['IngresoDesc']; ?></td>
                <td><?php echo $mostrar['IngresoMonto']; ?></td>
                <td><?php echo $mostrar['IngresoFecha']; ?></td>
            </tr>
        <?php
            }
        ?>
            </table>
        <br> <!--Tabla Gastos-->
        <div>
            <h5 class="left-align headings">Gastos - Saldo: <?php echo $gastoSaldo; ?></h5>
        </div>
            <table class="highlight responsive-table">
                <tr>
                    <td><b>Descripción</b></td>
                    <td><b>Monto (MXN)</b></td>
                    <td><b>Fecha</b></td>
                    <td><b>Cobro</b></td>
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
        <br> <!--Tabla Ahorros-->
        <div>
            <h5 class="left-align headings">Ahorros - Saldo: <?php echo $ahorroSaldo; ?></h5>
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
            <br> <!--Tabla Deudas-->
        <div>
            <h5 class="left-align headings">Deudas - Saldo: <?php echo $deudaSaldo; ?></h5>
        </div>
            <table class="highlight responsive-table">
                <tr>
                    <td><b>Descripción</b></td>
                    <td><b>Monto (MXN)</b></td>
                    <td><b>Fecha de vencimiento</b></td>
                <tr>
        <?php
            $consulta = "SELECT * FROM deuda WHERE usuario_idUsuario = '$usuario_id'"; 
            $resultado = mysqli_query($conexion, $consulta);
            
            while($mostrar = mysqli_fetch_array($resultado)) {
        ?>
            <tr>
                <td><?php echo $mostrar['DeudaDesc']; ?></td>
                <td><?php echo $mostrar['DeudaMonto']; ?></td>
                <td><?php echo $mostrar['DeudaFecha']; ?></td>
            </tr>
        <?php
            }            
        ?>
            </table>
        </div>
    </section>

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
