<?php

for($i=0;$i<count($housing);$i++){
  $housing[$i]=str_replace("<br/>",null,$housing[$i]);
}

$checked[1]=$housing[1]=="Yes"?"checked='checked'":null;
$checked[2]=$housing[1]=="No"?"checked='checked'":null;
$checked[3]=$housing[3]=="Yes"?"checked='checked'":null;
$checked["8yes"]=$housing[8]=="Yes"?"checked='checked'":null;
$checked["8no"]=$housing[8]=="No"?"checked='checked'":null;
$checked["9yes"]=$housing[9]=="Yes"?"checked='checked'":null;
$checked["9no"]=$housing[9]=="No"?"checked='checked'":null;
$checked["10yes"]=$housing[10]=="Yes"?"checked='checked'":null;
$checked["10no"]=$housing[10]=="No"?"checked='checked'":null;
$checked["15no"]=$housing[15]=="No"?"checked='checked'":null;
$checked["15yes"]=$housing[15]=="Yes"?"checked='checked'":null;
$checked["15reg"]=$housing[15]=="Regular smoker"?"checked='checked'":null;
$checked["15occ"]=$housing[15]=="Occasional smoker"?"checked='checked'":null;
$checked["16yes"]=$housing[16]=="Yes"?"checked='checked'":null;
$checked["16no"]=$housing[16]=="No"?"checked='checked'":null;
$checked["17yes"]=$housing[17]=="Yes"?"checked='checked'":null;
$checked["17no"]=$housing[17]=="No"?"checked='checked'":null;
$checked["18yes"]=$housing[18]=="Yes"?"checked='checked'":null;
$checked["18no"]=$housing[18]=="No"?"checked='checked'":null;
$checked["19yes"]=$housing[19]=="Yes"?"checked='checked'":null;
$checked["19no"]=$housing[19]=="No"?"checked='checked'":null;
$checked["20yes"]=$housing[20]=="Yes"?"checked='checked'":null;
$checked["20no"]=$housing[20]=="No"?"checked='checked'":null;
$checked["21yes"]=$housing[21]=="Yes"?"checked='checked'":null;
$checked["21no"]=$housing[21]=="No"?"checked='checked'":null;
$checked["22yes"]=$housing[22]=="Yes"?"checked='checked'":null;
$checked["22no"]=$housing[22]=="No"?"checked='checked'":null;
$checked["23yes"]=$housing[23]=="Yes"?"checked='checked'":null;
$checked["23no"]=$housing[23]=="No"?"checked='checked'":null;
$checked["26yes"]=$housing[26]=="Yes"?"checked='checked'":null;
$checked["26no"]=$housing[26]=="No"?"checked='checked'":null;
$checked["30First"]=$housing[30]=="First"?"checked='checked'":null;
$checked["30Second"]=$housing[30]=="Second"?"checked='checked'":null;
$checked["31First"]=$housing[31]=="First"?"checked='checked'":null;
$checked["31Second"]=$housing[31]=="Second"?"checked='checked'":null;


echo <<<EOD
<div id='div-edit$id' style='display:$display2;'>
<form name='stdform$id' action='update.php' method='post'>
<input type='hidden' name='table' value='housing' />
<input type='hidden' name='acl' value='7' />
<input type='hidden' name='std_id' value='$std_id' />
<input type='hidden' name='semestre' value='$semestre' />
<input type='hidden' name='page' value='students-view2.php' />
<input type='hidden' name='std-page' value='housing.php' />

<h3>Housing</h3>
<!-- <fieldset> -->
<div class='fieldset'>
<h2 style='text-align:center;'>Vassar-Wesleyan Program in Paris Housing Questionnaire</h2>
<p style='text-align:justify;'>
This questionnaire will be used by the Assistant Director in Paris to match you with a suitable housing 
situation.  A specific housing situation will be reserved for you <u>based on your responses to this 
questionnaire</u>. Thank you for having read the Housing Process Residence commitment sections of 
the VWPP website before filling out this questionnaire. Be honest and thoughtful in your 
responses. The more the Assistant Director knows about you, the better the chance of a successful match 
between you and the housing reserved for you.  Should any criteria concerning you change between filling 
out this form and your arrival in Paris, please inform the VWPP Paris office as soon as possible at 
<a href='mailto:housing@vwpp.org'>housing@vwpp.org</a>
</p>
<p style='text-align:justify;font-weight:bold;'>
Please fill this questionnaire by the deadline set by the Office of International Programs (Vassar) or 
the Office of International Studies (Wesleyan).
</p>


<table style='width:1170px;' border='0'>
<tr><td colspan='5'><h3>I. Personal details</h3></td></tr>
<tr><td>1. Last Name : </td>
<td colspan='2'><div class='response2'>{$std['lastname']}</div></td>
<td>First Name : </td>
<td><div class='response2'>{$std['firstname']}</div></td></tr>
<tr><td>2. Date of birth : </td>
<td colspan='2'><div class='response2'>{$std['dob_text']}</div></td>
<td>Gender : </td>
<td><div class='response2'>{$std['gender']}</div></td></tr>
<tr><td>3. Citizenship : 1. </td>
<td colspan='2'><div class='response2'>{$std['citizenship1']}</div></td>
<td>2. </td>
<td><div class='response2'>{$std['citizenship2']}</div></td></tr>
<tr><td colspan='5'>4. <u>Home address (street, city, state)</u> : </td></tr>
<tr><td>&nbsp;</td>
<td colspan='4'><div class='response2'>{$address}</div></td></tr>
<tr style='margin-top:10px;'><td>5. University or college : </td>
<td colspan='2'><div class='response2'>{$std['university2']}</div></td>
<td>Year of graduation : </td>
<td><div class='response2'>{$std['graduation']}</div></td></tr>
<tr><td>6. e-mail address : </td>
<td colspan='4'><div class='response2'>{$std['email']}</div></td></tr>
<tr><td>7. I am applying for : </td>
<td colspan='4'><div class='response2'>{$std['semestre']}</div></td></tr>

<tr><td colspan='5'>
<h3>II. Travel information (please check one box)</h3>
</td></tr>
<tr><td colspan='2'>I will arrive with the group flight : </td>
<td><input type='radio' name='data[1]' value='Yes' {$checked[1]} /></td></tr>
<tr><td colspan='2'>I will make my own travel arrangements : </td>
<td><b><input type='radio' name='data[1]' value='No' {$checked[2]} /></b></td></tr>
<tr><td colspan='5' style='text-align:justify;font-style:italic;'>
Note: Please make every effort to join the group flight.  It will facilitate your travel and arrival 
in France. If you have to travel on your own, please forward your full travel itinerary as soon as you 
make your travel plans to <a href='mailto:housing@vwpp.edu'>housing@vwpp.org</a>.</td></tr>

<tr><td colspan='5'>
<h3>III. Housing</h3>
</td></tr>
<tr><td colspan='5' style='text-align:justify;'>
The Vassar Wesleyan Program in Paris semester fee includes tuition, room and partial board arranged by 
the Vassar-Wesleyan Program in Paris.</td></tr>
<tr><td colspan='2'>I accept to have housing arranged by VWPP</td>
<td><b><input type='checkbox' name='data[3]' value='Yes' {$checked[3]} /></b></td></tr>
<tr><td colspan='5' style='text-align:justify;font-style:italic;'>
Please note: Exception may be made only in the case of a student who wishes to live with a relative 
living in Paris. In such cases, students must indicate this on this housing form after obtaining 
permission from the Director of International Studies (Wesleyan) or the Director of International 
Programs (Vassar). The cost of room and partial board will be deducted from the program fee in such 
cases.</td></tr>
<tr><td colspan='5' style='text-align:justify;font-style:italic;'>
If this is the case, please explain below with whom and where you will be living. We must have the 
address and phone number.</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[4]'>{$housing[4]}</textarea></td></tr>

<tr><td colspan='5'>
<h3>IV. Background Information</h3>
</td></tr>
<tr><td colspan='5' style='text-align:justify;'>
1. Have you ever traveled or lived in France or another foreign country?  If so, where and for how long? 
(maximum 220 characters including spaces)</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[5]'>{$housing[5]}</textarea></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
2. Have you ever had a home stay experience with a foreign family or hosted an international student?  
If so, please describe briefly your impressions and how this experience influences your current 
preferences in housing in Paris.</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[6]'>{$housing[6]}</textarea></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
3. What is your own family like (parents, brothers, sisters, ages, occupations, etc.)?</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[7]'>{$housing[7]}</textarea></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
4. Have you lived in an independent living situation before such as an apartment or house, or 
non-dormitory style living?</td></tr>
<tr><td colspan='2'>&nbsp;</td>
<td><b><input type='radio' name='data[8]' value='Yes' {$checked['8yes']} /> Yes
<input type='radio' name='data[8]' value='No' {$checked['8no']} /> No </b>
</td></tr>

<tr><td colspan='2' style='text-align:justify;'>
5. With roommates?</td>
<td style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[9]' value='Yes' {$checked['9yes']} /> Yes
<input type='radio' name='data[9]' value='No' {$checked['9no']} /> No</td></tr>

<tr><td colspan='2' style='text-align:justify;'>
6. Did you cook for yourself?</td>
<td style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[10]' value='Yes' {$checked['10yes']} /> Yes
<input type='radio' name='data[10]' value='No' {$checked['10no']} /> No</td></tr>

<tr><td colspan='5' style='text-align:justify;'>
7. How does this experience influence your current preference in housing in Paris?</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[11]'>{$housing[11]}</textarea></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
8. What are your principal reasons for coming to Paris?</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[12]'>{$housing[12]}</textarea></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
9. What are your main academic interests?</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[13]'>{$housing[13]}</textarea></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
10. What are your extra-curricular and leisure time interests and activities?</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[14]'>{$housing[14]}</textarea></td></tr>

<tr><td colspan='1' style='text-align:justify;'>
11. Do you smoke?</td>
<td colspan='4'><b>
<input type='radio' name='data[15]' value='No' {$checked['15no']} /> No
<!-- <input type='radio' name='data[15]' value='Yes' {$checked['15yes']} /> Yes -->
<input type='radio' name='data[15]' value='Regular smoker' {$checked['15reg']} /> Regular smoker
<input type='radio' name='data[15]' value='Occasional smoker' {$checked['15occ']} /> Occasional smoker</td></tr>

<tr><td colspan='5' style='text-align:justify;'>
12. Can you live with smokers if you are placed to live with them? 
<b>
<input type='radio' name='data[16]' value='Yes' {$checked['16yes']} /> Yes
<input type='radio' name='data[16]' value='No' {$checked['16no']} /> No
</b></td></tr>

<tr><td colspan='5'>
<h3>V. Dietary considerations</h3>
</td></tr>
<tr><td colspan='5' style='text-align:justify;'>
Please be as specific as possible below, and please let 
<a href='mailto:housing@vwpp.org'>housing@vwpp.org</a> know if any of these change between filling out 
this form and your arrival.</td></tr>

<tr><td colspan='2' style='text-align:justify;'>
1. Are you a vegetarian now?</td>
<td style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[17]' value='Yes' {$checked['17yes']} /> Yes
<input type='radio' name='data[17]' value='No' {$checked['17no']} /> No
</td></tr>

<tr><td colspan='5' style='text-align:justify;'>
2. Do you eat:</td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
a) fish?</td>
<td colspan='2' style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[18]' value='Yes' {$checked['18yes']} /> Yes
<input type='radio' name='data[18]' value='No' {$checked['18no']} /> No
</td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
b) chicken?</td>
<td colspan='2' style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[19]' value='Yes' {$checked['19yes']} /> Yes
<input type='radio' name='data[19]' value='No' {$checked['19no']} /> No
</td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
c) eggs?</td>
<td colspan='2' style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[20]' value='Yes' {$checked['20yes']} /> Yes
<input type='radio' name='data[20]' value='No' {$checked['20no']} /> No
</td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
d) dairy products?</td>
<td colspan='2' style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[21]' value='Yes' {$checked['21yes']} /> Yes
<input type='radio' name='data[21]' value='No' {$checked['21no']} /> No
</td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
e) pork?</td>
<td colspan='2' style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[22]' value='Yes' {$checked['22yes']} /> Yes
<input type='radio' name='data[22]' value='No' {$checked['22no']} /> No
</td></tr>

<tr><td colspan='2' style='text-align:justify;'>
3. Do you occasionally eat red meat?</td>
<td colspan='2' style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[23]' value='Yes' {$checked['23yes']} /> Yes
<input type='radio' name='data[23]' value='No' {$checked['23no']} /> No
</td></tr>

<tr><td colspan='5'style='text-align:justify;'>
4. Please note any specific:</td></tr>

<tr><td colspan='5' style='text-align:justify;padding-left:30px;'>
a) dietary allergies</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[24]'>{$housing[24]}</textarea></td></tr>

<tr><td colspan='5' style='text-align:justify;padding-left:30px;'>
b) customs</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[25]'>{$housing[25]}</textarea></td></tr>

<tr><td colspan='5'style='text-align:justify;'>
5. Do you think you will adhere strictly to these dietary habits in France and do we need to abide 
by them when considering your housing?</td></tr>
<tr><td colspan='2'>&nbsp;</td>
<td style='text-align:justify;font-weight:bold;'>
<input type='radio' name='data[26]' value='Yes' {$checked['26yes']} /> Yes
<input type='radio' name='data[26]' value='No' {$checked['26no']} /> No
</td></tr>
	
<tr><td colspan='5' style='text-align:justify;'>
6. Do you have any allergies to cats, dogs, or are you allergic to anything else?</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[27]'>{$housing[27]}</textarea></td></tr>

<tr><td colspan='5'>
<h3>VI. The housing options are described in detail in the “Types of Housing” section of the <a href='http://en.vwpp.org/info-for-accepted-students/essential-housing-information/'>Essential Housing Information page on the VWPP Web site</a>. <u>Please read through the descriptions 
VERY carefully and then answer the following questions</u>.</h3>
</td></tr>

<tr><td colspan='5'style='text-align:justify;'>
1. What is your principal concern or priority regarding housing?</td></tr>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[28]'>{$housing[28]}</textarea></td></tr>

<tr><td colspan='5'style='text-align:justify;'>
2. Please mark your first and second choice of type of housing:<br/>
<i><u>Please note</u>: every student should be prepared to live in a room in a French host’s apartment 
(chambre dans un appartement- accueil en famille) since the availability of  “colocations” cannot be 
guaranteed every semester.</td></tr>

<tr><td colspan='5'style='text-align:justify;'>
<ul style='margin:0 0 0 0;'><li>
“Chambre dans un appartement- accueil en famille”: 7 breakfasts and 3 dinners included are provided by 
the family.
<font font-weight:bold;text-align:right;'>
<input type='radio' name='data[30]' value='First' {$checked['30First']} /> First
<input type='radio' name='data[30]' value='Second' {$checked['30Second']} /> Second
</font></li></ul></td></tr>

<tr><td colspan='5'style='text-align:justify;'>
<ul style='margin:0 0 0 0;'><li>
“Colocation” Furnished apartment with a young French adult or student/s, with 7 breakfasts and 3 dinners 
stipend – cooking together or on own. 			

<font font-weight:bold;text-align:right;'>
<input type='radio' name='data[31]' value='First' {$checked['31First']} /> First
<input type='radio' name='data[31]' value='Second' {$checked['31Second']} /> Second
</font></li></ul></td></tr>

<tr><td colspan='5'style='text-align:justify;'><i>
Note: Students who choose this option must be ready to accept to be placed in a “chambre dans un 
appartement-accueil en famille”.</i></td></tr>

<tr><td colspan='5'>
<h3>Other information</h3>
</td></tr>
<tr><td colspan='5'style='text-align:justify;'>
Please provide any further information that will assist us in securing the best housing arrangements 
for you by commenting on any of the following topics that are important to you with reference to your 
housing: children, animals, interests, neatness, study habits, noise, sleeping habits. (120 words)</td>
<tr><td colspan='5' style='text-align:justify;font-weight:bold;'>
<textarea name='data[32]'>{$housing[32]}</textarea></td></tr>
</table>


<h3>...</h3>
<table style='width:800px;margin-left:50px;'>
EOD;
foreach($customForm as $elem){
  echo "<tr><td>{$elem['question']}</td><td>";
  get_input($elem['type'],$elem['id'],$elem['responses'],$elem['response']);
  echo "</td></tr>\n";
}

echo <<<EOD
</table>

<p style='text-align:right'>
<!-- <a href='javascript:document.stdform$id.submit();'>Submit</a>  -->
<input type='button' value='Submit' onclick='document.stdform$id.submit();' />
</p>

<!-- </fieldset> --> </div></form></div>

EOD;
?>
