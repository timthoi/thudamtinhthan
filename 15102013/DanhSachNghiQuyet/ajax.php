<?php
//xài cho nghiquyet.php xác định xem maCD có trong dsThamDu và đã biểu quyết chưa
if(isset($_POST['maCD'])){
     include_once("../helper/CoDong.php");
     $maCD=$_POST['maCD'];
     $result=isInDsThamDu($maCD);
     if($result!=false){     
         $result['bieuquyet']="";
         if(isIn($_POST['tenNQ'],$maCD)) $result['bieuquyet']="đã biểu quyết";   
         echo json_encode($result);
     }
     else
     {
        echo false;
     }
}