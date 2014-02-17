<html>
<head>
    <title>Xóa sửa cổ đông</title>
    <meta charset="utf-8"/>        
    <script src="../jquery/jquery.dataTables.js"></script>
    <script src="../jquery/jquery-1.10.1.min.js"></script>    
    <script src="../jquery/jquery.dataTables.js"></script>
    <script src="../jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="../jquery/jquery.validate.min.js"></script>    
    <link rel="stylesheet" href="../jquery/redmond/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>  
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
	<div class="left"><img src="../img/VINASUN.gif" width="201" height="200" alt="logoVinasun"></div>
  	<div class="right">
  	  <div>CÔNG TY CỔ PHẨN ÁNH DƯƠNG VIỆT NAM </div>
  	  <div>Vinasun Corporation</div>
	  <h1>ĐẠI HỘI CỔ ĐÔNG</h1>
      <div class="logout"><?php echo $username;?><a href="?logout"><img src="../img/application_exit.png" width="24" height="24" alt="exit"></a></div>    
    </div>
    
</header>    
<div class="horizon"></div>

<div class="content">
<h1>Quản lý cổ đông</h1>
<fieldset>   
    <legend>Thông tin:</legend>    
    <h3 style="color: red;">Trạng thái tham dự : <?php echo $codong['trangthaithamdu'];?></h3>        
    
    <div>    
        <label>Mã cổ đông:</label>
        <span><?php echo $codong['macd'];?></span>
        <?php $macd_o=$codong['macd'];?>
    </div>      
    <div>          
        <label>Họ tên:</label>
        <span><?php echo $codong['ho'].' '.$codong['ten'];?></span>
    </div>
    <div>
        <label>CMND:</label>
        <span><?php echo $codong['cmnd'];?></span>
    </div>
    <div>
        <label>Ngày cấp:</label>
        <span><?php echo $codong['ngaycap'];?></span>
    </div>
    <div>
        <label>Điện thoại:</label>
        <span><?php echo $codong['dienthoai'];?></span>
    </div>
    <div>
        <label>Địa chỉ:</label>
        <span><?php echo $codong['diachi'];?></span>
    </div>
    <div>
        <label>Sổ cổ phần:</label>
        <span ><?php echo $codong['socophan'];?></span>
    </div>            
</fieldset>        
    <form action="delete.php" method="post">
        <input type="hidden" value="<?php echo $codong['macd'];?>" name="macd"/>
        <input type="submit" value="Xóa cổ đông" name="btt_Del"/>
        <input type="submit" value="Xóa ds ủy quyền" name="btt_Del"/>           
    </form>

     <?php if($codong['trangthaithamdu']=="Cổ đông ủy quyền" || $codong['trangthaithamdu']=='Người nhận ủy quyền'):?>
    <table id="tbThamDu" class="pretty">
     <caption>Danh sách cổ đông đã ủy quyền</caption>
     <thead>
        <tr>
            <th>Mã Cổ Đông</th>
            <th>Họ tên</th>        
            <th>CMND</th>
            <th>Ngày cấp</th>
            <th>Điện thoại</th>
            <th>Địa chỉ</th>
            <th>Số cổ phần</th>
            <th>Admin</th>            
        </tr>
     </thead>
     <tbody>
     <?php foreach($dsCoDongUQ as $codong):?>
        <tr>       
          <td>
            <?php echo $codong['macd']; ?>        
          </td>
          <td>
            <?php echo $codong['ho'].' '.$codong['ten']; ?>        
          </td>
          <td>
            <?php echo $codong['cmnd']; ?>        
          </td>
          <td>
            <?php echo $codong['ngaycap']; ?>        
          </td>
          <td>
            <?php echo $codong['dienthoai']; ?>        
          </td>
          <td>
            <?php echo $codong['diachi']; ?>        
          </td>
          <td>
            <?php echo $codong['socophan']; ?>        
          </td>                       
            <td>
                <form method="post" action="delete.php">         
                    <input type="hidden" value="<?php echo $codong['macd']; ?>" name="macd"/>
                    <input type="hidden" value="<?php echo $codong['socophan']; ?>" name="socophan"/>     
                    <input type="submit" value="xóa" name="dialogbtt"/>                  
                    <input type="submit" value="sửa" name="dialogbtt"/>
                </form>
            </td>             
        </tr>        
     <?php endforeach;?>
    </tbody>
    </table>
    <?php endif;?>   
    
    
    <form id="dialog-form" title="Danh sách mã cổ đông đã ủy quyền">
    
        <?php if (isset($dsCoDongUQ)){
            foreach($dsCoDongUQ as $codong):?>
            <div><input type="radio" name="maCD_dialog" value="<?php echo $codong['macd'];?>"  <?php echo ($macd_o==$codong['macd'])?"checked":""; ?> /><?php echo $codong['macd'];?></div>                                  
        <?php endforeach;}?>                
    </form>
    
    <form action="delete.php" method="post">    
        <div><input type="submit" value="Quay lại" name="back"/></div>    
    </form>
    
</div>

<footer>
	<div>Copyright © 2013 by timthoi. Vinasun Corp.</div>
</footer>
</div>

<script>
$(document).ready(function(){   
    $("#tbThamDu").dataTable({
             "bJQueryUI": true
        });
    $("#bttChange").click(function(e){
        e.preventDefault();
         $("#dialog-form").dialog( "open" );
    });
    var maCD="<?php echo $macd_o;?>";  
    $("#dialog-form").dialog({
        autoOpen:false,
        height: 450,
        width: 350,
        modal: true,
        position: ['center', 'top'],
        buttons:{
            "Thay đổi":function(){
                $.ajax({
                   type:'POST',
                   url:'ajax6.php',
                   data:{
                    maCD:maCD,
                    maCD_UQ:function(){return $('[name=maCD_dialog]:checked').val();}                                                                               
                   },
                   success:function(data){
                    alert(data);
                    }
                    })
            },
            "Cancel": function () {
                $(this).dialog("close");
            }
        }        
    })
});
</script>
</body>
</html>