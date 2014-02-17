<?php

ob_start();
@session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['role'])){
    $role=$_SESSION['role'];
    $username=$_SESSION['username'];                
    

include_once("../ConnectDB/UniversalConnect.php");
$pdo=new UniversalConnect();
$pdo=$pdo->doConnect();

try{
    $sql='SELECT * FROM codong';    
    $result=$pdo->query($sql);        
}
catch(PDOException $e)
{
    $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng CoDong'.$e->getMessage();
    include'../helper/output.html.php';
    exit();
}
//tim thay
while($row=$result->fetch()){
    $dsThamDu[]=array('macd'=>$row['MaCD'],
            'ho'=>$row['Ho'],
            'ten'=>$row['Ten'],            
            'cmnd'=>$row['CMND'],
            'ngaycap'=>$row['ngaycap'],
            'dienthoai'=>$row['dienthoai'],
            'diachi'=>$row['diachi'],
            'socophan'=>$row['SoCoPhan']);   
}
if (isset($_POST['btt']) && $_POST['btt']=="Quay lại") {
    header('Location:..');
}
if (isset($_POST['btt']) && $_POST['btt']=="Import") {
    if($_FILES['file']['name']==""){
        $error="Chưa chọn file excel";
        $goto=".";
        include"../helper/error.html.php";
    };
    $typeOK = false;
    //nhận file excel 2003 và file excel 2007    
    $permitted=array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    foreach($permitted as $type)    
        if($type==$_FILES['file']['type'])
            {$typeOK=true;
            break;}    
    
    if($typeOK==true)
    {
        //danh sách cổ đông Mã cổ đông	- Số cổ phần - Họ -	Tên -	CMND
        //tải file excel vào c:/upload
        define('UPLOAD_DIR','c:/upload/');
        $filePath=UPLOAD_DIR.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
        
        //bắt đầu đọc file excel
        include_once "../Classes/PHPExcel.php";
        $inputFileType = PHPExcel_IOFactory::identify($filePath);  
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filePath);
        
        //$sheetData là 1 mảng
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        //lấy tổng số hàng
        $max_row=$objPHPExcel->getActiveSheet()->getHighestRow();        
        $objPHPExcel->getActiveSheet()
           ->getStyle('E')
           ->getNumberFormat()
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
        //làm rỗng bảng Codong để thêm danh sách mới vào
        //làm rỗng bảng thamdu vì mới update bảng codong
        //xóa tất cả các nq1...nq2...nq3 ==>không cần vì khi tạo nq nó sẽ xóa
        try{
            $sql='DELETE FROM codong';      
            $pdo->query($sql);
            $sql='DELETE FROM thamdu';      
            $pdo->query($sql);
            $sql='DELETE FROM codonguyquyen';      
            $pdo->query($sql);             
            
            $sql="SELECT * FROM dsnghiquyet";
            $result=$pdo->query($sql);
            while($row=$result->fetch())
            {               
               $sql = 'DROP TABLE '.$row['DBNghiQuyet'];                        
               $pdo->query($sql);   
            }          
        }
        catch(PDOException $e)
        {
            $output='Không thể thực hiện câu lệnh DELETE bảng codong'.$e->getMessage();
            include'../helper/output.html.php';
            exit();
        }
        
        try{
            $sql='INSERT INTO codong SET
                    MaCD=:macd,
                    SoCoPhan=:socophan,
                    Ho=:ho,
                    Ten=:ten,
                    ngaycap=:ngaycap,
                    dienthoai=:dienthoai,
                    diachi=:diachi,
                    CMND=:cmnd';
            $s=$pdo->prepare($sql);
            for($i=2;$i<=$max_row;$i++){
                $s->bindValue(':macd',$sheetData[$i]['A']);            
                $s->bindValue(':ho',$sheetData[$i]['B']);                    
                $s->bindValue(':ten',$sheetData[$i]['C']);                
                $s->bindValue(':cmnd',$sheetData[$i]['D']);
                //date trong file excel fai la yyyy-mm-dd neu ko deo doc dc chua tim ra phuong phap khac phuc
                $s->bindValue(':ngaycap',$sheetData[$i]['E']);
                $s->bindValue(':dienthoai',$sheetData[$i]['F']);
                $s->bindValue(':diachi',$sheetData[$i]['G']);                
                $s->bindValue(':socophan',$sheetData[$i]['H']);
                $s->execute();                
            }                       
        }
        catch(PDOException $e)
        {
            $output='Không thể thực hiện câu lệnh INSERT vào DB codong'.$e->getMessage();
            include'../helper/output.html.php';
            exit();
        }
    
    }
    header("Location:.");
}

include "importDSCoDong.html.php";
}
else{
    $error="Access is denied!!";
    $goto="..";
    include "../helper/error.html.php";
}
