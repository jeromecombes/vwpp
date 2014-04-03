<?php
include "../inc/config.php";
/*
$req[]="alter table students add homeInstitution text;";
$req[]="create table univ_reg_lock1 (id int auto_increment primary key, semester varchar(20), student int);";
$req[]="create table univ_reg2 (id int primary key auto_increment, semester varchar(20), student int, question int, response text);";
$req[]="alter table `users` add token varchar(100);";
$req[]="update users set token=md5(email);";
*/

// $req[]="alter table courses_attrib_rh add published int(1);";
// $req[]="create table courses_rh (id int auto_increment primary key, student int, semester varchar(20));";
// $req[]="create table courses_rh2 (id int auto_increment primary key, student int, semester varchar(20));";

/*$req[]="CREATE TABLE IF NOT EXISTS `dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(20) DEFAULT NULL,
  `date1` text,
  `date2` text,
  `date3` text,
  `date4` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;";

$req[]="INSERT INTO `dates` (`id`, `semester`, `date1`, `date2`, `date3`, `date4`) VALUES
(1, 'Spring 2012', 'April 23, 2012', 'April 23, 2012', 'May 20, 2012', 'May 30, 2012'),
(2, 'Fall 2012', 'April 22, 2012', 'April 22, 2012', 'May 20, 2012', 'May 20, 2012');";

*/
//	$req[]="ALTER TABLE `grades` CHANGE course course enum('','VWPP','UNIV','CIPH','TD')";
// $req[]="ALTER TABLE `dates` ADD date5 text;";
// $req[]="ALTER TABLE `dates` ADD date6 text;";
// $req[]="ALTER TABLE `dates` ADD date7 text;";



/*	*********		2013		**************	*/
$req[]="CREATE TABLE courses_univ4 (id int primary key auto_increment, code text, nom text, nature text,lien text, institution text,
  institutionAutre text ,discipline text ,niveau text, prof text, email text, jour text, debut text, fin text, note text, 
  modalites text, modalites1 text, modalites2 text);";

$req[]="ALTER TABLE courses_univ4 add semester varchar(20), add student int;";
$req[]="ALTER TABLE courses_univ4 add `lock` int(1) default 0;";
$req[]="ALTER TABLE courses_univ4 CHANGE note note int(1) default 0;";
$req[]="ALTER TABLE users ADD alerts int(1) default 0;";




foreach($req as $elem){
  $db=new db();
  $db->query($elem);
}

?>
