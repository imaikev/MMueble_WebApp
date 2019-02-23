<?php 
	require 'database.php';
	
	session_start();  
 					
					if(!$_SESSION['user'])  
					{  
					header("Location: login.php");//redirect to login page to secure the welcome page without login access.  
					}

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$stockError = null;
		$priceError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$stock = $_POST['stock'];
		$price = $_POST['price'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($stock)) {
			$stockError = 'Please enter Stock';
			$valid = false;
		}
		
		if (empty($price)) {
			$priceError = 'Please enter Price';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE products  set name = ?, stock = ?, price =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$stock,$price,$id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM products where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['name'];
		$stock = $data['stock'];
		$price = $data['price'];
		Database::disconnect();
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
    z-index: -1;
    bottom: 0;
    background: green;
    height: 60px;
}


</style>
</head>

<body>

	<div class="navbar">
	<nav class="teal" role="navigation">
		<div class="nav-wrapper container valign-wrapper" ><a id="logo-container"><h5>Actualizar Producto</h5></a>
		</div>
	</nav>
</div>  

<div class="container valign-wrapper" style="height: 80%;">		
    
    			<div class="span10 offset1">    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					<div class="control-group">
                        <label class="control-label">Codigo</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['id'];?>
                            </label>
                        </div>
                      </div>		
						<hr>
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Producto</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Producto" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($stockError)?'error':'';?>">
					    <label class="control-label">Stock</label>
					    <div class="controls">
					      	<input name="stock" type="text" placeholder="Stock" value="<?php echo !empty($stock)?$stock:'';?>">
					      	<?php if (!empty($stockError)): ?>
					      		<span class="help-inline"><?php echo $stockError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($priceError)?'error':'';?>">
					    <label class="control-label">Precio</label>
					    <div class="controls">
					      	<input name="price" type="text"  placeholder="Precio" value="<?php echo !empty($price)?$price:'';?>">
					      	<?php if (!empty($priceError)): ?>
					      		<span class="help-inline"><?php echo $priceError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Actualizar</button>
 						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
	
	
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
		