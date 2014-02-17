<?php

if(isset($_POST['btt'])){
    if($_POST['btt']=='Thành viên HĐQT')
    {     
        //chức danh =1 thành viên hội đồng quản trị
        ob_start();
        @session_start();
        $_SESSION['idChucDanh']=1;
        $_SESSION['tenChucDanh']='Thành viên HĐQT';        
        $_SESSION['db']='dsBauCu_HDQT';                
        include_once("../ConnectDB/UniversalConnect.php");
        $pdo=new UniversalConnect();
        $pdo=$pdo->doConnect();
        
        try{
            $sql="SELECT idUngVien FROM ungvien_chucdanh WHERE idChucDanh=1";
            $result=$pdo->query($sql);
        }
        catch(PDOException $e)
        {
            $output='Không thể thực hiện câu lệnh truy vấn ungvien_chucdanh'.$e->getMessage();
            include'../helper/output.html.php';
            exit();
        }        
        
        $_SESSION['dsIdUngVien']=NULL;
        
        while($row=$result->fetch())
        {
            $dsIdUngVien[]=array('idUngVien'=>$row['idUngVien']);
            $_SESSION['dsIdUngVien'][]=$row['idUngVien'];
        }                
        //tạo database dsBauCu_HDQT (chucdanh) gồm macd idUngVien
        //nhớ dấu ''
        $result=$pdo->query("SHOW TABLES LIKE '".$_SESSION['db']."'");
        //echo $result->rowCount();
        // rowCount()=0 là chừa có .... >0 là có                                
           
        if(isset($dsIdUngVien) && $result->rowCount()==0){
            try{
                $sql="CREATE TABLE IF NOT EXISTS  ".$_SESSION['db']."(
                        MaCD VARCHAR(10) NOT NULL PRIMARY KEY, 
                        ChucDanh VARCHAR(255) default 'Thành viên HDQT',
                        ";
                foreach ($dsIdUngVien as $idUngVien) {
                   $sql .= "idUngVien".$idUngVien['idUngVien']." INT,";
                }
                $sql .="trangthai CHAR(20) default 'chưa bầu cử') DEFAULT CHARACTER SET utf8 ENGINE=InnoDB";
                //trả về true hay false                                                                                        
                $pdo->exec($sql);                
            }
            catch(PDOException $e)
            {
                $output='Không thể tạo DB danh sách NghiQuyet'.$e->getMessage();
                include'../helper/output.html.php';
                exit();
            }
            //insert vào db mới tạo                       
            try{
                $sql="INSERT INTO ".$_SESSION['db']." SET
                        MaCD=:macd";
                foreach ($dsIdUngVien as $idUngVien) {
                       $sql .= ",idUngVien".$idUngVien['idUngVien']."=:idUngVien".$idUngVien['idUngVien'];
                }
                $s=$pdo->prepare($sql);
                $dsThamDu = getDsThamDu();            
                foreach($dsThamDu as $codong){
                    $s->bindValue(':macd',$codong['MaCD']);
                    foreach ($dsIdUngVien as $idUngVien) {
                       $sql .= ",idUngVien".$idUngVien['idUngVien']."=:idUngVien".$idUngVien['idUngVien'];
                       $s->bindValue(":idUngVien".$idUngVien['idUngVien'],0);
                    }
                $s->execute();                                
                }                                                                   
            }
            catch(PDOException $e){
                $output='Không thể thêm vào DB dsBauCu'.$e->getMessage();
                include'../helper/output.html.php';
                exit();
            }
        } 
        header('Location:HoiDongQuanTri/');                       
                                   
    }
    if($_POST['btt']=='Thành viên Ban kiểm soát')
    {
        include_once("../ConnectDB/UniversalConnect.php");    
        $pdo=new UniversalConnect();
        $pdo=$pdo->doConnect();        
    }
}
function getDsThamDu(){
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try{
        $sql='SELECT * FROM thamdu';
        $result=$pdo->query($sql);
    }
    catch(PDOException $e){
        $output='Không thể query thamdu'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }
    foreach($result as $row){
        $codong[]=array("MaCD"=>$row['MaCD']);
    }
    return $codong;
}
include "baucu.html.php";