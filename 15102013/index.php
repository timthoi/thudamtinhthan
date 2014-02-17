<?php 
ob_start();
@session_start();
if(!isset($_SESSION['loggedIn']) || !isset($_SESSION['username']) || !isset($_SESSION['password'])){
    header("location:DangNhap/") ; 
    exit();       
}


$role=$_SESSION['role'];
$username=$_SESSION['username'];
if(isset($_GET['logout'])){    
    unset($_SESSION['loggedIn']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['role']);
    header('Location:DangNhap/');
    exit();
}


if(isset($_POST['btt'])){
    if($_POST['btt']=="BIỂU QUYẾT"){
        header("Location:DanhSachNghiQuyet/");
    }
    if($_POST['btt']=="THAM DỰ"){
        header("Location:CoDong/");
    }
}

if(isset($_GET['UpdateThamDu'])){
    header("Location:UpdateDanhSachThamDu/");    
}
$username=$_SESSION['username'];
$password=$_SESSION['password'];
        
include "index.html.php";
