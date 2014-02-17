<?php
if(isset($_POST['maCDnhanUQ'])){    
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    
    $maCD=$_POST['maCDnhanUQ'];
            
    try{
        $sql='SELECT * FROM codonguyquyen WHERE MaCDnhanUQ=:MaCD';
        $s=$pdo->prepare($sql);
        $s->bindValue(":MaCD",$maCD);
        $s->execute();        
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng codonguyquyen'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }    
    //tim thay
    
    while($codong=$s->fetch()){
        $dsCoDongUQ[]=array('macd'=>$codong['MaCD'],                    
                'socophan'=>$codong['socophan'],
                'cmnd'=>$codong['CMND']
                );
        }
    if(!isset($dsCoDongUQ)) $dsCoDongUQ='false'; 
    
    echo json_encode($dsCoDongUQ);    
    
}