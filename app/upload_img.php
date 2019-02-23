<?php	

    set_time_limit(120);
	
	session_start();  		
	
	use \Gumlet\ImageResize;
	
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
		 if ( !empty($_GET['id'])) {
        $_SESSION['prdid'] = $_REQUEST['id'];
		$uploadId=$_SESSION['prdid'];
		
		}
	
					
if ( !empty($_POST)) {
$target_dir = "gallery/";
$uploadOk = 1;
$uploadId = $_SESSION['prdid'];
$FileType = strtolower(pathinfo($target_dir . basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));

// Check file size
//if ($_FILES["fileToUpload"]["size"] > 500000) {
 //	echo "<script>alert('Perdon, El archivo es muy grande.')</script>";
   // $uploadOk = 0;
//}
// Allow certain file formats

echo $FileType; 

//if($FileType != "jpg" //&& $FileType != "csv" 
//) {    
	// echo "<script>alert('Disculpe, Solo archivos JPG esta permitido.')</script>";  
    //$uploadOk = 0;
//}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "<script>alert('Disculpe, El archivo no se subio.')</script>";
 // if everything is ok, try to upload file
} else {
	
	$a = glob('gallery/'.$uploadId.'*.*',GLOB_BRACE);
	$arr_length = count($a)+1; 
	$target_file = $target_dir . $uploadId . '-'. $arr_length .'.jpg' ;
	
    if (
	move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)
	) {
 		
	include 'ImageResize.php';


	$image = new ImageResize($target_file);
	$image->resizeToBestFit(800, 600);
	$image->save($target_file);
	echo "<script>alert('El archivo se subio OK! ".$uploadId.".')</script>";
	$_SESSION['prdid'] = null;
	
	header('Location: gallery.php?id='.$uploadId.'');

		
    } else {
 		echo "<script>alert('Disculpe, Ocurrio un problema mientras se subia el archivo.')</script>";
    }
}
}
?>

<html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Galeria</title>
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
<div class="navbar" >
	<nav class="teal" role="navigation">
		<div class="nav-wrapper container valign-wrapper" ><a id="logo-container"><h5><?php echo 'Producto: '.  $uploadId ?></h5></a>
		</div>
	</nav>
</div>   

			
<div class="container valign-wrapper" style="height: 80%;">
<form action="upload_img.php" method="post" enctype="multipart/form-data">
    <h4>Seleccionar Imagen:</h4>
	<div class="form-group"> 
    <input type="file" class="btn btn-success" name="fileToUpload" id="fileToUpload">
	<hr>
    <input type="submit" class="btn btn-info" value="Subir" name="submit">
 	</div>
</form>
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