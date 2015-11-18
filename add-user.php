<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="icon" href="img/eo.ico" type="image/gif" sizes="16x16">
<META HTTP-EQUIV="REFRESH" CONTENT="5;URL=administrador.php">
</head>


<body>


<?php
	if ( !empty($_POST)) {
		$idError = null;
        $nameError = null;
        $lastnameError = null;
        $modeError = null;
        $photoError = null;
        $userError = null;

        $id = $_POST['id'];
        $name = $_POST['nombre'];
        $lastname = $_POST['apellidos'];
        $mode = $_POST['privilegios'];
        $username = $_POST['usuario'];

        $valid = true;
        if (empty($id)) {
            $idError = 'De un id de personal';
            $valid = false;
        }
         
        if (empty($name)) {
            $nameError = 'De un nombre';
            $valid = false;
        }
        
        if (empty($lastname)) {
            $lastnameError = 'De un nombre';
            $valid = false;
        }
         
        
	$picture_tmp = $_FILES['image']['tmp_name'];
    $picture_name = $_FILES['image']['name'];
    $picture_type = $_FILES['image']['type'];

    $allowed_type = array('image/png', 'image/gif', 'image/jpg', 'image/jpeg');

    if(in_array($picture_type, $allowed_type)) {
        $path = 'img/profiles/'.$picture_name; //change this to your liking
         move_uploaded_file($picture_tmp, $path);
    } else {
        $error[] = 'File type not allowed';
        $valid=false;
    }


       

        

		
        // insert data
        if ($valid) {
        	include('conexion.php');

        	$exist_user = "select count(*) from usuario where nombre='$username'";
        	$results = mysql_query($exist_user, $conexion) or die(mysql_error());
        	$total = mysql_num_rows($results);

        	if($total>0){
        		echo "<div class='container'>
						<div class='error row'> 
							<img id='cargando' src='img/cargando.gif'><br>
							<h2 class='text-center'>Clave de empleado repetido</h2>
						</div>
					</div>";
					return false;
        	}

        	$insert_user = "insert into usuario(nombre) values('$username') ";
        	$insert_new_user = mysql_query($insert_user, $conexion) or die(mysql_error());
        	
			$new_id_user = "select idusuario from usuario where nombre = '$username'";
			$result = mysql_query($new_id_user, $conexion) or die(mysql_error());
			$total = mysql_num_rows($result);

			if($total == 1){
				while ($rows = mysql_fetch_assoc($result)) {
					$id_system = $rows['idusuario'];
				}


				$exist_w = "select count(*) as veces from personal where idpersonal='$id'";
	        	$results = mysql_query($exist_w, $conexion) or die(mysql_error());
	        	$total = mysql_num_rows($results);

	        	if($total>0){
	        		echo "<div class='container'>
							<div class='error row'> 
								<img id='cargando' src='img/cargando.gif'><br>
								<h2 class='text-center'>Clave de empleado repetido</h2>
							</div>
						</div>";
						return false;
	        	}



				$sql = "insert into personal(idpersonal,nombre,apellidos,foto,privilegios_idprivilegios,usuario_idusuario) values('$id','$name','$lastname','$path','$mode','$id_system')";
				$resultado = mysql_query($sql, $conexion) or die(mysql_error());

				echo "<div class='container'>
						<div class='error row'> 
							<img id='cargando' src='img/cargando.gif'><br>
							<h2 class='text-center'>Informaci&oacute;n recibida correctamente</h2>
						</div>
					</div>";
			}
        }
        else{
    	echo "<div class='container'>
			<div class='error row'> 
				<img id='cargando' src='img/cargando.gif'><br>
				<h2 class='text-center'>Informaci&oacute;n no recibida</h2>
			</div>
		</div>";
		return false;
    	}
    }
    

    
?>

</body>