<?php
include_once("../ConnectDB/UniversalConnect.php");
$pdo=new UniversalConnect();
$pdo=$pdo->doConnect();

try{
    $sql="SELECT * FROM dsbaucu_hdqt WHERE MaCD='vns001'";
    $result=$pdo->query($sql);
}
catch(PDOException $e)
{
    $output='Không thể thực hiện câu lệnh truy vấn SELECT bảng CoDong'.$e->getMessage();
    include'../helper/output.html.php';
    exit();
}
$mang= $result->fetch();
var_dump($mang);
foreach($mang as $key=>$value){
    echo $mang[$key];   
    
    echo "</br>";
}

foreach ($colors as $key => $color) {
    $colors[$key] = strtoupper($color);
}