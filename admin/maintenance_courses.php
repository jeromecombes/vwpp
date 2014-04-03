<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);

require_once "../inc/config.php";

/*
$db=new db();
$db->select("courses_univ","*",null,"group by university,cm_code");

$keys=array_keys($db->result[0]);
$i=0;
foreach($db->result as $elem){
  foreach($keys as $key){
    if(in_array($key,array("id","student","semester","lock","ref"))){
      $tab[$i][$key]=$elem[$key];
    }
    elseif(in_array($key,array("university","cm_code"))){
      $tab[$i][$key]=($elem[$key] and !is_numeric($key))?decrypt($elem[$key]):null;
    }
    elseif(!is_numeric($key)){
      $tab[$i][$key]=($elem[$key] and !is_numeric($key))?decrypt($elem[$key],$elem['student']):null;
    }
  }
$i++;
}

//	Creation de la table courses_cm
$db=new db();
$db->query("drop table courses_cm;");

$db=new db();
$db->query("create table courses_cm (id int auto_increment primary key, university varchar(20), 
  code varchar(20), semester varchar(20), ufr text, parcours text, discipline text, departement text, 
  licence text, niveau text, nom text, jour1 text, debut1 text, fin1 text, jour2 text, debut2 text, 
  fin2 text, prof text, ufr_en text, parcours_en text, discipline_en text, departement_en text, 
  licence_en text, nom_en text, email text);");

//	Creation de la table courses_td
$db=new db();
$db->query("drop table courses_td;");
$db=new db();
$db->query("create table courses_td (id int auto_increment primary key, university varchar(20), 
  code varchar(20), semester varchar(20), jour1 text, debut1 text, fin1 text, jour2 text, debut2 text, 
  fin2 text, prof text, nom text, nom_en text, email text);");


//	Creation de la table courses_univ3
//	Cette table permettra de faire les liens entre l'etudiant et les CM et TD choisis
//	Champ tmp temporaire, permet d'associer les CM de l'ancienne table aux TD
$db=new db();
$db->query("drop table courses_univ3;");
$db=new db();
$db->query("create table courses_univ3 (id int auto_increment primary key, semester varchar(20), 
  student int, cm int, td int, tmp int);");


//	Insertion des élements dans la table courses_cm
$cmFields1=array("university"=>"university","code"=>"cm_code","semester"=>"semester",
  "ufr"=>"ufr","parcours"=>"parcours","discipline"=>"discipline","licence"=>"licence","niveau"=>"niveau",
  "nom"=>"cm_name","jour1"=>"cm_day1","debut1"=>"cm_start1","fin1"=>"cm_end1","jour2"=>"cm_day2",
  "debut2"=>"cm_start2","fin2"=>"cm_end2","prof"=>"cm_prof","ufr_en"=>"ufr_en",
  "parcours_en"=>"parcours_en","discipline_en"=>"discipline_en","departement_en"=>"departement_en",
  "licence_en"=>"licence_en","nom_en"=>"cm_name_en","departement"=>"departement");

$cmFields2=array("university","code","semester","ufr","parcours","discipline","departement",
  "licence","niveau","nom","jour1","debut1","fin1","jour2","debut2","fin2","prof","ufr_en",
  "parcours_en","discipline_en","departement_en","licence_en","nom_en");

$fields=join(", ",$cmFields2);
$values=join(", :",$cmFields2);
$sql="insert into courses_cm ($fields) values (:$values);";
$db=new dbh();
$db->prepare($sql);

foreach($tab as $elem){
  if($elem['cm_code'] or $elem['cm_name'] or$elem['cm_prof']){
    foreach($cmFields2 as $key){
      if(in_array($key,array("semester","university","code"))){
	$data[":$key"]=$elem[$cmFields1[$key]];
      }
      elseif(!is_numeric($key)){
	$data[":$key"]=($elem[$cmFields1[$key]] and !is_numeric($key))?encrypt($elem[$cmFields1[$key]]):null;
      }
    }
    if(empty($data[':code']) or $data[':code']=="?" or $data[':code']=="N/A" or $data[':code']=="NA")
      $data[':code']=$elem['student'];
    $db->execute($data);
    print_r($data);
    echo "<br><br>";
  }
}


//	Insertion des élements dans la table courses_td

$db=new db();
$db->select("courses_univ");

$keys=array_keys($db->result[0]);
$i=0;
foreach($db->result as $elem){
  foreach($keys as $key){
    if(in_array($key,array("id","student","semester","lock","ref"))){
      $tab[$i][$key]=$elem[$key];
    }
    elseif(in_array($key,array("university","cm_code"))){
      $tab[$i][$key]=($elem[$key] and !is_numeric($key))?decrypt($elem[$key]):null;
    }
    elseif(!is_numeric($key)){
      $tab[$i][$key]=($elem[$key] and !is_numeric($key))?decrypt($elem[$key],$elem['student']):null;
    }
  }
$i++;
}



$tdFields1=array("university"=>"university","code"=>"td_code","semester"=>"semester",
  "nom"=>"td_name","jour1"=>"td_day1","debut1"=>"td_start1","fin1"=>"td_end1","jour2"=>"td_day2",
  "debut2"=>"td_start2","fin2"=>"td_end2","prof"=>"td_prof","nom_en"=>"td_name_en");

$tdFields2=array("university","code","semester","nom","jour1","debut1","fin1","jour2","debut2",
  "fin2","prof", "nom_en");

$fields=join(", ",$tdFields2);
$values=join(", :",$tdFields2);
$sql="insert into courses_td ($fields) values (:$values);";
$db=new dbh();
$db->prepare($sql);

$data=array();
foreach($tab as $elem){
  if($elem['td_code'] or $elem['td_name'] or $elem['td_prof']){
    foreach($tdFields2 as $key){
      if(in_array($key,array("semester","university","code"))){
	$data[":$key"]=$elem[$tdFields1[$key]];
      }
      elseif(!is_numeric($key)){
	$data[":$key"]=($elem[$tdFields1[$key]] and !is_numeric($key))?encrypt($elem[$tdFields1[$key]]):null;
      }
    }
    if(empty($data[':code']) or $data[':code']=="?" or $data[':code']=="N/A" or $data[':code']=="NA")
      $data[':code']=$elem['student'];
  
    $db2=new db();
    $db2->select("courses_td","*","university='{$data[':university']}' AND code='{$data[':code']}'");
    if(!$db2->result){
      $db->execute($data);
      print_r($data);
      echo "<br><br>";
    }
  }
}


//	Association CM
$db=new db();
$db->select("courses_univ");
foreach($db->result as $elem){
  $univ=$elem["university"]?decrypt($elem["university"]):null;
  $code=$elem["cm_code"]?decrypt($elem["cm_code"]):$elem['student'];
  $semester=str_replace("_"," ",$elem['semester']);
  $db2=new db();
  $db2->select("courses_cm","id","university='$univ' AND code='$code'");
  if($db2->result){
    $db3=new db();
    $db3->insert2("courses_univ3",array("semester"=>$semester,"student"=>$elem['student'],"cm"=>$db2->result[0]['id'],"tmp"=>$elem['id']));
  }
}

//	Association TD
$db=new db();
$db->select("courses_univ");
foreach($db->result as $elem){
  $univ=$elem["university"]?decrypt($elem["university"]):null;
  $code=$elem["td_code"]?decrypt($elem["td_code"]):$elem['student'];
  $semester=str_replace("_"," ",$elem['semester']);
  $db2=new db();
  $db2->select("courses_td","id","university='$univ' AND code='$code'");
  if($db2->result){
    $db3=new db();
    $db3->select("courses_univ3","*","tmp='{$elem['id']}'");
    if($db3->result){
      $db4=new db();
      $db4->update("courses_univ3","td='{$db2->result[0]['id']}'","id='{$db3->result[0]['id']}'");
    }
    else{
      $db4=new db();
      $db4->insert2("courses_univ3",array("semester"=>$semester,"student"=>$elem['student'],"td"=>$db2->result[0]['id']));
    }
  }
}
*/

//	Supprime _ dans les semestres pour courses_cm
$db=new db();
$db->select("courses_cm");
foreach($db->result as $elem){
  $tab[]=array(":id"=>$elem['id'],":semester"=>str_replace("_"," ",$elem["semester"]));
}
$db=new dbh();
$db->prepare("UPDATE courses_cm SET semester=:semester WHERE id=:id");
foreach($tab as $elem){
  $db->execute($elem);
}

//	Supprime _ dans les semestres pour courses_td
$db=new db();
$db->select("courses_td");
foreach($db->result as $elem){
  $tab[]=array(":id"=>$elem['id'],":semester"=>str_replace("_"," ",$elem["semester"]));
}
$db=new dbh();
$db->prepare("UPDATE courses_td SET semester=:semester WHERE id=:id");
foreach($tab as $elem){
  $db->execute($elem);
}

//	Remplace L1, L2 ... par Licence 1 ....
$dbh=new dbh();
$dbh->prepare("UPDATE courses_cm SET niveau=:niveau WHERE id=:id");

$db=new db();
$db->select("courses_cm");
foreach($db->result as $elem){
  $niveau=decrypt($elem["niveau"]);
  $niveau=str_replace(array("L","M"),array("Licence ","Master "),$niveau);
  $niveau=encrypt($niveau);
  $data=array(":id"=>$elem['id'],":niveau"=>$niveau);
  $dbh->execute($data);
}

//	Ajout des champs lockCM et lockTD
// $db=new db();
// $db->query("alter table courses_univ3 add lockCM int(1);");
// $db=new db();
// $db->query("alter table courses_univ3 add lockTD int(1);");


//	Ajout du champ creditd
/*$db=new db();
$db->query("alter table courses_cm add credits text");*/
?>