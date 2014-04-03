<?php
require_once "../header.php";
require_once "menu.php";
//access_ctrl(13);

$semestre=$_SESSION['vwpp']['semestre'];

if(isset($_GET['formId'])){
  $formId=$_SESSION['vwpp']['formId']=$_GET['formId'];
}
else{
  $formId=$_SESSION['vwpp']['formId'];
}

switch($formId){
  case 6 : $formName="Students"; break;
  case 7 : $formName="Housing"; break;
}

echo "<h3>$formName form for $semestre</h3>\n";

$db=new db();
$db->select("forms","*","semestre='$semestre' AND formId='$formId'","order by ordre");
if(!$db->result){
  echo "This form does not exist.<br/>\n";
  if(in_array($formId,$_SESSION['vwpp']['access'])){
    $db=new db();
    $db->select("forms","*","formId='$formId'");
    echo "<ul>\n";
    if($db->result)
      echo "<li><a href='forms-copy.php'>Copy an existing form</a></li>\n";
    echo "<li><a href='forms-edit.php'>Create a new form</a></li>\n";
    echo "</ul>\n";
   }
}
else{
  echo "<table>\n";
  foreach($db->result as $elem){
    echo "<tr><td>{$elem['question']}</td><td>\n";
    get_input($elem['type'],$elem['id'],$elem['responses']);
    echo "</td></tr>\n";
  }
  echo "</table>\n";
  if(in_array($formId,$_SESSION['vwpp']['access']))
    echo "<a href='forms-edit.php'>Edit</a>\n";
}
echo "<br/><br/><a href='forms.php'>Back to list</a>\n";

require_once "../footer.php";
?>