<?php
require_once 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de trabajadores</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <h1>Lista de trabajadores</h1>
  <table>
    <thead>
      <tr>
        <th>ID Checador</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Edad</th>
        <th>Sexo</th>
        <th>Número de teléfono</th>
        <th>Correo electrónico</th>
        <th>Contraseña</th>
        <th>ID Admin</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $stmt = $pdo->prepare("SELECT * FROM checador_tb");
      $stmt->execute();
      $trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($trabajadores as $trabajador) {
        echo '<tr>';
        echo '<td>' . $trabajador['id_checador'] . '</td>';
        echo '<td>' . $trabajador['nombre'] . '</td>';
        echo '<td>' . $trabajador['apellido'] . '</td>';
        echo '<td>' . $trabajador['edad'] . '</td>';
        echo '<td>' . $trabajador['sexo'] . '</td>';
        echo '<td>' . $trabajador['numero_telefono'] . '</td>';
        echo '<td>' . $trabajador['correo'] . '</td>';
        echo '<td>' . $trabajador['contrasena'] . '</td>';
        echo '<td>' . $trabajador['id_admin'] . '</td>';
        echo '<td><a href="editar.php?id=' . $trabajador['id_checador'] . '">Editar</a> | <a href="eliminar.php?id=' . $trabajador['id_checador'] . '">Eliminar</a></
