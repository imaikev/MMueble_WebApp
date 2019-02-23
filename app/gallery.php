<!DOCTYPE html>

<?php
    require 'database.php';
	
	session_start();  
 					
					if(!$_SESSION['user'])  
					{  
					header("Location: login.php");//redirect to login page to secure the welcome page without login access.  
					}
					
	$admin = $_SESSION['admin'];
	
    $id =null; 
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    } 
    if ( null==$id ) {
        header("Location: index.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM products where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
    }
?>

<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Galeria</title>
  <!-- CSS  -->
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="iconfont/material-icons.css" rel="stylesheet">

  <style>
  

.parallax-container {
      height: 100%;
	  background-position: top center !important;
	  min-height:700px;
      margin-top: 100px;
      margin-bottom: 60px;
    }
	
.parallax {
    /* Full height */
     height: 100%;  
	 background-position: top center !important;
	 min-height:700px;

}
.navbar {
    overflow: hidden;
    background-color: teal;
    position: fixed; /* Set the navbar to fixed position */
    top: 0; /* Position the navbar at the top of the page */
    width: 100%; /* Full width */
}

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
    z-index: 1;
    bottom: 0;
    background: green;
    height: 60px;
}

</style>

</head>
<body>

<div class="navbar valign-wrapper">
	<nav class="teal" role="navigation">
		<div class="nav-wrapper container valign-wrapper "><a id="logo-container"><h5><?php echo $data['name'] .' '. '$' . $data['price']?></h5></a>
		</div>
		
	</nav>
</div>   
	
 <?php  
   $a = glob('gallery/'.$id.'-*.jpg',GLOB_BRACE);
	$arr_length = count($a); 
	if ($arr_length == 0) {
		
	echo '<div class="parallax-container">';
	echo ' ';
    echo '<div class="parallax" ><img src=gallery/NoImage.jpg width="50%" height="50%"></div>';
	echo ' ';
    echo '</div>';	
		
	}
	else{
	for($i=0;$i<$arr_length;$i++) 
	{ 	
	echo '<div class="parallax-container">';
	echo ' ';
    echo '<div class="parallax"><img src='.$a[$i].'  width="100%" height="100%" ></div>';
	if ($admin){
	echo '<a class="btn right" href="del_img.php?id='.$a[$i].'"><i class="material-icons">delete_forever</i></a>';
	echo ' ';
	}
	echo '</div>';	
	}
	}
?>	 

<footer class="page-footer teal">
    <div class="container" style="height: 10%;">
         <div class="col l6 s12">
 		  <div class="row">
		  <div class="form-group"> 
			<a class="btn" href="index.php"><i class="material-icons">chevron_left</i></a>
			<?php
		  if ($admin){
		  echo '<a class="btn" href="upload_img.php?id='. $id . '"><i class="material-icons">add_a_photo</i></a>';
		  }
		  ?>
			</div>
		  </div>
        </div>
    </div>
  </footer>

  <!--  Scripts-->
  <script src="js/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>
