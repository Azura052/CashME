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
    $query_saldo = "SELECT SUM(IngresoMonto) as ingresoSaldo 
                    FROM ingreso 
                    WHERE usuario_idUsuario = $usuario_id 
                    AND DATE_FORMAT(IngresoFecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $ingresoSaldo = $row_saldo['ingresoSaldo'];
    // Obtener el saldo de presupuestos del usuario
    $query_saldo = "SELECT SUM(PresupuestoMonto) as presupuestoSaldo 
                    FROM presupuesto 
                    WHERE usuario_idUsuario = $usuario_id 
                    AND DATE_FORMAT(PresupuestoFecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $presupuestoSaldo = $row_saldo['presupuestoSaldo'];
    // Obtener el saldo de deudas del usuario
    $query_saldo = "SELECT SUM(DeudaMonto) as deudaSaldo 
                    FROM deuda 
                    WHERE usuario_idUsuario = $usuario_id 
                    AND DATE_FORMAT(DeudaFecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $deudaSaldo = $row_saldo['deudaSaldo'];
    // Obtener el saldo de inversiones del usuario
    $query_saldo = "SELECT SUM(InversionMonto) as inversionSaldo 
                    FROM inversion 
                    WHERE usuario_idUsuario = $usuario_id 
                    AND DATE_FORMAT(InversionFecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $inversionSaldo = $row_saldo['inversionSaldo'];
    // Obtener el saldo de adeudos del usuario
    $query_saldo = "SELECT SUM(AdeudoMonto) as adeudoSaldo 
                    FROM adeudo 
                    WHERE usuario_idUsuario = $usuario_id 
                    AND DATE_FORMAT(AdeudoFecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $adeudoSaldo = $row_saldo['adeudoSaldo'];

    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');

    // Obtener el mes actual en español
    $mes_actual = strftime('%B'); // Nombre completo del mes
    $anio_actual = date('Y'); // Año actual
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
<nav style="background-color: orange;">
    <div class="nav-wrapper">
        <a href="index.html" class="brand-logo" style="padding-left: 15px; color: white;">
            CashME
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="35" height="35" stroke-width="1" style="vertical-align: middle;">
                <path d="M15 11v.01"></path>
                <path d="M5.173 8.378a3 3 0 1 1 4.656 -1.377"></path>
                <path d="M16 4v3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342c-.336 .95 -.907 1.8 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3h0z"></path>
            </svg>
        </a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a class="sombras" href="resumen.php" style="color: white;">Resumen</a></li>
            <li><a class="sombras" href="ingresos.php" style="color: white;">Ingresos</a></li>
            <li><a class="sombras" href="presupuestos.php" style="color: white;">Presupuestos</a></li>
            <li><a class="sombras" href="deudas.php" style="color: white;">Deudas</a></li>
            <li><a class="sombras" href="inversiones.php" style="color: white;">Inversiones</a></li>
            <li><a class="sombras" href="adeudos.php" style="color: white;">Adeudos</a></li>
            <li><a class="sombras" href="analisis.php" style="color: white;">Análisis Gráfico</a></li>
            <li><a id="cierre" href="logout.php" style="color: white;">Cerrar Sesión</a></li>
        </ul>
        <form class="right" style="margin-right: 20px; display: flex; align-items: center;">
            <input type="text" placeholder="Buscar..." 
                style="height: 35px; border-radius: 20px; border: none; padding: 0 15px; outline: none; font-size: 16px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);">
            <button type="submit" style="margin-left: 10px; background-color: white; color: orange; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; justify-content: center; align-items: center; box-shadow: 0px 2px 5px rgba(255, 255, 255, 0.2); cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </form>
    </div>
</nav>
 
    <section id="tabla-resumen">
        <div>
        <br> 
            <div class="texto">
                <h5 class="center-align">Resumen - <?php echo $mes_actual . ' ' . $anio_actual; ?> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="55" height="55" stroke-width="1">
                <path d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
                <path d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
                <path d="M5 8h4"></path>
                <path d="M9 16h4"></path>
                <path d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z"></path>
                <path d="M14 9l4 -1"></path>
                <path d="M16 16l3.923 -.98"></path>
                </svg></h5>
                <p>Si deseas conocer sobre tus movimientos de este mes, puedes consultarlos generando un resumen.</p>
                <p>¡No olvides que CashME está aquí para ayudarte a mejorar tus finanzas personales!</p>
                <p>*Recuerda que los todos tus movimientos son separados en movimientos quincenales.*</p>
            </div>
            <div class="botones-reporte">
            <button class="boton-reporte" onclick="window.location.href='generarReporteMensual.php'">Reporte Mensual <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" 
            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1"> 
            <path d="M12 20h-6a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12v5"></path> <path d="M13 16h-7a2 2 0 0 0 -2 2"></path> 
            <path d="M15 19l3 3l3 -3"></path> <path d="M18 22v-9"></path> </svg> </button>
            <button class="boton-reporte" onclick="window.location.href='generarReporteQuincenal.php'">Reporte Quincenal <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" 
            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="1"> 
            <path d="M12 20h-6a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12v5"></path> <path d="M13 16h-7a2 2 0 0 0 -2 2"></path> 
            <path d="M15 19l3 3l3 -3"></path> <path d="M18 22v-9"></path></svg> </button>
            </div>
        <br><!--Tabla Ingresos-->
        <div>
            <h5 class="left-align headings">Ingresos - Saldo Total: <?php echo $ingresoSaldo; ?> MXN</h5>
        </div>
        <table class="highlight responsive-table">
            <?php
            // Obtener los ingresos del usuario del mes actual
            $consulta = "SELECT * FROM ingreso 
                        WHERE usuario_idUsuario = '$usuario_id' 
                        AND DATE_FORMAT(IngresoFecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m') 
                        ORDER BY IngresoFecha DESC";
            $resultado = mysqli_query($conexion, $consulta);

            $ingresos = [];
            while ($mostrar = mysqli_fetch_array($resultado)) {
                $ingresos[] = $mostrar;
            }

            // Separar los ingresos por quincenas
            $quincena_1 = [];
            $quincena_2 = [];

            foreach ($ingresos as $ingreso) {
                $dia = (int)date('d', strtotime($ingreso['IngresoFecha']));
                if ($dia <= 15) {
                    $quincena_1[] = $ingreso;
                } else {
                    $quincena_2[] = $ingreso;
                }
            }

            // Función para mostrar las tablas de quincenas
            function mostrarQuincena($titulo, $quincena) {
                if (!empty($quincena)) {
                    $suma = array_reduce($quincena, function ($carry, $item) {
                        return $carry + $item['IngresoMonto'];
                    }, 0);
                    echo "<h5 class='left-align headings1'>$titulo - Total: $suma MXN</h5>";
                    echo "<table class='highlight responsive-table'>";
                    echo "<tr>
                            <td><b>Descripción</b></td>
                            <td><b>Monto (MXN)</b></td>
                            <td><b>Fecha</b></td>
                        </tr>";
                    foreach ($quincena as $ingreso) {
                        echo "<tr>
                                <td>{$ingreso['IngresoDesc']}</td>
                                <td>{$ingreso['IngresoMonto']}</td>
                                <td>{$ingreso['IngresoFecha']}</td>
                            </tr>";
                    }
                    echo "</table><br>";
                }
            }

            // Mostrar los ingresos divididos en quincenas
            mostrarQuincena('Primera Quincena', $quincena_1);
            mostrarQuincena('Segunda Quincena', $quincena_2);
            ?>
        </table>

        <br><!--Tabla Presupuestos-->
        <div>
            <h5 class="left-align headings">Presupuestos - Saldo Total: <?php echo $presupuestoSaldo; ?> MXN</h5>
        </div>
        <table class="highlight responsive-table">
            <?php
            // Obtener los presupuestos del usuario del mes actual
            $consulta = "SELECT * FROM presupuesto 
                        WHERE usuario_idUsuario = '$usuario_id' 
                        AND DATE_FORMAT(PresupuestoFecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m') 
                        ORDER BY PresupuestoFecha DESC";
            $resultado = mysqli_query($conexion, $consulta);

            $presupuestos = [];
            while ($mostrar = mysqli_fetch_array($resultado)) {
                $presupuestos[] = $mostrar;
            }

            // Separar los presupuestos por quincenas
            $quincena_1 = [];
            $quincena_2 = [];

            foreach ($presupuestos as $presupuesto) {
                $dia = (int)date('d', strtotime($presupuesto['PresupuestoFecha']));
                if ($dia <= 15) {
                    $quincena_1[] = $presupuesto;
                } else {
                    $quincena_2[] = $presupuesto;
                }
            }

            // Función para mostrar las tablas de quincenas
            function mostrarQuincenaPresupuesto($titulo, $quincena) {
                if (!empty($quincena)) {
                    $suma = array_reduce($quincena, function ($carry, $item) {
                        return $carry + $item['PresupuestoMonto'];
                    }, 0);
                    echo "<h5 class='left-align headings1'>$titulo - Total: $suma MXN</h5>";
                    echo "<table class='highlight responsive-table'>";
                    echo "<tr>
                            <td><b>Descripción</b></td>
                            <td><b>Monto (MXN)</b></td>
                            <td><b>Fecha</b></td>
                            <td><b>Tipo de presupuesto</b></td>
                        </tr>";
                    foreach ($quincena as $presupuesto) {
                        echo "<tr>
                                <td>{$presupuesto['PresupuestoDesc']}</td>
                                <td>{$presupuesto['PresupuestoMonto']}</td>
                                <td>{$presupuesto['PresupuestoFecha']}</td>
                                <td>{$presupuesto['PresupuestoTipo']}</td>
                            </tr>";
                    }
                    echo "</table><br>";
                }
            }

            // Mostrar los presupuestos divididos en quincenas
            mostrarQuincenaPresupuesto('Primera Quincena', $quincena_1);
            mostrarQuincenaPresupuesto('Segunda Quincena', $quincena_2);
            ?>
        </table>

        <br> <!--Tabla Inversiones-->
        <div>
            <h5 class="left-align headings">Inversiones - Saldo Total: <?php echo $inversionSaldo; ?> MXN</h5>
        </div>
        <table class="highlight responsive-table">
            <?php
            // Obtener las inversiones del usuario del mes actual
            $consulta = "SELECT * FROM inversion 
                        WHERE usuario_idUsuario = '$usuario_id' 
                        AND DATE_FORMAT(InversionFecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m') 
                        ORDER BY InversionFecha DESC";
            $resultado = mysqli_query($conexion, $consulta);

            $inversiones = [];
            while ($mostrar = mysqli_fetch_array($resultado)) {
                $inversiones[] = $mostrar;
            }

            // Separar las inversiones por quincenas
            $quincena_1 = [];
            $quincena_2 = [];

            foreach ($inversiones as $inversion) {
                $dia = (int)date('d', strtotime($inversion['InversionFecha']));
                if ($dia <= 15) {
                    $quincena_1[] = $inversion;
                } else {
                    $quincena_2[] = $inversion;
                }
            }

            // Función para mostrar las tablas de quincenas
            function mostrarQuincenaInversion($titulo, $quincena) {
                if (!empty($quincena)) {
                    $suma = array_reduce($quincena, function ($carry, $item) {
                        return $carry + $item['InversionMonto'];
                    }, 0);
                    echo "<h5 class='left-align headings1'>$titulo - Total: $suma MXN</h5>";
                    echo "<table class='highlight responsive-table'>";
                    echo "<tr>
                            <td><b>Descripción</b></td>
                            <td><b>Monto (MXN)</b></td>
                            <td><b>Fecha</b></td>
                            <td><b>Porcentaje de Retorno</b></td>
                            <td><b>Rendimiento MXN</b></td>
                        </tr>";
                    foreach ($quincena as $inversion) {
                        echo "<tr>
                                <td>{$inversion['InversionDesc']}</td>
                                <td>{$inversion['InversionMonto']}</td>
                                <td>{$inversion['InversionFecha']}</td>
                                <td>{$inversion['InversionPor']}%</td>
                                <td>{$inversion['InversionRen']}</td>
                            </tr>";
                    }
                    echo "</table><br>";
                }
            }

            // Mostrar las inversiones divididas en quincenas
            mostrarQuincenaInversion('Primera Quincena', $quincena_1);
            mostrarQuincenaInversion('Segunda Quincena', $quincena_2);
            ?>
        </table>

        <br> <!--Tabla Adeudos-->
        <div>
            <h5 class="left-align headings">Adeudos - Saldo Total: <?php echo $adeudoSaldo; ?> MXN</h5>
        </div>
        <table class="highlight responsive-table">
            <?php
            // Obtener los adeudos del usuario del mes actual
            $consulta = "SELECT * FROM adeudo 
                        WHERE usuario_idUsuario = '$usuario_id' 
                        AND DATE_FORMAT(AdeudoFecha, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m') 
                        ORDER BY AdeudoFecha DESC";
            $resultado = mysqli_query($conexion, $consulta);

            $adeudos = [];
            while ($mostrar = mysqli_fetch_array($resultado)) {
                $adeudos[] = $mostrar;
            }

            // Separar los adeudos por quincenas
            $quincena_1 = [];
            $quincena_2 = [];

            foreach ($adeudos as $adeudo) {
                $dia = (int)date('d', strtotime($adeudo['AdeudoFecha']));
                if ($dia <= 15) {
                    $quincena_1[] = $adeudo;
                } else {
                    $quincena_2[] = $adeudo;
                }
            }

            // Función para mostrar las tablas de quincenas
            function mostrarQuincenaAdeudo($titulo, $quincena) {
                if (!empty($quincena)) {
                    $suma = array_reduce($quincena, function ($carry, $item) {
                        return $carry + $item['AdeudoMonto'];
                    }, 0);
                    echo "<h5 class='left-align headings1'>$titulo - Total: $suma MXN</h5>";
                    echo "<table class='highlight responsive-table'>";
                    echo "<tr>
                            <td><b>Descripción</b></td>
                            <td><b>Monto (MXN)</b></td>
                            <td><b>Fecha de Vencimiento</b></td>
                            <td><b>Entidad acreedora</b></td>
                            <td><b>Estado</b></td>
                        </tr>";
                        foreach ($quincena as $adeudo) {
                            $estado_color = $adeudo['AdeudoEstado'] == 'Pagado' ? 'green-text' : 'red-text';
                            echo "<tr class='{$estado_color}'>
                                <td>{$adeudo['AdeudoDesc']}</td>
                                <td>{$adeudo['AdeudoMonto']}</td>
                                <td>{$adeudo['AdeudoFecha']}</td>
                                <td>{$adeudo['AdeudoCobro']}</td>
                                <td>{$adeudo['AdeudoEstado']}</td>
                            </tr>";
                    }
                    echo "</table><br>";
                }
            }

            // Mostrar los adeudos divididos en quincenas
            mostrarQuincenaAdeudo('Primera Quincena', $quincena_1);
            mostrarQuincenaAdeudo('Segunda Quincena', $quincena_2);
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

