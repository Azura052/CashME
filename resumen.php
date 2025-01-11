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
    // Obtener el saldo de presupuestos del usuario
    $query_saldo = "SELECT SUM(PresupuestoMonto) as presupuestoSaldo FROM Presupuesto WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $presupuestoSaldo = $row_saldo['presupuestoSaldo'];
    // Obtener el saldo de deudas del usuario
    $query_saldo = "SELECT SUM(DeudaMonto) as deudaSaldo FROM Deuda WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $deudaSaldo = $row_saldo['deudaSaldo'];

    // Obtener el saldo de inversiones del usuario
    $query_saldo = "SELECT SUM(InversionMonto) as inversionSaldo FROM Inversion WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $inversionSaldo = $row_saldo['inversionSaldo'];

    // Obtener el saldo de adeudos del usuario
    $query_saldo = "SELECT SUM(AdeudoMonto) as adeudoSaldo FROM Adeudo WHERE usuario_idUsuario = $usuario_id";
    $result_saldo = mysqli_query($conexion, $query_saldo);
    $row_saldo = mysqli_fetch_assoc($result_saldo);
    $adeudoSaldo = $row_saldo['adeudoSaldo'];
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
<!--TODO: Cambiar aqui lo de la busqueda-->
        <!-- Formulario de búsqueda -->
        <form action="" method="GET">
        <input type="text" name="query" placeholder="Escribe tu búsqueda aquí">
        <button type="submit">Buscar</button>
    </form>
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
            <li><a class="sombras" href="presupuestos.php">Presupuestos</a></li>
            <li><a class="sombras" href="deudas.php">Deudas</a></li>
            <li><a class="sombras" href="inversiones.php">Inversiones</a></li>
            <li><a class="sombras" href="adeudos.php">Adeudos</a></li>
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
        <br> <!--Tabla Ingresos-->
        <div>
            <h5 class="left-align headings">Ingresos - Saldo Total: <?php echo $ingresoSaldo; ?> MXN</h5>
        </div>
            <table class="highlight responsive-table">
                <?php
                // Obtener los ingresos del usuario
                $consulta = "SELECT * FROM ingreso WHERE usuario_idUsuario = '$usuario_id' ORDER BY IngresoFecha ASC"; 
                $resultado = mysqli_query($conexion, $consulta);

                $ingresos = [];
                while($mostrar = mysqli_fetch_array($resultado)) {
                    $ingresos[] = $mostrar;
                }

                // Separar los ingresos en periodos de 15 días
                $periodos = [];
                $periodo_actual = [];
                $fecha_inicio = null;

                foreach ($ingresos as $ingreso) {
                    $fecha_ingreso = new DateTime($ingreso['IngresoFecha']);
                    if ($fecha_inicio === null) {
                        $fecha_inicio = $fecha_ingreso;
                    }

                    $intervalo = $fecha_inicio->diff($fecha_ingreso)->days;
                    if ($intervalo < 15) {
                        $periodo_actual[] = $ingreso;
                    } else {
                        $periodos[] = $periodo_actual;
                        $periodo_actual = [$ingreso];
                        $fecha_inicio = $fecha_ingreso;
                    }
                }

                if (!empty($periodo_actual)) {
                    $periodos[] = $periodo_actual;
                }

                // Mostrar las tablas de ingresos por periodos de 15 días
                foreach ($periodos as $index => $periodo) {
                    $suma_periodo = array_reduce($periodo, function($carry, $item) {
                        return $carry + $item['IngresoMonto'];
                    }, 0);
                    echo "<h5 class='left-align headings1'>Total: $suma_periodo MXN</h5>";
                    echo "<table class='highlight responsive-table'>";
                    echo "<tr>
                            <td><b>Descripción</b></td>
                            <td><b>Monto (MXN)</b></td>
                            <td><b>Fecha</b></td>
                          </tr>";

                    foreach ($periodo as $ingreso) {
                        echo "<tr>
                                <td>{$ingreso['IngresoDesc']}</td>
                                <td>{$ingreso['IngresoMonto']}</td>
                                <td>{$ingreso['IngresoFecha']}</td>
                              </tr>";
                    }

                    echo "</table><br>";
                }
            ?>
            </table>
        <br> <!--Tabla Presupuestos-->
        <div>
            <h5 class="left-align headings">Presupuestos - Saldo Total: <?php echo $presupuestoSaldo; ?> MXN</h5>
        </div>
            <table class="highlight responsive-table">
            <?php
                // Obtener los presupuestos del usuario
                $consulta = "SELECT * FROM presupuesto WHERE usuario_idUsuario = '$usuario_id' ORDER BY PresupuestoFecha ASC"; 
                $resultado = mysqli_query($conexion, $consulta);

                $presupuestos = [];
                while($mostrar = mysqli_fetch_array($resultado)) {
                    $presupuestos[] = $mostrar;
                }

                // Separar los presupuestos en periodos de 15 días
                $periodos = [];
                $periodo_actual = [];
                $fecha_inicio = null;

                foreach ($presupuestos as $presupuesto) {
                    $fecha_presupuesto = new DateTime($presupuesto['PresupuestoFecha']);
                    if ($fecha_inicio === null) {
                        $fecha_inicio = $fecha_presupuesto;
                    }

                    $intervalo = $fecha_inicio->diff($fecha_presupuesto)->days;
                    if ($intervalo < 15) {
                        $periodo_actual[] = $presupuesto;
                    } else {
                        $periodos[] = $periodo_actual;
                        $periodo_actual = [$presupuesto];
                        $fecha_inicio = $fecha_presupuesto;
                    }
                }

                if (!empty($periodo_actual)) {
                    $periodos[] = $periodo_actual;
                }

                // Mostrar las tablas de presupuestos por periodos de 15 días
                foreach ($periodos as $index => $periodo) {
                    $suma_periodo = array_reduce($periodo, function($carry, $item) {
                        return $carry + $item['PresupuestoMonto'];
                    }, 0);
                    echo "<h5 class='left-align headings1'>Total: $suma_periodo MXN</h5>";
                    echo "<table class='highlight responsive-table'>";
                    echo "<tr>
                            <td><b>Descripción</b></td>
                            <td><b>Monto (MXN)</b></td>
                            <td><b>Fecha</b></td>
                            <td><b>Tipo de presupuesto</b></td>
                          </tr>";

                    foreach ($periodo as $presupuesto) {
                        echo "<tr>
                                <td>{$presupuesto['PresupuestoDesc']}</td>
                                <td>{$presupuesto['PresupuestoMonto']}</td>
                                <td>{$presupuesto['PresupuestoFecha']}</td>
                                <td>{$presupuesto['PresupuestoTipo']}</td>
                              </tr>";
                    }

                    echo "</table><br>";
                }
            ?>
            </table>
            <br> <!--Tabla Deudas-->
            <div>
                <h5 class="left-align headings">Deudas - Saldo Total: <?php echo $deudaSaldo; ?> MXN</h5>
            </div>
            <table class="highlight responsive-table">
                <?php
                    // Obtener las deudas del usuario
                    $consulta = "SELECT * FROM deuda WHERE usuario_idUsuario = '$usuario_id' ORDER BY DeudaFecha ASC"; 
                    $resultado = mysqli_query($conexion, $consulta);

                    $deudas = [];
                    while($mostrar = mysqli_fetch_array($resultado)) {
                        $deudas[] = $mostrar;
                    }

                    // Separar las deudas en periodos de 15 días
                    $periodos = [];
                    $periodo_actual = [];
                    $fecha_inicio = null;

                    foreach ($deudas as $deuda) {
                        $fecha_deuda = new DateTime($deuda['DeudaFecha']);
                        if ($fecha_inicio === null) {
                            $fecha_inicio = $fecha_deuda;
                        }

                        $intervalo = $fecha_inicio->diff($fecha_deuda)->days;
                        if ($intervalo < 15) {
                            $periodo_actual[] = $deuda;
                        } else {
                            $periodos[] = $periodo_actual;
                            $periodo_actual = [$deuda];
                            $fecha_inicio = $fecha_deuda;
                        }
                    }

                    if (!empty($periodo_actual)) {
                        $periodos[] = $periodo_actual;
                    }

                    // Mostrar las tablas de deudas por periodos de 15 días
                    foreach ($periodos as $index => $periodo) {
                        $suma_periodo = array_reduce($periodo, function($carry, $item) {
                            return $carry + $item['DeudaMonto'];
                        }, 0);
                        echo "<h5 class='left-align headings1'>Total: $suma_periodo MXN</h5>";
                        echo "<table class='highlight responsive-table'>";
                        echo "<tr>
                                <td><b>Descripción</b></td>
                                <td><b>Monto (MXN)</b></td>
                                <td><b>Fecha</b></td>
                                <td><b>Deuda</b></td>
                            </tr>";

                        foreach ($periodo as $deuda) {
                            echo "<tr>
                                    <td>{$deuda['DeudaDesc']}</td>
                                    <td>{$deuda['DeudaMonto']}</td>
                                    <td>{$deuda['DeudaFecha']}</td>
                                    <td>{$deuda['DeudaCobro']}</td>
                                </tr>";
                        }

                        echo "</table><br>";
                    }
                ?>
            </table>
            <br> <!--Tabla Inversiones-->
            <div>
                <h5 class="left-align headings">Inversiones - Saldo Total: <?php echo $inversionSaldo; ?> MXN</h5>
            </div>
            <table class="highlight responsive-table">
                <?php
                    // Obtener las inversiones del usuario
                    $consulta = "SELECT * FROM inversion WHERE usuario_idUsuario = '$usuario_id' ORDER BY InversionFecha ASC"; 
                    $resultado = mysqli_query($conexion, $consulta);

                    $inversiones = [];
                    while($mostrar = mysqli_fetch_array($resultado)) {
                        $inversiones[] = $mostrar;
                    }

                    // Separar las inversiones en periodos de 15 días
                    $periodos = [];
                    $periodo_actual = [];
                    $fecha_inicio = null;

                    foreach ($inversiones as $inversion) {
                        $fecha_inversion = new DateTime($inversion['InversionFecha']);
                        if ($fecha_inicio === null) {
                            $fecha_inicio = $fecha_inversion;
                        }

                        $intervalo = $fecha_inicio->diff($fecha_inversion)->days;
                        if ($intervalo < 15) {
                            $periodo_actual[] = $inversion;
                        } else {
                            $periodos[] = $periodo_actual;
                            $periodo_actual = [$inversion];
                            $fecha_inicio = $fecha_inversion;
                        }
                    }

                    if (!empty($periodo_actual)) {
                        $periodos[] = $periodo_actual;
                    }

                    // Mostrar las tablas de inversiones por periodos de 15 días
                    foreach ($periodos as $index => $periodo) {
                        $suma_periodo = array_reduce($periodo, function($carry, $item) {
                            return $carry + $item['InversionMonto'];
                        }, 0);
                        echo "<h5 class='left-align headings1'>Total: $suma_periodo MXN</h5>";
                        echo "<table class='highlight responsive-table'>";
                        echo "<tr>
                                <td><b>Descripción</b></td>
                                <td><b>Monto (MXN)</b></td>
                                <td><b>Fecha</b></td>
                                <td><b>Porcentaje de rendimiento</b></td>
                                <td><b>Rendimiento esperado MXN</b></td>
                            </tr>";

                        foreach ($periodo as $inversion) {
                            echo "<tr>
                                    <td>{$inversion['InversionDesc']}</td>
                                    <td>{$inversion['InversionMonto']}</td>
                                    <td>{$inversion['InversionFecha']}</td>
                                    <td>{$inversion['InversionPor']}</td>
                                    <td>{$inversion['InversionRen']}</td>
                                </tr>";
                        }

                        echo "</table><br>";
                    }
                ?>
            </table>
            <br> <!--Tabla Adeudos-->
            <div>
                <h5 class="left-align headings">Adeudos - Saldo Total: <?php echo $adeudoSaldo; ?> MXN</h5>
            </div>
            <table class="highlight responsive-table">
                <?php
                    // Obtener los adeudos del usuario
                    $consulta = "SELECT * FROM adeudo WHERE usuario_idUsuario = '$usuario_id' ORDER BY AdeudoFecha ASC"; 
                    $resultado = mysqli_query($conexion, $consulta);

                    $adeudos = [];
                    while($mostrar = mysqli_fetch_array($resultado)) {
                        $adeudos[] = $mostrar;
                    }

                    // Separar los adeudos en periodos de 15 días
                    $periodos = [];
                    $periodo_actual = [];
                    $fecha_inicio = null;

                    foreach ($adeudos as $adeudo) {
                        $fecha_adeudo = new DateTime($adeudo['AdeudoFecha']);
                        if ($fecha_inicio === null) {
                            $fecha_inicio = $fecha_adeudo;
                        }

                        $intervalo = $fecha_inicio->diff($fecha_adeudo)->days;
                        if ($intervalo < 15) {
                            $periodo_actual[] = $adeudo;
                        } else {
                            $periodos[] = $periodo_actual;
                            $periodo_actual = [$adeudo];
                            $fecha_inicio = $fecha_adeudo;
                        }
                    }

                    if (!empty($periodo_actual)) {
                        $periodos[] = $periodo_actual;
                    }

                    // Mostrar las tablas de adeudos por periodos de 15 días
                    foreach ($periodos as $index => $periodo) {
                        $suma_periodo = array_reduce($periodo, function($carry, $item) {
                            return $carry + $item['AdeudoMonto'];
                        }, 0);
                        echo "<h5 class='left-align headings1'>Total: $suma_periodo MXN</h5>";
                        echo "<table class='highlight responsive-table'>";
                        echo "<tr>
                                <td><b>Descripción</b></td>
                                <td><b>Monto (MXN)</b></td>
                                <td><b>Fecha</b></td>
                                <td><b>Entidad acreedora</b></td>
                                <td><b>Estado del adeudo</b></td>
                            </tr>";

                        foreach ($periodo as $adeudo) {
                            echo "<tr>
                                    <td>{$adeudo['AdeudoDesc']}</td>
                                    <td>{$adeudo['AdeudoMonto']}</td>
                                    <td>{$adeudo['AdeudoFecha']}</td>
                                    <td>{$adeudo['AdeudoCobro']}</td>
                                    <td>{$adeudo['AdeudoEstado']}</td>
                                </tr>";
                        }

                        echo "</table><br>";
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

