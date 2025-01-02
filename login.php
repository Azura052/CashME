<?php
session_start();

// Configuración de la base de datos
$db_host = 'localhost';
$db_user = 'root';  // Usuario por defecto de XAMPP
$db_password = '123456';   // Contraseña por defecto de XAMPP
$db_name = 'dbCashme';

// Crear conexión
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!$email || !$password) {
        $error_message = "Por favor, completa todos los campos";
    } else {
        try {
            // Preparar la consulta
            $stmt = $conn->prepare("SELECT * FROM usuario WHERE usuarioEmail = ? AND usuarioContra = ?");
            $stmt->execute([$email, $password]);
            
            // Verificar si existe el usuario
            if ($user = $stmt->fetch()) {
                // Usuario encontrado - Iniciar sesión
                $_SESSION['user_id'] = $user['idUsuario'];
                $_SESSION['user_name'] = $user['usuarioNom'];
                
                // Redirigir al dashboard o página principal
                header("Location: resumen.php");
                exit();
            } else {
                // Usuario no encontrado o credenciales incorrectas
                $error_message = "Correo electrónico o contraseña incorrectos";
            }
        } catch(PDOException $e) {
            $error_message = "Error al procesar la solicitud";
        }
    }
}

// Si hay errores, volver al formulario
if (isset($error_message)) {
    include 'loginUsuario.php';
    exit();
}
?>