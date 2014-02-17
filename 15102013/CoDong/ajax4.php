<?php
if(isset($_POST['maCDUQ'])){
     include_once("../helper/CoDong.php");
     $d['macd']=$_POST['maCDUQ'];
     $d['mcdNhanUQ']=$_POST['maCDnhanUQ'];
     $d['socophan']=$_POST['socophan'];
     $d['cmnd']=$_POST['cmnd'];
     $d['trangthai']='Cổ đông ủy quyền';     
     insertIn_CoDongUQ($d);
     
    $coDongThamDu=isInDsThamDu($d['mcdNhanUQ']);
    $d['socophan']=$d['socophan']+$coDongThamDu['socophan'];            
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try{
        $sql = 'UPDATE thamdu SET
                    SoCophan = :socophan,
                    trangthaithamdu=:trangthai                        
                    WHERE macd = :macd';
        $s = $pdo->prepare($sql);
        $s->bindValue(':macd', $d['mcdNhanUQ']);
        $s->bindValue(':trangthai', 'Cổ đông ủy quyền');
        $s->bindValue(':socophan', $d['socophan']);
        $s->execute();               
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh UPDATE bảng ThamDu'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }          
     echo json_encode($d);
     
}

