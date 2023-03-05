<?php
// Conexión a la base de datos
$dsn = "mysql:host=localhost;dbname=bd_tranzit";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectarse a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario
$id_transporte = $_POST['id_transporte'];
$ruta = $_POST['ruta'];
$hr_ent = $_POST['hr_ent']; 
$fecha = $_POST['fecha'];
$id_checador = $_POST['id_checador'];
$id_conductor = $_POST['id_conductor'];

// Verificar que los ids existen en las tablas correspondientes
$checador_query = "SELECT * FROM checador_tb WHERE id_checador = ?";
$checador_stmt = $pdo->prepare($checador_query);
$checador_stmt->execute([$id_checador]);
$checador_result = $checador_stmt->fetch();

$conductor_query = "SELECT * FROM registro_personal_tb WHERE id_conductor = ?";
$conductor_stmt = $pdo->prepare($conductor_query);
$conductor_stmt->execute([$id_conductor]);
$conductor_result = $conductor_stmt->fetch();

if (!$checador_result || !$conductor_result) {
    echo "<script>alert('Los ids de checador o conductor no existen en las tablas correspondientes. Intente de nuevo.')</script>";
    echo "<script>window.location.href='FormHEntr.html'</script>";
    exit();
}

// Insertar los datos en la tabla hora_ent_tb
$insert_query = "INSERT IGNORE INTO hora_ent_tb (id_trans, ruta, hr_ent, fecha, id_checador, id_conductor) VALUES (?, ?, ?, ?, ?, ?)"; 
$insert_stmt = $pdo->prepare($insert_query);
try {
    $insert_stmt->execute([$id_transporte, $ruta, $hr_ent, $fecha, $id_checador, $id_conductor]); 

    // Mostrar mensaje de éxito
    echo '
    <script>
        alert("el registro se hizo correctamente");
        window.location = "FormHEntr.html"
    </script>
    ';
    exit;
} catch (PDOException $e) {
    echo "<script>alert('Error al insertar los datos: " . $e->getMessage() . "')</script>";
    echo "<script>window.location.href='FormHEntr.html'</script>";
    exit();
}

?>