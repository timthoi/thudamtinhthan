<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Cập nhập danh sách cổ đông</title>
    <script src="../jquery/jquery-1.10.1.min.js"></script>        
    <script src="../jquery/jquery.dataTables.js"></script>
    <script src="../jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="../jquery/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="../jquery/redmond/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>    
    <style type="text/css">
    
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
<h1>CẬP NHẬP DANH SÁCH CỔ ĐÔNG THAM DỰ</h1>
<form action="." method="post" enctype="multipart/form-data">
    <p>
        <label for="file">File excel:</label>    
        <input type="file" name="file" id="file" />
    </p>
    <p>
        <input type="submit" name="btt" id="btt" value="Import" />        
    </p>
    <p>
        <input type="submit" name="btt" id="btt" value="Quay lại" />        
    </p>
    
</form>

<?php if(isset($dsThamDu)):?>
<h2>Danh sách cổ đông tham dự</h2>
<table id="tbThamDu" class="pretty"> 
 <thead>
    <tr>
        <th>Mã Cổ Đông</th>
        <th>Họ</th>
        <th>Tên</th>
        <th>CMND</th>
        <th>Ngày cấp</th>
        <th>Điện thoại</th>
        <th>Điạ chỉ</th>
        <th>Số cổ phần</th>        
    </tr>
 </thead>
 
 <tbody>
    <?php foreach ($dsThamDu as $khach):?>        
        <tr>       
          <td>
            <?php echo $khach['macd']; ?>        
          </td>
          <td>
            <?php echo $khach['ho']; ?>        
          </td>
          <td>
            <?php echo $khach['ten']; ?>        
          </td>
          <td>
            <?php echo $khach['cmnd']; ?>        
          </td>
          <td>
            <?php echo $khach['ngaycap']; ?>        
          </td>
          <td>
            <?php echo $khach['dienthoai']; ?>        
          </td>
          <td>
            <?php echo $khach['diachi']; ?>        
          </td>
          <td>
            <?php echo $khach['socophan']; ?>        
          </td>                       
        </tr>        
    <?php endforeach; ?>
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
    $("#tbThamDu").dataTable({
         "bJQueryUI": true
    });
})
</script>
</body>
</html>