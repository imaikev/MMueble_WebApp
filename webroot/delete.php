<?php
    require 'database.php';
    $id = 0;
     
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM products  WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: index.php");
         
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head> 
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Buscar</title>
  <!-- CSS  -->
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

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
    z-index: -1;
    bottom: 0;
    background: green;
    height: 60px;
}


</style>

</head> 

 

<body>
	<div class="navbar" style="height: 10%">
	<nav class="teal" role="navigation">
		<div class="nav-wrapper container center" ><a id="logo-container"><h5>Eliminar Producto</h5></a>
		</div>
	</nav>
</div>   
				
<div class="container valign-wrapper" style="height: 80%;">		
     
                <div class="span10 offset1">
                    <form class="form-horizontal" action="delete.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $id;?>"/>
                      <p class="alert alert-error">Esta seguro de eliminar el Producto: <?php echo $id;?>?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Si</button>
                          <a class="btn" href="index.php">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
	
	
<footer class="page-footer teal">
    <div class="container" style="height: 10%;">

    </div>
  </footer>
  
  </body>
</html>