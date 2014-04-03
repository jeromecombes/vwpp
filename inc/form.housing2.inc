<?php
$housing[2]=$housing[1]=="Yes"?"No":($housing[1]=="No"?"Yes":null);
$displayBack=$_SESSION['vwpp']['category']=="admin"?null:"style='display:none;'";

//	toujours visible pour les admins
$displayBack="style='display:none;'";
$displayH3=$_SESSION['vwpp']['category']=="admin"?"style='display:none;'":null;

echo <<<EOD
<div id='div$id' style='display:$display;'>
<h3 $displayH3 >Housing</h3>
<p $displayBack><a href='javascript:change_menu(2);' >Back</a><br/><br/></p>
<!-- <fieldset id='fieldsetHousing' > -->
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


<table border='0'>
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
<td><div class='response2'>{$housing[1]}</div></td></tr>
<tr><td colspan='2'>I will make my own travel arrangements :</td>
<td><div class='response2'>{$housing[2]}</div></td></tr>
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
<tr><td colspan='2'>
I accept to have housing arranged by VWPP</td>
<td><div class='response2'>{$housing[3]}</div></td></tr>
<tr><td colspan='5' style='text-align:justify;font-style:italic;'>
Please note: Exception may be made only in the case of a student who wishes to live with a relative 
living in Paris. In such cases, students must indicate this on this housing form after obtaining 
permission from the Director of International Studies (Wesleyan) or the Director of International 
Programs (Vassar). The cost of room and partial board will be deducted from the program fee in such 
cases.</td></tr>
<tr><td colspan='5' style='text-align:justify;'>
<i>If this is the case, please explain below with whom and where you will be living. We must have the 
address and phone number.</i></td></tr>
<tr><td colspan='5'>
<div class='response'>{$housing[4]}</div></td></tr>

<tr><td colspan='5'>
<h3>IV. Background Information</h3>
</td></tr>
<tr><td colspan='5' style='text-align:justify;'>
1. Have you ever traveled or lived in France or another foreign country?  If so, where and for how long? 
(maximum 220 characters including spaces)
<div class='response'>{$housing[5]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
2. Have you ever had a home stay experience with a foreign family or hosted an international student?  
If so, please describe briefly your impressions and how this experience influences your current 
preferences in housing in Paris.
<div class='response'>{$housing[6]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
3. What is your own family like (parents, brothers, sisters, ages, occupations, etc.)?
<div class='response'>{$housing[7]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
4. Have you lived in an independent living situation before such as an apartment or house, or 
non-dormitory style living?</td></tr>
<tr><td colspan='2'>&nbsp;</td>
<td><div class='response2'>{$housing[8]}</div></td></tr>

<tr><td colspan='2' style='text-align:justify;'>
5. With roommates?</td>
<td><div class='response2'>{$housing[9]}</div></td></tr>

<tr><td colspan='2' style='text-align:justify;'>
6. Did you cook for yourself?</td>
<td><div class='response2'>{$housing[10]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
7. How does this experience influence your current preference in housing in Paris?</td></tr>
<tr><td colspan='5'><div class='response'>{$housing[11]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
8. What are your principal reasons for coming to Paris?
<div class='response'>{$housing[12]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
9. What are your main academic interests?
<div class='response'>{$housing[13]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
10. What are your extra-curricular and leisure time interests and activities?
<div class='response'>{$housing[14]}</div></td></tr>

<tr><td style='text-align:justify;' colspan='2'>
11. Do you smoke?</td>
<td colspan='4'><div class='response2'>{$housing[15]}</div></td></tr>

<tr><td style='text-align:justify;' colspan='5'>
12. Can you live with smokers if you are placed to live with them?
<div class='response2'>{$housing[16]}</div></td></tr>

<tr><td colspan='5'>
<h3>V. Dietary considerations</h3>
</td></tr>

<tr><td colspan='5' style='text-align:justify;'>
Please be as specific as possible below, and please let 
<a href='mailto:housing@vwpp.org'>housing@vwpp.org</a> know if any of these change between filling out 
this form and your arrival.</td></tr>

<tr><td colspan='2' style='text-align:justify;'>
1. Are you a vegetarian now?</td>
<td><div class='response2'>{$housing[17]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
2. Do you eat:</td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
a) fish?</td>
<td><div class='response2'>{$housing[18]}</div></td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
b) chicken?</td>
<td><div class='response2'>{$housing[19]}</div></td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
c) eggs?</td>
<td><div class='response2'>{$housing[20]}</div></td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
d) dairy products?</td>
<td><div class='response2'>{$housing[21]}</div></td></tr>

<tr><td colspan='2' style='text-align:justify;padding-left:30px;'>
e) pork?</td>
<td><div class='response2'>{$housing[22]}</div></td></tr>

<tr><td colspan='2' style='text-align:justify;'>
3. Do you occasionally eat red meat?</td>
<td colspan='2'><div class='response2'>{$housing[23]}</div></td></tr>

<tr><td colspan='5'style='text-align:justify;'>
4. Please note any specific:</td></tr>

<tr><td colspan='5' style='text-align:justify;padding-left:30px;'>
a) dietary allergies
<div class='response'>{$housing[24]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;padding-left:30px;'>
b) customs
<div class='response'>{$housing[25]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
5. Do you think you will adhere strictly to these dietary habits in France and do we need to abide 
by them when considering your housing?</td></tr>
<tr><td colspan='2'>&nbsp;</td>
<td><div class='response2'>{$housing[26]}</div></td></tr>
	
<tr><td colspan='5' style='text-align:justify;'>
6. Do you have any allergies to cats, dogs, or are you allergic to anything else?
<div class='response'>{$housing[27]}</div></td></tr>

<tr><td colspan='5'>
<h3>VI. The housing options are described in detail in the “Types of Housing” section of the <a href='http://en.vwpp.org/info-for-accepted-students/essential-housing-information/'>Essential Housing Information page on the VWPP Web site</a>. <u>Please read through the descriptions 
VERY carefully and then answer the following questions</u>.</h3>
</td></tr>

<tr><td colspan='5' style='text-align:justify;'>
1. What is your principal concern or priority regarding housing?
<div class='response'>{$housing[28]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
2. Please mark your first and second choice of type of housing:<br/>
<i><u>Please note</u>: every student should be prepared to live in a room in a French host’s apartment 
(chambre dans un appartement- accueil en famille) since the availability of  “colocations” cannot be 
guaranteed every semester.
<!-- <div class='response'>{$housing[29]}</div> -->
</td></tr>

<tr><td colspan='5' style='text-align:justify;'>
<ul style='margin:0 0 0 0;'><li>
“Chambre dans un appartement- accueil en famille”: 7 breakfasts and 3 dinners included are provided by 
the family.</li></ul></td></tr>
<tr><td colspan='2'>&nbsp;</td>
<td><div class='response2'>{$housing[30]}</div></td></tr>

<tr><td colspan='5' style='text-align:justify;'>
<ul style='margin:0 0 0 0;'><li>
“Colocation” Furnished apartment with a young French adult or student/s, with 7 breakfasts and 3 dinners 
stipend – cooking together or on own.</li></ul></td></tr>
<tr><td colspan='2'>&nbsp;</td>
<td><div class='response2'>{$housing[31]}</div></td></tr>

<tr><td colspan='5'style='text-align:justify;'><i>
Note: Students who choose this option must be ready to accept to be placed in a “chambre dans un 
appartement-accueil en famille”.</i></td></tr>

<tr><td colspan='5'>
<h3>Other information</h3>
</td></tr>

<tr><td colspan='5'style='text-align:justify;'>
Please provide any further information that will assist us in securing the best housing arrangements 
for you by commenting on any of the following topics that are important to you with reference to your 
housing: children, animals, interests, neatness, study habits, noise, sleeping habits. (120 words)
<div class='response'>{$housing[32]}</div></td></tr>
</table>


<h3>...</h3>
<table>
EOD;
foreach($customForm as $elem){
  echo "<tr><td>{$elem['question']}</td><td><div class='response2'>{$elem['response']}</div></td></tr>\n";
}
echo "</table>\n";
echo "<h3>Thank you for submitting your Housing questionnaire online.</h3>\n";

get_button("Edit",$id,7,"right");	// text, div id, acl, align
echo "<!-- </fieldset> --> </div></div>\n";	

?>