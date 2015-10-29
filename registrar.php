<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

	<?php

	if(empty($_POST['usuario']) || empty($_POST['clave'])){
		echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=index.php'>
		<div class='container'>
			<div class='error row'> 
				<img id='cargando' src='img/cargando.gif'><br>
				<h2 class='text-center'>Informaci&oacute;n no recibida</h2>
			</div>
		</div>";
		return false;
	}
	include('conexion.php')
	$dia = date("Y-m-d H:i:sa");
	$usuario = $_POST['usuario'];
	$clave = $_POST['clave'];

		/*Obtener id del sistema*/
		$id_system = "select idusuario from usuario where nombre = '$usuario'";
		$resEmp = mysql_query($id_system, $conexion) or die(mysql_error());
		$total = mysql_num_rows($resEmp);
		if($total==1){	
			while ($rowEmp = mysql_fetch_assoc($resEmp)) {
				$id_system = $rowEmp['idusuario'];
			}
			$acceder = "select * from personal where idpersonal = '$clave' and usuario_idusuario = '$id_system'";
			$resAcceder = mysql_query($acceder, $conexion) or die(mysql_error());
			$total = mysql_num_rows($resAcceder);
			if($total==1){
				$sql = "select * from horario where usuario_idusuario = '$id_system' and salida IS NULL";
				/*$sql = "insert into horario(entrada,usuario_idusuario) values('$dia','$id_system')";*/
				$if_exist_entrada = mysql_query($sql, $conexion) or die(mysql_error());
				$total = mysql_num_rows($if_exist_entrada);
				if ($total==1) {

					while ($rowEmp = mysql_fetch_assoc($if_exist_entrada)) {
						$entrada = $rowEmp['entrada'];
						$sql = "UPDATE horario SET salida='$dia' WHERE usuario_idusuario='$id_system' and entrada = '$entrada'";
						$resultado = mysql_query($sql, $conexion) or die(mysql_error());
					}
					
				}
				else{

					echo "Insertando horario<br>";
					$sql = "insert into horario(entrada,usuario_idusuario) values('$dia','$id_system')";
					$resultado = mysql_query($sql, $conexion) or die(mysql_error());

				}
			}
			else{
				echo "<div class='container'>
					<div class='error row'> 
						<img id='cargando' src='img/cargando.gif'><br>
						<h2 class='text-center'>Numero de empleado no encontrado. Revisa tu numero de empleado</h2>
					</div>
				</div>";
			}
					
		}	
		else{
		echo "<div class='container'>
		<div class='error row'> 
			<img id='cargando' src='img/cargando.gif'><br>
			<h2 class='text-center'>ID de usuario no encontrado. Revisa tu nombre de usuario</h2>
		</div>
	</div>";
		}



		

	?>

</body>
