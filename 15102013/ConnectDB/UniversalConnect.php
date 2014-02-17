<?php
include_once('IConnectInfo.php');
class UniversalConnect implements IConnectInfo{
    private static $_server=IConnectInfo::HOST;
    private static $_currentDB=IConnectInfo::DBNAME;
    private static $_user=IConnectInfo::UNAME;
    private static $_pass=IConnectInfo::PW;    
    private static $_pdo;
    public function doConnect(){
        try{
            self::$_pdo=new PDO('mysql:host='.self::$_server.';dbname='.self::$_currentDB,self::$_user,self::$_pass);
            self::$_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            self::$_pdo->exec('SET NAMES "utf8"');            
        }
        catch(PDOException $e){
            $output='Không thể kết nối đến cơ sở dữ liệu'.$e->getMessage();
            include '../helper/output.html.php';
            exit();
        }
         
        return self::$_pdo;
    }
}

