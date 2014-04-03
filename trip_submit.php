<?php
require_once "inc/config.php";

$data=array_map("entities",$_POST['data']);

$message= <<<EOD
<style type='text/css'>
.response {
  margin: 5px 0 20px 0;
  color:blue;
  font-weight:bold;
  text-align:justify;
}
</style>

<h3>Formulaire de voyage</h3>
<!--
<p style='font-weight:bold;text-align:justify;width:1170px;'>Veuillez remplir le formulaire ci-dessous au moins 24h avant votre départ et il vous sera envoyé une confirmation de réception de la part du programme avant votre départ :</p>
-->

<div class='fieldset'>
<table border='0' style='width:100%;'>
<tr><td style='width:360px;'>&nbsp;</td><td style='width:360px;'>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><b>Nom, prénom : </b></td>
<td colspan='2' class='response'>{$data[9]}, {$data[10]}</td></tr>

<tr><td><b>Email, Mobile: </b></td>
<td colspan='2' class='response'>{$data[11]}, {$data[12]}</td></tr>

<tr><td style='padding-top:20px;'><b>Date de départ :</b> </td>
<td colspan='2' style='padding-top:20px;' class='response'>{$data[0]}</td></tr>

<tr><td style='padding-top:20px;'><b>Date de retour :</b> </td>
<td colspan='2' style='padding-top:20px;' class='response'>{$data[1]}</td></tr>

<tr><td style='padding-top:20px;'><b>Destination(s) :</b> </td>
<td colspan='2' style='padding-top:20px;' class='response'>{$data[2]}</td></tr>

<tr><td style='text-align:justify;padding-top:20px;' colspan='3'><b>Moyen(s) de transport 
(avion - N° de vols, horaires et compagnies aériennes ; trains - horaires et destinations des trains)</b></td></tr>
<tr><td>&nbsp;</td><td colspan='2' class='response'>{$data[3]}</td></tr>

<tr><td style='text-align:justify;padding-top:20px;' colspan='3'><b>Adresse(s) sur place 
(hôtel, auberge, amis, etc.) :</b> </td></tr>
<tr><td>&nbsp;</td><td colspan='2' class='response'>{$data[4]}</td></tr>

<tr><td colspan='2' style='padding-top:20px;'><b>N° de téléphone où on peut vous joindre :</b> </td>
<td colspan='2' style='padding-top:20px;' class='response'>{$data[5]}</td></tr>

<tr><td style='padding-top:20px;text-align:justify;' colspan='2'>
<b>Acceptez-vous que l'on communique ces informations à vos parents ?</b> </td>
<td style='padding-top:20px;' class='response'>{$data[6]}</td></tr>

<tr><td style='padding-top:20px;text-align:justify;' colspan='2'>
<b>Acceptez-vous que l'on communique ces informations à votre université ?</b> </td>
<td style='padding-top:20px;' class='response'>{$data[7]}</td></tr>

<tr><td style='padding-top:20px;text-align:justify;' colspan='2'>
<b>Avez-vous lu les consignes de sécurité avant les congés ? :</b> </td>
<td style='padding-top:20px;' class='response'>{$data[8]}</td></tr>

<tr><td colspan='3' style='padding-top:20px;'><b>
Assurez-vous que vous avez le N°  de téléphone portable du directeur avec vous :</b></td></tr>

<!--
<tr><td colspan='3' style='padding-top:20px;text-align:center;font-size:22pt;'><b>
06-40-15-51-71</b></td></tr>
-->

</table>
</div>	<!-- fieldset -->
EOD;

$error=1;
$msg="send_email_error";

$mail=new vwppMail();
if(is_array($config['emailForTripForm'])){
  foreach($config['emailForTripForm'] as $elem){
    $mail->addAddress($elem);
  }
  $subject="Formulaire de voyage ";
  $subject.=html_entity_decode($data[9],ENT_QUOTES|ENT_IGNORE,"utf-8").", ";
  $subject.=html_entity_decode($data[10],ENT_QUOTES|ENT_IGNORE,"utf-8");
  $mail->subject=$subject;
  $mail->body = $message;
  $mail->from=$data[11];
  $mail->sender=$data[11];
  $mail->fromName="{$data[9]}, {$data[10]}";
  $mail->send();
  if($mail->error){		// Si erreur, met from et sender par défaut et essai de nouveau
    $mail->error=null;		//	(permet l'envoi même si l'addresse de l'étudiant est erronée)
    $mail->from=null;		
    $mail->sender=null;
    $mail->fromName=null;
    $mail->send();

  }
  if(!$mail->error){
    $error=0;
    $msg="send_email_success";
  }
}

header("Location: trip_index.php?error=$error&msg=$msg");
?>