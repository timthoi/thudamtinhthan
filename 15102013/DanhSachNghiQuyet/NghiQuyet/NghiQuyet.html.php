<html>
<head>
    <meta charset="utf-8"/>
    <title><?php echo $tenNghiQuyet;?></title>   
    <script src="../../jquery/jquery-1.10.1.min.js"></script>    
    <script src="../../jquery/jquery.dataTables.js"></script>
    <script src="../../jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="../../jquery/jquery.validate.min.js"></script>    
    <link rel="stylesheet" href="../../jquery/redmond/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="../../css/style.css"/>      
    <style type="text/css">        
 fieldset {
    background-color: rgba(126,208,214,0.3);
    border: 3px solid rgb(255,255,255);       
    border-radius: 10px; 
    margin: 0 0 1em 0;
    width: 300px;
}
fieldset:hover {
    background-color: rgba(126,208,214,0.5);
}
legend {
    font-size: 133%;
    font-weight: bold;
    padding:20px;
}
fieldset div{
    float: left;
    width: 100%;
    padding: 0 0 0.75em 0;
    position: relative;
}
fieldset label {
    float: left;
    width: 40%;
    font-size: 116.7%;
}
fieldset span {
    display: block;
    float: left;
    padding-left: 40px;    
    font-size: 116.7%;
    font-weight: bold;    
}     
    </style>
</head>

<body>
<div class="wrapper">
<header>
	<div class="left"><img src="../../img/VINASUN.gif" width="201" height="200" alt="logoVinasun"></div>
  	<div class="right">
  	  <div>CÔNG TY CỔ PHẨN ÁNH DƯƠNG VIỆT NAM </div>
  	  <div>Vinasun Corporation</div>
	  <h1>ĐẠI HỘI CỔ ĐÔNG</h1>
      <div class="logout"><?php echo $username;?><a href="?logout"><img src="../../img/application_exit.png" width="24" height="24" alt="exit"></a></div>    
    </div>
    
</header>    
<div class="horizon"></div>

<div class="content">    
<h1><?php echo $tenNghiQuyet;?></h1>
<form action=".." method="post">    
     <input type="hidden" value="<?php echo $DBNghiQuyet;?>" name="dbNghiQuyet"/>        
     <input type="submit" value="<?php echo ($trangthai==1)?"Đã hoàn thành":"Hoàn thành";?>" id="btt" name="bttEnd" <?php if($trangthai==1) echo"disabled";?>/>
     <input type="submit" value="Quay lại"/>
</form>

<form method="post" action=".">   
    <input type="submit" value="Xuất nghị quyết" id="btt_XuatNQ" name="btt"/>
      
    <input type="hidden" value="<?php echo $xuatExcel;?>" id="ketquaXuat"/>
    <input type="submit" value="Xuất danh sách cổ đông" id="btt" name="btt" title="file Excel duoc lưu mặc định C:/nghiquyet/"/>
</form>


<div style="float: left;width: 100%;margin-top: 20px;">
<div style="float: left;width: 50%;">
    <label>Mã cổ đông</label>
    <input type="text" name="maCoDong" id="maCoDong"/>
    <input type="submit" value="Kiểm tra" name="btt1" id="kiemtra" <?php if($trangthai==1) echo "disabled";?>/>
    <form method="post" action=".">
        <input type="hidden" name="maCoDong" id="mcd"/>
        <input type="hidden" name="hoten" id="hoten"/>        
        <input type="hidden" name="cmnd" id="cmnd"/>
        <input type="hidden" name="ngaycap" id="ngaycap" />
        <input type="hidden" name="dienthoai" id="dienthoai"/>
        <input type="hidden" name="diachi" id="diachi"/>
        <input type="hidden" name="socophan" id="socophan"/>        
        <input type="hidden" name="trangthaithamdu" id="trangthaithamdu"/>
                                
        <fieldset name="thongtin" id="thongtin">
            <legend>Thông tin:</legend>            
            <div id="trangthai" style="color: red;"></div>
            <div>         
                <label>Mã cổ đông:</label>
                <span id="maCD"></span>
            </div>  
            <div>       
                <label>Họ tên:</label>
                <span id="hoten"></span>
            </div>
            <div>
                <label>CMND:</label>
                <span id="cmnd"></span>
            </div>
            <div>
                <label>Ngày cấp:</label>
                <span id="ngaycap"></span>
            </div>
            <div>
                <label>Điện thoại:</label>
                <span id="dienthoai"></span>
            </div>
            <div>
                <label>Địa chỉ:</label>
                <span id="diachi"></span>
            </div>
            <div>
                <label>Sổ cổ phần:</label>
                <span id="socophan"></span>
            </div>
                <div>                                                         
                    <input type="submit" value="Không đồng ý" name="btt_BieuQuyet" disabled="" />
                    <input type="submit" value="Ý kiến khác" name="btt_BieuQuyet" disabled="" />                                                        
                </div>    
        </fieldset>
    </form>

</div>    
<div style="float: left;width: 50%;">
    <div>
        <h4>Đồng ý : </h4>
        <label>Số cổ phần:<?php echo $dongy;?></label>
        <div class="pb1" class="1"><div class="label_pb1"><?php echo $tileDongY.'%';?></div></div>
    </div>
    <div>          
        <h4>Không đồng ý: </h4>
        <div><label>Số lượng cổ đông: <?php echo $slkhongdongy;?></label></div>
        <label>Số cổ phần: <?php echo $khongdongy;?></label>
        <div class="pb2" class="1"><div class="label_pb2"><?php echo $tileKhongDongY.'%';?></div></div>
    </div>
    <div>
        <h4>Ý kiến khác: </h4>
        <div><label>Số lượng cổ đông: <?php echo $slykienkhac;?></label></div>
        <label>Số cổ phần:<?php echo $ykienkhac;?></label>        
        <div class="pb3" class="1"><div class="label_pb3"><?php echo $tileYKienKhac.'%';?></div></div>
    </div>
</div>

</div>

<h2><?php echo "DANH SÁCH CỔ ĐÔNG KHÔNG ĐỒNG Ý HOẶC Ý KIẾN KHÁC";?></h2>
<?php if(isset($dsCoDong)):?>
<table id="tbCoDong" class="pretty">
    <thead>
        <th>Mã cổ đông</th>
        <th>Họ tên</th>        
        <th>CMND</th>
        <th>Ngày cấp</th>
        <th>Điện thoại</th>
        <th>Địa chỉ</th>
        <th>Số cổ phần</th>        
        <th>Trạng thái tham dự</th>
        <th>Biểu quyết</th>
        <th>Thao tác</th>
    </thead>
    <tbody>
        <?php foreach($dsCoDong as $codong): ?>
        <form method="post" action="."> 
          <tr>            
             <td>
                <?php echo $codong['macd'];?>
                <input type="hidden" value="<?php echo $codong['macd'];?>" name="maCoDong"/>   
             </td>
             <td><?php echo $codong['hoten'];?></td>
             <td>
                <?php echo $codong['cmnd'];?>
                <input type="hidden" value="<?php echo $codong['cmnd'];?>" name="cmnd"/>
             </td>
             <td><?php echo $codong['ngaycap'];?></td>
             <td><?php echo $codong['dienthoai'];?></td>
             <td><?php echo $codong['diachi'];?></td>
             <td><?php echo $codong['socophan'];?></td>
             <td><?php echo $codong['trangthaithamdu']; ?></td>
             <td><?php echo $codong['bieuquyet']; ?></td>
             <td><input type="submit" value="Delete" name="btt"/></td>             
          </tr>
        </form>
        <?php endforeach;?>
    </tbody>
</table>


<?php  endif; ?>
</div>
<footer>
	<div>Copyright © 2013 by timthoi. Vinasun Corp.</div>
</footer>
</div>


<script>
$(document).ready(function(){      
    if($("#ketquaXuat").val()!=""){
        alert($("#ketquaXuat").val());
    }
    $( ".pb1" ).progressbar({
        value: <?php echo $tileDongY;?>        
    });
    $( ".pb2" ).progressbar({
        value: <?php echo $tileKhongDongY;?>
    });
    $( ".pb3" ).progressbar({
        value: <?php echo $tileYKienKhac;?>
    });
 
   
    $("#kiemtra").click(function(e){
     var tenNQ="<?php echo $DBNghiQuyet;?>";  
     $.ajax({
       type:'POST',
       //khong để trong cùng thư mục của NghiQuyet duoc vì dùng function .. giải quyết bằng dùng class 
       //cần phải khắc phục
       url:'../ajax.php',
       data:{
        maCD:function(){return $("#maCoDong").val()},
        tenNQ:tenNQ
       },
       success:function(data){        
        //tim thay                
        if(data!=false){            
            var codong = JSON.parse(data);                                             
                        
            $("span#maCD").text(codong['macd']);
            $("span#hoten").text(codong['hoten']);
            $("span#cmnd").text(codong['cmnd']);
            $("span#ngaycap").text(codong['ngaycap']);
            $("span#dienthoai").text(codong['dienthoai']);
            $("span#diachi").text(codong['diachi']);
            $("span#socophan").text(codong['socophan']);
            $("span#trangthaithamdu").text(codong['trangthaithamdu']);
            //nhung ĐÃ bieu quyet            
            if(codong['bieuquyet']!="") {                    
                $("#trangthai").text(codong['bieuquyet']);
            }
            //chua bieu quyet
            else
            {
                $("#trangthai").text("");
                $("input#mcd").prop("value",codong['macd']);
                $("input#hoten").prop("value",codong['hoten']);                
                $("input#ngaycap").prop("value",codong['ngaycap']);
                $("input#dienthoai").prop("value",codong['dienthoai']);
                $("input#diachi").prop("value",codong['diachi']);
                $("input#socophan").prop("value",codong['socophan']);
                $("input#cmnd").prop("value",codong['cmnd']);
                $("input#trangthaithamdu").prop("value",codong['trangthaithamdu']);                
                                            
                $("input[name$='btt_BieuQuyet']" ).prop("disabled",false);
            }
        }
        //khong tim thay
        else
        {
            $("span#trangthaithamdu").text("");
            $("span#maCD").text("");
            $("span#hoten").text("");
            $("span#cmnd").text("");
            $("span#socophan").text("");
            $("#trangthai").text("");
            $("span#ngaycap").text("");
            $("span#dienthoai").text("");
            $("span#diachi").text("");
            $("input[name$='btt_BieuQuyet']" ).prop("disabled",true);          
            alert("Mã cổ đông không có trong danh sách tham dự");
        }
       }                      
    });         
    })
    $("#tbCoDong").dataTable({
         "bJQueryUI": true
    });
});
     
</script>
</body>
</html>