<?php
// Last update 2015-06-16

require_once "inc/class.reidhall.inc";

$student=$_SESSION['vwpp']['student'];
$semester=$_SESSION['vwpp']['semestre'];

//		Getting data from courses table
$rh=new reidhall();
$rh->fetchAll();


usort($rh->seminars,"cmp_code");
usort($rh->writings,"cmp_code");

//		Select data from courses_choices
$db=new db();
$db->select("courses_choices","*","student='$student' AND semester='$semester'");
$stdCourse=!empty($db->result)?$db->result[0]:array();

//	Selected Options
if($rh->isLock($student)){
  foreach($rh->writings as $elem){
    if($stdCourse['a1']==$elem['id'])
      $a1="{$elem['code']} {$elem['nom']}, {$elem['professor']}";
    if($stdCourse['b1']==$elem['id'])
      $b1="{$elem['code']} {$elem['nom']}, {$elem['professor']}";
    if($stdCourse['c1']==$elem['id'])
      $c1="{$elem['code']} {$elem['nom']}, {$elem['professor']}";
    if($stdCourse['d1']==$elem['id'])
      $d1="{$elem['code']} {$elem['nom']}, {$elem['professor']}";
  }
  foreach($rh->seminars as $elem){
    if($stdCourse['a2']==$elem['id'])
      $a2="{$elem['code']} {$elem['nom']}, {$elem['professor']}";
    if($stdCourse['b2']==$elem['id'])
      $b2="{$elem['code']} {$elem['nom']}, {$elem['professor']}";
    if($stdCourse['c2']==$elem['id'])
      $c2="{$elem['code']} {$elem['nom']}, {$elem['professor']}";
    if($stdCourse['d2']==$elem['id'])
      $d2="{$elem['code']} {$elem['nom']}, {$elem['professor']}";
    if($stdCourse['e2']==$elem['id'])
      $e2="{$elem['code']} {$elem['nom']}, {$elem['professor']}";
  }


  echo <<<EOD
  <fieldset>
  <h3><u>My Choices</u></h3>
  <table>
  <tr><td colspan='2' style='padding-left:0px;'><u><b>Writing-Intensive Course</b></u></td></tr>
  <tr><td style='padding-left:30px;'><b>1<sup>st</sup> Choice</b></td>
  <td>$a1</td></tr>
  <tr><td style='padding-left:30px;'><b>2<sup>nd</sup> Choice</b></td>
  <td>$b1</td></tr>
  <tr><td style='width:200px;padding-left:30px;'><b>3<sup>rd</sup> Choice</b></td>
  <td>$c1</td></tr>
  <tr><td style='width:200px;padding-left:30px;'><b>4<sup>th</sup> Choice</b></td>
  <td>$d1</td></tr>
  <tr><td colspan='2' style='padding:20px 0 0 0;'><u><b>Seminar</b></u></td></tr>
  <tr><td style='padding-left:30px;'><b>1<sup>st</sup> Choice</b></td>
  <td>$a2</td></tr>
  <tr><td style='padding-left:30px;'><b>2<sup>nd</sup> Choice</b></td>
  <td>$b2</td></tr>
  <tr><td style='width:200px;padding-left:30px;'><b>3<sup>rd</sup> Choice</b></td>
  <td>$c2</td></tr>
  <tr><td style='width:200px;padding-left:30px;'><b>4<sup>th</sup> Choice</b></td>
  <td>$d2</td></tr>
  <tr><td style='width:200px;padding-left:30px;'><b>5<sup>th</sup> Choice</b></td>
  <td>$e2</td></tr>
  </table></form></fieldset>
EOD;
}
else{
  echo <<<EOD
  <fieldset>
  <h3><u>My Choices</u></h3>
  <form name='form_rh' action='courses-update.php' method='post'>
  <input type='hidden' name='id' value='{$stdCourse['id']}' />
  <input type='hidden' name='univ' value='rh' />
  <table>
EOD;

  echo "<tr><td colspan='2' style='padding-left:0px;'><u><b>Writing-Intensive Course</b></u></td></tr>\n";
  echo "<tr><td style='padding-left:30px;'><b>1<sup>st</sup> Choice</b></td>\n";
  echo "<td><select name='a1' style='width:100%;'>\n";
  echo "<option value=''>&nbsp;</option>\n";
  foreach($rh->writings as $elem){
    $selected=$stdCourse['a1']==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['nom']}, {$elem['professor']}</option>\n";
  }
  echo "</select></td></tr>\n";

  echo "<tr><td style='padding-left:30px;'><b>2<sup>nd</sup> Choice</b></td>\n";
  echo "<td><select name='b1' style='width:100%;'>\n";
  echo "<option value=''>&nbsp;</option>\n";
  foreach($rh->writings as $elem){
    $selected=$stdCourse['b1']==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['nom']}, {$elem['professor']}</option>\n";
  }
  echo "</select></td></tr>\n";

  echo "<tr><td style='width:200px;padding-left:30px;'><b>3<sup>rd</sup> Choice</b></td>\n";
  echo "<td><select name='c1' style='width:100%;'>\n";
  echo "<option value=''>&nbsp;</option>\n";
  foreach($rh->writings as $elem){
    $selected=$stdCourse['c1']==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['nom']}, {$elem['professor']}</option>\n";
  }
  echo "</select></td></tr>\n";

  echo "<tr><td style='width:200px;padding-left:30px;'><b>4<sup>th</sup> Choice</b></td>\n";
  echo "<td><select name='d1' style='width:100%;'>\n";
  echo "<option value=''>&nbsp;</option>\n";
  foreach($rh->writings as $elem){
    $selected=$stdCourse['d1']==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['nom']}, {$elem['professor']}</option>\n";
  }
  echo "</select></td></tr>\n";

  echo "<tr><td colspan='2' style='padding:20px 0 0 0;'><u><b>Seminar</b></u></td></tr>\n";
  echo "<tr><td style='padding-left:30px;'><b>1<sup>st</sup> Choice</b></td>\n";
  echo "<td><select name='a2' style='width:100%;'>\n";
  echo "<option value=''>&nbsp;</option>\n";
  foreach($rh->seminars as $elem){
    $selected=$stdCourse['a2']==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['nom']}, {$elem['professor']}</option>\n";
  }
  echo "</select></td></tr>\n";

  echo "<tr><td style='padding-left:30px;'><b>2<sup>nd</sup> Choice</b></td>\n";
  echo "<td><select name='b2' style='width:100%;'>\n";
  echo "<option value=''>&nbsp;</option>\n";
  foreach($rh->seminars as $elem){
    $selected=$stdCourse['b2']==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['nom']}, {$elem['professor']}</option>\n";
  }
  echo "</select></td></tr>\n";

  echo "<tr><td style='width:200px;padding-left:30px;'><b>3<sup>rd</sup> Choice</b></td>\n";
  echo "<td><select name='c2' style='width:100%;'>\n";
  echo "<option value=''>&nbsp;</option>\n";
  foreach($rh->seminars as $elem){
    $selected=$stdCourse['c2']==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['nom']}, {$elem['professor']}</option>\n";
  }
  echo "</select></td></tr>\n";

  echo "<tr><td style='width:200px;padding-left:30px;'><b>4<sup>th</sup> Choice</b></td>\n";
  echo "<td><select name='d2' style='width:100%;'>\n";
  echo "<option value=''>&nbsp;</option>\n";
  foreach($rh->seminars as $elem){
    $selected=$stdCourse['d2']==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['nom']}, {$elem['professor']}</option>\n";
  }
  echo "</select></td></tr>\n";

  echo "<tr><td style='width:200px;padding-left:30px;'><b>5<sup>th</sup> Choice</b></td>\n";
  echo "<td><select name='e2' style='width:100%;'>\n";
  echo "<option value=''>&nbsp;</option>\n";
  foreach($rh->seminars as $elem){
    $selected=$stdCourse['e2']==$elem['id']?"selected='selected'":null;
    echo "<option value='{$elem['id']}' $selected>{$elem['code']} {$elem['nom']}, {$elem['professor']}</option>\n";
  }
  echo "</select></td></tr>\n";

  echo <<<EOD
  <tr><td colspan='2' style='text-align:right;padding-top:20px;'>
  <input type='submit' value='Valider' class='myUI-button-right'/></td></tr>
  </table></form></fieldset>
EOD;
}

?>
