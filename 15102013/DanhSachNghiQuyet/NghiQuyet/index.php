<?php
ob_start();
@session_start();
//chưa hoàn thiện
const TONGCOPHAN=1111;

if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['role'])){
    $role=$_SESSION['role'];
    $username=$_SESSION['username']; 
    include_once("../../ConnectDB/UniversalConnect.php");
    $xuatExcel="";        
    //session tên db NghiQuyet và tên from nghị quyết    
    $DBNghiQuyet=$_SESSION['DBNghiQuyet'];
    $tenNghiQuyet=$_SESSION['tenNghiQuyet'];
    $tenBieuMau=$_SESSION['tenBieuMau'];
    $trangthai=$_SESSION['trangthai'];
    
    $dongy=100;
    $khongdongy=$ykienkhac=0;
    $slkhongdongy=$slykienkhac=0;
    $tileKhongDongY=0;
    $tileYKienKhac=0;
    $tileDongY=100;
    
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    
    
    //kiem tra xem đã tồn tại DB Nghị quyết chưa
    
    //nếu db nghị quyết tồn tại liệt kê các cỏ đông biểu quyết không đồng ý hoặc không ý kiến
    try{
        $sql="SELECT * FROM ".$DBNghiQuyet;
        $result=$pdo->query($sql);
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh truy vấn DBNGHIQUYET'.$e->getMessage();
        include'../../helper/output.html.php';
        exit();
    }
    
    while($row=$result->fetch())
    {
        $dsCoDong[]=array('macd'=>$row['MaCD'],
                    'hoten'=>$row['HoTen'],
                    'ngaycap'=>$row['NgayCap'],                  
                    'dienthoai'=>$row['DienThoai'],
                    'socophan'=>$row['SoCoPhan'],
                    'diachi'=>$row['DiaChi'],
                    'cmnd'=>$row['CMND'],
                    'trangthaithamdu'=>$row['TrangThaiThamDu'],
                    'bieuquyet'=>$row['BieuQuyet']
                    );
    }
    //nếu DBNghiQuyet có cổ đông đã biểu quyết thì hiển thị là KHONG DONG Y hay KHONG Y KIEn
    if(isset($dsCoDong)){
        foreach($dsCoDong as $cd){
            if($cd['bieuquyet']=='Không đồng ý') {
                $khongdongy=$khongdongy+$cd['socophan'];
                $slkhongdongy=$slkhongdongy+1;
            }
            if($cd['bieuquyet']=='Ý kiến khác') {
                $ykienkhac=$ykienkhac+$cd['socophan'];
                $slykienkhac=$slykienkhac+1;
            }                        
        }   
        $dongy=TONGCOPHAN-$khongdongy-$ykienkhac;                                 
        $tileKhongDongY= round($khongdongy/TONGCOPHAN*100,3);
        $tileYKienKhac= round($ykienkhac/TONGCOPHAN*100,3);
        $tileDongY=100-$tileKhongDongY-$tileYKienKhac;
    }
    
    
    
    if(isset($_POST['btt_BieuQuyet'])){
        
        $bieuquyet=$_POST['btt_BieuQuyet'];            
        //kiểm tra xem mcd đã biểu quyết chưa là ko cần thiết
        //thệm vào DB Nghị Quyết    
        try{
            $sql='INSERT INTO '.$DBNghiQuyet.' SET
                    MaCD=:maCD,
                    HoTen=:HoTen,                                        
                    SoCoPhan=:SoCoPhan,
                    CMND=:CMND,
                    NgayCap=:NgayCap,
                    DienThoai=:DienThoai,
                    DiaChi=:DiaChi,                    
                    TrangThaiThamDu=:trangthaithamdu,
                    BieuQuyet=:bieuquyet';
            $s=$pdo->prepare($sql);                                
            $s->bindValue(':maCD',$_POST['maCoDong']);                        
            $s->bindValue(':HoTen',$_POST['hoten']);                        
            $s->bindValue(':SoCoPhan',$_POST['socophan']);
            $s->bindValue(':CMND',$_POST['cmnd']);
            $s->bindValue(':NgayCap',$_POST['ngaycap']);
            $s->bindValue(':DienThoai',$_POST['dienthoai']);
            $s->bindValue(':DiaChi',$_POST['diachi']);
            $s->bindValue(':trangthaithamdu',$_POST['trangthaithamdu']);
            
            $s->bindValue(':bieuquyet',$bieuquyet);
            $s->execute();                                         
        }
        catch(PDOException $e)
        {
            $output="Không thể thực hiện câu lệnh INSERT vào bảng NghiQuyet".$e->getMeassage();
            include '../../helper/output.html.php';
            exit();
        }
        header('Location:.');          
    }
    
    //chuyển file lên server thêm ${dongy} ${khongdongy} ${khongdykien} sau đó save vào C:/nghiquyet chưa xử lý dc vụ file có dấu
    if (isset($_POST['btt'])){
       if($_POST['btt']=="Xuất nghị quyết"){
            require_once 'PHPWord/PHPWord.php';
            $PHPWord = new PHPWord();        
            $document = $PHPWord->loadTemplate("../".$tenBieuMau);
                    
            $document->setValue('dongy', $tileDongY);
            $document->setValue('khongdongy', $tileKhongDongY);
            $document->setValue('khongykien', $tileYKienKhac);
               
            $document->save($tenBieuMau);
            
            header ("Content-type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'");   
            header ("Content-disposition: attachment; filename=".$tenBieuMau.";");                
            readfile($tenBieuMau);     
       }
       if($_POST['btt']=='Delete'){
            try{
                
                $sql = 'DELETE FROM '.$DBNghiQuyet.' WHERE MaCD=:macd AND CMND=:cmnd';
                $s = $pdo->prepare($sql);
                $s->bindValue(':macd', $_POST['maCoDong']);
                $s->bindValue(':cmnd', $_POST['cmnd']);
                $s->execute();
            }
            catch(PDOException $e)
            {
                $output="Không thể thực hiện câu lệnh DELETE bảng NQ".$e->getMeassage();
                include '../../helper/output.html.php';
                exit();
            }
            header('Location:.');
       }
       
       if($_POST['btt']=='Xuất danh sách cổ đông'){
            if(isset($dsCoDong)){        
                include_once "../../Classes/PHPExcel.php";
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);
                
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Mã Cổ Đông');                
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Họ');
                $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Tên');
                $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Số cổ phần');        
                $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'CMND');
                $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Trạng thái tham dự');
                $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Biểu quyết');
                
                
                for($i=0;$i<count($dsCoDong);$i++){                        
                    $x=$i+2;
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$x, $dsCoDong[$i]['macd']);                
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$x, $dsCoDong[$i]['ho']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$x, $dsCoDong[$i]['ten']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$x, $dsCoDong[$i]['socophan']);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$x, $dsCoDong[$i]['cmnd']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$x, $dsCoDong[$i]['trangthaithamdu']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$x, $dsCoDong[$i]['ykien']);             
                }
                                
                define('UPLOAD_DIR2','C:/nghiquyet/');
                $fileName=UPLOAD_DIR2.$DBNghiQuyet.'.xlsx';    
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                $objWriter->save($fileName);  
                $xuatExcel="đã lưu vào c:/nghiquyet/".$DBNghiQuyet.".xlsx";
            }
            else{
                $xuatExcel='không có dữ liệu thì xuất cái gì';}    
        
       }
    }
    
     include 'NghiQuyet.html.php';
}
else{
    $error="Access is denied!!";
    $goto="...";
    include ".../helper/error.html.php";
}
