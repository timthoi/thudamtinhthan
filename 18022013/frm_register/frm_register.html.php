<html>
<head>
    <meta charset="utf-8"/>
    <title>Form Register</title>
    <link rel="stylesheet" href="frm_style.css"/>
    <script src="../jquery/jquery-1.10.1.min.js"></script>
    <script src="../jquery/jquery.validate.min.js"></script>
</head>
<body>
	<img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
    <input type="text" name="captcha_code" size="10" maxlength="6" />
2	<a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>    
</body>

<script>
$(document).ready(function(){
    
});
</script>
</html>