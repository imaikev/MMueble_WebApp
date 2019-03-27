<?php  
session_start();//session starts here  
  
?>  
  
  
<html>  
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>  
</head>

<style>  
    .login-panel {  
        margin-top: 150px;  
</style>  
  
<body>  
  
  
<div class="container">  
    <div class="row">  
        <div class="span10 offset1">  
            <div class="login-panel panel panel-success">  
                <div class="panel-heading">  
                    <h3 class="panel-title">Conectar</h3>  
                </div>  
                <div class="panel-body">  
                    <form role="form" method="post" action="login.php">  
                        <fieldset>  
                            <div class="form-group"  >  
                                <input class="form-control" placeholder="Usuario" name="user" type="text" autofocus>  
                            </div>  
                            <div class="form-group">  
                                <input class="form-control" placeholder="Contraseña" name="pass" type="password" value="">  
                            </div>    
  
                                <input class="btn btn-success" type="submit" value="OK" name="login" >  
  
                            <!-- Change this to a button or input when using this as a form -->  
                          <!--  <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a> -->  
                        </fieldset>  
                    </form>  
                </div>  
            </div>  
        </div>  
    </div>  
</div>  
  
  
</body>  
  
</html>  
  
<?php  
  include 'database.php';
					   
if(isset($_POST['login']))  
{  
    $user_login=$_POST['user'];  
    $user_pass=$_POST['pass'];  
    $pdo = Database::connect();
    $sql = "select * from users WHERE user = ? AND pass= ? "; 
	$q = $pdo->prepare($sql);
	$q->execute(array($user_login,$user_pass));		
	$data = $q->fetch(PDO::FETCH_ASSOC);	
	Database::disconnect();
		
    if($q->rowCount())  
    {  
        echo "<script>window.open('index.php','_self')</script>";  
          $_SESSION['user']=$user_login;//here session is used and value of $user_login store in $_SESSION.  
		  $_SESSION['admin']=$data['admin'];
      }  
    else  
    {  
      echo "<script>alert('Usuario o Contraseña es incorrecta!')</script>";  
    }  
}  
?>
