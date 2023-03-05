<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "bd_tranzit"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$id_conductor = $_POST["id_conductor"];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$edad = $_POST["edad"];
$sexo = $_POST["sexo"];

// Insertar datos en la tabla registro_personal_tb
$sql = "INSERT INTO registro_personal_tb (id_conductor, nombre, apellido, edad, sexo)
VALUES ('$id_conductor', '$nombre', '$apellido', '$edad', '$sexo')";

if ($conn->query($sql) === TRUE) {
  echo "Registro exitoso";
} else {
  echo "Error al registrar datos: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
