<?php 
function databaseContainsUser($username, $password)
{
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try
    {
        $sql = 'SELECT * FROM user
                WHERE username = :username AND password = :password';
        $s = $pdo->prepare($sql);
        $s->bindValue(':username', $username);
        $s->bindValue(':password', $password);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $error = 'Không thể thực hiện lệnh query select db USER'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }
    $row = $s->fetch();
    if ($row[0] !=null)
    {
        return $row[2];
    }
    else
    {        
        return FALSE;
    }
} 

ob_start();
@session_start();
if(isset($_SESSION['loggedIn'])&&$_SESSION['loggedIn']==TRUE){
    //gọi hàm jquery xuất dialog lỗi
    $error="Logout trước khi login";
    $goto="..";
    include "../helper/error.html.php";
}
else{
if(isset($_POST['action']) && $_POST['action']=="login"){
  // $password=md5($_POST['password'] . 'ijdb');
   $password=$_POST['password'];   
    if(databaseContainsUser($_POST['username'],$password)){            
        $_SESSION['loggedIn'] = TRUE;
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $password;                
        $_SESSION['role'] = databaseContainsUser($_POST['username'],$password);
        header("Location:..");
    }
    else{        
        unset($_SESSION['loggedIn']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['role']);
        $GLOBALS['loginError'] ='Username hoặc password sai!!!';    
    }
               
}



include "frm_dangnhap.html.php";
}