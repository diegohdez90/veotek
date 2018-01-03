<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="icon" href="img/eo.ico" type="image/gif" sizes="16x16">
</head>


<body>

<?php
if(empty($_GET['month'])){
	echo "<META HTTP-EQUIV='REFRESH' CONTENT='5;URL=reportes.php'>
	<div class='container'>
		<div class='error row'> 
			<img id='cargando' src='img/cargando.gif'><br>
			<h2 class='text-center'>Informaci&oacute;n no recibida</h2>
		</div>
	</div>";
	return false;
}
$number_month = $_GET['month'];
$first_day = $number_month."-01";
$last_day = date("Y-m-t", strtotime($first_day));
$mes = substr($number_month, 5,7);
$meses = array('1' =>  'Enero', 
			'2' =>  'Febrero',
			'3' =>  'Marzo',
			'4' =>  'Abril',
			'5' =>  'Mayo',
			'6' =>  'Junio',
			'7' =>  'Julio',
			'8' =>  'Agosto',
			'9' =>  'Septiembre',
			'10' =>  'Octubre',
			'11' =>  'Noviembre',
			'12' =>  'Diciembre',);
$nombre_mes = $meses[$mes];
?>
<div class="container">
		<div class="row horario">
			<div class="table-responsive">
				<h3>Reporte de entradas y salidas de <?php echo $nombre_mes;?></h3>
				<table class="table">
					<tr>
						<th>ID Personal</th>
						<th>Nombre</th>
						<th>Apellidos</th>
						<th>Hora de entrada</th>
						<th>Hora de salida</th>
					</tr>
					<?php
						include('conexion.php');
						$datos = "select idpersonal,nombre,apellidos,entrada,salida from horario,personal where personal.usuario_idusuario = horario.usuario_idusuario and entrada >= '$first_day' and entrada <= '$last_day' order by entrada";
						$horario = mysql_query($datos, $conexion) or die(mysql_error());
						$totEmp = mysql_num_rows($horario);
						while ($rows = mysql_fetch_assoc($horario)) {
							echo "<tr>";
							$idpersonal = $rows['idpersonal'];
							echo "<td>".$idpersonal."</td>";
							$nombre = $rows['nombre'];
							echo "<td>".$nombre."</td>";
							$apellido = $rows['apellidos'];
							echo "<td>".$apellido."</td>";
							$entrada = $rows['entrada'];
							echo "<td>".$entrada."</td>";
							$salida = $rows['salida'];
							echo "<td>".$salida."</td>";
							echo "</tr>";
						}
						
					?>
				</table>
			</div>
		</div>
	</div>

</body>
