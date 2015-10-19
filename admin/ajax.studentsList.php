<?php
// Update : 2015-10-19

session_start();

$list=filter_input(INPUT_POST,"list",FILTER_SANITIZE_STRING);

if($list){
  $list=str_replace("&#34;",'"',$list);
  error_log($list);
  $_SESSION["vwpp"]["studentsList"]=json_decode($list);
}else{
  $_SESSION["vwpp"]["studentsList"]=null;
}
?>
  