<?php
// Last update : 2014-04-04, Jérôme Combes

require_once "../inc/eval.questions.inc";
require_once "../inc/config.php";
require_once "../inc/class.eval.inc";

access_ctrl(15);

$_SESSION['vwpp']['eval_form']=isset($_GET['form'])?$_GET['form']:$_SESSION['vwpp']['eval_form'];
$form=$_SESSION['vwpp']['eval_form'];

$questions=$quest[$form];
$eval=new evaluation();
$eval->fetchAll($form,1,$_SESSION['vwpp']['login_univ']);
$result=$eval->elemExcel;

$Fnm = "../data/eval_{$_GET['form']}_{$_SESSION['vwpp']['semestre']}";

if($_GET['type']=="csv")
	{
	$separate="';'";
	$Fnm.=".csv";
	}
else
	{
	$separate="\t";
	$Fnm.=".xls";
	}

for($i=0;$i<count($questions);$i++){		// plus necessaire avec la fonction eval::fetchAll (ne pas supprimer pour le moment)
  $questions[$i]=utf8_decode(html_entity_decode($questions[$i],ENT_QUOTES,"UTF-8"));
  $questions[$i]=str_replace(array("\n","\r","\t")," ",$questions[$i]);
}
$lines=Array();
$lines[]=join($questions,$separate);

foreach($result as $elem){
  $cells=array();
  for($i=1;$i<count($questions)+1;$i++){
    if($form=="program" and $i==32){
      $tmp=unserialize($elem[$i]);
      if(is_array($tmp)){
	$elem[$i]=join($tmp," ; ");
      }
    }						// plus necessaire avec la fonction eval::fetchAll (ne pas supprimer pour le moment)
    $tmp=utf8_decode(html_entity_decode($elem[$i],ENT_QUOTES,"UTF-8"));
    $cells[]=str_replace(array("\n","\r","\t")," ",$tmp);
   }
  $lines[]=join($cells,$separate);
}


$inF = fopen($Fnm,"w");
foreach($lines as $elem){
  fputs($inF,$elem."\n");
}
fclose($inF);

header("Location: $Fnm");
?>