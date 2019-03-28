<?php
class Database
{
    private static $dbName = 'prd' ;
    //private static $dbHost = getenv("MYSQL_SERVICE_HOST");
    private $dbHost = $_SERVER('MYSQL_SERVICE_HOST');
    private static $dbUsername = 'prd';
    private static $dbUserPassword = 'prd';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
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
        
