<?php
require_once "class.student.inc";
require_once "class.users.inc";


//	Access control
function access_ctrl($ids){
  $ids=explode(",",$ids);
  $access=false;
  foreach($ids as $elem){
    if(in_array($elem,$_SESSION['vwpp']['access'])){
      $access=true;
    }
  }

  if(!$access){
    echo "<b style='color:red;'>Access denied</b><br/><br/><a href='javascript:history.back()'>Back</a>";
    $folder=preg_match('/admin/',$_SERVER['SCRIPT_NAME'])?"../":null;
    require_once "{$folder}footer.php";
    exit;
   }
}

function cmp_countDesc($a,$b){
  if($a['type']==$b['type']){
    if($a['count']==$b['count'])
      return 0;
    else
      return ($a['count'] > $b['count']) ? -1 : 1;
  }
  return ($a['type'] > $b['type']) ? -1 : 1;
}

function cmp_cm_code($a,$b){
  return (strtolower($a['cm_code']) > strtolower($b['cm_code']));
}

function cmp_cm_code_desc($a,$b){
  return (strtolower($a['cm_code']) < strtolower($b['cm_code']));
}

function cmp_cm_code2($a,$b){
  if($a['university']==$b['university'])
    return (strtolower($a['cm_code']) > strtolower($b['cm_code']));
  return $a['university']>$b['university'];
  
}

function cmp_cm_name_en($a,$b){
  return ($a['cm_name_en'] > $b['cm_name_en']);
}

function cmp_cm_name_en_desc($a,$b){
  return ($a['cm_name_en'] < $b['cm_name_en']);
}

function cmp_cm_nom($a,$b){
//   return (strtolower($a['cm_nom']) > strtolower($b['cm_nom']));
  return (strtolower($a['cm_nom']) > strtolower($b['cm_nom']));
}

function cmp_cm_nom_desc($a,$b){
  return (strtolower($a['cm_nom']) < strtolower($b['cm_nom']));
}



function cmp_lastname($a,$b){
  $a['lastname']=strtolower($a['lastname']);
  $a['firstname']=strtolower($a['firstname']);
  $b['lastname']=strtolower($b['lastname']);
  $b['firstname']=strtolower($b['firstname']);

  if($a['lastname']==$b['lastname']){
    if($a['firstname']==$b['firstname'])
      return 0;
    else
      return ($a['firstname'] < $b['firstname']) ? -1 : 1;
  }
  return ($a['lastname'] < $b['lastname']) ? -1 : 1;
}

function cmp_lastname_desc($a,$b){
  $a['lastname']=strtolower($a['lastname']);
  $a['firstname']=strtolower($a['firstname']);
  $b['lastname']=strtolower($b['lastname']);
  $b['firstname']=strtolower($b['firstname']);

  if($a['lastname']==$b['lastname']){
    if($a['firstname']==$b['firstname'])
      return 0;
    else
      return ($a['firstname'] > $b['firstname']) ? -1 : 1;
  }
    return ($a['lastname'] > $b['lastname']) ? -1 : 1;
}

function cmp_firstname($a,$b){
  if($a['firstname']==$b['firstname']){
    if($a['lastname']==$b['lastname'])
      return 0;
    else
      return ($a['lastname'] < $b['lastname']) ? -1 : 1;
  }
  return ($a['firstname'] < $b['firstname']) ? -1 : 1;
}

function cmp_firstname_desc($a,$b){
  if($a['firstname']==$b['firstname']){
    if($a['lastname']==$b['lastname'])
      return 0;
    else
      return ($a['lastname'] > $b['lastname']) ? -1 : 1;
  }
  return ($a['firstname'] > $b['firstname']) ? -1 : 1;
}

function cmp_frenchUniv($a,$b){
  if(strcasecmp($a['frenchUniv'],$b['frenchUniv'])==0){
    return strcasecmp($a['lastname'],$b['lastname']);
  }
  return strcasecmp($a['frenchUniv'],$b['frenchUniv']);
}

function cmp_frenchUniv_desc($a,$b){
  if(strcasecmp($a['frenchUniv'],$b['frenchUniv'])==0){
    return strcasecmp($a['lastname'],$b['lastname']);
  }
  return strcasecmp($b['frenchUniv'],$a['frenchUniv']);
}

function cmp_phonenumber($a,$b){
  return ($a['phonenumber'] > $b['phonenumber']);
}

function cmp_phonenumber_desc($a,$b){
  return ($a['phonenumber'] < $b['phonenumber']);
}

function cmp_cellphone($a,$b){
  return ($a['cellphone'] > $b['cellphone']);
}

function cmp_cellphone_desc($a,$b){
  return ($a['cellphone'] < $b['cellphone']);
}

function cmp_cm_name($a,$b){
  return ($a['cm_name'] > $b['cm_name']);
}

function cmp_cm_name_desc($a,$b){
  return ($a['cm_name'] < $b['cm_name']);
}

function cmp_cm_prof($a,$b){
  return (strtolower($a['cm_prof']) > strtolower($b['cm_prof']));
}

function cmp_cm_prof_desc($a,$b){
  return (strtolower($a['cm_prof']) < strtolower($b['cm_prof']));
}

function cmp_code($a,$b){
  return ($a['code'] > $b['code']);
}

function cmp_code_desc($a,$b){
  return ($a['code'] < $b['code']);
}

function cmp_dob($a,$b){
  return ($a['dob'] > $b['dob']);
}

function cmp_dob_desc($a,$b){
  return ($a['dob'] < $b['dob']);
}

function cmp_domaine($a,$b){
  return ($a['domaine'] > $b['domaine']);
}

function cmp_domaine_desc($a,$b){
  return ($a['domaine'] < $b['domaine']);
}

function cmp_email($a,$b){
  return ($a['email'] > $b['email']);
}

function cmp_email_desc($a,$b){
  return ($a['email'] < $b['email']);
}

function cmp_gender($a,$b){
  return ($a['gender'] > $b['gender']);
}

function cmp_institution_desc($a,$b){
  return ($a['institution'] < $b['institution']);
}

function cmp_institution($a,$b){
  return ($a['institution'] > $b['institution']);
}

function cmp_institution2($a,$b){
  if(strtolower($a['institution']) == strtolower($b['institution'])){
    if(strtolower($a['institutionAutre']) == strtolower($b['institutionAutre'])){
      if(strtolower($a['discipline']) == strtolower($b['discipline'])){
        if(strtolower($a['niveau']) == strtolower($b['niveau'])){
	  if(strtolower($a['lien']) == strtolower($b['lien'])){
	    if(strtolower($a['code']) == strtolower($b['code'])){
	      return (strtolower($a['nom']) > strtolower($b['nom']));
	    }
	    return (strtolower($a['code']) > strtolower($b['code']));
	  }
	  return (strtolower($a['lien']) > strtolower($b['lien']));
	}
	return (strtolower($a['niveau']) > strtolower($b['niveau']));
      }
      return (strtolower($a['discipline']) > strtolower($b['discipline']));
    }
    return (strtolower($a['institutionAutre']) > strtolower($b['institutionAutre']));
  }
  return (strtolower($a['institution']) > strtolower($b['institution']));
}

function cmp_institution2_desc($a,$b){
  if(strtolower($a['institution']) == strtolower($b['institution'])){
    if(strtolower($a['institutionAutre']) == strtolower($b['institutionAutre'])){
      if(strtolower($a['discipline']) == strtolower($b['discipline'])){
        if(strtolower($a['niveau']) == strtolower($b['niveau'])){
	  if(strtolower($a['lien']) == strtolower($b['lien'])){
	    if(strtolower($a['code']) == strtolower($b['code'])){
	      return (strtolower($a['nom']) > strtolower($b['nom']));
	    }
	    return (strtolower($a['code']) > strtolower($b['code']));
	  }
	  return (strtolower($a['lien']) > strtolower($b['lien']));
	}
	return (strtolower($a['niveau']) > strtolower($b['niveau']));
      }
      return (strtolower($a['discipline']) > strtolower($b['discipline']));
    }
    return (strtolower($a['institutionAutre']) < strtolower($b['institutionAutre']));
  }
  return (strtolower($a['institution']) < strtolower($b['institution']));
}

function cmp_discipline2($a,$b){
  if(strtolower($a['discipline']) == strtolower($b['discipline'])){
    if(strtolower($a['lien']) == strtolower($b['lien'])){
      if(strtolower($a['code']) == strtolower($b['code'])){
	return (strtolower($a['nom']) > strtolower($b['nom']));
      }
      return (strtolower($a['code']) > strtolower($b['code']));
    }
    return (strtolower($a['lien']) > strtolower($b['lien']));
  }
  return (strtolower($a['discipline']) > strtolower($b['discipline']));
}

function cmp_discipline2_desc($a,$b){
  if(strtolower($a['discipline']) == strtolower($b['discipline'])){
    if(strtolower($a['lien']) == strtolower($b['lien'])){
      if(strtolower($a['code']) == strtolower($b['code'])){
	return (strtolower($a['nom']) > strtolower($b['nom']));
      }
      return (strtolower($a['code']) > strtolower($b['code']));
    }
    return (strtolower($a['lien']) > strtolower($b['lien']));
  }
  return (strtolower($a['discipline']) < strtolower($b['discipline']));
}

function cmp_code2($a,$b){
  if(strtolower($a['code']) == strtolower($b['code'])){
    return (strtolower($a['nom']) > strtolower($b['nom']));
  }
  return (strtolower($a['code']) > strtolower($b['code']));
}

function cmp_code2_desc($a,$b){
  if(strtolower($a['code']) == strtolower($b['code'])){
    return (strtolower($a['nom']) > strtolower($b['nom']));
  }
  return (strtolower($a['code']) < strtolower($b['code']));
}

function cmp_instructeur($a,$b){
  return ($a['instructeur'] > $b['instructeur']);
}

function cmp_instructeur_desc($a,$b){
  return ($a['instructeur'] < $b['instructeur']);
}

function cmp_gender_desc($a,$b){
  return ($a['gender'] < $b['gender']);
}

function cmp_name($a,$b){
  return (strtolower($a['name']) > strtolower($b['name']));
}

function cmp_name_desc($a,$b){
  return (strtolower($a['name']) < strtolower($b['name']));
}

function cmp_name2($a,$b){
  return ($a['name2'] > $b['name2']);
}

function cmp_name2_desc($a,$b){
  return ($a['name2'] < $b['name2']);
}

function cmp_nature($a,$b){
  if(strtolower($a['nature']) == strtolower($b['nature'])){
    if(strtolower($a['institution']) == strtolower($b['institution'])){
      if(strtolower($a['institutionAutre']) == strtolower($b['institutionAutre'])){
	if(strtolower($a['discipline']) == strtolower($b['discipline'])){
	  if(strtolower($a['niveau']) == strtolower($b['niveau'])){
	    if(strtolower($a['lien']) == strtolower($b['lien'])){
	      if(strtolower($a['code']) == strtolower($b['code'])){
		return (strtolower($a['nom']) > strtolower($b['nom']));
	      }
	      return (strtolower($a['code']) > strtolower($b['code']));
	    }
	    return (strtolower($a['lien']) > strtolower($b['lien']));
	  }
	  return (strtolower($a['niveau']) > strtolower($b['niveau']));
	}
	return (strtolower($a['discipline']) > strtolower($b['discipline']));
      }
      return (strtolower($a['institutionAutre']) > strtolower($b['institutionAutre']));
    }
    return (strtolower($a['institution']) > strtolower($b['institution']));
  }
  return (strtolower($a['nature']) > strtolower($b['nature']));
}

function cmp_nature_desc($a,$b){
  if(strtolower($a['nature']) == strtolower($b['nature'])){
    if(strtolower($a['institution']) == strtolower($b['institution'])){
      if(strtolower($a['institutionAutre']) == strtolower($b['institutionAutre'])){
	if(strtolower($a['discipline']) == strtolower($b['discipline'])){
	  if(strtolower($a['niveau']) == strtolower($b['niveau'])){
	    if(strtolower($a['lien']) == strtolower($b['lien'])){
	      if(strtolower($a['code']) == strtolower($b['code'])){
		return (strtolower($a['nom']) > strtolower($b['nom']));
	      }
	      return (strtolower($a['code']) > strtolower($b['code']));
	    }
	    return (strtolower($a['lien']) > strtolower($b['lien']));
	  }
	  return (strtolower($a['niveau']) > strtolower($b['niveau']));
	}
	return (strtolower($a['discipline']) > strtolower($b['discipline']));
      }
      return (strtolower($a['institutionAutre']) > strtolower($b['institutionAutre']));
    }
    return (strtolower($a['institution']) > strtolower($b['institution']));
  }
  return (strtolower($a['nature']) < strtolower($b['nature']));
}

function cmp_nom($a,$b){
  return (strtolower($a['nom']) > strtolower($b['nom']));
}

function cmp_nom_desc($a,$b){
  return (strtolower($a['nom']) < strtolower($b['nom']));
}

function cmp_nom_en($a,$b){
  return (strtolower($a['nom_en']) > strtolower($b['nom_en']));
}

function cmp_nom_en_desc($a,$b){
  return (strtolower($a['nom_en']) < strtolower($b['nom_en']));
}

function cmp_prof($a,$b){
  return (strtolower($a['prof']) > strtolower($b['prof']));
}

function cmp_prof_desc($a,$b){
  return (strtolower($a['prof']) < strtolower($b['prof']));
}

function cmp_professor($a,$b){
  return (strtolower($a['professor']) > strtolower($b['professor']));
}

function cmp_professor_desc($a,$b){
  return (strtolower($a['professor']) < strtolower($b['professor']));
}

function cmp_rel($a,$b){
  return ($a['rel'] > $b['rel']);
}

function cmp_rel_desc($a,$b){
  return ($a['rel'] < $b['rel']);
}

function cmp_timestamp($a,$b){
  return ($a['timestamp'] > $b['timestamp']);
}

function cmp_timestamp_desc($a,$b){
  return ($a['timestamp'] < $b['timestamp']);
}

function cmp_titre($a,$b){
  return ($a['titre'] > $b['titre']);
}

function cmp_titre_desc($a,$b){
  return ($a['titre'] < $b['titre']);
}

function cmp_vwppChoices($a,$b){
  if($a['type']==$b['type']){
    if($a['code']==$b['code']){
      if($a['title']==$b['title']){
	if($a['nom']==$b['nom']){
	  if($a['professor']==$b['professor']){
	    if($a['choice']==$b['choice']){
	      if($a['studentLastname']==$b['studentLastname']){
		return ($a['studentFirstname']>$b['studentFirstname']);
	      }
	      return ($a['studentLastname']>$b['studentLastname']);
	    }
	    return ($a['choice']>$b['choice']);
	  }
	  return ($a['professor']>$b['professor']);
	}
	return ($a['nom']>$b['nom']);
      }
      return ($a['title']>$b['title']);
    }
    return ($a['code']>$b['code']);
  }
  return ($a['type']>$b['type']);
}

function cmp_zipcode($a,$b){
  return ($a['zipcode'] > $b['zipcode']);
}

function cmp_zipcode_desc($a,$b){
  return ($a['zipcode'] < $b['zipcode']);
}


function cmp_schedule($a,$b){
  if($a['day']==$b['day']){
    if($a['debut']==$b['debut']){
      return ($a['fin']>$b['fin']);
    }
    else{
      return ($a['debut']>$b['debut']);
    }
  }
  else{
    return ($a['day']>$b['day']);
  }
}

function cmp_studentName($a,$b){
  return (strtolower($a['studentName']) > strtolower($b['studentName']));
}

function cmp_studentName_desc($a,$b){
  return (strtolower($a['studentName']) < strtolower($b['studentName']));
}

function cmp_studentName2($a,$b){
  if(strtolower($a['studentName']) == strtolower($b['studentName'])){
    if(strtolower($a['institution']) == strtolower($b['institution'])){
      if(strtolower($a['institutionAutre']) == strtolower($b['institutionAutre'])){
	if(strtolower($a['discipline']) == strtolower($b['discipline'])){
	  if(strtolower($a['niveau']) == strtolower($b['niveau'])){
	    if(strtolower($a['lien']) == strtolower($b['lien'])){
	      if(strtolower($a['code']) == strtolower($b['code'])){
		return (strtolower($a['nom']) > strtolower($b['nom']));
	      }
	      return (strtolower($a['code']) > strtolower($b['code']));
	    }
	    return (strtolower($a['lien']) > strtolower($b['lien']));
	  }
	  return (strtolower($a['niveau']) > strtolower($b['niveau']));
	}
	return (strtolower($a['discipline']) > strtolower($b['discipline']));
      }
      return (strtolower($a['institutionAutre']) > strtolower($b['institutionAutre']));
    }
    return (strtolower($a['institution']) > strtolower($b['institution']));
  }
  return (strtolower($a['studentName']) > strtolower($b['studentName']));
}

function cmp_studentName2_desc($a,$b){
  if(strtolower($a['studentName']) == strtolower($b['studentName'])){
    if(strtolower($a['institution']) == strtolower($b['institution'])){
      if(strtolower($a['institutionAutre']) == strtolower($b['institutionAutre'])){
	if(strtolower($a['discipline']) == strtolower($b['discipline'])){
	  if(strtolower($a['niveau']) == strtolower($b['niveau'])){
	    if(strtolower($a['lien']) == strtolower($b['lien'])){
	      if(strtolower($a['code']) == strtolower($b['code'])){
		return (strtolower($a['nom']) > strtolower($b['nom']));
	      }
	      return (strtolower($a['code']) > strtolower($b['code']));
	    }
	    return (strtolower($a['lien']) > strtolower($b['lien']));
	  }
	  return (strtolower($a['niveau']) > strtolower($b['niveau']));
	}
	return (strtolower($a['discipline']) > strtolower($b['discipline']));
      }
      return (strtolower($a['institutionAutre']) > strtolower($b['institutionAutre']));
    }
    return (strtolower($a['institution']) > strtolower($b['institution']));
  }
  return (strtolower($a['studentName']) < strtolower($b['studentName']));
}

function cmp_type($a,$b){
  if(strcasecmp($a['type'],$b['type'])==0){
    return(strcasecmp($a['nom'],$b['nom']));
  }
  return(strcasecmp($a['type'],$b['type']));
}

function cmp_type_desc($a,$b){
  if(strcasecmp($a['type'],$b['type'])==0){
    return(strcasecmp($a['nom'],$b['nom']));
  }
  return(strcasecmp($b['type'],$a['type']));
}

function cmp_title($a,$b){
  if($a['title']==$b['title']){
    if($a['professor']==$b['professor'])
      return 0;
    else
      return ($a['professor'] < $b['professor']) ? -1 : 1;
  }
  return ($a['title'] < $b['title']) ? -1 : 1;
}

function cmp_title_desc($a,$b){
  if($a['title']==$b['title']){
    if($a['professor']==$b['professor'])
      return 0;
    else
      return ($a['professor'] < $b['professor']) ? -1 : 1;
  }
  return ($a['title'] > $b['title']) ? -1 : 1;
}

function cmp_typeDesc($a,$b){
  if($a['type']==$b['type']){
    if($a['title']==$b['title'])
      return 0;
    else
      return ($a['title'] < $b['title']) ? -1 : 1;
  }
  return ($a['type'] > $b['type']) ? -1 : 1;
}

function cmp_ufr($a,$b){
  return ($a['ufr'] > $b['ufr']);
}

function cmp_ufr_desc($a,$b){
  return ($a['ufr'] < $b['ufr']);
}

function cmp_ufr_en($a,$b){
  return (strtolower($a['ufr_en']) > strtolower($b['ufr_en']));
}

function cmp_ufr_en_desc($a,$b){
  return (strtolower($a['ufr_en']) < strtolower($b['ufr_en']));
}

function cmp_univ($a,$b){
  if($a['university']==$b['university']){
    if($a['title']==$b['title'])
      return 0;
    else
      return ($a['title'] < $b['title']) ? -1 : 1;
  }
  return ($a['university'] < $b['university']) ? -1 : 1;
}

function cmp_univ_desc($a,$b){
  if($a['university']==$b['university']){
    if($a['title']==$b['title'])
      return 0;
    else
      return ($a['title'] > $b['title']) ? -1 : 1;
  }
  return ($a['university'] > $b['university']) ? -1 : 1;
}

function cmp_univ_lastname($a,$b){
  if(strtolower($a['university'])==strtolower($b['university']))
    return (strtolower($a['lastname']) > strtolower($b['lastname']));
  return (strtolower($a['university']) > strtolower($b['university']));
}

function cmp_univ_lastname_desc($a,$b){
  if(strtolower($a['university'])==strtolower($b['university']))
    return (strtolower($a['lastname']) > strtolower($b['lastname']));
  return (strtolower($a['university']) < strtolower($b['university']));
}

function delete_rnt($n){
  if(is_array($n)){
    return array_map("delete_rnt",$n);
  }
  return str_replace(array("\r","\n","\t")," ",$n);
}

function encryptTab($n){
  return encrypt($n);
}

function entities($n){
  return htmlentities($n,ENT_QUOTES|ENT_IGNORE,"utf-8");
}

function entity_decode($n){
  if(is_array($n)){
    return array_map("entity_decode",$n);
  }
  else
    return html_entity_decode($n,ENT_QUOTES|ENT_IGNORE,"utf-8");
}

function decrypt($str,$key=null)
{  
    $key=$key.$GLOBALS['config']['crypt_key'];
    $key=substr($key,0,24);
    $str = mcrypt_decrypt(MCRYPT_3DES, $key, $str, MCRYPT_MODE_ECB);

    $block = mcrypt_get_block_size('des', 'ecb');
    $pad = ord($str[($len = strlen($str)) - 1]);
    return substr($str, 0, strlen($str) - $pad);
}

function decrypt2($str)
{  
    $key=$GLOBALS['config']['crypt_key'];
    $key=substr($key,0,24);
    $str = mcrypt_decrypt(MCRYPT_3DES, $key, $str, MCRYPT_MODE_ECB);

    $block = mcrypt_get_block_size('des', 'ecb');
    $pad = ord($str[($len = strlen($str)) - 1]);
    return substr($str, 0, strlen($str) - $pad);
}

function encrypt($str,$key=null)
{
    $key=$key.$GLOBALS['config']['crypt_key'];
    $key=substr($key,0,24);
    $block = mcrypt_get_block_size('tripledes', 'ecb');
    $pad = $block - (strlen($str) % $block);
    $str .= str_repeat(chr($pad), $pad);

    return mcrypt_encrypt(MCRYPT_3DES, $key, $str, MCRYPT_MODE_ECB);
}

function genTrivialPassword($len = 8){
  $r = '';
  for($i=0; $i<$len; $i++)
    $r .= chr(rand(0, 25) + ord('a'));
  return $r;
}


    //	Make Inputs (radio, checkbox ...)	$input = array(data_id,type,array(values))
function input($input,$data,$td=false){
  $inputs=array();
  $td1=$td?"<td>":null;
  $td2=$td?"</td>":null;
  for($i=0;$i<count($input);$i++){
    for($j=0;$j<count($input[$i][2]);$j++){
      $input[$i][3][$j]=$data[$input[$i][0]]==$input[$i][2][$j]?"checked='checked'":null;
      $inputs[]="$td1<input type='{$input[$i][1]}' name='data[{$input[$i][0]}]' {$input[$i][3][$j]} value='{$input[$i][2][$j]}'/>{$input[$i][2][$j]}$td2\n";
    }
  }
  return $inputs;
}


function ctrl_log_access(){	// Verify log_access (wrong authentications)
  $db=new dbh();
  $db->prepare("SELECT * FROM `{$GLOBALS['dbprefix']}log_access` WHERE ip=:ip AND timestamp>(SYSDATE()-1800);");
  $db->execute(array(":ip"=>encrypt($_SERVER['REMOTE_ADDR'])));
  if(count($db->result)>4){		// If 5 wrong auth in 30 minutes : print error message and exit
    echo "<br/><br/><h3>Your IP address ({$_SERVER['REMOTE_ADDR']}) has temporarily denied access</h3>\n";
    echo "<p>Because it has voilated a security policy (too many invalid login attempts).</p>\n";
    exit;
    }
}

//	Login control
function login_ctrl(){
  if(isset($_SESSION['vwpp']['last_activity']) and (time()-$_SESSION['vwpp']['last_activity']>$GLOBALS['config']['sessionTimeOut'])){
    unset($_SESSION['vwpp']);
    header("Location: index.php");
  }
  if(isset($_SESSION['vwpp']['last_activity']))
    $_SESSION['vwpp']['last_activity']=time();

  if(!$_SESSION['vwpp']['login']){	// if no session => login_ctrl
    ctrl_log_access();

    $std=new student();			// try to log students
    $std->setToken(trim($_POST['login']));
    $std->setPassword($_POST['password']);
    $std->login();
    if(!$std->auth){			// if not, try to log admin
      $u=new user();
      $u->setToken($_POST['login']);
      $u->setPassword($_POST['password']);
      $u->login();
    }

  if(!$std->auth and !$u->auth and $_POST['login']){
    $log_access=array(":login"=>encrypt($_POST['login']),":ip"=>encrypt($_SERVER['REMOTE_ADDR']));
    $db=new dbh();
    $db->prepare("INSERT INTO `{$GLOBALS['dbprefix']}log_access` (login,ip,timestamp) VALUES (:login,:ip,SYSDATE());");
    $db->execute($log_access);		// Log if authentication failed
    ctrl_log_access();
  }

  if($std->auth or $u->auth)
    $_SESSION['vwpp']['last_activity']=time();
  }



  if($_SESSION['vwpp']['category']=="student" and stripos($_SERVER['PHP_SELF'],"admin")){
    header("Location: ..");		// redirect student to home if try to get admin pages
  }
  elseif($_SESSION['vwpp']['category']=="admin" and !stripos($_SERVER['PHP_SELF'],"admin")){
    header("Location: admin");		// redirect admin to admin pages
  }
}


function get_button($text,$id,$required,$align="left",$margin=null){
  if($_SESSION['vwpp']['category']=="admin" and !in_array($required,$_SESSION['vwpp']['access']))
    return false;
  echo "<p style='text-align:$align;margin:$margin'><input type='button' value='$text' onclick='edit($id);' class='myUI-button'/></p>\n";
}

function get_input($type,$id,$responses=null,$response=null){
  switch($type){
    case "checkbox" : 
      $responses=explode(",",$responses);
      foreach($responses as $elem)
	echo "<input type='checkbox' name='input[$id][]' value='$elem' />$elem\n";
      break;
    case "radio" : 
      $responses=explode(",",$responses);
      foreach($responses as $elem){
	$checked=$elem==$response?"checked='checked'":null;
	echo "<input type='radio' name='input[$id]' value='$elem' $checked />$elem\n";
      }
      break;
    case "select" : 
      $responses=explode(",",$responses);
      echo "<select name='input[$id]'>\n";
      foreach($responses as $elem)
	echo "<option value='$elem' />$elem</option>\n";
      echo "</select>\n";
      break;
    case "password" :
      echo "<input type='password' name='input[$id]' />\n";
      break;
    case "textarea" :
      echo "<textarea name='input[$id]'></textarea>\n";
      break;
    default : echo "<input type='text' name='input[$id]' />\n";
  }
}

function get_menu_new_not_used($menu,$page,$id,$required){
  if(!in_array($required,$_SESSION['vwpp']['access']))
    return false;

  $lid=$id==$GLOBALS['current_id']?"current":"li".$id;
  echo "<li id='$lid'><a href='$page'>$menu</a></li>\n";
  echo "<script type='text/JavaScript'>li_ids.push($id);</script>\n";
}

function get_menu($menu,$id,$required){
  $access=false;
  if(is_array($required)){
    foreach($required as $elem){
      if(in_array($elem,$_SESSION['vwpp']['access'])){
	$access=true;
      }
    }
  }
  elseif(in_array($required,$_SESSION['vwpp']['access'])){
    $access=true;
  }

  if(!$access)
    return false;

  $lid=$id==$GLOBALS['current_id']?"current":"li".$id;
  echo "<li id='$lid'><a href='javascript:change_menu($id);'>$menu</a></li>\n";
  echo "<script type='text/JavaScript'>li_ids.push($id);</script>\n";

}

function get_menu2($menu,$id,$required){
  $access=false;
  if(is_array($required)){
    foreach($required as $elem){
      if(in_array($elem,$_SESSION['vwpp']['access'])){
	$access=true;
      }
    }
  }
  elseif(in_array($required,$_SESSION['vwpp']['access'])){
    $access=true;
  }

  if(!$access)
    return false;

  $class=$id==$GLOBALS['current_id']?"ui-tabs-active ui-state-active":null;
  echo "<li id='$lid' class='ui-state-default ui-corner-top $class'><a href='students-view2.php?menu_id=$id'>$menu</a></li>\n";
  echo "<script type='text/JavaScript'>li_ids.push($id);</script>\n";
}

function get_page($page,$id,$required){
  $std=$GLOBALS['std'];
  $display=$id==$GLOBALS['current_id']?"":"none";
  $page=stripos($_SERVER['PHP_SELF'],"admin")?"../inc/$page":"inc/$page";	// If /admin : add ../

  $access=false;
  if(is_array($required)){
    foreach($required as $elem){
      if(in_array($elem,$_SESSION['vwpp']['access'])){
	$access=true;
      }
    }
  }
  elseif(in_array($required,$_SESSION['vwpp']['access'])){
    $access=true;
  }

  if($access)
    include $page;
}

function import_excel()
	{
	echo "<h3>Importation d'un fichier Excel</h3>\n";
	require_once 'include/Excel/reader.php';
	//print_r($_FILES);
	// ExcelFile($filename, $encoding);
	$data = new Spreadsheet_Excel_Reader();

	// Set output Encoding.
	$data->setOutputEncoding('CP1251');
	$data->read($GLOBALS['tmp_file']);
	$tab=$data->sheets[0]['cells'];		// $tab[ligne][colonne]
	return $tab;
	}
	
function import_csv()
	{
	echo "<h3>Importation d'un fichier CSV</h3>\n";
	$ligne=array();
	$tab=array();
	$fp=fopen($GLOBALS['tmp_file'],"ro");
	while($ligne=fgetcsv($fp,1000))
		{
		for($i=count($ligne);$i>0;$i--)		// decalage de l'offset pour correspondance avec fonction Excel
			$ligne[$i]=utf8_decode($ligne[$i-1]);		// et changement de l'encodage
		if($ligne[1])
			$tab[]=$ligne;
		}
	return $tab;
	}

function replace_name($tab){
  $tab['nom_en']=$tab['nom_en']?$tab['nom_en']:$tab['nom'];
  return $tab;
}

function utf8_decode2($n){
  if(is_array($n)){
    return array_map("utf8_decode2",$n);
  }
  else{
    $result=mb_detect_encoding($n)=="UTF-8"?utf8_decode($n):$n;
    return $result;
  }
}


?>