<!-- Ta chỉ kiểm tra required đơn giản thôi chưa vào chi tiết đâu nha bé--!>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Form register</title>
    <link rel="stylesheet" href="frm_style.css"/>
    <script src="../jquery/jquery-1.10.1.min.js"></script>    
    <script src="../jquery/jquery.validate.min.js"></script>
</head>
<body>
<div class="wrapper">
<form method="post" action="." id="frm_login" class="frm">
    <h2>Log In</h2>
    <!-- Tất cả các lỗi sẽ thông báo ở đây --!>
    <div id="errors"></div>
    <div class="u">
        <input type="text" name="uName" id="uName" placeholder="Username or Email"class="required error"/>        
    </div>
    
    <div class="u">
        <input type="password" name="uPassword" id="uPassword"  placeholder="Password" autocomplete="off" class="required error"/>
    </div>
    
    <div class="u">
        <input type="submit" name="uLogIn" id="uLogIn" value="Log In"/>
    </div>    
</form>

</div>
</body>


<script>
$(document).ready(function(){
    $("#frm_login").validate({
       rules:{
         uName:{
            required:true
         },
         uPassword:{
            required:true                    
         }        
       }, 
       messages:{
         uName:{
            required:"Nhập username hoặc địa chỉ email"
         },            
         uPassword:{
            required:"Nhập password"                        
         }
       },
       //by default the error elements is a <label>
       errorElement: "div",
        //place all errors in a <div id="errors"> element
       errorPlacement: function(error, element) {
            error.appendTo("div#errors");
        } 
       });    
 });
</script>
</html>
