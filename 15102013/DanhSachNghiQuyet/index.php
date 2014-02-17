<?php



ob_start();
@session_start();

include_once("../ConnectDB/UniversalConnect.php");
$pdo=new UniversalConnect();
$pdo=$pdo->doConnect();

$hidden="hidden";
if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['role'])){
    if(isset($_GET['homepage'])){
        header("Location:..");
    }
    $role=$_SESSION['role'];
    $username=$_SESSION['username'];                
    
    include_once "../helper/CoDong.php";
    $_SESSION['tongSCP']=tongSCP($pdo,"thamdu");
    echo $_SESSION['tongSCP'];
    
    try{
        $sql="SELECT * FROM dsnghiquyet";
        $result=$pdo->query($sql);
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh truy vấn DBNGHIQUYET'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }
    $dsNghiQuyet=NULL;
    while($row=$result->fetch())
    {
        $dsNghiQuyet[]=array('DBNghiQuyet'=>$row['DBNghiQuyet'],
                    'tenNghiQuyet'=>$row['TenNghiQuyet'],
                    'noidungNghiQuyet'=>$row['MieuTa'],
                    'tenBieuMau'=>$row['TenBieuMau'],
                    'trangthai'=>$row['TrangThai']                    
                    );
    }                
    //nợ phần xóa sửa NQ - kiểm tra thông tin nhập nghị quyết - ẩn hiện nút thêm 
    //thêm 1 nghị quyết vào dsNghiQuyet quyền admin
    if(isset($_POST['btt']) ){
      //sửa  
      if($_POST['btt']=='sửa'){
           $hidden="";
           $DBNghiQuyet=$_POST['DBNghiQuyet'];
           $tenNghiQuyet=$_POST['tenNghiQuyet'];
           $tenBieuMau=$_POST['tenBieuMau'];
           $noidungNghiQuyet=$_POST['noidungNghiQuyet'];
           $trangthai=$_POST['trangthai'];           
      }      
      
      //xóa trong 2 bảng dsNghiQuyet và xóa lun bảng NQ đã tạo
      if($_POST['btt']=='xóa'){
          try{
            $sql = 'DELETE FROM dsnghiquyet WHERE DBNghiQuyet = :dbNQ';
            $s = $pdo->prepare($sql);
            $s->bindValue(':dbNQ', $_POST['DBNghiQuyet']);
            $s->execute();        
          }
          catch(PDOException $e)
          {
            $output='Không thể thực hiện câu lệnh DELETE bảng dsNghiQuyet'.$e->getMessage();
            include'../helper/output.html.php';
            exit();
          }
          
          try{
            $sql = 'DROP TABLE '.$_POST['DBNghiQuyet'];                        
            $pdo->query($sql);        
          }
          catch(PDOException $e)
          {
            $output='Không thể thực hiện câu lệnh DROP dbNghiQuyet'.$e->getMessage();
            include'../helper/output.html.php';
            exit();
          }   
          header('Location:.');               
      }                
      //thêm                        
    }
    if(isset($_POST['bttFrm'])){
        //update bảng DsNghiQuyet
        //thực hiện Thêm nghị quyết - (NỢ)xóa biểu mẫu cũ - thêm biểu mẫu mới
        if($_POST['bttFrm']=='Sửa'){                                
            try{
            $sql = 'UPDATE dsnghiquyet SET
                        TenNghiQuyet = :tNQ,
                        MieuTa=:mtNQ,
                        TenBieuMau=:tenBieuMau,
                        TrangThai=:tt                        
                        WHERE DBNghiQuyet = :dbNQ';
            $s = $pdo->prepare($sql);
            $s->bindValue(':dbNQ',$_POST['frmDBNghiQuyet']);
            $s->bindValue(':tNQ',$_POST['tenNghiQuyet']);
            $s->bindValue(':tenBieuMau',$_POST['tenBieuMau'].'.docx');
            $s->bindValue(':mtNQ',$_POST['noidungNghiQuyet']);
            $s->bindValue(':tt',$_POST['trangthai']);
            $s->execute();
            //xóa file cũ
            define('UPLOAD_DIR','C:/xampp/htdocs/15102013/DanhSachNghiQuyet/');
            $filePath=UPLOAD_DIR.$_POST['frmTenBMCu'];
            unlink($filePath);
            //thêm file mới
            $typeOK = false;    
            $permitted=array("application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document");
            foreach($permitted as $type) 
            {   
                if($type==$_FILES['fileWord']['type'])
                    {$typeOK=true;
                    break;}
    
             }       
            if($typeOK==true){                         
                $filePath=UPLOAD_DIR.$_POST['tenBieuMau'].'.docx';
                move_uploaded_file($_FILES['fileWord']['tmp_name'], $filePath);
            }               
            }
            catch(PDOException $e)
            {
                $output='Không thể thực hiện câu lệnh UPDATE bảng ThamDu'.$e->getMessage();
                include'../helper/output.html.php';
                exit();                
            }   
            header('Location:.');      
                        
        }
        if($_POST['bttFrm']=='Thêm'){
            //thêm đồng thời thực hiện việc upload file biêu mẫu lên server - tạo table NQ
            //tạo table NQ
            try{
                $sql="CREATE TABLE ".$_POST['DBNghiQuyet']."(
                        MaCD VARCHAR(10) NOT NULL PRIMARY KEY,
                        HoTen TEXT,
                        CMND VARCHAR(10),
                        NgayCap DATE NULL,
                        DienThoai VARCHAR(20) NULL,                                           
                        DiaChi TEXT NULL,
                        SoCoPhan BIGINT(20),
                        TrangThaiThamDu VARCHAR(20),
                        BieuQuyet VARCHAR(20)
                        ) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB";
                $pdo->exec($sql);
            }
            catch(PDOException $e)
            {
                $output='Không thể tạo DB danh sách NghiQuyet'.$e->getMessage();
                include'../helper/output.html.php';
                exit();
            }
            //thêm nghị quyết vừa tạo vào db dsnghiquyet                           
            try{
                $sql='INSERT INTO dsnghiquyet SET
                        DBNghiQuyet=:dbNQ,
                        TenNghiQuyet=:tNQ,
                        MieuTa=:mtNQ,
                        TenBieuMau=:tenBieuMau,
                        TrangThai=:tt';
                $s=$pdo->prepare($sql);
                $s->bindValue(':dbNQ',$_POST['DBNghiQuyet']);
                $s->bindValue(':tNQ',$_POST['tenNghiQuyet']);
                $s->bindValue(':tenBieuMau',$_POST['tenBieuMau'].'.docx');
                $s->bindValue(':mtNQ',$_POST['noidungNghiQuyet']);
                $s->bindValue(':tt',0);
                $s->execute();
                //upload biểu mẫu lên server                    
                $typeOK = false;    
                $permitted=array("application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document");
                foreach($permitted as $type) 
                {   
                    if($type==$_FILES['fileWord']['type'])
                        {$typeOK=true;
                        break;}
        
                 }       
                if($typeOK==true){         
                    define('UPLOAD_DIR','C:/xampp/htdocs/15102013/DanhSachNghiQuyet/');
                    $filePath=UPLOAD_DIR.$_POST['tenBieuMau'].'.docx';
                    move_uploaded_file($_FILES['fileWord']['tmp_name'], $filePath);
                }    
            }
            catch(PDOException $e){
                $output='Không thể thêm vào DB dsNghiQuyet'.$e->getMessage();
                include'../helper/output.html.php';
                exit();
            }
            header('Location:.');          
           }
          } 
    //chọn nghị quyết chuyển đến file NghiQuyet.php de xu ly
    if(isset($_POST['bttNQ'])){    
        $DBNghiQuyet=$_POST['DBNghiQuyet'];
        $tenNghiQuyet=$_POST['bttNQ'];    
                                              
        ob_start();
        @session_start();    
        //tên bảng database chứa các cổ đông không đồng ý hoặc không có ý kiến
        $_SESSION['DBNghiQuyet']=$DBNghiQuyet;
        $_SESSION['tenNghiQuyet']=$tenNghiQuyet;
        $_SESSION['tenBieuMau']=$_POST['tenBieuMau'];
        $_SESSION['trangthai']=$_POST['trangthai'];
        $_SESSION['noidungNghiQuyet']=$_POST['noidungNghiQuyet'];        
        header('Location:NghiQuyet/.');
            
    }
    
    //vô hiệu hóa nút nghị quyết đã hoàn thành
    if(isset($_POST['bttEnd'])){   
        try{
            $sql = 'UPDATE '.$Db_DsNghiQuyet.' SET
                        TrangThai = :tt        
                    WHERE DBNghiQuyet = :dbnq';
            $s = $pdo->prepare($sql);   
            $s->bindValue(':tt', 1);
            $s->bindValue(':dbnq', $_POST['dbNghiQuyet']);
            $s->execute();
        }
        catch(PDOException $e){
            $output='Không thể sửa DB dsNghiQuyet'.$e->getMessage();
            include'../helper/output.html.php';
            exit();
        }
        header('Location:.');
    }
    
    include 'DSNghiQuyet.html.php';
}
else{
    $error="Access is denied!!";
    $goto="..";
    include "../helper/error.html.php";
}
