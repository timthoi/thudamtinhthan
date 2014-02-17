<html>
<head>
    <meta charset="utf-8"/>
    <title>Danh sách các nghị quyết</title>
    <script src="../jquery/jquery-1.10.1.min.js"></script>        
    <script src="../jquery/jquery.dataTables.js"></script>
    <script src="../jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="../jquery/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="../jquery/redmond/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>    
    <style type="text/css">

.frm_wrapper {    
    margin-left:50px;
    width: 400px;   
    border: 3px solid #ccc;
    padding:20px;    
    margin:20px 0px;
    border-radius: 10px;
    float:left;
}
.frm_wrapper div {
float: left;
width: 400px;
padding: 0 0 0.75em 0;
}
.frm_wrapper label {
float: left;
width: 120px;
}
.frm_wrapper textarea, .frm_wrapper input {
float: right;
width: 260px;
}

.frm_wrapper textarea{
height: 200px;
}

.frm_wrapper textarea:focus, form input:focus {
box-shadow: -2px 1px 2px 2px rgba(0, 0, 0, 0.1); 
}

.frm_wrapper input[type="submit"]:focus {
box-shadow: -2px 1px 2px 2px rgba(0, 0, 0, 0.1); 
}

.frm_wrapper input[type="submit"] {
float: right;
width: auto;
text-align: right;
}
.frm_wrapper label.error{
    color: red; 
    display:block;
    
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
<a href="?homepage">Homepage</a> 
<h2>DANH SÁCH CÁC NGHỊ QUYẾT</h2>
<?php if(isset($dsNghiQuyet)):
    foreach($dsNghiQuyet as $nq):?>        
      <form action="." method="post">    
        <input type="submit" value="<?php echo $nq['tenNghiQuyet'];?>" name="bttNQ" id="bttNQ"/>
        <label><?php echo ($nq['trangthai']==1)?'đã hoàn thành':'';?></label>
        <input type="hidden" value="<?php echo $nq['DBNghiQuyet'];?>" name="DBNghiQuyet"/>
        <input type="hidden" value="<?php echo $nq['tenBieuMau'];?>" name="tenBieuMau"/>
        <input type="hidden" value="<?php echo $nq['trangthai'];?>" name="trangthai"/>
        <input type="hidden" value="<?php echo $nq['noidungNghiQuyet'];?>" name="noidungNghiQuyet"/>
      </form>
<?php endforeach; endif;?>
       
<form action="." method="post" enctype="multipart/form-data" id="form_DsNghiQuyet">    
    <input type="submit" value="Thêm Nghị Quyết" <?php echo (isset($DBNghiQuyet))?"disabled":"";?> name="themnghiquyet" id="themnghiquyet"/>    
    <div <?php echo (isset($hidden))?$hidden:"";?> id="form_capnhap">    
      <h3 id="frm_title"></h3>
      <div class="frm_wrapper">                 
        <div>
            <label for="DBNghiQuyet">Database Nghị quyết</label>
            <input type="text" <?php echo (isset($DBNghiQuyet))?"disabled":"";?>  value="<?php echo (isset($DBNghiQuyet))?$DBNghiQuyet:"";?>"id="frm_DBNghiQuyet" name="DBNghiQuyet" placeholder="NQ1" class="required error"/>
            <input type="hidden" value="<?php echo (isset($DBNghiQuyet))?$DBNghiQuyet:"";?>"name="frmDBNghiQuyet" />            
        </div>        
        <div>
            <label for="tenNghiQuyet">Tên Nghị quyết</label>
            <input type="text" value="<?php echo (isset($tenNghiQuyet))?$tenNghiQuyet:"";?>" name="tenNghiQuyet" placeholder="Nghị quyết 1" class="required error"/>            
        </div>
        
        <div>
            <label for="noidungNghiQuyet">Nội dung nghị quyết</label>
            <textarea name="noidungNghiQuyet" placeholder="có thể để trống"><?php echo (isset($noidungNghiQuyet))?$noidungNghiQuyet:"";?></textarea>
        </div>        
        <div>
            <label for="file">Biểu mẫu nghị quyết</label>
            <input type="file" name="fileWord" id="file" class="required error"/>
        </div>
         
        <div>
            <label for="file">Tên biểu mẫu</label>
            <input type="text" value="<?php echo (isset($tenBieuMau))?$tenBieuMau:"";?>" name="tenBieuMau" placeholder="nghiquyet1" class="required error"/>
            <input type="hidden" value="<?php echo (isset($tenBieuMau))?$tenBieuMau:"";?>"name="frmTenBMCu" />
        </div>
        <?php if(isset($trangthai)):?>
        <div>
            <input type="radio" name="trangthai" value="1" <?php echo ($trangthai==1)?"checked":"";?> />Hoàn Thành<br/>
            <input type="radio" name="trangthai" value="0" <?php echo ($trangthai==0)?"checked":"";?>/>Chưa hoàn thành
        </div>                      
        <?php endif;?>
        <div>
            <input type="submit" value="Cancel" name="bttFrm" id="btt_Cancel"/>
            <input type="submit" value="Sửa" name="bttFrm" id="btt_SuaThem"/>            
        </div>        
      </div>
    </div>
</form> 
<!-- Danh sách các nghị quyết table--!>

<h3 style="clear: both;">DANH SÁCH CÁC NGHỊ QUYẾT (ADMIN)</h3>
<?php if(isset($dsNghiQuyet)): ?>
<table id="tbNghiQuyet" class="pretty">
<thead>
    <th>Tên nghị quyết</th>
    <th>Tên Database</th>
    <th>Tên biểu mẫu</th>    
    <th>Trạng thái</th>    
    <th>Admin</th>
</thead>
<tbody>
    <?php foreach($dsNghiQuyet as $nq):?>      
        <tr>
            <td><?php echo $nq['tenNghiQuyet'];?></td>    
            <td><?php echo $nq['DBNghiQuyet'];?></td>
            <td><?php echo $nq['tenBieuMau'];?></td>            
            <td><?php echo ($nq['trangthai']==1)?'đã hoàn thành':'chưa hoàn thành';?></td>
            <form action="." method="post" enctype="multipart/form-data">
              <td><input type="submit" value="sửa" name="btt" class="btt_suaNghiQuyet"/> <input type="submit" value="xóa" name="btt"/></td>   
              <input type="hidden" value="<?php echo $nq['DBNghiQuyet'];?>" name="DBNghiQuyet"/>
              <input type="hidden" value="<?php echo $nq['tenBieuMau'];?>" name="tenBieuMau"/>
              <input type="hidden" value="<?php echo $nq['trangthai'];?>" name="trangthai"/>
              <input type="hidden" value="<?php echo $nq['noidungNghiQuyet'];?>" name="noidungNghiQuyet"/>
              <input type="hidden" value="<?php echo $nq['tenNghiQuyet'];?>" name="tenNghiQuyet"/>                            
            </form>
        </tr>    
      
    <?php endforeach;?>
</tbody>
</table>
<?php endif; ?>


</div>
<footer>
	<div>Copyright © 2013 by timthoi. Vinasun Corp.</div>
</footer>
</div>
<script>
$(document).ready(function(){    
    $("#themnghiquyet").click(function(e){
        $("#btt_SuaThem").val("Thêm");                
        $("#form_capnhap").toggle();
        e.preventDefault();        
    })    
    
    $("#btt_Cancel").click(function(e){        
        window.location=".";
    })
        
    
    $("#form_DsNghiQuyet").validate({        
        messages:{
            DBNghiQuyet:{
                required:"Chưa nhập",                
            },
            tenNghiQuyet:{
                required:"Chưa nhập",                
            },
            tenBieuMau:{
                required:"Chưa nhập",                
            },
            fileWord:{
                required:"Chưa nhập",                
            },
            descriptionNghiQuyet:{
                required:"Chưa nhập",                
            },
            frmNghiQuyet:{
                required:"Chưa nhập",                
            },
            
        }
    });  
    $("#tbNghiQuyet").dataTable({
         "bJQueryUI": true
    });
});
</script>
</body>
</html>