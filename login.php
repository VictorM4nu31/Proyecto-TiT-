<?php
include "conexion.php";

// Iniciar sesión
session_start();
// Obtener los datos del formulario
//$nombre = $_POST["nombre"];
$nombre_usuario = $_POST['nombre'];
$contrasena = $_POST["contrasena"];


// Conectar a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
	die("Conexión fallida: " . mysqli_connect_error());
}

// Consultar la tabla de administradores para verificar si el usuario es un administrador
$sql = "SELECT * FROM admin_tb WHERE nombre = '$nombre_usuario' AND contrasena = '$contrasena'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // El usuario es un administrador, redirigir a "menu.html"
    header("Location: admi/menu.html");
} else {
    // Consultar la tabla de checadores para verificar si el usuario es un checador
    $sql = "SELECT * FROM checador_tb WHERE nombre = '$nombre_usuario' AND contrasena = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El usuario es un checador, redirigir a "FormHEntr.html"
        header("Location: registr_combis/menu.html");
    } else {
        // El usuario no es ni administrador ni checador
        echo '
        <script>
            alert("el usuario o contraseña no son correctos");
            window.location = "Login.html"
        </script>
        ';
    }
}

// Cerrar la conexión con la base de datos
$conn->close();

?>