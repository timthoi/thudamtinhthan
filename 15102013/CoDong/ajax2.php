<?php 
if(isset($_POST['nguoiUyQuyen'])){               
    // json_decode() is used to decode a json string to an array/data object. json_encode() creates a json string from an array or data. You are using the wrong function my friend, try json_encode();

    $nguoiUyQuyen=json_encode($_POST['nguoiUyQuyen']); 
    $nguoiUyQuyen=json_decode($nguoiUyQuyen,true);
    include_once("../helper/CoDong.php");
    
    $result=CMNDisIn("codonguyquyen",$nguoiUyQuyen['cmnd']);    
    //truong hop tìm thấy uy quyen cho nguoi đã dc ủy quyền rồi CMND
    $d=array();
    $d['macd']=$nguoiUyQuyen['macd'];
    $d['cmnd']=$nguoiUyQuyen['cmnd'];        
    $d['trangthai']="Người nhận ủy quyền";    
    $d['socophan']=$nguoiUyQuyen['socophan'];
    
    if($result!=FALSE){
        $d['mcdNhanUQ']=$result;
        insertIn_CoDongUQ($d);
        //$nguoiUyQuyen['macd']=$result;              
        //update moi dung - lấy số cổ phần trong DB ThamDu
        $coDongThamDu=isInDsThamDu($d['mcdNhanUQ']);
        $d['socophan']=$d['socophan']+$coDongThamDu['socophan'];
        
        include_once("../ConnectDB/UniversalConnect.php");
        $pdo=new UniversalConnect();
        $pdo=$pdo->doConnect();
        try{
            $sql = 'UPDATE thamdu SET
                        SoCophan = :socophan                        
                        WHERE macd = :macd';
            $s = $pdo->prepare($sql);
            $s->bindValue(':macd', $d['mcdNhanUQ']);            
            $s->bindValue(':socophan', $d['socophan']);
            $s->execute();               
        }
        catch(PDOException $e)
        {
            $output='Không thể thực hiện câu lệnh UPDATE bảng ThamDu'.$e->getMessage();
            include'../helper/output.html.php';
            exit();
        }        
        //echo json_encode($d['socophan']);         
        //        
    }
    //truong hop khong tìm thấy uy quyen cho 1 nguoi ma nguoi nay chua ai UQ
    else{         
        $d['mcdNhanUQ']=$nguoiUyQuyen['macd'];
        insertIn_CoDongUQ($d);
        
        $d['ho']=$nguoiUyQuyen['ho'];
        $d['ten']=$nguoiUyQuyen['ten'];
        $d['ngaycap']=$nguoiUyQuyen['ngaycap'];
        $d['dienthoai']=$nguoiUyQuyen['dienthoai'];
        $d['diachi']=$nguoiUyQuyen['diachi'];
        //var_dump($d)
        insertIn_ThamDu($d);
    }
    
    
    $nguoiUyQuyen=json_encode($nguoiUyQuyen);     
          
}

/*
   $json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
   $json=json_encode($json);
   var_dump($json);         
   $json=json_decode($json, true);  
   var_dump($json);    
   $json=json_encode($json);
   // It is a boolean type parameter, when set to TRUE, returned objects will be converted into associative arrays.
   echo '</br>';
   echo $json;   
   

*/