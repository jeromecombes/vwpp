<?php
// Last Update 2015-10-13, Jérôme Combes
session_start();

global $config;
global $dbprefix;
$config=Array();


//	Main Configuration
$config['db']="mysql";	// mysql or postgre
//$config['dbhost']="vwppdatabase2.db.9181526.hostedresource.com";
$config['dbhost']="your_db_host";
$config['dbname']="your_db_name";
$config['port']="your_db_port";
$config['dbuser']="your_db_host";
$config['dbpass']="your_password";
$config['dbprefix']="";
$dbprefix=$config['dbprefix'];
$config['dateFormat']="M d, Y H:i";
$config['docsFolder']="/var/www/vwpp/docs/database2";
$config['crypt_key']="your_hexa_crypt_key";
$config['folder']="/database2";
$config['url']="https://data.vwpp.org/database2";
$config['sessionTimeOut']=1800;

$config['documentType']=array("Passport","Health insurance id","French Essay","Pledge","Risk and release waiver",
	"Student medical release and parental statement form","Health form","Immunization records","Flight information",
	"Transcript","Language recommendation","Recommendation","Carte de séjour","Photo",
        "French Univ. Student Card","Visa","TCP certificate","Early departure");
sort($config['documentType']);
$config['documentType'][]="Other";

//	Send Mail configuration
$config['Mail-IsMail-IsSMTP']="IsMail";
$config['Mail-WordWrap']=50;
$config['Mail-Hostname']="data.vwpp.org";
$config['Mail-Host']="smtp.vwpp.org";
$config['Mail-Port']=26;
$config['Mail-SMTPSecure']=null;
$config['Mail-SMTPAuth']=false;
$config['Mail-Username']="";
$config['Mail-Password']="";
$config['Mail-From']="inscriptions@vwpp.org";
$config['Mail-FromName']="Service des Inscriptions, VWPP";
$config['Mail-Sender']="inscriptions@vwpp.org";	//return-path
$config['Mail-CharSet']="utf-8";


//	Messages (E-mails) 
$config['Messages-Welcome-Title']="IMPORTANT : VWPP Registration Details";

$config['Messages-Welcome']=<<<EOD
Dear [FIRSTNAME] [LASTNAME],<br/>
<br/>
Congratulations on being accepted to the Vassar-Wesleyan Program in Paris.  Please use the following login and password information to connect to the VWPP Administrative Portal at <a href='http://data.vwpp.org'>http://data.vwpp.org</a>. You will need access to your account in order fill in required forms for the Housing Questionnaire, University choice and Course registration among others.<br/>
Instructions and key deadlines can be found on the pre-registration timeline on the VWPP website at <a href='http://en.vwpp.org'>http://en.vwpp.org</a> under the heading "Info for Accepted Students".<br/>
<br/>

login: <b>[EMAIL]</b><br/>
password: <b>[PASSWORD]</b><br/>
<br/>
Please note: you will be able to change your password by clicking on the My Account tab once you enter into the system.<br/>
<br/>
If you have any questions, please do not hesitate to contact the office of International Programs at Vassar College or the Office of International Studies at Wesleyan University.<br/>
<br/>
Thank you.<br/>
EOD;


$config['disciplines']=array("Art-Archéologie","Arts appliqués (studio art)","Cinéma-Communication","Droit","Economie","Histoire-Géographie","Langues","Littérature","Musicologie","Philosophie","Psychologie-Psychanalyse","Sciences appliquées (biologie, chimie, maths, physique ...)","Sciences du langage (grammaire, traduction, linguistique ...)","Sociologie");
$config['institutions']=array("Université Paris III","Université Paris IV","Université Paris VII","Académie de Port Royal","CIPh");
$config['niveaux']=array("Licence 1","Licence 2","Licence 3","Master 1","Master 2");
$config['univCoursNature']=array("CM","TD","Option","TP");


$inc=explode("/",$_SERVER['SCRIPT_NAME']);
$folder=($inc[count($inc)-2]=="inc" or $inc[count($inc)-2]=="admin")?"../":null;


date_default_timezone_set('Europe/Paris');

require_once $folder."inc/db_{$config['db']}.php";
require_once $folder."inc/functions.php";

include "states.inc";
?>
