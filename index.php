
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inicio</title>
  <!-- CSS  -->
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="iconfont/material-icons.css" rel="stylesheet">
	
  <!--  Scripts-->
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/materialize.js"></script>
	 
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
.content {
    position: relative;
    z-index: 1;
    border-top: 1px solid black;
    border-bottom: 10px solid black; 
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
h4 {
    color: 	#F5FFFA;
}
nav-wrapper{
	.dropdown-button{position:absolute; right:0; top : 0;
     height: 50px;	
	  width: 100%;
	}
	
}
input[type=text] {
    width: 130px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}
/* When the input field gets focus, change its width to 100% */
input[type=text]:focus {
    width: 100%;
}
</style>

  <div class="nav-wrapper  teal center" >
  <a href="index.php" class="img-responsive" ><img src="gallery/logo1.png"  width="250px"></a>
    <ul class="right">
      <!-- Dropdown Trigger -->
      <li><a class="dropdown-button " href="#!" data-activates="dropdown1" data-beloworigin="true"><i class="material-icons" style="font-size: 45px;color:#F5FFFA;position:absolute; right:0; top : 0;">menu</i></a></li>
    </ul>
  </div>

<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">

<?php
					session_start();   					
		if(!$_SESSION['user'])  
		{  
		header("Location: login.php");//redirect to login page to secure the welcome page without login access.  
		}	  
 		
	if ( $_SESSION['admin'] ){
	echo ' <li><a href="create.php"><i class="material-icons">add</i>Nuevo</a></li>';
	echo ' <li><a href="update_db.php"><i class="material-icons">cloud_upload</i>Actualizar</a></li>';
	echo '<li class="divider"></li>			 ';
  	 }  
?>
  <li><a href="software.php"><i class="material-icons">get_app</i>Software</a></li>			
  <li><a href="logout.php"><i class="material-icons">exit_to_app</i>Salir</a></li>
</ul>

</head> 
 
<body>

<form action="index.php" method="post">
	<div class="input-field" style="margin-left:50px;">
          <label class="label-icon" for="search"><i class="material-icons" >search</i></label>    
           
		  <input id="search" type="search" name="txt" placeholder="Buscar..." style="margin-left:50px;width:80%" >
		  
              </div>
	</form>
  
<main>
<div class="container" style="height: 80%;">		
            <div class="row">
                <table class="table bordered">
                      <thead>
                        <tr>
                          <th>Codigo</th>
                          <th>Producto</th>
                          <th>Stock</th>
                          <th>Precio</th>
						  <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
					  
                      <?php
                       include 'database.php';										
				
					   #	echo '<a href="find.php" class="btn btn-success" style="float: left;margin: 6px 5px;"><i class="material-icons">search</i></a>';
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					 if ( !empty($_POST)) {
					   
					   $txt = $_POST["txt"];
					   $ltxt = "%$txt%";
                       $sql = 'SELECT id,name,price,SUM(stock) as stock FROM products where id = ? OR name LIKE ?  group by 1,2,3 ORDER BY name ASC';
					   $q = $pdo->prepare($sql);
					   $q->execute(array($txt,$ltxt));					   
					 }
					 else
					 {
						$sql = 'SELECT id,name,price,SUM(stock) as stock FROM products group by 1,2,3 order by 2 ASC limit 5';
						$q = $pdo->query($sql);
					 }					 					 
                       foreach ($q as $row) {
                                echo '<tr>';
								echo '<td>'. $row['id'] . '</td>';
                                echo '<td>'. $row['name'] . '</td>';
                                echo '<td>'. intval($row['stock']) . '</td>';
                                echo '<td>'. $row['price'] . '</td>';
                                echo '<td width=210>';
                                echo '<a class="btn" href="read.php?id='.$row['id'].'"><i class="material-icons">pageview</i></a>';
                                echo ' ';
                                echo '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();					   
                      ?>
                      </tbody>
                </table>
				<hr>
        </div>
    </div> <!-- /container -->
</main>
	<footer class="page-footer teal" width="250px" >            
          <div class="footer-copyright teal" width="250px">
            <div class="container" width="250px">
            © 2018 Copyright by Myke - V 2.7 - <a href="/Changelog.txt" download> Changelog </a>
			 </div>
          </div>
        </footer>
            
  </body>
</html>
