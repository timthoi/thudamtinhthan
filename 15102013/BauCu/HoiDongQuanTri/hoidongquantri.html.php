<html>
<head>
    <meta charset="utf-8" />
    <title>Bầu cử</title>    
    <script src="../../jquery/jquery-1.10.1.min.js"></script>    
    <script src="../../jquery/jquery.dataTables.js"></script>
    <script src="../../jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="../../jquery/jquery.validate.min.js"></script>    
    <link rel="stylesheet" href="../../jquery/redmond/jquery-ui.css"/>
    <style type="text/css">
    </style>
</head>
<body>
<h1>BẦU CỬ</h1>
<h2>ỨNG CỬ THÀNH VIÊN HỘI ĐỒNG QUẢN TRỊ</h2>
<h3>Số lượng cổ đông tham dự: <?php echo $slCoDong;?></h3>
<h3>Số lượng cổ đông đã bầu cử: <?php echo $slCoDongDaBC;?></h3>

<?php if(isset($dsUngVien)):?>
<h2>Danh sách ứng viên</h2>
<form id="frm_UngVien" method="post" action=".">

<div id="macodong_baucu">Mã cổ đông</div>     
<div>    
    <label>SCP hiện có</label>
    <div id="socophan_baucu">Tổng</div>
    <input type="hidden" name="socophan_baucu"/>
</div>
<div> 
    <label>SCP bầu cử</label>
    <div id="tongSoCoPhan_baucu">Tổng</div>
    <!-- dùng để validate - validate  bằng name -->
    <input type="hidden" name="tongSoCoPhan_baucu" id="tongSCP_baucu"/>        
</div>  
<div class="trangthai"></div>
<div><input type="submit" id="btt_baucu" name="btt_baucu" value="OK" disabled="" /></div>
<!-- dùng để validate -->
<input type="hidden" name="macodong_baucu" id="mcd_baucu"/>    
 
<table id="tbUngVien"> 
 <thead>
    <tr>
        <th>STT</th>
        <th>Họ Tên</th>
        <th>Số cổ phần</th>           
        <th>Nhập</th>
    </tr>
 </thead>

 <tbody>
    <?php $i=0;?>    
    <?php 
      $i=0; 
      foreach ($dsUngVien as $uv):?>      
        <tr>       
          <td>
            <?php  echo $i; ?>        
          </td>
          <td>
            <?php echo $uv['hoten']; ?>        
          </td>
          <td>
            <?php echo $uv['socophan']; ?>        
          </td>
          <td>                     
            <input  disabled="" class="required digits error"
            type="text" id="<?php echo $uv['idUngVien']."_baucu";?>" 
            name="<?php echo "socophan[$i]"; ?>" value="" placeholder="số cổ phần" />                        
          </td>              
        </tr>
        <?php $i++;?>        
    <?php endforeach; ?>
    
 </tbody>
</table>


</form>
<?php endif; ?>

              

<div>
    <label>Mã cổ đông</label>
    <input type="text" name="maCoDong" id="maCoDong"/>
    <input type="submit" value="Kiểm tra" name="btt1" id="kiemtra"/>
</div>

<fieldset name="thongtin" id="thongtin">
    <legend>Thông tin:</legend>
    <form method="post" name="CoDong" action=".">     
        <div>Mã cổ đông:<span id="maCD"></span></div>                
        <div>Họ tên:<span id="hoten"></span></div>
        <div>CMND:<span id="cmnd"></span></div>
        <div>Ngày cấp:<span id="ngaycap"></span></div>
        <div>Điện thoại:<span id="dienthoai"></span></div>
        <div>Địa chỉ:<span id="diachi"></span></div>
        <div>Sổ cổ phần:<span id="socophan"></span></div>
        <div>
            <div class="trangthai"></div>
            <input type="hidden" name="maCoDong" id="mcd"/>            
            <input type="hidden" name="socophan" id="socophan"/>      
        </div>
    </form>
</fieldset>
<?php 
ob_start();
@session_start(); 
$dsIdUngVien=$_SESSION['dsIdUngVien'];
?>
<script>   
 $(document).ready(function(){ 
    var slUngVien=<?php echo (isset($dsUngVien))?count($dsUngVien):0;?>;
    var dsIdUngVien=<?php echo json_encode($dsIdUngVien );?>;
    function sumSCP(){
        var sum=0;
        for(var i=0;i<dsIdUngVien.length;i++){
            var a="idUngVien"+dsIdUngVien[i];                    
            var idUngVien=$("#"+a+"_baucu");
            sum=sum+parseInt(idUngVien.val());                                                                  
        }     
        return sum;
    }               
    $("#frm_UngVien").validate();
     
   
   var sum=0;
   for(var i=0;i<dsIdUngVien.length;i++){
        var a="idUngVien"+dsIdUngVien[i];
        var idUngVien=$("#"+a+"_baucu");                                        
        idUngVien.blur(function(){
            var sum=sumSCP();              
            if($(this).val()=='') {
                $(this).val('0');
                var sum=sumSCP();                
                $("#tongSoCoPhan_baucu").text(sum);
            }
                                                        
            if(sum>$("#socophan_baucu").text()) {
                  $("input#btt_baucu").attr("disabled", "disabled");
                  alert("Lớn hơn SCP được phép rồi")       
            }
            else{ 
                $("input#btt_baucu").removeAttr("disabled");  
                $("#tongSoCoPhan_baucu").text(sum);

            }                                                                        
        });                                                   
    }
   
   $("#kiemtra").click(function(e){
    $.ajax({
           type:'POST',
           url:'../ajax.php',
           data:{
            maCD:function(){return $("#maCoDong").val()}
           },
           success:function(data){            
            if(data!="false"){            
                var codong = JSON.parse(data);                                                                                      
                
                $("span#maCD").text(codong['macd']);
                $("span#hoten").text(codong['ho']+" "+codong['ten']);
                $("span#cmnd").text(codong['cmnd']);
                $("span#ngaycap").text(codong['ngaycap']);
                $("span#dienthoai").text(codong['dienthoai']);
                $("span#diachi").text(codong['diachi']);
                $("span#socophan").text(codong['socophan']);
                var socophan_baucu=codong['socophan']*slUngVien;                                
                                                    
                $("#macodong_baucu").text(codong['macd']);            
                $("input#mcd_baucu").prop("value",codong['macd']);                                
                $("#socophan_baucu").text(socophan_baucu);
                //enable khi nhập đúng
                $("input#btt_baucu").removeAttr("disabled");               
                                
                for(var i=0;i<dsIdUngVien.length;i++){
                    var a="idUngVien"+dsIdUngVien[i];                    
                    var idUngVien=$("#"+a+"_baucu");
                    idUngVien.removeAttr("disabled");
                    idUngVien.val(codong[a]);                    
                }                
                var sum=sumSCP();                
                $("#tongSoCoPhan_baucu").text(sum);

                
                //Đã bầu cử hoặc chưa bầu cử
                $(".trangthai").text(codong['trangthai']);                
            }
            else
            {
                $("#tongSoCoPhan_baucu").text("");
                $("span#maCD").text("");
                $("span#hoten").text("");
                $("span#cmnd").text("");
                $("span#socophan").text("");
                $(".trangthai").text("");
                $("input#mcd_baucu").prop("value","");  
                $("span#ngaycap").text("");
                $("span#diachi").text("");
                $("span#dienthoai").text("");
                //disable khi nhập sai
                $("input#btt_baucu").attr("disabled", "disabled");                                        
                for(var i=0;i<dsIdUngVien.length;i++){
                    var a="idUngVien"+dsIdUngVien[i];                    
                    var idUngVien=$("#"+a+"_baucu");
                    idUngVien.attr("disabled", "disabled");                                        
                }                
                
                $("#macodong_baucu").text("Mã cổ đông");
                $("#socophan_baucu").text("Tổng");                           
                alert("Mã cổ đông không có trong danh sách tham dự");
            }
           }                      
        });        
    })
})
</script>
</body>
</html>
