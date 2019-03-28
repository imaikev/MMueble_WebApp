<?php

set_time_limit(1900);

	
	session_start();  
				
	if(!$_SESSION['user'])  
		{  
		
		header("Location: login.php");//redirect to login page to secure the welcome page without login access.  
		}					
					else
					{
						if ($_SESSION['admin'] != 1)
						{
								header("Location: index.php");
						}
					}
					
if ( !empty($_POST)) {
 
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
 	echo "<script>alert('Perdon, El archivo es muy grande.')</script>";
    $uploadOk = 0;
}

// Allow certain file formats
if($FileType != "txt" && $FileType != "csv" ) {
    
	 echo "<script>alert('Perdon, Solo TXT o CSV esta permitido.')</script>";  
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "<script>alert('Perdon, El archivo no se subio.')</script>";
 // if everything is ok, try to upload file
} else {
	
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		
require 'database.php';
  
$txt_file    = file_get_contents($target_file);

$rows = str_replace('"', '', explode("\n", $txt_file));

array_shift($rows);

 $pdo = Database::connect();
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $pdo->setAttribute(PDO::ATTR_TIMEOUT, 90);
  
	$sql = 'DELETE FROM PRD.STG_PRODUCTS';
	$q = $pdo->query($sql);
 
 $sql = "INSERT INTO PRD.STG_PRODUCTS VALUES (?, ?, ?, ?,?)";
 $q = $pdo->prepare($sql);
 $count = 0;
 
 echo "<script>alert('El archivo se esta procesando ....')</script>";

			
foreach($rows as $row => $data)
{
    //get row data
    $row_data = explode(',', $data);
	
	if (!empty($row_data[0])){
 	
    $info[$row]['id']           = $row_data[0];
    $info[$row]['name']         = $row_data[1];
    $info[$row]['stock']  		= $row_data[2];
	//$info[$row]['list']       	= $row_data[3];
	$info[$row]['price']       	= $row_data[4];
	//$info[$row]['total']       	= $row_data[5];
	//$info[$row]['moneda']       	= $row_data[6];
	$info[$row]['store']       	= $row_data[7];
	
	 $q->execute(array($info[$row]['id'],$info[$row]['name'],$info[$row]['stock'],$info[$row]['price'],$info[$row]['store']));
     $count += 1; 
	} 
}
		
	$sql = 'DELETE FROM PRD.PRODUCTS';
	$q = $pdo->query($sql);
		
		
	$sql = 'INSERT INTO PRD.PRODUCTS SELECT * FROM PRD.STG_PRODUCTS';
	$q = $pdo->query($sql);

	Database::disconnect();
	
	unlink($target_file);
	
	echo "<script>alert('Se Procesaron $count registros....')</script>";
		
    } else {		
	
 		echo "<script>alert('Perdon, Ocurrio un problema ## ". $_FILES["fileToUpload"]["error"] . " ## mientras se subia el archivo')</script>"; 
    }
}
}
?>

<html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Actualizar Base</title>
  <!-- CSS  -->
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="iconfont/material-icons.css" rel="stylesheet">

	<style>

body {
    margin: 0;
}

header {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: -1;
    height: 100px;
    background: cyan;
}
.wrapper-parallax {
    margin-top: 100px;
    margin-bottom: 60px;
}
.content {
    position: relative;
    z-index: 1;
    border-top: 1px solid black;
    border-bottom: 1px solid black; 
    background: white;
    min-height: 500px;
}
footer {
    width: 100%;
    position: fixed;
    bottom: 0;
    background: green;
    height: 60px;
}


</style>
</head>

<body>
	<div class="navbar valign-wrapper">
	<nav class="teal" role="navigation">
		<div class="nav-wrapper container valign-wrapper" ><a id="logo-container"><h5>Actualizar Base de Datos</h5></a>
		</div>
	</nav>
</div>   
		
		
<div class="container valign-wrapper" style="height: 80%;">
<form action="update_db.php" method="post" enctype="multipart/form-data">
    <h4>Seleccionar Archivo:</h4>
	<div class="form-group"> 
    <input type="file" class="btn btn-success" name="fileToUpload" id="fileToUpload">
	<hr>
    <input type="submit" class="btn btn-info" value="Actualizar" name="submit">
 	</div>
	<h6>NOTA: Se debe subir el reporte con el detalle por depositos...</h6>
	</form>
</div>
</div>


</div>

 <footer class="page-footer teal">
    <div class="container" style="height: 10%;">
         <div class="col l6 s12">
 		  <div class="row">
		  <div class="form-group"> 
			<a class="btn" href="index.php"><i class="material-icons">chevron_left</i></a>
			</div>
		  </div>
        </div>
    </div>
  </footer>
  
</body>
</html>