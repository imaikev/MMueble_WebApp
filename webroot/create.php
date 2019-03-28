<?php
     
    require 'database.php';
	
	session_start();  
 					
					if(!$_SESSION['user'] )  
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
        // keep track validation errors
		$nameId = null;
        $nameError = null;
        $stockError = null;
        $priceError = null;
         
        // keep track post values
        $id = $_POST['id'];
        $name = $_POST['name'];
        $stock = $_POST['stock'];
        $price = $_POST['price'];
         
        // validate input
        $valid = true;
		
		if (empty($id)) {
            $nameId = 'Ingrese Id';
            $valid = false;
        }
		
        if (empty($name)) {
            $nameError = 'Ingrese Producto';
            $valid = false;
        }
         
        if (empty($stock)) {
            $stockError = 'Ingrese Stock';
            $valid = false;
        }
         
        if (empty($price)) {
            $priceError = 'Ingrese Precio';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO products (id,name,stock,price) values(?,?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($id,$name,$stock,$price));
            Database::disconnect();
            header("Location: index.php");
        }
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
    z-index: 0;
    bottom: 0;
    background: green;
    height: 60px;
}

</style>

</head>
 
<body>
	<div class="navbar valign-wrapper" >
	<nav class="teal" role="navigation">
		<div class="nav-wrapper container valign-wrapper" ><a id="logo-container"><h5>Alta de Producto</h5></a>
		</div>
		
	</nav>
</div>   
		
<main>	

<div class="container valign-wrapper" >		
 
                    <div class="span30 offset2">    					
                    <form class="form-horizontal " action="create.php" method="post">
					<hr>
					 <div class="control-group <?php echo !empty($idError)?'error':'';?>">
                        <label class="control-label">Id</label>
                        <div class="controls">
                            <input name="id" type="text"  placeholder="id" value="<?php echo !empty($id)?$id:'';?>">
                            <?php if (!empty($idError)): ?>
                                <span class="help-inline"><?php echo $idError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Producto</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Producto" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Stock</label>
                        <div class="controls">
                            <input name="stock" type="text" placeholder="Stock" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                        <label class="control-label">Precio</label>
                        <div class="controls">
                            <input name="price" type="text"  placeholder="Precio" value="<?php echo !empty($mobile)?$mobile:'';?>">
                            <?php if (!empty($mobileError)): ?>
                                <span class="help-inline"><?php echo $mobileError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Alta</button>
                         </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
	
	</main>
<footer class="page-footer teal">
    <div class="container">
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