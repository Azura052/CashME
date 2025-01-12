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

    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');

    // Obtener el mes actual en español
    $mes_actual = strftime('%B'); // Nombre completo del mes
    $anio_actual = date('Y'); // Año actual

    // Conectar a la base de datos
    $conexion = mysqli_connect("localhost", "root", "123456", "dbcashme");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $query = "SELECT 
                    MONTH(IngresoFecha) AS mes, 
                    SUM(IngresoMonto) AS ingresos, 
                    SUM(PresupuestoMonto) AS presupuestos, 
                    SUM(DeudaMonto) AS deudas, 
                    SUM(InversionMonto) AS inversiones, 
                    SUM(AdeudoMonto) AS adeudos
                  FROM 
                    (SELECT IngresoFecha, IngresoMonto, 0 AS PresupuestoMonto, 0 AS DeudaMonto, 0 AS InversionMonto, 0 AS AdeudoMonto FROM Ingreso WHERE usuario_idUsuario = $usuario_id
                     UNION ALL
                     SELECT PresupuestoFecha, 0, PresupuestoMonto, 0, 0, 0 FROM Presupuesto WHERE usuario_idUsuario = $usuario_id
                     UNION ALL
                     SELECT DeudaFecha, 0, 0, DeudaMonto, 0, 0 FROM Deuda WHERE usuario_idUsuario = $usuario_id
                     UNION ALL
                     SELECT InversionFecha, 0, 0, 0, InversionMonto, 0 FROM Inversion WHERE usuario_idUsuario = $usuario_id
                     UNION ALL
                     SELECT AdeudoFecha, 0, 0, 0, 0, AdeudoMonto FROM Adeudo WHERE usuario_idUsuario = $usuario_id) AS movimientos
                  GROUP BY mes";

        $result = $conexion->query($query);
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo '<script>const backendData = ' . json_encode($data) . ';</script>';
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
            <li><a class="sombras" href="presupuestos.php">Presupuestos</a></li>
            <li><a class="sombras" href="deudas.php">Deudas</a></li>
            <li><a class="sombras" href="inversiones.php">Inversiones</a></li>
            <li><a class="sombras" href="adeudos.php">Adeudos</a></li>
            <li><a class="sombras" href="analisis.php">Analisis Grafico</a></li>
            <li><a id="cierre" href="logout.php">   Cerrar Sesión</a></li>
            </ul>
        </div>
        </nav>
        <br>
        <br>
        <h5 style="text-align: center;" class="center-align">Analisis de Movimientos <?php echo $anio_actual; ?> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="55" height="55" stroke-width="1">
        <path d="M3 13a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
        <path d="M15 9a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
        <path d="M9 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
        <path d="M4 20h14"></path>
        </svg></h5>

        <div class="chart-container" style="width: 80%; max-width: 800px; margin: auto;">
            <canvas id="barChart"></canvas>
        </div>
        <br>
        <br>
        <br>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
        function processData(data) {
            const months = [];
            const categories = { Ingresos: [], Presupuestos: [], Deudas: [], Inversiones: [], Adeudos: [] };
            data.sort((a, b) => a.mes - b.mes); // Ordenar los datos por mes

            data.forEach(entry => {
                months.push(new Date(0, entry.mes - 1).toLocaleString('en', { month: 'long' }));
                categories.Ingresos.push(entry.ingresos);
                categories.Presupuestos.push(entry.presupuestos);
                categories.Deudas.push(entry.deudas);
                categories.Inversiones.push(entry.inversiones);
                categories.Adeudos.push(entry.adeudos);
            });

            return { months, categories };
        }

        const { months, categories } = processData(backendData);

        const barChartConfig = {
            type: 'bar',
            data: {
                labels: months,
                datasets: Object.entries(categories).map(([key, values], index) => ({
                    label: key,
                    data: values,
                    backgroundColor: `rgba(${50 * index}, ${100 + 20 * index}, ${150 - 10 * index}, 0.7)`
                }))
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Graficos de movimientos por mes'
                    }
                },
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const barCtx = document.getElementById('barChart').getContext('2d');

        new Chart(barCtx, barChartConfig);
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
