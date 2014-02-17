<html>
<head>
    <meta charset="utf-8" />
    <title>Cổ đông tham dự</title>        
    <script src="jquery/jquery-1.10.1.min.js"></script>    
    <script src="jquery/jquery.dataTables.js"></script>
    <script src="jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="jquery/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>     
    <style type="text/css">
input[type="submit"]{
	width: 300px;
	height: 150px;
    font-size: 30px;
    font-weight: bolder;
    text-transform: uppercase;
    background-color: #fff;
    color:#006339;
    border:0;	
}

input[type="submit"]:hover{
    cursor: pointer;
    
}
    </style>                
</head>
<body>
<div class="wrapper">
<header>
	<div class="left"><img src="img/VINASUN.gif" width="201" height="200" alt="logoVinasun"></div>
  	<div class="right">
  	  <div>CÔNG TY CỔ PHẨN ÁNH DƯƠNG VIỆT NAM </div>
  	  <div>Vinasun Corporation</div>
	  <h1>ĐẠI HỘI CỔ ĐÔNG</h1>
      <div class="logout"><?php echo $username;?><a href="?logout"><img src="img/application_exit.png" width="24" height="24" alt="exit"></a></div>    
    </div>
    
</header>    
<div class="horizon"></div>

<div class="content">    
    <form method="post" action="." >
        <div class="left"><input type="submit" value="BIỂU QUYẾT" name="btt" /></div>        
        <div class="left">
            <input type="submit" value="THAM DỰ" name="btt" id="btt_thamdu"/>
            <a href="?UpdateThamDu" id="updateThamDu">Cập nhập danh sách tham dự</a>
        </div>
        <div class="left">
            <input type="submit" value="BẦU CỬ" name="btt" id="btt_baucu"/>
            <a href="?UpdateBauCu" id="updateBauCu">Cập nhập danh sách bầu cử</a>        
        </div>        
    </form>
</div>        

<div class="horizon"></div>
<footer>
	<div>Copyright © 2013 by timthoi. Vinasun Corp.</div>
</footer>
</div>
<script>
$(document).ready(function(){
      
    $("#updateThamDu").hide();
    $("#updateBauCu").hide();
    var update1 = $('#updateThamDu');
    var update2 = $('#updateBauCu');
    $('#btt_thamdu').mouseover(
        function () {
            update1.stop(true, true).slideDown(400);
    });
    
    $("#updateThamDu").mouseleave(        
        function () {
            update1.stop(true, true).slideUp(400)
    });
    
    $('#btt_baucu').mouseover(
        function () {
            update2.stop(true, true).slideDown(400);
    });
    
    $("#updateBauCu").mouseleave(        
        function () {
            update2.stop(true, true).slideUp(400)
    });        
    
});
</script>
</body>
</html>