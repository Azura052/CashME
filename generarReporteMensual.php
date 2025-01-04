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
    // Colores corporativos
    private $primaryColor = [41, 128, 185]; // Azul
    private $secondaryColor = [44, 62, 80]; // Gris oscuro
    private $accentColor = [46, 204, 113]; // Verde
    private $userName = '';

    function setUserName($name) {
        $this->userName = $name;
    }

    function Header()
    {
    
        $this->Image('img/logoEscom.png', 10, 10, 30);
        
        // Título principal
        $this->SetFont('Arial', 'B', 20);
        $this->SetTextColor($this->primaryColor[0], $this->primaryColor[1], $this->primaryColor[2]);
        $this->Cell(0, 10, 'Resumen de Movimientos Mensual', 0, 1, 'C');
        
        // Subtítulo con fecha
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor($this->secondaryColor[0], $this->secondaryColor[1], $this->secondaryColor[2]);
        $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y'), 0, 1, 'C');
        $this->Ln(10); // Añadir espacio entre los párrafos
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, 'A continuacion, se presentan los movimientos que registraste durante los ultimos 30 dias. Este informe te ofrece un resumen claro y detallado de las transacciones realizadas y seguimiento de tus actividades financieras.', 0, 'J');
        $this->Ln(5); // Añadir espacio entre los párrafos

        // Información del usuario
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Cliente: ' . $this->userName, 0, 1, 'R');
        
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-25);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor($this->secondaryColor[0], $this->secondaryColor[1], $this->secondaryColor[2]);
        
        // Línea divisoria
        $this->SetDrawColor($this->primaryColor[0], $this->primaryColor[1], $this->primaryColor[2]);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        
        // Pie de página
        $this->Cell(0, 10, 'CashMe - Gestion Financiera Personal', 0, 1, 'C');
        $this->Cell(0, 5, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    function CategoryHeader($title, $color)
    {
        $this->SetFillColor($color[0], $color[1], $color[2]);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, $title, 0, 1, 'L', true);
        $this->Ln(5);
    }

    function TableHeader($header)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor($this->secondaryColor[0], $this->secondaryColor[1], $this->secondaryColor[2]);
        $this->SetTextColor(255, 255, 255);
        
        $this->Cell(80, 8, $header[0], 1, 0, 'C', true);
        $this->Cell(50, 8, $header[1], 1, 0, 'C', true);
        $this->Cell(50, 8, $header[2], 1, 1, 'C', true);
    }

    function TableBody($data)
    {
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor($this->secondaryColor[0], $this->secondaryColor[1], $this->secondaryColor[2]);
        $fill = false;
        
        $total = 0;
        foreach ($data as $row) {
            $this->Cell(80, 7, $row[0], 1, 0, 'L', $fill);
            $this->Cell(50, 7, '$ ' . number_format($row[1], 2), 1, 0, 'R', $fill);
            $this->Cell(50, 7, date('d/m/Y', strtotime($row[2])), 1, 1, 'C', $fill);
            $total += $row[1];
            $fill = !$fill;
        }
        
        // Total de la categoría
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(80, 8, 'Total:', 1, 0, 'R');
        $this->Cell(50, 8, '$ ' . number_format($total, 2), 1, 0, 'R');
        $this->Cell(50, 8, '', 1, 1, 'C');
        
        $this->Ln(10);
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->setUserName($nombre_usuario); // Establecer el nombre del usuario
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 30);

// Definir categorías y sus colores
$categories = [
    'Ingreso' => [46, 204, 113], // Verde
    'Ahorro' => [52, 152, 219],  // Azul
    'Gasto' => [231, 76, 60],    // Rojo
    'Deuda' => [230, 126, 34]    // Naranja
];
$mes_actual = date('m/Y'); // Obtener el mes y año actual en formato numérico

foreach ($categories as $category => $color) {
    $pdf->CategoryHeader($category . 's del Mes de ' . $mes_actual, $color);
    
    $header = ['Descripcion', 'Monto', 'Fecha'];
    $pdf->TableHeader($header);

    $query = "SELECT {$category}Desc, {$category}Monto, {$category}Fecha 
              FROM $category 
              WHERE usuario_idUsuario = ? AND {$category}Fecha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
              ORDER BY {$category}Fecha DESC";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            $row["{$category}Desc"],
            $row["{$category}Monto"],
            $row["{$category}Fecha"]
        ];
    }

    $pdf->TableBody($data);
}

// Cerrar la conexión a la base de datos
$stmt_usuario->close();
$conexion->close();

$pdf->Output('ResumenMensual.pdf', 'I');
?>