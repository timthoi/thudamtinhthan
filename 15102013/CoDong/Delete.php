<?php
ob_start();
@session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['role'])){
    $role=$_SESSION['role'];
    $username=$_SESSION['username'];

    include_once("../ConnectDB/UniversalConnect.php");
    include_once("../helper/CoDong.php");
    if(isset($_SESSION['MaCD']) && isset($_SESSION['trangthaithamdu']))
    {
        $maCD=$_SESSION['MaCD'];
        $trangthaithamdu=$_SESSION['trangthaithamdu'];
       
        if($trangthaithamdu=="Tham dự"){
            xoaCoDongThamDu($maCD);
            header('Location:.');
        }       
       
        $codong=isInDsThamDu($maCD);               
        $pdo=new UniversalConnect();
        $pdo=$pdo->doConnect();                    
        try{
            $sql='SELECT * 
                FROM codonguyquyen INNER JOIN codong
                ON codong.MaCD=codonguyquyen.MaCD 
                WHERE MaCDnhanUQ=:MaCD
                ';
            $s=$pdo->prepare($sql);
            $s->bindValue(":MaCD",$codong['macd']);
            $s->execute();        
        }
        catch(PDOException $e)
        {
            $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng codonguyquyen'.$e->getMessage();
            include'../helper/output.html.php';
            exit();
        }    
        //tim thay
        
        while($row=$s->fetch()){
            $dsCoDongUQ[]=array('macd'=>$row['MaCD'],
                    'socophan'=>$row['SoCoPhan'],
                    'ten'=>$row['Ten'],
                    'ho'=>$row['Ho'],
                    'cmnd'=>$row['CMND'],
                    'ngaycap'=>$row['ngaycap'],
                    'dienthoai'=>$row['dienthoai'],
                    'diachi'=>$row['diachi']
                    );
            }        
    }
    if(isset($_POST['back'])){
        header('Location:.');
    }
    
    if(isset($_POST['dialogbtt'])){
        //xóa trong codonguyquyen
        //update lại socophan trong thamdu
        //truong hop có 1 co dong trong codonguyquyen - thuc hien xoa ds uyquyen
        if($_POST['dialogbtt']=='xóa'){
            $maCD=$_SESSION['MaCD'];
            $maCDUyQuyen=$_POST['macd'];
            $cd=isInDsThamDu($maCD);
            $socophan=$cd['socophan']-$_POST['socophan'];
            
            //trường hợp Macd=MaCDUyQuyen - xoa - cấp lại macd/
            //số cổ phần đã ủy quyền
            
            
            xoaCoDongUyQuyen($maCDUyQuyen);
            //kiem tra trong CoDongUyQuyen con thang nao ko
            $pdo=new UniversalConnect();
            $pdo=$pdo->doConnect();                    
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
            $result=$s->fetch();
            
            if($result[0]!=NULL){
                try
                {
                    $sql = 'UPDATE thamdu SET
                        socophan = :socophan                                      
                        WHERE MaCD = :macd';
                    $s = $pdo->prepare($sql);
                    $s->bindValue(':socophan', $socophan);                                         
                    $s->bindValue(':macd', $_SESSION['MaCD']);
                    $s->execute();
                }
                catch (PDOException $e)
                {
                    $output='Không thể thực hiện câu lệnh UPDATE bảng thamdu'.$e->getMessage();
                    include'../helper/output.html.php';
                    exit();
                }  
                header('Location:Delete.php');      
            }
            else{
                if($_SESSION['trangthaithamdu']=='Người nhận ủy quyền'){
                    xoaCoDongThamDu($_SESSION['MaCD']);
                    unset($_SESSION['MaCD']);
                    unset($_SESSION['trangthaithamdu']);
                    header('Location:.'); 
                }
                else{                            
                    try
                    {
                        $sql = 'UPDATE thamdu SET
                            socophan = :socophan,
                            trangthaithamdu = :trangthaithamdu                   
                            WHERE MaCD = :macd';
                        $s = $pdo->prepare($sql);
                        $s->bindValue(':socophan', $socophan);
                        $s->bindValue(':trangthaithamdu', 'Tham dự');                         
                        $s->bindValue(':macd', $_SESSION['MaCD']);
                        $s->execute();
                    }
                    catch (PDOException $e)
                    {
                        $output='Không thể thực hiện câu lệnh UPDATE bảng thamdu'.$e->getMessage();
                        include'../helper/output.html.php';
                        exit();
                    }
                    header('Location:Delete.php');           
                }           
            }
          
        }    
    }
    if(isset($_POST['btt_Del'])){
        //thực hiện xóa trong DSThamDu DSCoDongUyQuyen -dongian
   
        if($_POST['btt_Del']=='Xóa cổ đông' || (($_POST['btt_Del']=='Xóa ds ủy quyền') && $_SESSION['trangthaithamdu']=='Người nhận ủy quyền')){
            //nợ 1 cái thông báo đã hoàn thành công việc
            $maCD=$_POST['macd'];
            xoaCoDongNhanUyQuyen($maCD);
            xoaCoDongThamDu($maCD);
            unset($_SESSION['MaCD']);
            unset($_SESSION['trangthaithamdu']);
            header('Location:.');             
        }    
        //thực hiện xóa trong ALL DSCoDongUyQuyen -
        //Update lại codong trong DSThamDu - socophan - trangthaithamdu=thamdu UPDATE 
        if($_POST['btt_Del']=='Xóa ds ủy quyền' && $_SESSION['trangthaithamdu']=='Cổ đông ủy quyền'){        
            $maCD=$_POST['macd'];
            xoaCoDongNhanUyQuyen($maCD);        
            //lấy cổ đông trong ds cho nó update lại thành thamdu
            $cd=isInDsCoDong($maCD);
            try
            {
                $sql = 'UPDATE thamdu SET
                    socophan = :socophan,
                    trangthaithamdu = :trangthaithamdu  
                    WHERE MaCD = :macd';
                $s = $pdo->prepare($sql);
                $s->bindValue(':socophan', $cd['socophan']);
                $s->bindValue(':trangthaithamdu', "Tham dự");
                $s->bindValue(':macd', $maCD);
                $s->execute();
            }
            catch (PDOException $e)
            {
                $output='Không thể thực hiện câu lệnh UPDATE bảng thamdu'.$e->getMessage();
                include'../helper/output.html.php';
                exit();
            }        
            header('Location:Delete.php');
        }
    }
    
    include 'Delete.html.php';
}
else{
    $error="Access is denied!!";
    $goto="..";
    include "../helper/error.html.php";
}
