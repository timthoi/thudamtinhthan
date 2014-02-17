<?php 


$donvi=array('0'=>'không', '1'=>'một', '2'=>'hai','3'=>'ba', '4'=>'bốn', '5'=>'năm','6'=>'sáu', '7'=>'bảy', '8'=>'tám','9'=>'chín','10'=>'mười');

function hangdonvi($num,$lenght){
    $l=$lenght;
    $n=$num;
    $hdv='';
    global  $donvi;
    switch($l){
        case 1:           
           $hdv='';           
        break;
        
        case 2:      
        {
            if($num=='0') $hdv='lẻ';
            else
                if($num=='1') $hdv='mười';
                else
                    $hdv='mươi';
        }
        break;
               
        case 3:        
            $hdv='trăm';
        break;                        
         
    }
    return $hdv;
}

function docso($num){    
    $kq='';
    global  $donvi;
    while($num[0]=='0') $num=substr($num,1);

    $length=strlen($num);
    
    for($i=0;$i<$length;$i++)
    {                     
        $vt=$length-$i;                
        $hdv=hangdonvi($num[$i],$vt);
        $so=$donvi[$num[$i]];
        if($vt==3)
            if($num[$i]==0 && $num[$i+1]==0 && $num[$i+2]==0) {
                $so='';
                $hdv='';   
            }
        if($vt==2){                
            if ($hdv=='mười' || $hdv=='lẻ') $so='';                                                              
            if ($hdv=='lẻ' && $num[$i+1]==0) $hdv='';
        }
        if($vt==1){
            if($num[$i]==0) {$so='';$hdv='';}
            else
                if($num[$i]==1 && $length>1 && $num[$i-1]>1) $so=' mốt';                            
        }                    
        $kq.=' '.$so.' '.$hdv;                                            
    }    
    return $kq;      
}
function docso2($num,$dv){
    $length=strlen($num);
    $kq='';
    $catChuoi=$length%3;        
    if($catChuoi==0)$catChuoi=3;
    $vt=0;
    while($length>0){
        $length=$length-$catChuoi+1;                
        $docso=substr($num,$vt,$catChuoi);
        $vt+=$catChuoi;  
        $catChuoi=3;
                
        $kq.= docso($docso);
        
        if(docso($docso)!='')
        {
            if(($length>3 && $length<7)) $kq.=' ngàn';                           
            if($length>6 && $length<10) $kq.= 'triệu';           
        }        
    }            
    //return $kq."</br>";
    return $kq.' '.$dv;   
}
if(isset($_POST['txt_num'])){
    $num=strval($_POST['txt_num']);
    //$_word=$donvi[$num];
    if(strlen($num)>9) {
        echo docso2(substr($num,0,strlen($num)-9),' tỉ').docso2(substr($num,strlen($num)-9),'');
    }
    else    
        echo docso2($num,'');
}

