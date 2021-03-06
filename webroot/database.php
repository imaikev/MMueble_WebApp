<?php
class Database
{
    private static $dbName = 'prd' ;  
    private  $dbHost;
    private static $dbUsername = 'prd';
    private static $dbUserPassword = 'prd';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
          $this->$dbHost = $_SERVER['MYSQL_SERVICE_HOST'];
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
          self::$cont->exec("set names utf8");

        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
        
