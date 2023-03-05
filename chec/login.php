<?php
    session_start();
    require("conexion.php");

    // RECIBE LOS DATOS DE LA APP
    $nombre = $_POST['username'];
    $contrasena = $_POST['password'];

// Conectar a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
	die("Conexión fallida: " . mysqli_connect_error());
}
// Consultar la tabla de usuarios
$sql = "SELECT * FROM checador_tb WHERE nombre = '$nombre' AND contrasena = '$contrasena'";
$resultado = mysqli_query($conn, $sql);

// Verificar si se encontró un usuario con los datos ingresados

// Verificar si se encontró un usuario con esas credenciales
if (mysqli_num_rows($resultado) == 1) {
	// Iniciar sesión
	$_SESSION['nombre'] = $nombre;
	header('Location: ../registr_combis/horario_combi.html');
	exit();
} else {
	// Mostrar un mensaje de error si las credenciales son incorrectas
	echo  '
    <script>
        alert("el usuario o contraseña no son correctos");
        window.location = "checador.html"
    </script>
    ';
    exit;
}
mysqli_close($conn);
?>