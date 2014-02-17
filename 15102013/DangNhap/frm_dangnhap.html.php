<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Form đăng nhập</title>
    <link rel="stylesheet" href="../css/style.css" />
    <script src="../jquery/jquery-1.10.1.min.js"></script>        
    <script src="../jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="../jquery/jquery.validate.min.js"></script>    
    <link rel="stylesheet" href="../jquery/css/ui-lightness/jquery-ui-1.10.3.custom.min.css"/>
    <style>
		body {
	background-color: #369;
	color: green;
	margin: 0;
	padding: 0;
	font: 1em Tahoma, sans-serif;
	background-image: url('../img/background.jpg');
	background-repeat: repeat;
		}
	.frmbtt {
		font-size: 16px;
		font-weight: bold;
        height:50px;
	}

	form {
		width: 400px;
		
	}
	.lbInput {
		padding-top: 10px;
		padding-right: 0px;
		padding-bottom: 20px;
		padding-left: 0px;
		margin-top: 0%;
		margin-right: 10%;
		margin-bottom: 0%;
		margin-left: 10%;
	}
		.wrapper {
			width: 400px;
			margin: 20px auto 40px auto;
			background-color: #ffffff;
			}
		.tieude{
	text-align: center;
	padding: 20px 0 0 0;
	font-size: 24px;
	font-weight: bold;
	text-transform: uppercase;
	border-bottom-style: solid;
	border-bottom-width: thin;
	border-bottom-color: #CCC;
		}
		form div {
			padding: 0 0 0.75em 0;
		}	
		form label {		
			width: 120px;
		}
		form input {
			width: 300px;
			height:25px;
		}	
        .input:focus{
            background-color: burlywood;
        }
		.error{
			color:red;
			}
    </style>
</head>
<body>
<div class="wrapper">
    <form id="frm_dangnhap" method="post" action=".">
    <div class="tieude">Đăng nhập</div>
    <div class="lbInput">
      <label class="error"><?php echo (isset($GLOBALS['loginError']))?$GLOBALS['loginError']:"";?></label>
    </div>  

    <div class="lbInput">        
        <div><label for="usernmae">Username</label></div>
        <input type="text" name="username" class="required error" />        
    </div>   
    <div class="lbInput"> 
		<div><label for="paswsword">Password</label></div>
        <input type="password" name="password" class="required error"/>
    </div>
   
      <div class="lbInput">
        <input name="action" type="submit" class="frmbtt" value="login"/>
      </div>
    
  </form>
</div> 
    
<script>
    $(document).ready(function(){        
        $("#frm_dangnhap").validate({
            messages:{
                username:{
                    required:"Chưa nhập"
                },
                password:{
                    required:"Chưa nhập"
                }
              
            }
        });            
    })

</script>        
</body>
</html>