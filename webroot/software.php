<?php

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
?>


<html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Software</title>
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
	<div class="navbar">
	<nav class="teal" role="navigation">
		<div class="nav-wrapper container valign-wrapper " ><a id="logo-container"><h5>Software</h5></a>
		</div>
	</nav>
</div>   

<main>		

<div class="container valign-wrapper" style="height: 50%;">		

<div class="form-group"> 
<p>Instalador Discovery Server:                <p>
<a href="/soft/DiscoveryServer.msi" download>
  <img border="0" src="/soft/DiscoveryServer.ico" width="140" height="142">
</a>
</div>
<hr>
<div class="form-group">
<p>Configurador ODBC Discovery:               <p>
<a href="/soft/ConfiguradorODBC.msi" download>
  <img border="0" src="/soft/ConfiguradorODBC.ico"  width="140" height="142">
</a>
<p><p>
</div>
<hr>
<div class="form-group">
<p>Teamviewer del Soporte:                 <p>
<a href="/soft/teamviewerQS.exe" download>
  <img border="0" src="/soft/teamviewer.png"  width="124" height="142">

  </a>

  </div>

  
</div> 
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