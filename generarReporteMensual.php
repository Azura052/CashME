<?php
require('fpdf/fpdf.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: loginUsuario.php");
    exit;
}

$usuario_id = $_SESSION['user_id'];
$conexion = mysqli_connect("localhost", "root", "123456", "dbcashme");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'esp');

    // Obtener el mes actual en español
    $mes_actual = strftime('%B'); // Nombre completo del mes
    $anio_actual = date('Y'); // Año actual

// Obtener información del usuario
$query_usuario = "SELECT CONCAT(usuarioNom, ' ', usuarioApePat, ' ', usuarioApeMat) as nombre_completo 
                 FROM usuario WHERE idUsuario = ?";
$stmt_usuario = $conexion->prepare($query_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$usuario_data = $result_usuario->fetch_assoc();
$nombre_usuario = $usuario_data['nombre_completo'];

class PDF extends FPDF
{
    private $primaryColor = [41, 128, 185]; // Azul
    private $secondaryColor = [44, 62, 80]; // Gris oscuro
    private $accentColor = [46, 204, 113]; // Verde
    private $userName = '';
    private $isFirstPage = true; // Variable para controlar si es la primera página

    function setUserName($name) {
        $this->userName = $name;
    }

    function Header() {
        if ($this->isFirstPage) {
            $this->Image('img/logoEscom.png', 10, 10, 30);
            $this->SetFont('Arial', 'B', 20);
            $this->SetTextColor($this->primaryColor[0], $this->primaryColor[1], $this->primaryColor[2]);
            $this->Cell(0, 10, 'Resumen de Movimientos Mensual', 0, 1, 'C');
            
            $this->SetFont('Arial', '', 12);
            $this->SetTextColor($this->secondaryColor[0], $this->secondaryColor[1], $this->secondaryColor[2]);
            $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y'), 0, 1, 'C');
            $this->Ln(10);
            $this->SetFont('Arial', '', 10);
            $this->MultiCell(0, 10, 'A continuacion, se presentan los movimientos que registraste durante el mes actual. Este informe te ofrece un resumen claro y detallado de las transacciones realizadas y seguimiento de tus actividades financieras.', 0, 'J');
            $this->Ln(5); 

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Cliente: ' . $this->userName, 0, 1, 'R');
            $this->Ln(10);

            $this->isFirstPage = false; // Desactivar el encabezado para las siguientes páginas
        }
    }

    function Footer() {
        $this->SetY(-25);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor($this->secondaryColor[0], $this->secondaryColor[1], $this->secondaryColor[2]);
        
        $this->SetDrawColor($this->primaryColor[0], $this->primaryColor[1], $this->primaryColor[2]);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        
        $this->Cell(0, 10, 'CashME - Gestion Financiera Personal', 0, 1, 'C');
        $this->Cell(0, 5, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    function CategoryHeader($title, $color) {
        $this->SetFillColor($color[0], $color[1], $color[2]);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, $title, 0, 1, 'L', true);
        $this->Ln(5);
    }

    function TableHeader($header) {
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor($this->secondaryColor[0], $this->secondaryColor[1], $this->secondaryColor[2]);
        $this->SetTextColor(255, 255, 255);
        
        foreach ($header as $col) {
            $this->Cell(37, 8, $col, 1, 0, 'C', true);
        }
        $this->Ln();
    }

    function TableBody($data) {
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor($this->secondaryColor[0], $this->secondaryColor[1], $this->secondaryColor[2]);
        
        foreach ($data as $row) {
            $this->Cell(35, 7, $row[0], 1, 0, 'L');  // Descripción
            $this->Cell(35, 7, '$ ' . number_format($row[1], 2), 1, 0, 'R'); // Monto
            $this->Cell(35, 7, date('d/m/Y', strtotime($row[2])), 1, 0, 'C'); // Fecha

            // Colocar las columnas adicionales
            for ($i = 3; $i < count($row); $i++) {
                $this->Cell(45, 7, $row[$i], 1, 0, 'C');  // Extra 1, Extra 2, etc.
            }
            $this->Ln();
        }
    }
}

// Crear PDF con orientación vertical
$pdf = new PDF('P', 'mm', 'A4'); // Cambié 'L' (horizontal) a 'P' (vertical)
$pdf->setUserName($nombre_usuario); // Establecer el nombre del usuario
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);

// Configuración de las categorías con columnas reales
$headers = [
    'Ingreso' => ['IngresoDesc', 'IngresoMonto', 'IngresoFecha'],
    'Deuda' => ['DeudaDesc', 'DeudaMonto', 'DeudaFecha', 'DeudaCobro'],
    'Adeudo' => ['AdeudoDesc', 'AdeudoMonto', 'AdeudoFecha', 'AdeudoCobro', 'AdeudoEstado'],
    'Inversion' => ['InversionDesc', 'InversionMonto', 'InversionFecha', 'InversionPor', 'InversionRen'],
    'Presupuesto' => ['PresupuestoDesc', 'PresupuestoMonto', 'PresupuestoFecha', 'PresupuestoTipo'],
];

$categories = [
    'Ingreso' => [46, 204, 113], // Verde
    'Deuda' => [231, 76, 60],    // Rojo
    'Adeudo' => [230, 126, 34],  // Naranja
    'Inversion' => [52, 152, 219], // Azul
    'Presupuesto' => [128, 0, 128] // Púrpura
];

$mes_actual = date('Y-m'); // Obtener el mes y año actual en formato numérico

// Procesar cada categoría
foreach ($headers as $category => $columns) {
    $column_list = implode(", ", $columns); // Crear la lista de columnas
    $query = "SELECT $column_list 
              FROM $category 
              WHERE usuario_idUsuario = ? AND DATE_FORMAT({$columns[2]}, '%Y-%m') = ?
              ORDER BY {$columns[2]} DESC";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("is", $usuario_id, $mes_actual);
    $stmt->execute();
    $result = $stmt->get_result();

    // Preparar datos y encabezados
    $data = [];
    $total_monto = 0;
    while ($row = $result->fetch_assoc()) {
        $data[] = array_values($row); // Convertir a un array indexado
        $total_monto += $row[$columns[1]]; // Sumar el monto
    }

    // Crear encabezados para el PDF
    $dynamic_headers = ['Descripcion', 'Monto', 'Fecha'];
    for ($i = 3; $i < count($columns); $i++) {
        $dynamic_headers[] = 'Info.'; // Añadir columnas dinámicas
    }

    // Crear encabezado de la categoría
    $pdf->CategoryHeader($category . 's del Mes de ' . strftime('%B', strtotime($mes_actual . '-01')) . ' ' . $anio_actual, $categories[$category]);
    $pdf->TableHeader($dynamic_headers);

    // Crear el cuerpo de la tabla
    $pdf->TableBody($data);

    // Mostrar la suma total de la categoría
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Total ' . $category . ': $ ' . number_format($total_monto, 2), 0, 1, 'R');
    $pdf->Ln(10);
}

// Cerrar la conexión
$stmt_usuario->close();
$conexion->close();

// Salida del PDF
$pdf->Output('ResumenMensual.pdf', 'I');
?>
