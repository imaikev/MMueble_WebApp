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
	 
    if ( null==$id OR  $admin != 1 ) {
        header("Location: index.php");
    } else {
		
	unlink($id);		
	$salida =  explode("/", $id);
	$salida =  explode("-", $salida[1]);	
	header("Location: gallery.php?id=".$salida[0]."");
	
    }
?>