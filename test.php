<?php
echo  $_ENV['code_img_href'];

foreach($_ENV as $key=>$val){
   if(strpos($key,"code_")>-1){
   
        echo $key.'--------'.$val.'<br>';
}
}
