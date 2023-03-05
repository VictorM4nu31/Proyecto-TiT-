<?php

include "conexion.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$edad = $_POST["edad"];
$sexo = $_POST["sexo"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$contrasena = $_POST["contrasena"];

// Insertar los datos en la tabla checador_tb
$sql = "INSERT INTO checador_tb (nombre, apellido, edad, sexo, numero_telefono, correo, contrasena)
VALUES ('$nombre', '$apellido', '$edad', '$sexo', '$telefono', '$correo', '$contrasena')";

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();

// Regresar al formulario
header("Location: registro.html");
exit();

?>