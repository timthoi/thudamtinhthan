<?php

ob_start();
@session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['role'])){
    $role=$_SESSION['role'];
    $username=$_SESSION['username']; 
    include_once("../ConnectDB/UniversalConnect.php");
    
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    
    try{
        $sql='SELECT * FROM ThamDu';
        $result=$pdo->query($sql);
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng ThamDu'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }
    while ($row=$result->fetch()){
        $dsThamDu[]=array('macd'=>$row['MaCD'],
                    'socophan'=>$row['SoCoPhan'],
                    'ten'=>$row['Ten'],
                    'ho'=>$row['Ho'],
                    'cmnd'=>$row['CMND'],
                    'ngaycap'=>date("d-m-Y",strtotime($row['ngaycap'])),
                    'dienthoai'=>$row['dienthoai'],
                    'diachi'=>$row['diachi'],
                    'uyquyen'=>$row['trangthaithamdu']);
    }
    
    
    if(isset($_POST['btt1'])){        
        if($_POST['btt1']=="Tham Dự"){       
            include_once "../helper/CoDong.php";
            $d['macd']=$_POST['maCoDong'];
            $d['ho']=$_POST['ho'];
            $d['ten']=$_POST['ten'];
            $d['cmnd']=$_POST['cmnd'];
            $d['ngaycap']=date("d-m-Y",strtotime($_POST['ngaycap']));
            $d['dienthoai']=$_POST['dienthoai'];
            $d['diachi']=$_POST['diachi'];        
            $d['trangthai']="Tham dự";        
            $d['socophan']=$_POST['socophan'];
            insertIn_ThamDu($d);
            header('Location:.');           
        }                    
        if($_POST['btt1']=="Xóa/sửa"){
            ob_clean();
            @session_start();
            $_SESSION['MaCD']=$_POST['macd'];
            $_SESSION['trangthaithamdu']=$_POST['trangthaithamdu'];
            header('Location:delete.php');                                                                        
        }
    }
    if(isset($_GET['homepage'])){
        header("Location:..");
    }
    
    include 'index.html.php';       
}
else{
    $error="Access is denied!!";
    $goto="..";
    include "../helper/error.html.php";
}
