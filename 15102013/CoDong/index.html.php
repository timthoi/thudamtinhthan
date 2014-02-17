<html>
<head>
    <meta charset="utf-8" />
    <title>Cổ đông tham dự</title>    
    <script src="../jquery/jquery-1.10.1.min.js"></script>    
    <script src="../jquery/jquery.dataTables.js"></script>
    <script src="../jquery/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="../jquery/jquery.validate.min.js"></script>    
    <link rel="stylesheet" href="../jquery/redmond/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>      
    <style type="text/css">
#form_nguoiUyQuyen,#form_codongUyQuyen {font-size: 100%;}
#form_nguoiUyQuyen label, #form_nguoiUyQuyen input,#form_codongUyQuyen label, #form_codongUyQuyen input { display:block; }
#form_nguoiUyQuyen input.text, #form_codongUyQuyen input.text { margin-bottom:12px; width:95%; padding: .4em; }
#form_nguoiUyQuyen fieldset, #form_codongUyQuyen fieldset{ padding:0; border:0; margin-top:25px; }        
#form_nguoiUyQuyen .error, #form_codongUyQuyen .error{
    color:#ED7476;
    margin-left:5px;
    display:inline;
}

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
.groupUQ{
    margin-top:20px;
    margin-left:20px;
    cursor: pointer;
        
}

    </style>                
</head>
<body>
<?php 
ob_start();
@session_start();
if(isset($_SESSION['ERROR_CHECKINDB'])){
    echo $_SESSION['ERROR_CHECKINDB'];
    unset($_SESSION['ERROR_CHECKINDB']);
}
    
?>
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
<h1>CỔ ĐÔNG THAM DỰ</h1>

<div>
    <label>Mã cổ đông</label>
    <input type="text" name="maCoDong" id="maCoDong"/>
    <input type="submit" value="Kiểm tra" name="btt1" id="kiemtra"/>
</div>


<fieldset name="thongtin" id="thongtin">
    <legend>Thông tin:</legend>
    <form method="post" name="CoDong" action="." id="frm_CoDong">
        <input type="hidden" name="maCoDong" id="mcd"/>
        <input type="hidden" name="ho" id="ho"/>
        <input type="hidden" name="ten" id="ten"/>
        <input type="hidden" name="cmnd" id="cmnd"/>
        <input type="hidden" name="ngaycap" id="ngaycap" />
        <input type="hidden" name="dienthoai" id="dienthoai"/>
        <input type="hidden" name="diachi" id="diachi"/>
        <input type="hidden" name="socophan" id="socophan"/>
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
            <input type="submit" value="Tham Dự" name="btt1" id="thamdu" disabled="" />
            <input type="submit" value="Ủy quyền" name="btt1" id="uyquyen" disabled="" />                                            
            <div hidden="" class="groupUQ">
                <div><input id="uyquyenNguoi" type="submit" value="Cho 1 người cụ thể" name="btt1"/></div>                
                <div><input id="uyquyenCoDong" type="submit" value="Cho 1 cổ đông cụ thể" name="btt1"/></div> 
                    
            </div>
        </div>
    </form>
</fieldset>

<?php if(isset($dsThamDu) && $dsThamDu!=NULL ):?>
<h2>Danh sách cổ đông tham dự</h2>
<table id="tbThamDu" class="pretty"> 
 <thead>
    <tr>
        <th>Mã Cổ Đông</th>
        <th>Họ Tên</th>
        <th>CMND</th>
        <th>Ngày cấp</th>
        <th>Điện thoại</th>
        <th>Địa chỉ</th>
        <th>Số cổ phần</th>
        <th>Trạng thái tham dự</th>
        <th>Admin</th>        
    </tr>
 </thead>
 
 <tbody>
    <?php foreach ($dsThamDu as $khach):?>
        
        <tr>       
          <td>
            <?php echo $khach['macd']; ?>        
          </td>
          <td>
            <?php echo $khach['ho'].' '.$khach['ten']; ?>        
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
          <td>
            <?php echo $khach['uyquyen']; ?>            
          </td>
          <td>
              <form method="post" action=".">
                <input type="hidden" name="macd" value="<?php echo $khach['macd']; ?>"/>
                <input type="hidden" name="trangthaithamdu" value="<?php echo $khach['uyquyen']; ?>"/>
                <input type="submit" value="xem" name="btt1" class="btt_xem"/>                  
                <input type="submit" value="Xóa/sửa" name="btt1"/>
              </form>
          </td>             
        </tr>    
    
    <?php endforeach; ?>
 </tbody>
</table>
<?php endif; ?>
<!-- Ủy quyền người--!>
<div id="dialog-form" title="Create new user">
  <form id="form_nguoiUyQuyen">  
    <div>        
        <label for="dialog_ho">Họ (*)</label>
        <input type="text" name="dialog_ho" id="dialog_ho" class="required error" />        
    </div>
    <div>  
        <label for="dialog_ten">Tên (*)</label>
        <input type="text" name="dialog_ten" id="dialog_ten" class="required error"/>
    </div>
    <div> 
        <label for="dialog_cmnd">Chứng minh nhân dân (*)</label>
        <input type="text" name="dialog_cmnd" id="dialog_cmnd" class="required digits error"/>
    </div>    
    <div> 
        <label for="dialog_ngaycap">Ngày cấp </label>
        <input type="text" name="dialog_ngaycap" id="dialog_ngaycap" placeholder="10-06-1989"/>       
    </div>
    <div> 
        <label for="dialog_diachi">Địa chỉ</label>
        <input type="text" name="dialog_diachi" id="dialog_diachi"/>
    </div>
    <div> 
        <label for="dialog_sodienthoai">Số điện thoại</label>
        <input type="text" name="dialog_sodienthoai" id="dialog_sodienthoai"/>
    </div>
    <div>  
        <label for="socophan">Số cổ phần (*)</label>
        <input type="text" name="dialog_socophan" id="dialog_socophan" class="required digits error"/>
        <input type="hidden" name="dialog_macodong" id="dialog_macodong"/>
    </div>    
  
  </form>
</div>
<!-- Ủy Quyền cho Cổ Đông --!>
<div id="dialog-form2" title="Ủy Quyền cho Cổ Đông">
  <form id="form_codongUyQuyen">    
    <div>
        <label for="maCoDongNhanUyQuyen">Mã cổ đông nhận Ủy quyền</label>
        <input type="text" name="maCoDongNhanUyQuyen" id="maCoDongNhanUyQuyen"/>
    </div>
    <div>
        <label for="socophanUQ">Số cổ phần Ủy quyền</label>
        <input type="text" name="socophanUQ" id="socophanUQ"/>
    </div>            
    <fieldset>
        <legend>Thông tin:</legend>
        <div id="dialog2_trangthai" style="color: red;"></div>
        <div>    
            <label>Mã cổ đông:</label>
            <span id="dialog2_maCD"></span>
        </div>      
        <div>          
            <label>Họ tên:</label>
            <span id="dialog2_hoten"></span>
        </div>
        <div>
            <label>CMND:</label>
            <span id="dialog2_cmnd"></span>
        </div>
        <div>
            <label>Ngày cấp:</label>
            <span id="dialog2_ngaycap"></span>
        </div>
        <div>
            <label>Điện thoại:</label>
            <span id="dialog2_dienthoai"></span>
        </div>
        <div>
            <label>Địa chỉ:</label>
            <span id="dialog2_diachi"></span>
        </div>
        <div>
            <label>Sổ cổ phần:</label>
            <span id="dialog2_socophan"></span>
        </div>
        <div>            
            <input type="hidden" name="dialog2_maCoDong" id="dialog2_mcd"/>                                
            <input type="hidden" name="dialog2_socophan" id="dialog2_socophan"/>
        </div>
        
    </fieldset>
  </form>
</div>
<!-- button_xem ? có thể kết hơp để hiện thị với mấy thằng khác dc ko --!>
<div id="dialog-form3" title="Cổ đông tham dự">
    <fieldset>       
        <legend>Thông tin:</legend>
        <div id="dialog3_trangthai" style="color: red;"></div>
        <div>    
            <label>Mã cổ đông:</label>
            <span id="dialog3_maCD"></span>
        </div>      
        <div>          
            <label>Họ tên:</label>
            <span id="dialog3_hoten"></span>
        </div>
        <div>
            <label>CMND:</label>
            <span id="dialog3_cmnd"></span>
        </div>
        <div>
            <label>Ngày cấp:</label>
            <span id="dialog3_ngaycap"></span>
        </div>
        <div>
            <label>Điện thoại:</label>
            <span id="dialog3_dienthoai"></span>
        </div>
        <div>
            <label>Địa chỉ:</label>
            <span id="dialog3_diachi"></span>
        </div>
        <div>
            <label>Sổ cổ phần:</label>
            <span id="dialog3_socophan"></span>
        </div>                             
                  
    </fieldset>
    <!-- gắn thêm table các cổ đông đã ủy quyền--!>
    <div id="target"></div>               
</div>
</div>
<footer>
	<div>Copyright © 2013 by timthoi. Vinasun Corp.</div>
</footer>
</div>

<script>
$(document).ready(function(){   
    $("#uyquyen").click(function(e){
        e.preventDefault();
        $("#uyquyen").next().toggle();       
    });
    
    var max_socophan;
    var maCoDong;
    
    $(".btt_xem").click(function(e){
        e.preventDefault();
        var codongThamDu = [];        
        $(this).closest('tr').find('td').not(':last').each(function() {
            var textval = $(this).text(); // this will be the text of each <td>
            codongThamDu.push(textval);
        });
        maCoDong=codongThamDu[0];
        $("#dialog-form3").dialog('option', 'title', codongThamDu[0]);
        $("#dialog3_maCD").text(codongThamDu[0]);        
        $("#dialog3_hoten").text(codongThamDu[1]);
        $("#dialog3_cmnd").text(codongThamDu[2]);
        $("#dialog3_ngaycap").text(codongThamDu[3]);
        $("#dialog3_dienthoai").text(codongThamDu[4]);
        $("#dialog3_diachi").text(codongThamDu[5]);
        $("#dialog3_socophan").text(codongThamDu[6]);
        $("#dialog3_trangthai").text(codongThamDu[7]);
        //bị dư khoảng trắng
        var a=$.trim($("#dialog3_trangthai").text());    
        //remove luon thang table cũ ra làm lại thằng mới     
        jQuery('#target').children().remove();                 
        
        if( ((a  == "Cổ đông ủy quyền")||(a  == "Người nhận ủy quyền"))){
            //load ajax lấy ds Cổ động ủy quyền - sau đó thêm vào table - trước đó clear sạch                                                            
            $.ajax({
               type:'POST',
               url:'ajax5.php',
               data:{
                maCDnhanUQ:$.trim(maCoDong) //thằng lìn này nó bị dư khoảng trắng                                                                            
               },
               success:function(data){   
                
                    var dsCoDongUQ=JSON.parse(data);                                        
                    var table = $('<table></table>').addClass('tablesorter');
                    var thead=['Mã cổ đông','Số cổ phần','CMND'];
                    
                    var r = $('<thead><tr></tr></thead>');
                    table.append(r);
                    for ( var i = 0; i < thead.length; i = i + 1 ) {
                        var r1 = $('<th></th>').text(thead[i]);                        
                        r.append(r1);
                   }
                    
                    $.each(dsCoDongUQ,function(_key,_array){
                        var row = $('<tr></tr>');
                        table.append(row);                                
                        $.each(_array,function(key,value){                            
                           var row1 = $('<td></td>').text(value);                           
                           row.append(row1);                                                       
                        });                                                         
                                     
                    });
                    $('#target').append(table);
               }
            });
        }                        
        
        $("#dialog-form3").dialog( "open" );
    });
    
    
    $("#dialog-form3").dialog({
        autoOpen:false,
        height: 550,
        width: 350,
        modal: true,
        position: ['center', 'top'],
        buttons:{
            "OK": function () {
                $(this).dialog("close");
            }
        }        
    })
      
    $("#uyquyenNguoi").click(function(e){
        e.preventDefault();
        //thay title dialog trước khi mở
        $("#dialog-form").dialog('option', 'title', 'Người nhận ủy quyền');                    
        $("#dialog_socophan").val(max_socophan);        
        $("#dialog_macodong").val(maCoDong);            
        $( "#dialog-form" ).dialog( "open" );        
    })  
    
    $("#uyquyenCoDong").click(function(e){
        e.preventDefault();
        $("#dialog2_uyquyen").button("option", "disabled", true);
        $("#socophanUQ").attr("disabled", true);        
        $("#dialog-form2").dialog( "open" );
    })
    
    $( "#dialog-form2" ).dialog({
        autoOpen: false,
          height: 550,
          width: 400,
          modal: true,
          position: ['center', 'top'],
          buttons: {
            checkUser:{ 
                class: 'leftButton',
                text: 'Kiểm tra',
                click : function (){                       
                    $.ajax({
                       type:'POST',
                       url:'ajax3.php',
                       data:{
                        maCD:function(){return $("#maCoDongNhanUyQuyen").val()}                                                                               
                       },
                       success:function(data){
                     //có trong ds Cổ đông   
                     if(data!="false"){            
                        var codong = JSON.parse(data);                                            
                        $("#dialog2_trangthai").text(codong['trangthai']);                                                      
                        $("span#dialog2_maCD").text(codong['macd']);
                        $("span#dialog2_hoten").text(codong['ho']+" "+codong['ten']);
                        $("span#dialog2_cmnd").text(codong['cmnd']);
                        $("span#dialog2_ngaycap").text(codong['ngaycap']);
                        $("span#dialog2_dienthoai").text(codong['dienthoai']);
                        $("span#dialog2_diachi").text(codong['diachi']);
                        $("span#dialog2_socophan").text(codong['socophan']);
                        //CHƯA THAM DU
                        if(codong['trangthai']!="") {                    
                            
                            $("#socophanUQ").attr("disabled", true);
                            $("#socophanUQ").val("");                                  
                            $("#dialog2_uyquyen").button("option", "disabled", true);
                        }
                        else
                        {
                            $("#dialog2_trangthai").text("");
                            $("input#dialog2_mcd").prop("value",codong['macd']);                                
                            $("input#dialog2_socophan").prop("value",codong['socophan']);
                            $("#socophanUQ").attr("disabled", false);                                
                            $("#dialog2_uyquyen").button("option", "disabled", false);
                            
                            max_socophan=parseInt($("#dialog2_socophan").text());
                            $( "#socophanUQ").val($("#dialog2_socophan").text());
                            $( "#socophanUQ" ).rules( "add", {
                                max: max_socophan, 
                                messages: {
                                    max:"nhỏ hơn "+max_socophan                        
                                }
                            });                                 
                        }
                    }
                    //không có trong ds Cổ đông
                    else
                    {
                        $("span#dialog2_maCD").text("");
                        $("span#dialog2_hoten").text("");
                        $("span#dialog2_cmnd").text("");
                        $("span#dialog2_socophan").text("");                        
                        $("span#dialog2_ngaycap").text("");
                        $("span#dialog2_dienthoai").text("");
                        $("span#dialog2_diachi").text("");                        
                        $("#dialog2_trangthai").text("");
                        $("#dialog2_uyquyen").button("option", "disabled", true);    
                        $("#socophanUQ").attr("disabled", true);
                        $( "#socophanUQ").val("");                    
                        alert("Mã cổ đông không có trong danh sách cổ đông");
                    }
                   }                                     
                    });  
                }
            },
        //thuc hien update va insert
         uyquyen:{ 
            id:"dialog2_uyquyen",
            text: 'Ủy quyền',
            click: function(){
                if($('#form_codongUyQuyen').valid()){
                    $.ajax({
                   type:'POST',
                   url:'ajax4.php',
                   data:{
                    maCDUQ:function(){return $("#maCD").text()},
                    maCDnhanUQ:function(){return $("span#dialog2_maCD").text()},
                    socophan:function(){return $("#socophanUQ").val()},
                    cmnd:function(){return $("span#dialog2_cmnd").text()}                                                                                                       
                   },
                   success:function(data){
                    alert("Đã ủy quyền thành công");
                    window.location.reload(true);                      
                   }
                }); 
                $(this).dialog("close");
                }
                
            } 
         },                        
        cancel:{                     
            text: 'Cancel',
            click: function() { 
                $(this).dialog("close");
            } 
         },       
          }  
        })
    $( "#dialog-form" ).dialog({
          autoOpen: false,
          height: 400,
          width: 350,
          position: ['center', 'top'],
          modal: true,
          buttons: {
            "Uỷ Quyền": function() { //on click of thêm button of dialog                                
                if($('#form_nguoiUyQuyen').valid()){  //call valid for form2 and show the errors                
                    //only if the form is valid submit the form                                                                                                                                                                  
                     var nguoiUyQuyen={
                            ho:$("#dialog_ho").val(),
                            ten:$("#dialog_ten").val(),
                            cmnd:$("#dialog_cmnd").val(),
                            socophan:$("#dialog_socophan").val(),
                            diachi:$("#dialog_diachi").val(),
                            dienthoai:$("#dialog_sodienthoai").val(),
                            ngaycap:$("#dialog_ngaycap").val(),
                            macd:$("#dialog_macodong").val()
                         };
                     $.ajax({
                        url: 'ajax2.php',
                        type: 'post',                        
                        success: function (data) {
                           alert("Đã ủy quyền thành công");
                           window.location.reload(true);                                                                     
                        },
                        data:{
                            nguoiUyQuyen:nguoiUyQuyen
                        }
                    });
                     $( this ).dialog( "close" );
                }
            },
            "Hủy": function() {
              $( this ).dialog( "close" );
            }
          }          
        });        
    $("#form_codongUyQuyen").validate({
        rules:{
            socophanUQ:{
                required:true,
                digits:true,
                min:0
            }
        },
        messages:{
            socophanUQ:{
                required:"Chưa nhập",
                digits:"Nhập số",
                min:"Phải lớn hơn 0"
            }
            
        }
    });                 
    $("#form_nguoiUyQuyen").validate({                     
        rules:{
              dialog_socophan:{
                required:true,
                digits:true,
                min:0                        
              },
              dialog_cmnd:{
                rangelength: [8, 9],
                digits:true
              }        
           },
       messages:{
          dialog_ho:{              
            required:"Chưa nhập"                       
          },
          dialog_ten:{
            required:"Chưa nhập"
          }, 
          dialog_cmnd:{
            required:"Chưa nhập",
            digits:"Nhập số"                       
          },
          dialog_socophan:{
            digits:"Nhập số",
            required:"Chưa nhập"                       
          }
          
       }    });
    $("#kiemtra").click(function(){
         $.ajax({
           type:'POST',
           url:'ajax.php',
           data:{
            maCD:function(){return $("#maCoDong").val()}
           },
           success:function(data){                                                        
            if(data!="false"){            
                var codong = JSON.parse(data);                                
                max_socophan=parseInt(codong['socophan']);
                $( "#dialog_socophan" ).rules( "add", {
                    max: max_socophan, 
                    messages: {
                        max:"nhỏ hơn "+max_socophan                        
                    }
                });                  
                maCoDong=(codong['macd']);                      
                
                $("span#maCD").text(codong['macd']);
                $("span#hoten").text(codong['ho']+" "+codong['ten']);
                $("span#cmnd").text(codong['cmnd']);
                $("span#ngaycap").text(codong['ngaycap']);
                $("span#dienthoai").text(codong['dienthoai']);
                $("span#diachi").text(codong['diachi']);
                $("span#socophan").text(codong['socophan']);
                //ĐÃ uy QUYỀN HOAC DA THAM DU
                if(codong['trangthai']!="") {                    
                    $("#trangthai").text(codong['trangthai']);
                }
                else
                {
                    $("#trangthai").text("");
                    $("input#mcd").prop("value",codong['macd']);
                    $("input#ho").prop("value",codong['ho']);
                    $("input#ten").prop("value",codong['ten']);
                    $("input#ngaycap").prop("value",codong['ngaycap']);
                    $("input#dienthoai").prop("value",codong['dienthoai']);
                    $("input#diachi").prop("value",codong['diachi']);
                    $("input#socophan").prop("value",codong['socophan']);
                    $("input#cmnd").prop("value",codong['cmnd']);
                    $("#thamdu").prop("disabled", false);
                    $("#uyquyen").prop("disabled", false);
                }
            }
            else
            {
                $("span#maCD").text("");
                $("span#hoten").text("");
                $("span#cmnd").text("");
                $("span#socophan").text("");
                $("#trangthai").text("");
                $("span#ngaycap").text("");
                $("span#diachi").text("");
                $("span#dienthoai").text("");
                $("#thamdu").prop("disabled", true);
                $("#uyquyen").prop("disabled", true);           
                alert("Mã cổ đông không có trong danh sách cổ đông");
            }
           }                      
        });         
    })
      
    $("#tbThamDu").dataTable({
         "bJQueryUI": true
    });
     $( "#dialog_ngaycap" ).datepicker({
         changeMonth: true,
         changeYear: true
             
     });
         
    $( "#dialog_ngaycap" ).datepicker( "option", "dateFormat","dd-mm-yy");
   
});
</script>
</body>
</html>