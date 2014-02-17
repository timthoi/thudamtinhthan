<?php 
//thay đổi mã cổ đông đã ủy quyền cho 1 người cụ thể
//dùng cho xóa - 
// chưa làm phần sửa nha kon
if(isset($_POST["maCD_UQ"]) && isset($_POST["maCD"]))
{
   //update khóa chính - có thể nhưng ngu lắm đéo ai cho làm vậy
   // mà dù có cho - thì cũng ngu lắm - bắt nó xóa đi nhập lại
    echo $_POST["maCD_UQ"];  
}