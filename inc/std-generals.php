<?php
require_once "class.housing.inc";
require_once "class.doc.inc";

$selected[0]=$std['gender']=="Female"?"selected='selected'":null;
$selected[1]=$std['gender']=="Male"?"selected='selected'":null;

//	Student housing
$l=new housing();
$l->getLogement($std['logement']);
$logement=$l->logement;

//	Months for Date of birth
$months=array("01" => "January", "02" => "Febuary","03" => "March", "04" => "April", "05" => "May",
  "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", 
  "11" => "November", "12" => "December");

//	Photo
$d=new doc();
$d->getPhoto($std['id']);

echo <<<EOD
<div id='div$id' style='display:$display;'>
<h3>Personal Details and Contact Information</h3>
<div class='fieldset'>
<table style='margin-left:-30px;'><tr><td style='width:485px;'>
<table style='width:100%;'>
<tr><td colspan='2'><br/><b><u>Personal Details</u></b></td></tr>		<!-- Personal details -->
<tr><td style='width:220px;'>Lastname</td><td style='width:280px;'>{$std['lastname']}</td></tr>
<tr><td>Firstname</td><td>{$std['firstname']}</td></tr>
<tr><td>Gender</td><td>{$std['gender']}</td></tr>
<tr><td>Citizenship 1</td><td>{$std['citizenship1']}</td></tr>
<tr><td>Citizenship 2</td><td>{$std['citizenship2']}</td></tr>
<tr><td>Date of birth</td><td>{$std['dob_text']}</td></tr>
<tr><td>Place of birth (City, State)</td><td>{$std['placeOB']}</td></tr>
<tr><td>Country of birth</td><td>{$std['countryOB']}</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Email</td><td><a href='mailto:{$std['email']}'>{$std['email']}</a></td></tr>
<tr><td>Cellphone in France</td><td>{$std['cellphone']}</td></tr>


<tr><td colspan='2'><br/><b><u>Housing in France</u></b></td></tr>			<!-- Housing 	-->
<tr><td>Lastname</td><td>{$logement['lastname']}</td></tr>
<tr><td>Firstname</td><td>{$logement['firstname']}</td></tr>
<tr><td>Address</td><td>{$logement['address']}</td></tr>
<tr><td>Zip Code</td><td>{$logement['zipcode']}</td></tr>
<tr><td>City</td><td>{$logement['city']}</td></tr>
<tr><td>Email</td><td><a href='mailto:{$logement['email']}'>{$logement['email']}</a></td></tr>
<tr><td>Phone number</td><td>{$logement['phonenumber']}</td></tr>
<tr><td>Cellphone</td><td>{$logement['cellphone']}</td></tr>

</table>
</td><td style='width:485px;'>
<table style='width:100%;'>
<tr><td colspan='2'><br/><b><u>Contact Information for Parent/Guardian</u></b></td></tr>		<!-- Contact information -->
<tr><td style='width:220px;'>Lastname</td><td style='width:360px;'>{$std['contactlast']}</td></tr>
<tr><td>Firstname</td><td>{$std['contactfirst']}</td></tr>
<tr><td>Street</td><td>{$std['street']}</td></tr>
<tr><td>City</td><td>{$std['city']}</td></tr>
<tr><td>Zip code</td><td>{$std['zip']}</td></tr>
<tr><td>State</td><td>{$std['state']}</td></tr>
<tr><td>Country</td><td>{$std['country']}</td></tr>
<tr><td>Phone number</td><td>{$std['contactphone']}</td></tr>
<tr><td>Cellphone number</td><td>{$std['contactmobile']}</td></tr>
<tr><td>Email</td><td><a href='mailto:{$std['contactemail']}'>{$std['contactemail']}</a></td></tr>

<tr><td colspan='2'><br/><b><u>Program Information</u></b></td></tr>		<!-- Program information -->
EOD;
echo count($std['semesters'])>1?"<tr><td>Semesters with VWPP</td>":"<tr><td>Semester with VWPP</td>";
echo "<td>{$std['semestersJoin']}</td></tr>\n";
echo "<tr><td>Home Institution</td><td>{$std['homeInstitution']}</td></tr>\n";
echo "<tr><td>Résultat TCF</td><td>{$std['resultatTCF']}</td></tr>\n";
echo "<tr><td>French University</td><td>{$std['frenchUniv']}</td></tr>\n";
echo "<tr><td>French Univ. Student number</td><td>{$std['frenchNumber']}</td></tr>\n";



echo <<<EOD
</table>
</td>
<td style='width:200px;padding-top:20px;'>{$d->photo}</td>
</tr></table>
EOD;

//	Edit Button
get_button("Edit",$id,6,"right");	// text, div id, acl, align
echo "</div></div>\n";	

//	Update Form
echo <<<EOD
<div id='div-edit$id' style='display:none;'>
<form name='stdform$id' action='update.php' method='post' />
<input type='hidden' name='std_id' value='{$std['id']}' />
<input type='hidden' name='page' value='students-view2.php' />
<input type='hidden' name='std-page' value='general.php' />
<input type='hidden' name='table' value='students' />
<input type='hidden' name='acl' value='6' />
<h3>Personal Details and Contact Information</h3>
<div class='fieldset'>
<table style='margin-left:-30px;'><tr><td style='width:485px;'>
<table style='width:100%;'>
<tr><td colspan='2'><br/><b><u>Personal Details</u></b></td></tr>		<!-- Personal details -->
<tr><td style='width:220px;'>Lastname</td>
<td style='width:360px;'><input type='text' name='std[lastname]' value='{$std['lastname']}'/></td></tr>
<tr><td>Firstname</td><td><input type='text' name='std[firstname]' value='{$std['firstname']}'/></td></tr>
<tr><td>Gender</td>
<td>
<select name='std[gender]'>
<option value=''>&nbsp;</option>
<option value='Female' {$selected[0]}>Female</option>
<option value='Male' {$selected[1]}>Male</option>
</select>
</td></tr>
<tr><td>Citizenship 1</td><td>
<select name='std[citizenship1]'/>
<option value=''>&nbsp;</option>
EOD;
foreach($GLOBALS['countries'] as $elem){
  $selected=$elem==$std['citizenship1']?"selected='selected';":null;
  echo "<option value='$elem' $selected>$elem</option>\n";
}
echo <<<EOD
</select>
</td></tr>
<tr><td>Citizenship 2</td><td>
<select name='std[citizenship2]'/>
<option value=''>&nbsp;</option>
EOD;
foreach($GLOBALS['countries'] as $elem){
  $selected=$elem==$std['citizenship2']?"selected='selected';":null;
  echo "<option value='$elem' $selected>$elem</option>\n";
}
echo <<<EOD
</select>
</td></tr>
<tr><td>Date of birth</td><td>
<select name='std[mob]' style='width:30%;'>
<option value=''>Month</option>
EOD;
$keys=array_keys($months);
foreach($keys as $key){
  $selected=$std['mob']==$key?"selected='selected'":null;
  echo "<option value='$key' $selected >{$months[$key]}</option>\n";
}

echo <<<EOD
</select>
<select name='std[dob]' style='width:30%;'>
<option value=''>Day</option>
EOD;
for($i=1;$i<32;$i++){
  $selected=$std['dob']==sprintf("%02d",$i)?"selected='selected'":null;
  echo "<option value='".sprintf("%02d",$i)."' $selected >".sprintf("%02d",$i)."</option>\n";
}
echo <<<EOD
</select>
<select name='std[yob]' style='width:30%;'>
<option value=''>Year</option>
EOD;
$year=date("Y")-15;
for($i=$year;$i>$year-30;$i--){
  $selected=$std['yob']==$i?"selected='selected'":null;
  echo "<option value='$i' $selected >$i</option>\n";
}
echo <<<EOD
</select>
</td></tr>
<tr><td>Place of birth (City, State)</td><td><input type='text' name='std[placeOB]' value='{$std['placeOB']}' /></td></tr>
<tr><td>Country of birth</td><td>
<select name='std[countryOB]'/>
<option value=''>&nbsp;</option>
EOD;
foreach($GLOBALS['countries'] as $elem){
  $selected=$elem==$std['countryOB']?"selected='selected';":null;
  echo "<option value='$elem' $selected>$elem</option>\n";
}
echo <<<EOD
</select>
</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Email</td><td><input type='text' name='std[email]' value='{$std['email']}'/></td></tr>
<tr><td>Cellphone in France</td><td><input type='text' name='std[cellphone]' value='{$std['cellphone']}'/></td></tr>


<tr><td colspan='2'><br/><b><u>Housing in France</u></b></td></tr>			<!-- Housing 	-->
<tr><td>Lastname</td><td>{$logement['lastname']}</td></tr>
<tr><td>Firstname</td><td>{$logement['firstname']}</td></tr>
<tr><td>Address</td><td>{$logement['address']}</td></tr>
<tr><td>Zip Code</td><td>{$logement['zipcode']}</td></tr>
<tr><td>City</td><td>{$logement['city']}</td></tr>
<tr><td>Email</td><td>{$logement['email']}</td></tr>
<tr><td>Phone number</td><td>{$logement['phonenumber']}</td></tr>
<tr><td>Cellphone</td><td>{$logement['cellphone']}</td></tr>

</table>
</td><td style='width:485px;'>
<table style='width:100%;'>
<tr><td colspan='2'><br/><b><u>Contact Information for Parent/Guardian</u></b></td></tr>		<!-- Contact information -->
<tr><td style='width:220px;'>Lastname</td><td style='width:360px;'><input type='text' name='std[contactlast]' value='{$std['contactlast']}'/></td></tr>
<tr><td>Firstname</td><td><input type='text' name='std[contactfirst]' value='{$std['contactfirst']}'/></td></tr>
<tr><td>Street</td><td><input type='text' name='std[street]' value='{$std['street']}'/></td></tr>
<tr><td>City</td><td><input type='text' name='std[city]' value='{$std['city']}'/></td></tr>
<tr><td>Zip code</td><td><input type='text' name='std[zip]' value='{$std['zip']}'/></td></tr>
<tr><td>State</td><td>
<select name='std[state]'/>
<option value=''>&nbsp;</option>
EOD;
foreach($GLOBALS['states'] as $elem){
  $selected=$elem==$std['state']?"selected='selected';":null;
  echo "<option value='$elem' $selected>$elem</option>\n";
}
echo <<<EOD
</select>
</td></tr>
<tr><td>Country</td><td>
<select name='std[country]'/>
<option value=''>&nbsp;</option>
EOD;
foreach($GLOBALS['countries'] as $elem){
  $selected=$elem==$std['country']?"selected='selected';":null;
  echo "<option value='$elem' $selected>$elem</option>\n";
}
echo <<<EOD
</select>
</td></tr>
<tr><td>Phone number</td><td><input type='text' name='std[contactphone]' value='{$std['contactphone']}'/></td></tr>
<tr><td>Cellphone number</td><td><input type='text' name='std[contactmobile]' value='{$std['contactmobile']}'/></td></tr>
<tr><td>Email</td><td><input type='text' name='std[contactemail]' value='{$std['contactemail']}'/></td></tr>
<tr><td colspan='2'><br/><b><u>Program Information</u></b></td></tr>		<!-- Program information -->
EOD;
if(substr($std['semesters'][0],0,4)=="Fall"){
  echo <<<EOD
  <tr><td>Semesters with VWPP</td>
  <td>
  <ul style='margin-top:0px;'>
  <li>{$std['semesters'][0]}</li>
EOD;
  if($_SESSION['vwpp']['category']=="admin")
    echo "<li>{$std['newSemester']} ? <input type='checkbox' name='std[semesters][]' value='{$std['newSemester']}' {$std['checkedSemester']}/></li>\n";
  elseif(substr($std['semesters'][1],0,6)=="Spring")
    echo "<li>{$std['newSemester']}<input type='hidden' name='std[semesters][]' value='{$std['newSemester']}' {$std['checkedSemester']}/></li>\n";
}
else{
  echo "<tr><td>Semester with VWPP</td><td>{$std['semesters'][0]}</td></tr>\n";
}
echo "</ul></td></tr>\n";
echo "<tr><td>Home Institution</td>\n";
echo "<tr><td>Home Institution</td><td>{$std['homeInstitution']}</td></tr>\n";
if($_SESSION['vwpp']['category']=="admin")
  echo "<tr><td>Résultat TCF</td><td><input type='text' name='std[resultatTCF]' value='{$std['resultatTCF']}' /></td></tr>\n";
else
  echo "<tr><td>Résultat TCF</td><td>{$std['resultatTCF']}</td></tr>\n";
echo "<tr><td>French University</td><td>{$std['frenchUniv']}</td></tr>\n";
echo "<tr><td>French Univ. Student number</td>\n";
echo "<td><input type='text' name='std[frenchNumber]' value='{$std['frenchNumber']}' /></td></tr>\n";

echo <<<EOD
</table>
</td>
<td style='width:200px;padding-top:20px;'>{$d->photo}</td>
</tr></table>

<p style='text-align:right'>
<input type='hidden' name='std[semesters][]' value='{$std['semesters'][0]}'/>
<input type='button' onclick='document.stdform$id.submit();' value='Done' /></p>

</div></form></div>
EOD;
?>