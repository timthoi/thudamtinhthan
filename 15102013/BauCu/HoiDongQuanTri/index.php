<?php
//xài session nên phải khởi động BauCu/index.php trước

include_once("../../ConnectDB/UniversalConnect.php");    
$pdo=new UniversalConnect();
$pdo=$pdo->doConnect();
ob_start();
@session_start();

try
{
    $sql = "SELECT hoten,dsUngVien.id as idUngVien, chucdanh.id as idChucDanh, ungvien_chucdanh.socophan as socophan
        FROM dsungvien INNER JOIN ungvien_chucdanh
        ON dsUngVien.id = idUngVien
        INNER JOIN chucdanh
        ON idChucDanh = chucdanh.id
        WHERE chucdanh.chucdanh='Thành viên HĐQT'";
    $result = $pdo->query($sql);
}
catch (PDOException $e)
{
    $output = 'Error fetching dsUngVien: ' . $e->getMessage();
    include'../../helper/output.html.php';
    exit();
}

//cần idChucDanh và idUngVien để update socophan cho db ungvien_chucdanh
while($row=$result->fetch()){
    $dsUngVien[]=array("idUngVien"=>"idUngVien".$row['idUngVien'],
                       "idChucDanh"=>$row['idChucDanh'],
                       "socophan"=>$row['socophan'], 
                       "hoten"=>$row['hoten']);
                               
}
//đếm tổng số cổ đông đã tham dự -
include_once("../../helper/CoDong.php");
$slCoDong=soluong($pdo,"thamdu");
$slCoDongDaBC=soluongDk($pdo,$_SESSION['db'],"đã bầu cử");
//đếm tổng số cổ đông đã bầu cử



if(isset($_POST['btt_baucu'])){
    
    //echo $_POST['macodong_baucu'];
    //var_dump($_SESSION['dsIdUngVien']);    
    $socophan=$_POST['socophan'];
    //var_dump($socophan);
    try
    {
        $sql = 'UPDATE '.$_SESSION['db'].' SET trangthai=:trangthai';
        foreach ($_SESSION['dsIdUngVien'] as $idUngVien) {
               $sql .= ",idUngVien".$idUngVien."=:idUngVien".$idUngVien;
        }               
        $sql.=' WHERE MaCD = :macd';
                       
        $s = $pdo->prepare($sql);
        $i=0;
        foreach ($_SESSION['dsIdUngVien'] as $idUngVien){            
            $s->bindValue(":idUngVien".$idUngVien,$socophan[$i]);
            $i++;
        }        
        $s->bindValue(':macd', $_POST['macodong_baucu']);
        $s->bindValue(':trangthai', "đã bầu cử");        
        $s->execute();        
    }
    catch (PDOException $e)
    {
        $output = 'Error Update dsbaucu_hdqt ' . $e->getMessage();
        include'../../helper/output.html.php';
        exit();
    }
    //tinh tổng 
    try
    {
        //idUngVien chi co so - minh fai them text "idUngVien" vao truoc no dus ma loi Database do em
        foreach($dsUngVien as $ungvien){
            $sql = "SELECT sum(".$ungvien['idUngVien'].") FROM ".$_SESSION['db'];
            $result = $pdo->query($sql);
            $s=$result->fetch();
            //echo $s[0]."</br>";
            $sum[]=$s[0];
        }
    }
    catch (PDOException $e)
    {
        $output = 'Error fetching dsUngVien: ' . $e->getMessage();
        include'../../helper/output.html.php';
        exit();
    }
    //var_dump($sum);
    //update tổng sổ cổ phần đã bầu cử trong ứng viên trong db ungvien_chucdanh
    try
    { 
        $i=0;
        foreach($_SESSION['dsIdUngVien'] as $idUngVien){    
            $sql = 'UPDATE ungvien_chucdanh 
                    SET socophan=:socophan WHERE idUngVien=:idUngVien AND idChucDanh=:idChucDanh';
            $s = $pdo->prepare($sql);
            $s->bindValue(':socophan', $sum[$i]);
            $s->bindValue(':idUngVien', $idUngVien);
            $s->bindValue(':idChucDanh', $_SESSION['idChucDanh']);
            $s->execute();  
            //echo $sum[$i]." ".$idUngVien." ".$_SESSION['idChucDanh']."</br>";
            $i++;
            //echo $s[0]."</br>";        
        }
    }
    catch (PDOException $e)
    {
        $output = 'Error fetching ungvien_chucdanh  ' . $e->getMessage();
        include'../../helper/output.html.php';
        exit();
    }   
    header('location:.');
}

include 'hoidongquantri.html.php';