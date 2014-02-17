<?php
if(isset($_POST['maCD'])){
     include_once("../helper/CoDong.php");
     $maCD=$_POST['maCD'];
     $result=isInDsThamDu($maCD);
     if($result!=false){     
        
         ob_start();
         @session_start();
            
        $result2=isInDSBauCu($maCD,$_SESSION['db'],$_SESSION['dsIdUngVien']);                  
        echo json_encode($result+$result2);
     }
     else
     {
        echo "false";
     }
}