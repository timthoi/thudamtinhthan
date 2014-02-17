<?php
if(isset($_POST['maCD'])){
     include_once("../helper/CoDong.php");
     $maCD=$_POST['maCD'];
     $result=isInDsCoDong($maCD);
     
     if($result!=false){        
        $a=isInDsThamDu($maCD);
        $result['trangthai']="";
        if($a==false) $result['trangthai']='Chưa tham dự';
        else
        {
            $result['socophan']=$a['socophan'];            
        }
        if($a['trangthaithamdu']=="Người nhận ủy quyền")  $result['trangthai']="Người nhận ủy quyền";                                                    
        echo json_encode($result);
     }
     else
     {
        echo "false";
     }
}
