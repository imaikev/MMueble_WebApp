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
        $sql = "SELECT  id,name,price,SUM(stock) as stock  FROM products where id = ? group by 1,2,3";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
				
		$sql2 = 'SELECT id,name,price,store,stock FROM products where id = ?';
		$s = $pdo->prepare($sql2);
		$s->execute(array($id));	
 		
        Database::disconnect();
		
		
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Detalle Producto</title>
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

<body>
	<div class="navbar" >
	<nav class="teal" role="navigation">
		<div class="nav-wrapper container valign-wrapper teal" ><a id="logo-container"><h5>Detalle</h5></a>
		</div>
	</nav>
</div>  
<div class="container valign-wrapper" style="height: 80%;">	 
 
                     <div class="form-horizontal">
					 <hr>
 					 <div class="control-group">
                        <label class="control-label">Codigo</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['id'];?>
                            </label>
                       </div>
                      </div>		
					  
						<hr>
                       <div class="control-group">
                        <label class="control-label">Producto</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['name'];?>
                            </label>
                        </div>
                      </div>
 
					  <hr>
                      <div class="control-group">
                        <label class="control-label">Stock</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo intval($data['stock']);?>
                            </label>
                        </div>
                      </div>
					  <hr>
                      <div class="control-group">
                        <label class="control-label">Precio</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['price'];?>
                            </label>
                        </div>
                      </div>
					   
						<hr>
					<div class="control-group">
                        <label class="control-label"><b>Stock por Deposito</b></label>						
						<?php
						foreach ($s as $row)
						{						
								if (intval($row['stock']) != 0 ){									
							echo ' <div class="control-group"> ';
							echo ' <label class="control-label"> Deposito: '.  $row['store']. '</label>';
							echo ' <div class="controls">';
							echo '   <label class="checkbox">';
							echo ' Stock: '.  intval($row['stock']);
							echo "    </label>";
							echo " </div>";
							echo "</div>";
							echo '<hr style="width:100%;">';						
							}				   
						}
                      ?>
					  
					    </div>
					  
					  
                    </div>
                  
    </div> <!-- /container -->
	
	<footer class="page-footer teal">
    <div class="container">
         <div class="col l6 s12">
 		  <div class="row">
		  <div class="form-group"> 
			<a class="btn" href="index.php"><i class="material-icons">chevron_left</i></a>
			<a class="btn"  href=<?php echo "gallery.php?id=".$id."" ?>><i class="material-icons">photo</i></a> 
		<?php
		  if ($admin){
 		  echo '<a class="btn"  href="update.php?id='. $id .'"><i class="material-icons">mode_edit</i></a>';
          echo ' ';
          echo '<a class="btn"  href="delete.php?id='. $id .'"><i class="material-icons">delete_forever</i></a>';
		  }
		  ?> 
			</div>
		  </div>
        </div>
    </div>
  </footer>
  
  </body>
</html>