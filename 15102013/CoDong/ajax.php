<?php
if(isset($_POST['maCD'])){
     include_once("../helper/CoDong.php");
     $maCD=$_POST['maCD'];
     $result=isInDsCoDong($maCD);
     if($result!=false){     
         $result['trangthai']="";
         if(isIn("codonguyquyen",$maCD) || isIn("thamdu",$maCD)) $result['trangthai']='đã ủy quyền hoặc đã tham dự';     
         echo json_encode($result);
     }
     else
     {
        echo "false";
     }
}