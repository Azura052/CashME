<?php
session_start();
session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión
header("Location: loginAdmin.php"); // Redirige a la página de inicio de sesión
exit();
?>
