<?php
  // Incluir el archivo de conexión a la base de datos
  include('conexion.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Tabla de registros</title>
  </head>
  <body>
    <h1>Tabla de registros</h1>
    
    <form method="POST">
      <label for="fecha">Selecciona una fecha:</label>
      <input type="date" name="fecha">
      <button type="submit">Mostrar registros</button>
    </form>
    
    <?php
      // Si se ha enviado el formulario de fecha
      if (isset($_POST['fecha'])) {
        // Obtener la fecha seleccionada y convertirla al formato de la base de datos
        $fecha = $_POST['fecha'];
        $fecha_db = date('Y-m-d', strtotime($fecha));
        
        // Consultar los registros de las dos tablas para la fecha seleccionada
        $sql = "SELECT hora_sal_tb.hora_sal, hora_ent_tb.hora_ent FROM hora_sal_tb INNER JOIN hora_ent_tb ON hora_sal_tb.id = hora_ent_tb.id WHERE hora_sal_tb.fecha = '$fecha_db' AND hora_ent_tb.fecha = '$fecha_db'";
        $result = $conn->query($sql);
        
        // Mostrar la tabla con los resultados
        if ($result->num_rows > 0) {
          echo "<h2>Registros para el $fecha</h2>";
          echo "<table>";
          echo "<tr><th>Hora de salida</th><th>Hora de entrada</th></tr>";
          while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["hora_sal"] . "</td><td>" . $row["hora_ent"] . "</td></tr>";
          }
          echo "</table>";
        } else {
          echo "<p>No hay registros para el $fecha.</p>";
        }
      }
      
      // Si se ha enviado el formulario de rango de fechas
      if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
        // Obtener las fechas seleccionadas y convertirlas al formato de la base de datos
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $fecha_inicio_db = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_fin_db = date('Y-m-d', strtotime($fecha_fin));
        
        // Borrar los registros de las dos tablas correspondientes al rango de fechas seleccionado
        $sql1 = "DELETE FROM hora_sal_tb WHERE fecha BETWEEN '$fecha_inicio_db' AND '$fecha_fin_db'";
        $result1 = $conn->query($sql1);
        $sql2 = "DELETE FROM hora_ent_tb WHERE fecha BETWEEN '$fecha_inicio_db' AND '$fecha_fin_db'";
      }
    ?>