<?php
session_start();
date_default_timezone_set('Europe/Paris');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Calendrier</title>
<link rel='StyleSheet' href='calendrier.css' type='text/css' />
<script type="text/JavaScript">
<!--
function returnDate(paramURL,date){
  tmp=paramURL.split("&");
  form=tmp[0];
  field=tmp[1];
  tmp=date.split("-");
  day=Math.round(tmp[2]);
  switch(day){
    case 1	: day="1st";		break;
    case 2	: day="2nd";		break;
    case 3	: day="3rd";		break;
}
  switch(tmp[1]){
    case "01"	: month="January";	break;
    case "02"	: month="Febuary";	break;
    case "03"	: month="March";	break;
    case "04"	: month="April";	break;
    case "05" 	: month="May";		break;
    case "06"	: month="June";		break;
    case "07"	: month="July";		break;
    case "08"	: month="August";	break;
    case "09"	: month="September";	break;
    case "10"	: month="October";	break;
    case "11"	: month="November";	break;
    case "12"	: month="December";	break;
}
  year=tmp[0];
//   date=tmp[2]+"/"+tmp[1]+"/"+tmp[0];
  date=month+" "+day+", "+year;

  parent.document.forms[form].elements[field].value=date;
  parent.document.getElementById("calendrier").style.display="none";
}
-->
</script>
</head>
<body>
<?php
require_once("calendrier.php");

$form=$_GET['form'];
$champ=$_GET['champ'];
$paramURL="$form&$champ";
// echo $paramURL;
//		Passer $form en argument
Calendrier("calendrier_","calendrier_","valid.php",$paramURL,false,true,false,"");
echo "<a href='javascript:parent.document.getElementById(\"calendrier\").style.display=\"none\";'>Close</a>\n";
?>
</body>
</html>