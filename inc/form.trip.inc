<?php
// Last update : 2016-03-12

require_once "class.student.inc";
$s=new student();
$s->id=$_SESSION['vwpp']['student'];
$s->fetch();
//	ajouter hidden, lastname, firstname, email, téléphone portable
echo <<<EOD
<h3>Formulaire de voyage</h3>
<p style='font-weight:bold;text-align:justify;'>Veuillez remplir le formulaire ci-dessous au moins 24h avant votre départ et il vous sera envoyé une confirmation de réception de la part du programme avant votre départ :</p>

<div class='fieldset'>
<form name='form_1' action='trip_submit.php' method='post' onsubmit='return tripFormValidation();'>
<input type='hidden' name='data[9]' value='{$s->elements['lastname']}' />
<input type='hidden' name='data[10]' value='{$s->elements['firstname']}' />
<input type='hidden' name='data[11]' value='{$s->elements['email']}' />
<input type='hidden' name='data[12]' value='{$s->elements['cellphone']}' />

<table border='0' style='width:100%;'>
<tr><td style='width:360px;'>&nbsp;</td><td style='width:360px;'>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><b>Nom, prénom : </b></td>
<td colspan='2' class='response'>{$s->elements['lastname']}, {$s->elements['firstname']}</td></tr>

<tr><td><b>Email, Mobile: </b></td>
<td colspan='2' class='response'>{$s->elements['email']}, {$s->elements['cellphone']}</td></tr>

<tr><td style='padding-top:20px;'><b>Date de départ :</b> (Obligatoire)</td>
<td colspan='2' style='padding-top:20px;'><input type='text' name='data[0]' value='{$data[0]}' class='myUI-datepicker-string required' style='width:100%;' />
</td></tr>

<tr><td style='padding-top:20px;'><b>Date de retour :</b> (Obligatoire)</td>
<td colspan='2' style='padding-top:20px;'><input type='text' name='data[1]' value='{$data[1]}' class='myUI-datepicker-string required' style='width:100%;' />
</td></tr>

<tr><td style='padding-top:20px;'><b>Destination(s) :</b> (Obligatoire)</td>
<td colspan='2' style='padding-top:20px;'><textarea name='data[2]' class='required'>{$data[2]}</textarea></td></tr>

<tr><td style='text-align:justify;' colspan='3'><b>Moyen(s) de transport 
(avion - N° de vols, horaires et compagnies aériennes ; trains - horaires et destinations des trains)</b></td></tr>
<tr><td>&nbsp;</td><td colspan='2'><textarea name='data[3]'>{$data[3]}</textarea></td></tr>

<tr><td style='text-align:justify;' colspan='3'><b>Adresse(s) sur place 
(hôtel, auberge, amis, etc.) :</b> (obligatoire)</td></tr>
<tr><td>&nbsp;</td><td colspan='2'><textarea name='data[4]' class='required'>{$data[4]}</textarea></td></tr>

<tr><td colspan='1'><b>N° de téléphone où on peut vous joindre :</b> (Obligatoire)</td>
<td colspan='2'><input type='text' name='data[5]' value='{$data[5]}' style='width:100%;' class='required'/></td></tr>

<tr><td style='padding-top:20px;text-align:justify;' colspan='3'>
<b>Acceptez-vous que l'on communique ces informations à vos parents ?</b> (Obligatoire)
<span style='position: absolute; left:620px;'>
<input type='radio' name='data[6]' value='Oui' class='requiredRadio'/> Oui
<input type='radio' name='data[6]' value='Non' style='margin-left:20px;' class='requiredRadio' /> Non
</span>
</td></tr>

<tr><td style='padding-top:20px;text-align:justify;' colspan='2'>
<b>Pour pouvoir envoyer votre formulaire, veuillez accepter les conditions suivantes :</b>
<ul>
<li><b>J’accepte que l'on communique ces informations à mon université</b> (Obligatoire)
<span style='position: absolute; left:620px;'><input type='checkbox' name='data[7]' value='Oui' class='requiredCheckbox' /></span>
</li>
<li><b>J'ai lu les consignes de sécurité avant les congés</b> (Obligatoire)
<span style='position: absolute; left:620px;'><input type='checkbox' name='data[8]' value='Oui' class='requiredCheckbox' /></span>
</ul>
</td></tr>

<tr><td colspan='3' style='padding-top:20px;'><b>
Assurez-vous que vous avez le N°  de téléphone portable du directeur avec vous :</b></td></tr>

<tr><td colspan='3' style='padding-top:20px;text-align:center;font-size:22pt;'><b>
06-40-15-51-71</b></td></tr>

<tr><td colspan='3' style='padding-top:20px;text-align:center;'>
<input type='submit' value='Envoyer' class='myUI-button' style='font-size:18pt;' /></td></tr>

</table>
</form>
</div>	<!-- fieldset -->












EOD;
?>