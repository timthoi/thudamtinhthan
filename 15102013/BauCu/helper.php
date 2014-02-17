<?php
function soluong($db){
    include_once("../../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try{
       $sql = 'SELECT COUNT(*) FROM '.$db;
       $result=$pdo->query($sql);
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh DELETE bảng thamdu'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }  
    $a=$result->fetch();
    return $a[0];
}


?>