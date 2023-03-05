<?php 
require('Conexion.php');
	$data=new Conexion();
	$conexion=$data->conect();
	$strquery ="SELECT * FROM hora_ent_tb";
	$result = $conexion->prepare($strquery);
	$result->execute();
	$data = $result->fetchall(PDO::FETCH_ASSOC);
	
	var_dump($data);
 ?>