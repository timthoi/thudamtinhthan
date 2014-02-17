<?php
//lấy thông tin chi tiết mã cổ đông
function isInDsCoDong($maCD)
{
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    
    try{
        $sql='SELECT * FROM CoDong WHERE MaCD=:MaCD';
        $s=$pdo->prepare($sql);
        $s->bindValue(":MaCD",$maCD);
        $s->execute();        
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng CoDong'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }
    $row=$s->fetch();
    //tim thay
    if($row[0]!=NULL){
        $a=array('macd'=>$row['MaCD'],
            'ho'=>$row['Ho'],
            'ten'=>$row['Ten'],            
            'cmnd'=>$row['CMND'],
            'ngaycap'=>date("d-m-Y",strtotime($row['ngaycap'])),
            'dienthoai'=>$row['dienthoai'],
            'diachi'=>$row['diachi'],
            'socophan'=>$row['SoCoPhan']);
        return $a;
    }
    //khong tim thay
    else{
        return FALSE;
    }    
}
function isInDsThamDu($maCD)
{   
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    
    try{
        $sql='SELECT * FROM ThamDu WHERE MaCD=:MaCD';
        $s=$pdo->prepare($sql);
        $s->bindValue(":MaCD",$maCD);
        $s->execute();        
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng ThamDu'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }
    $row=$s->fetch();
    //tim thay
    if($row[0]!=NULL){
        $a=array('macd'=>$row['MaCD'],
            'ho'=>$row['Ho'],
            'ten'=>$row['Ten'],            
            'cmnd'=>$row['CMND'],
            'ngaycap'=>date("d-m-Y",strtotime($row['ngaycap'])) ,
            'dienthoai'=>$row['dienthoai'],
            'diachi'=>$row['diachi'],
            'socophan'=>$row['SoCoPhan'],
            'trangthaithamdu'=>$row['trangthaithamdu']);
        return $a;
    }
    //khong tim thay
    else{
        return FALSE;
    }    
}
//trả về chi tiết mã cô đông đã tham dự và bầu cử chức danh - trong bảng dsBauCu
function isInDSBauCu($maCD,$db,$dsIdUngVien){
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try{
        $sql="SELECT * FROM ".$db." WHERE MaCD=:MaCD";
        $s=$pdo->prepare($sql);
        $s->bindValue(":MaCD",$maCD);
        $s->execute();        
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng CoDong'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }
    $mang= $s->fetch();
    $a=array("macd"=>$mang['MaCD'],
            "chucdanh"=>$mang['ChucDanh'],
            "trangthai"=>$mang['trangthai']);
   
    foreach($dsIdUngVien as $idUngVien){
        $x="idUngVien".$idUngVien;
        $a[$x]=$mang[$x];
    }
    return $a;
}
function isIn($db,$maCD)
{
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    
    try{
        $sql='SELECT * FROM '.$db.' WHERE MaCD=:MaCD';
        $s=$pdo->prepare($sql);
        $s->bindValue(":MaCD",$maCD);
        $s->execute();        
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng '.$db.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }
    $row=$s->fetch();
    //tim thay trả về mã cổ đông
    if($row[0]!=NULL){       
        return $row[0];
    }
    //khong tim thay
    else{
        return FALSE;
    }    
}

//tim theo cmnd tim thay tra về mã cổ đông
function CMNDisIn($db,$cmnd)
{
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    
    try{
        $sql='SELECT * FROM '.$db.' WHERE CMND=:cmnd';
        $s=$pdo->prepare($sql);
        $s->bindValue(":cmnd",$cmnd);
        $s->execute();        
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng '.$db.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }
    $row=$s->fetch();
    //tim thay trả về mã cổ đông nhận uy quyen
    if($row[0]!=NULL){          
        return $row[2];
    }
    //khong tim thay
    else{
        return FALSE;
    }    
}

function insertIn_ThamDu($mang){
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try{
        $sql='INSERT INTO thamdu SET
                MaCD=:maCD,
                Ho=:Ho,
                Ten=:Ten,
                SoCoPhan=:SoCoPhan,
                ngaycap=:ngaycap,
                dienthoai=:dienthoai,
                diachi=:diachi,
                CMND=:CMND,
                trangthaithamdu=:trangthaithamdu';
        $s=$pdo->prepare($sql);
        $s->bindValue(':maCD',$mang['macd']);
        $s->bindValue(':Ho',$mang['ho']);            
        $s->bindValue(':Ten',$mang['ten']);
        $s->bindValue(':SoCoPhan',$mang['socophan']);
        $s->bindValue(':ngaycap',date("Y-m-d",strtotime($mang['ngaycap'])));
        $s->bindValue(':dienthoai',$mang['dienthoai']);
        $s->bindValue(':diachi',$mang['diachi']);
        $s->bindValue(':CMND',$mang['cmnd']);
        $s->bindValue(':trangthaithamdu',$mang['trangthai']);
        $s->execute();
    }
    catch(PDOException $e)
    {
        $output="Không thể thực hiện câu lệnh INSERT vào bảng ThamDu".$e->getMessage();
        include '../helper/output.html.php';
        exit();
    }            
}

function insertIn_CoDongUQ($mang){
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try{
        $sql='INSERT INTO codonguyquyen SET
                MaCD=:maCD,                
                socophan=:SoCoPhan,
                CMND=:CMND,
                trangthaithamdu=:trangthaithamdu,
                MaCDnhanUQ=:MCDnhanUQ';
        $s=$pdo->prepare($sql);
        $s->bindValue(':maCD',$mang['macd']);        
        $s->bindValue(':SoCoPhan',$mang['socophan']);
        $s->bindValue(':CMND',$mang['cmnd']);
        $s->bindValue(':trangthaithamdu',$mang['trangthai']);
        $s->bindValue(':MCDnhanUQ',$mang['mcdNhanUQ']);
        $s->execute();
    }
    catch(PDOException $e)
    {
        $output="Không thể thực hiện câu lệnh INSERT vào bảng CoDongUyQuyen".$e->getMessage();
        include '../helper/output.html.php';
        exit();
    }            
}

function xoaCoDongNhanUyQuyen($macd){
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try{
       $sql = 'DELETE FROM codonguyquyen WHERE MaCDnhanUQ = :macd';
        $s = $pdo->prepare($sql);
        $s->bindValue(':macd', $macd);
        $s->execute();        
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh DELETE bảng codonguyquyen'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }  
}

function xoaCoDongUyQuyen($macd){
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try{
       $sql = 'DELETE FROM codonguyquyen WHERE MaCD = :macd';
        $s = $pdo->prepare($sql);
        $s->bindValue(':macd', $macd);
        $s->execute();        
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh DELETE bảng codonguyquyen'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }  
}

function xoaCoDongThamDu($macd){
    include_once("../ConnectDB/UniversalConnect.php");
    $pdo=new UniversalConnect();
    $pdo=$pdo->doConnect();
    try{
       $sql = 'DELETE FROM thamdu WHERE MaCD = :macd';
        $s = $pdo->prepare($sql);
        $s->bindValue(':macd', $macd);
        $s->execute();        
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh DELETE bảng thamdu'.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }  
}

function tongSCP($pdo,$db){
    try{
       $sql = 'SELECT SUM(socophan) as TongSCP FROM '.$db;
       $result=$pdo->query($sql);
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh DELETE bảng '.$db.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }  
    $a=$result->fetch();
    return $a[0];
}
function soluong($pdo,$db){    
    try{
       $sql = 'SELECT COUNT(*) FROM '.$db;
       $result=$pdo->query($sql);
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh DELETE bảng '.$db.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }  
    $a=$result->fetch();
    return $a[0];
}

function soluongDk($pdo,$db,$dk){    
    try{
        $sql = "SELECT COUNT(*) FROM ".$db." WHERE trangthai='".$dk."'";
        $result=$pdo->query($sql);
    }
    catch(PDOException $e)
    {
        $output='Không thể thực hiện câu lệnh DELETE bảng '.$db.$e->getMessage();
        include'../helper/output.html.php';
        exit();
    }  
    $a=$result->fetch();
    return $a[0];
}