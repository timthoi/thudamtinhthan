<html>
<head>
    <meta charset="utf-8"/>
    <title>Error</title>    
    <script src="../jquery/jquery-1.10.1.min.js"></script>
    <script src="../jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <link rel="stylesheet" href="../jquery/redmond/jquery-ui.css"/>
</head>
<body>
<div id="error" title="Thông báo"><?php echo (isset($error))?$error:"";?></div>
    
<script>
    $(document).ready(function(){        
        var $goto="<?php echo (isset($goto))?$goto:"";?>";       
        $("#error").dialog({
        autoOpen:true,
        height: 200,
        width: 300,
        modal: true,
        buttons:{
            "OK": function () {
                if($goto=="") $(this).dialog('close'); 
                else
                    window.location=$goto;
            }
        }        
    })   
    });


</script>
</body>
</html>