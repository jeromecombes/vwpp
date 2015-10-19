// Last update : 2015-10-19, Jérôme Combes

var li_ids=new Array();
var logins=new Array();

// function activEval(semester){
//     file("activEval.php?semester="+semester);
// }
function accept_housing_charte(me){
  file("housing-accept.php");
  if(me.checked){
     document.getElementById("text").style.display="none";
     document.getElementById("link").style.display="";
  }
  else
    me.checked=true;
/*  else{
     document.getElementById("text").style.display="";
     document.getElementById("link").style.display="none";
  }*/
}


function add_fields(i){
 i++;
 if(document.getElementById("tr_"+i).style.display=="none")
   document.getElementById("tr_"+i).style.display="";
}

function addTD(cm_id,admin){
  td_id=document.getElementById("TD_"+cm_id+"_28").value;
  if(admin)
    document.location.href="../inc/courses_univ3Update.php?action=addTD&cm="+cm_id+"&td="+td_id;
  else
    document.location.href="inc/courses_univ3Update.php?action=addTD&cm="+cm_id+"&td="+td_id;
}

function addUnivCourse(me){
  me.style.display="none";
  document.getElementById("newUnivCourse").style.display="block";
}

function alertDelete(msg,id){
  if(confirm(msg))
    location.href="courses-update.php?id="+id+"&delete=";
}


function calendar(form,champ,admin)
	{
	if(admin)
	  url="../inc/calendar/index.php?form="+form+"&champ="+champ;
	else
	  url="inc/calendar/index.php?form="+form+"&champ="+champ;
	
	X=document.body.clientWidth;
	Y=document.body.clientHeight;
	x=document.position.x.value;
	y=document.position.y.value;
	if(x>X-210)
		x=X-210;
/*	if(y>Y-180)
		y=Y-180;*/
y=y-40;
	document.getElementById('calendrier').style.left=x+"px";
	document.getElementById('calendrier').style.top=y+"px";
	document.getElementById('calendrier').style.display="";
	document.getElementById('calendrier').src=url;
	}

function change_menu(id){
  for(i=0;i<li_ids.length;i++)
    if(!document.getElementById("li"+li_ids[i]))
    original=li_ids[i];						// find original id
  document.getElementById("current").id="li"+original;		// change menu
  document.getElementById("li"+id).id="current";
  if(document.getElementById("div"+original))			// change content
    document.getElementById("div"+original).style.display="none";
  if(document.getElementById("div-edit"+original))
    document.getElementById("div-edit"+original).style.display="none";
  if(document.getElementById("div"+id))
    document.getElementById("div"+id).style.display="";
  file("../inc/change_menu.php?id="+id);
  document.getElementById("div6").style.display="none";
  
}

function changeNotifications(me){
  file("myAccountNotifications.php?notif="+me.checked);
}

function resetNewCourse(){
  document.getElementById("newUnivCourse").style.display="none";
  document.getElementById("AddCourseButton").style.display="";
}

function showHousingForm(){
  document.getElementById("div6").style.display="";
  document.getElementById("div2").style.display="none";
}

function change_password(me){
    if(me.checked){
      document.getElementById("tr_password1").style.display="";
      document.getElementById("tr_password2").style.display="";
      document.form.password.disabled=false;
      document.form.password2.disabled=false;
      document.form.password.value="";
      document.form.password2.value="";
      password_ctrl(document.form.password);
    }
    else{
      document.getElementById("tr_password1").style.display="none";
      document.getElementById("tr_password2").style.display="none";
      document.form.password.disabled=true;
      document.form.password2.disabled=true;
    }
}

function checkall(form,me){
  elem=document.forms[form].elements;
  for(i=0;i<elem.length;i++)
    if(elem[i].type=="checkbox" && elem[i]!=me)
      elem[i].click();
}

function checkInstitution(me,id){
  if(me.value=="Autre"){
    document.getElementById("institutionAutreTr"+id).style.display="";
  }
  else{
    document.getElementById("institutionAutreTr"+id).style.display="none";
  }
}

function checkLink(me,admin,id){
  document.getElementById("institution"+id).value="";
  document.getElementById("institutionAutre"+id).value="";
  document.getElementById("discipline"+id).value="";
  document.getElementById("niveau"+id).value="";
  document.getElementById("institutionAutreTr"+id).style.display="none";
  document.getElementById("institution"+id).disabled=false;
  document.getElementById("institutionAutre"+id).disabled=false;
  document.getElementById("discipline"+id).disabled=false;
  document.getElementById("niveau"+id).disabled=false;

  if(me.value){
    if(admin)
      url="../inc/courses_univ4Info.php?id="+me.value;
    else
      url="inc/courses_univ4Info.php?id="+me.value;
    data=file(url);
    tab=data.split("&&&");
    document.getElementById("institution"+id).value=tab[1];
    document.getElementById("institutionAutre"+id).value=tab[2];
    document.getElementById("discipline"+id).value=tab[3];
    document.getElementById("niveau"+id).value=tab[4];
    document.getElementById("institution"+id).disabled=true;
    document.getElementById("institutionAutre"+id).disabled=true;
    document.getElementById("discipline"+id).disabled=true;
    document.getElementById("niveau"+id).disabled=true;
    if(tab[1]=="Autre"){
      document.getElementById("institutionAutreTr"+id).style.display="";
    }
  }
}

function courses_ref(id){
    file("courses_ref.php?id="+id);
}

function ctrlAddTD(me){
    if(me.nom.value)
      return true;
    return false;
}

function ctrl_form1(){
//   login_ctrl(document.form.login);
  password_ctrl(document.form.password);
  password_ctrl(document.form.password2);
  return form1_ctrl();
}

function ctrl_form2(first){
//   login_ctrl2(document.form.login,first);
  password_ctrl(document.form.password);
  password_ctrl(document.form.password2);
  return form1_ctrl();
}

function ctrl_form3(){
    if(confirm("Do you really want to submit this form ?"))
      return true;
    return false;
}

function ctrl_form_univreg(){
  if(!document.getElementById("univ_reg_1_21").value && document.getElementById("category").value=="student"){
    document.getElementById("univ_reg_1_21").style.background="#FF3333";
    alert("Vous devez remplir le champ \"Discipline voulue à l'université\".");
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FF5555\"",800);
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FF6666\"",900);
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FF7777\"",1000);
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FF9999\"",1100);
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FFAAAA\"",1200);
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FFBBBB\"",1300);
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FFCCCC\"",1400);
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FFDDDD\"",1500);
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FFEEEE\"",1600);
    setTimeout("document.getElementById(\"univ_reg_1_21\").style.background=\"#FFFFFF\"",1700);
    return false;
  }
  return true;
}

function delete_check(form){
  if(confirm("Do you really want to delete selected items ?"))
    document.forms[form].submit();
}

function delete_course(univ,id,admin){
   if(confirm("Voulez-vous vraiment supprimer ce cours ?"))
    if(admin)
      document.location.href="students-coursesUpdate.php?id="+id+"&univ="+univ+"&delete=";
    else
      document.location.href="courses-update.php?id="+id+"&univ="+univ+"&delete=";
}

function delete_doc(id){
  if(confirm("Do you really want to delete this file ?"))
    document.location.href="deleteDoc.php?id="+id;
}
  
function delete_line(i){
  document.getElementById("q"+i).value="";
  document.getElementById("t"+i).selectedIndex=0;
  document.getElementById("r"+i).value="";
}

function displayAdd(form){
  document.getElementById("fieldSet"+form).style.display="";
  if(document.forms["form"+form+"_"]){
    inputs=document.forms["form"+form+"_"].elements;
    i=0;
    while(inputs[i]){
      inputs[i++].style.display="";
    }
  }

  i=0;
  while(document.getElementById("form"+form+"__"+i)){
     document.getElementById("form"+form+"__"+i++).style.display="none";
  }
  
  if(document.getElementById("form"+form+"__done")){
    document.getElementById("form"+form+"__done").style.display="";
  }
}

function displayForm(form,id){
  inputs=document.forms[form+"_"+id].elements;
  i=0;
  while(inputs[i]){
    inputs[i++].style.display="";
  }

  i=0;
  while(document.getElementById(form+"_"+id+"_radio"+"_"+i)){
    document.getElementById(form+"_"+id+"_radio"+"_"+i++).style.display="";
  }

  i=0;
  while(document.getElementById(form+"_"+id+"_"+i)){
     document.getElementById(form+"_"+id+"_"+i++).style.display="none";
  }
  
  document.getElementById(form+"_"+id+"_done").style.display="";
  
  //	Les étudiants voient mais ne changent pas les infos discipline, UFR et MoveOnLine
  if(form=="univreg" && document.getElementById("category").value=="student"){
   document.getElementById("univreg_1_13").style.display="";		//	Discipline
   document.getElementById("univreg_1_14").style.display="";		//	UFR
   document.getElementById("univreg_1_15").style.display="";		//	MoveOnLine Username
   document.getElementById("univreg_1_16").style.display="";		//	MoveOnLine Password
   document.getElementById("univreg_1_17").style.display="none";	//	Discipline (Form)
   document.getElementById("univreg_1_18").style.display="none";	//	UFR (Form)
   document.getElementById("univreg_1_19").style.display="none";	//	MoveOnLine Username (Form)
   document.getElementById("univreg_1_20").style.display="none";	//	MoveOnLine Password (Form)
  }
}

function displayText(form,id){
  inputs=document.forms[form+"_"+id].elements;
  i=0;
  while(inputs[i]){
    inputs[i++].style.display="none";
  }

  i=0;
  while(document.getElementById(form+"_"+id+"_"+i)){
     document.getElementById(form+"_"+id+"_"+i++).style.display="";
  }
  
  document.getElementById(form+"_"+id+"_done").style.display="none";
}

// function displayText(form,id){
//   inputs=document.forms[form+"_"+id].elements;
//   i=0;
//   while(inputs[i]){
//     inputs[i++].style.display="none";
//   }
// 
//   i=0;
//   while(document.getElementById(form+"_"+id+"_"+i)){
//      document.getElementById(form+"_"+id+"_"+i++).style.display="";
//   }
//   
//   document.getElementById(form+"_"+id+"_done").style.display="none";
//   document.getElementById(form+"_"+id+"_delete").style.display="";
//   document.getElementById(form+"_"+id+"_edit").style.display="";
//   document.getElementById(form+"_"+id+"_lock").style.display="";
//   
// }

function displayTD(id){
  document.getElementById("TD_"+id+"_5").style.display=""; 
  document.getElementById("TD_"+id+"_6").style.display=""; 
  document.getElementById("TD_"+id+"_Add").style.display="none"; 
  document.getElementById("Delete_"+id).style.display="none"; 
  document.location.href="#TD1_"+id;
}

function dropCourse(id,admin){
  if(confirm("Etes vous sûr(e) de vouloir supprimer ce cours ?")){
    if(admin){
      url="../inc/courses_univ4Update.php?delete=true&id="+id;
    }
    else{
      url="inc/courses_univ4Update.php?delete=true&id="+id;
    }
    document.location.href=url;
  }
}

function dropCourse2(id,admin){
  if(confirm("Etes vous sûr(e) de vouloir supprimer ce cours ?")){
    url="courses4-univ-update.php?delete=true&id="+id;
    document.location.href=url;
  }
}
    
    
function edit(id){
  if(document.getElementById("div-edit"+id).style.display==""){
    document.getElementById("div-edit"+id).style.display="none";
    document.getElementById("div"+id).style.display="";
  }
  else{
    document.getElementById("div-edit"+id).style.display="";
    document.getElementById("div"+id).style.display="none";
  }
}

function editCourse(id,edit){
  if(edit){
    document.getElementById("UnivCourse"+id).style.display="none";
    document.getElementById("UnivCourseEdit"+id).style.display="";
  }
  else{
    document.getElementById("UnivCourse"+id).style.display="";
    document.getElementById("UnivCourseEdit"+id).style.display="none";
  }
}

function editModalites(id,edit){
  if(edit){
    document.getElementById("modalitesText"+id).style.display="none";
    document.getElementById("modalitesTextarea"+id).style.display="";
    document.getElementById("modalites0_"+id).style.display="none";
    document.getElementById("modalitesRadio"+id).style.display="";
    document.getElementById("modalitesUpdate"+id).style.display="none";
    document.getElementById("modalitesReset"+id).style.display="";
    document.getElementById("modalitesSubmit"+id).style.display="";
    
  }
  else{
    document.getElementById("modalitesText"+id).style.display="";
    document.getElementById("modalitesTextarea"+id).style.display="none";
    document.getElementById("modalites0_"+id).style.display="";
    document.getElementById("modalitesRadio"+id).style.display="none";
    document.getElementById("modalitesUpdate"+id).style.display="";
    document.getElementById("modalitesReset"+id).style.display="none";
    document.getElementById("modalitesSubmit"+id).style.display="none";
  }
}

function file(fichier){
  if(fichier.indexOf("php?")>0)
    fichier=fichier+"&ms="+new Date().getTime();
  else if(fichier.indexOf("php")>0)
    fichier=fichier+"?ms="+new Date().getTime();

  if(window.XMLHttpRequest) // FIREFOX
    xhr_object = new XMLHttpRequest();
  else if(window.ActiveXObject) // IE
    xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
   else
    return(false);
   
   xhr_object.open("GET", fichier, false);
   xhr_object.send(null);	
   if(xhr_object.readyState == 4) return(xhr_object.responseText);
   else return(false);
}

function getCMInfo(admin){
  code=document.formCM.code.value;
  univ=document.formCM.university.value;
  if(admin)
    fichier=file("../inc/getCMInfo.php?univ="+univ+"&code="+code);	// Univ ne passe pas (&eacute;) ???
  else
    fichier=file("inc/getCMInfo.php?univ="+univ+"&code="+code);

  if(fichier){
    tab=fichier.split("=%!");
    for(i=0;i<tab.length;i++){
      tab2=tab[i].split("!%=");
      if(document.getElementById("CM2_"+tab2[0])){
	if(tab2[0]=="university")			//	University, replace "UP" with "Université ..."
	  tab2[1]=tab2[1].replace("UP","Universit&eacute; Paris ");
	if(tab2[0]=="debut1" || tab2[0]=="debut2" || tab2[0]=="fin1" ||tab2[0]=="fin2")
	  tab2[1]=tab2[1].replace(":","h");		//	Hours, replace ":" with "h"
	if(tab2[0]=="email")				//	Add mailto for emails
	  tab2[1]="<a href='mailto:"+tab2[1]+"'>"+tab2[1]+"</a>";
	if(tab2[0]=="jour1" && tab2[1])			//	Show Hours (Horaires) only if there is a value
	  document.getElementById("CM2_horaires1").style.display="";
	if(tab2[0]=="jour2" && tab2[1])			//	Idem
	  document.getElementById("CM2_horaires2").style.display="";
	document.getElementById("CM2_"+tab2[0]).innerHTML=tab2[1];	// Show info
      }
      if(tab2[0]=="id")
	document.formCM2.cm.value=tab2[1];		//	Set hidden ID
    }
    document.getElementById("fieldSetUniv2").style.display="";		// Display appropriate DIV
    document.getElementById("fieldSetUniv3").style.display="none";
  }
  else{
    document.getElementById("fieldSetUniv2").style.display="none";	// Display appropriate DIV
    document.getElementById("fieldSetUniv3").style.display="";
    document.getElementById("CM3_university").innerHTML=document.formCM.university.value.replace("UP","Universit&eacute; Paris ");
    document.getElementById("CM3_code").innerHTML=document.formCM.code.value.replace("UP","Universit&eacute; Paris ");
    document.formCM3.university.value=document.formCM.university.value;
    document.formCM3.code.value=document.formCM.code.value;
    document.location.href="#CM3";
  }
  
  return false;
}

function getTDInfo(id,admin){
  code=document.getElementById("TD_"+id+"_code").value;
  univ=document.getElementById("TD_"+id+"_univ").value;
  
  //	Hide TD form
  document.getElementById("TD_"+id+"_7").style.display="none";
  document.getElementById("TD_"+id+"_8").style.display="none";
  document.getElementById("TD_"+id+"_12").style.display="none";
  document.getElementById("TD_"+id+"_13").style.display="none";
  document.getElementById("TD_"+id+"_14").style.display="none";
  document.getElementById("TD_"+id+"_15").style.display="none";
  document.getElementById("TD_"+id+"_16").style.display="none";
  document.getElementById("TD_"+id+"_17").style.display="none";
  //	Hide TD Info
  document.getElementById("TD_"+id+"_1").style.display="none";
  document.getElementById("TD_"+id+"_2").style.display="none";
  document.getElementById("TD_"+id+"_3").style.display="none";
  document.getElementById("TD_"+id+"_4").style.display="none";
  document.getElementById("TD_"+id+"_18").style.display="none";
  document.getElementById("TD_"+id+"_23").style.display="none";
  document.getElementById("TD_"+id+"_25").style.display="none";
  document.getElementById("TD_"+id+"_27").style.display="none";

  if(admin)
    fichier=file("../inc/getTDInfo.php?univ="+univ+"&code="+code);	// Univ ne passe pas (&eacute;) ???
  else
    fichier=file("inc/getTDInfo.php?univ="+univ+"&code="+code);

  if(fichier){
    tab=fichier.split("=%!");
    for(i=0;i<tab.length;i++){
      tab2=tab[i].split("!%=");
      if(tab2[0]=="nom")
	nom=tab2[1];
      if(tab2[0]=="prof")
	prof=tab2[1];
      if(tab2[0]=="email")
	email=tab2[1];
      if(tab2[0]=="horaires1")
	horaires1=tab2[1];
      if(tab2[0]=="horaires2")
	horaires2=tab2[1];
      if(tab2[0]=="id")
	td_id=tab2[1];
    }

    document.getElementById("TD_"+id+"_19").innerHTML=code;
    document.getElementById("TD_"+id+"_20").innerHTML=nom;
    document.getElementById("TD_"+id+"_21").innerHTML=prof;
    document.getElementById("TD_"+id+"_22").innerHTML="<a href='mailto:"+email+"'>"+email+"</a>";
    document.getElementById("TD_"+id+"_24").innerHTML=horaires1;
    document.getElementById("TD_"+id+"_26").innerHTML=horaires2;
    document.getElementById("TD_"+id+"_28").value=td_id;
    
    document.getElementById("TD_"+id+"_1").style.display="";
    document.getElementById("TD_"+id+"_2").style.display="";
    document.getElementById("TD_"+id+"_3").style.display="";
    document.getElementById("TD_"+id+"_4").style.display="";
    document.getElementById("TD_"+id+"_18").style.display="";
    document.getElementById("TD_"+id+"_23").style.display="";
    document.getElementById("TD_"+id+"_25").style.display="";
    document.getElementById("TD_"+id+"_27").style.display="";

    document.location.href="#TD3_"+id;
  
  }
  else{
    //	Display TD form
    document.getElementById("TD_"+id+"_7").style.display="";
    document.getElementById("TD_"+id+"_8").style.display="";
    document.getElementById("TD_"+id+"_9").innerHTML=code;
    document.getElementById("TD_"+id+"_10").value=code;
    document.getElementById("TD_"+id+"_11").value=univ;
    document.getElementById("TD_"+id+"_12").style.display="";
    document.getElementById("TD_"+id+"_13").style.display="";
    document.getElementById("TD_"+id+"_14").style.display="";
    document.getElementById("TD_"+id+"_15").style.display="";
    document.getElementById("TD_"+id+"_16").style.display="";
    document.getElementById("TD_"+id+"_17").style.display="";
    document.location.href="#TD2_"+id;
  }
  
  return false;
}

function js_autocomplete(me){			// supprimer les éléments ne contenant pas à me.value
//   auto=autocomplete[me.name].join(",");	// afficher les éléments dans un <div> flotant
//    alert(auto);				// click sur element -> me.value=element
}
function lock_registration(form,id,lock){
  table="courses_"+form;
  if(form=="stages")
     table=form;
  file("lock.php?table="+table+"&id="+id+"&lock="+lock);
  document.location.reload(false);
}

function lock2(table){
  msg=file("lock2.php?table="+table);
  document.location.href="students-view2.php?error=0&msg="+msg;
}

function lockCM(id){
  file("../inc/courses_univ3_lock.php?action=lockCM&id="+id);
  document.getElementById("lockCM_"+id).style.display="none";
  document.getElementById("unLockCM_"+id).style.display="";
}

function lockCourse4(id){
  lock=file("courses4Lock.php?id="+id);
  if(lock==1){
    document.getElementById("lock"+id).value="Déverrouiller";
  }
  else{
    document.getElementById("lock"+id).value="Verrouiller";
  }
}

function lockTD(id){
  file("../inc/courses_univ3_lock.php?action=lockTD&id="+id);
  document.getElementById("lockTD_"+id).style.display="none";
  document.getElementById("unLockTD_"+id).style.display="";
}

function lockRH(me,student){
  file("lockRH.php?student="+student+"&lock="+me.value);
  if(me.value=="Lock")
     me.value="Unlock";
  else
    me.value="Lock";
}

function lockRH2(me,student){
  file("lockRH2.php?student="+student+"&lock="+me.value);
  if(me.value=="Publish")
     me.value="Hide";
  else
    me.value="Publish";
}

function login_ctrl(me){
  if(me.value==""){
      document.getElementById("login_msg").innerHTML="Login is required.";
      form1_ctrl();
      return;
    }
    for(i=0;i<logins.length;i++)
    if(logins[i]==me.value.toLowerCase()){
      document.getElementById("login_msg").innerHTML="This login is allready used.";
      form1_ctrl();
      return;
    }
   document.getElementById("login_msg").innerHTML="";
   form1_ctrl();
}

function login_ctrl2(me,first){
  if(me.value==first){
    document.getElementById("login_msg").innerHTML="";
    form1_ctrl();
  }
  else
   login_ctrl(me);
}

function form1_ctrl(){
/*  if(document.getElementById("login_msg").innerHTML=="" 
    && document.getElementById("passwd1").innerHTML=="" */
  if(document.getElementById("passwd1").innerHTML=="" 
    && document.getElementById("passwd2").innerHTML==""){
     document.getElementById("submit").disabled=false;
     return true;
  }
   else{
     document.getElementById("submit").disabled=true;
     return false;
   }
}

function password_ctrl(me){
  if(me.disabled)
    return;
  if(me.name=="password"){
    if(me.value.length<8){
      document.getElementById("passwd1").innerHTML="Must be 8 characters";
      form1_ctrl();
      return;
    }
     document.getElementById("passwd1").innerHTML="";
      form1_ctrl();
     return;
  }
   if(me.name=="password2"){
     if(me.value!=document.getElementById("password").value){
       document.getElementById("passwd2").innerHTML="Passwords don't match";
      form1_ctrl();
     return;
     }
     document.getElementById("passwd2").innerHTML="";
      form1_ctrl();
     return;
  }
}

function select_action(form){
  me=document.getElementById("action");
  elem=document.forms[form].elements;
  checked=false;
  for(i=0;i<elem.length;i++)
    if(elem[i].checked && elem[i].name!="all")
    checked=true;
  if(me.value && checked){
     $("#submit_button").attr("disabled",false);
     $("#submit_button").removeClass("ui-state-disabled");
  }
  else{
     $("#submit_button").attr("disabled",true);
     $("#submit_button").addClass("ui-state-disabled");
  }

}

function submit_action(form,form2){		// a finir
  switch(document.forms[form].action.value){
    case "Delete" : delete_check(form2);	break;
    
    case "CreatePassword" :
	if(confirm("The password of selected students will be changed.\nContinue ?")){
	  document.forms[form2].action="students-password.php";
	  document.forms[form2].submit();
	}
	break;
	  
    case "Email" :
	inputs=document.forms[form2].elements;
	i=0;
	mails=new Array();
	while(inputs[i]){
	  if(inputs[i].name=="students[]" && inputs[i].checked){
	    mails.push(document.getElementById("mail_"+inputs[i].value).value);
	  }
	  i++;
	}
	mails=mails.join(", ");
	document.location.href="mailto:"+mails;
	break;

    case "Email2" :
	  document.forms[form2].action="students-email.php";
	  document.forms[form2].submit();	break;


    case "Excel" :
	  document.forms[form2].action="students-excel.php";
	  document.forms[form2].submit();	break;

    case "Email_Housing" :
	inputs=document.forms[form2].elements;
	i=0;
	mails=new Array();
	while(inputs[i]){
	  if(inputs[i].name=="housing[]" && inputs[i].checked){
	    if(document.getElementById("mail_"+inputs[i].value).value);
	      mails.push(document.getElementById("mail_"+inputs[i].value).value);
	    if(document.getElementById("mail2_"+inputs[i].value).value);
	      mails.push(document.getElementById("mail2_"+inputs[i].value).value);
	  }
	  i++;
	}
	mails=mails.join(", ");
	document.location.href="mailto:"+mails;
	break;

    case "Email2_Housing" :
	  document.forms[form2].action="housing-email.php";
	  document.forms[form2].submit();	break;


    case "Excel_Housing" :
	  document.forms[form2].action="housing-excel.php";
	  document.forms[form2].submit();	break;

    case "closeHousing" :
	  document.forms[form2].action="housing-close.php";
	  document.forms[form2].submit();	break;
	  
    case "openHousing" :
	  document.forms[form2].action="housing-open.php";
	  document.forms[form2].submit();	break;

    case "lockVWPP" :
	  document.forms[form2].action="lockRH3.php";
	  document.forms[form2].submit();	break;

    case "unlockVWPP" :
	  document.forms[form2].action="lockRH4.php";
	  document.forms[form2].submit();	break;

    case "publishVWPP" :
	  document.forms[form2].action="lockRH5.php";
	  document.forms[form2].submit();	break;

    case "hideVWPP" :
	  document.forms[form2].action="lockRH6.php";
	  document.forms[form2].submit();	break;

    case "Univ_reg" :
	  document.forms[form2].action="univ_reg_export2.php";
	  document.forms[form2].submit();	break;

    case "intership" :
	  document.forms[form2].action="intership_export.php";
	  document.forms[form2].submit();	break;

    case "tutorial" :
	  document.forms[form2].action="tutorial_export.php";
	  document.forms[form2].submit();	break;


  }


}

function unLockCM(id){
  file("../inc/courses_univ3_lock.php?action=unLockCM&id="+id);
  document.getElementById("lockCM_"+id).style.display="";
  document.getElementById("unLockCM_"+id).style.display="none";
}

function unLockTD(id){
  file("../inc/courses_univ3_lock.php?action=unLockTD&id="+id);
  document.getElementById("lockTD_"+id).style.display="";
  document.getElementById("unLockTD_"+id).style.display="none";
}


function user_delete(id){
 if(confirm("Do you really want to delete this user ?"))
   document.location.href="users-delete.php?id="+id;
}



function verifLoginForm(){
 if(document.form.login.value && document.form.password.value)
   document.form.submit2.disabled=false;
 else
   document.form.submit2.disabled=true;
}


function isNumeric(input){
    return (input-0)==input && input.length>0;
}

function verifNote(form,me){
  me.value=me.value.replace(",",".");
  me.value=me.value.replace(";",".");
  me.value=me.value.replace(" ","");
  me.value=me.value.replace("-","");
  me.value=me.value.replace("+","");
  if(me.value && (me.value>20 || !isNumeric(me.value) || me.value.length>5)){
    me.style.background="red";
  }
  else{
    me.style.background="white";
  }
  
  verifNote2(form);
}

function verifNote2(form){
  if(document.getElementById("submit"))
    document.getElementById("submit").disabled=false;
  if(document.getElementById(form+"_done"))
    document.getElementById(form+"_done").disabled=false;
  elem=document.forms[form].elements;
  for(i=0;i<elem.length;i++){
    if(elem[i].style.background.search("red")!=-1){
      if(document.getElementById("submit"))
	document.getElementById("submit").disabled=true;
      if(document.getElementById(form+"_done"))
	document.getElementById(form+"_done").disabled=true;
      return;
    }
  }
  
}

/***********		Position du pointeur		*************/
// Detection du navigateur
nc6=(typeof(window.controllers) !='undefined' && typeof(window.locationbar) != 'undefined')?true:false;
nc4=(document.layers)?true:false;
ie4=(document.all)? true:false;

// on lance la detection des mouvements du pointeur
// instructions pour netscape 4.x
if(nc4)
	{
	document.captureEvents(Event.MOUSEMOVE);
	}
// Instructions pour Netscape 6.x
if(nc6) 
	{
	//~ document.addEventListener("mousemove",document.onmousemove,true);
	suivre_souris;
	}
// Instructions pour IE
document.onmousemove=suivre_souris;
// fonction execut�e pour chaque mouvement de pointeur
function suivre_souris(e)
	{
	// Instruction pour Netscape 4 et sup�rieur
	if(nc4 || nc6)
		{
		// On affete � x et y les positions X et Y du pointeur lors de l'�venement move
		var x=e.pageX;
		var y=e.pageY;
		}
	// Instructions �quivalentes pour Internet Explorer
	if(ie4)
		{
		var x = event.x;
		var y = event.y;
		}
	// On affecte les donn�es obtenues au champs du formulaire
	//~ if(document.position)
		//~ {
		document.position.x.value=x;
		document.position.y.value=y;
		//~ }
	}
/***********		FIN Position du pointeur		*************/

$(document).ready(function(){

	$(".datatable").each(function(){
	  // columns sort
  		var aoCol=[];
  		$(this).find("thead th").each(function(){
    		if($(this).attr("class")==undefined){
      			aoCol.push({"bSortable":true});
    		}
    		else if($(this).hasClass("dataTableDate")){
      			aoCol.push({"sType": "date"});
   			}
    		else if($(this).hasClass("dataTableNoSort")){
      			aoCol.push({"bSortable":false});
   			}
		else{
      			aoCol.push({"bSortable":true});
			}
   		});
  
	  var sort=[[1,"asc"],[2,"asc"]];		// {{"1","asc"},{"2","asc"}}
	  if($(this).attr("data-sort")){
	    var sort=JSON.parse($(this).attr("data-sort"));
	  }
  		$(this).dataTable({
      		"bJQueryUI": true,
      		"sPaginationType": "full_numbers",
      		"bStateSave": true,
      		"aLengthMenu" : [[25,50,75,100,-1],[25,50,75,100,"All"]],
      		"iDisplayLength" : -1,
      		"aaSorting" : sort,
      		"aoColumns" : aoCol,
  		});
  	});


  $(".myUI-button").button();
  $(".myUI-button-right").button();
  $(".myUI-datepicker-string").datepicker({dateFormat: "MM d, yy"});

  $("#loginName").find("span").hover(function(){
    $("#myMenu").show();
  });

  $("#loginName").find("span").mouseout(function(){
    timeoutMyMenu=window.setTimeout(function(){$("#myMenu").hide()},3000);
  });

  $(document).tooltip();

  // Menu : set active tab
  var href=document.location.href;
  if(href.indexOf(".php")<1){
    href+="index.php";
  }
  
  href=href.replace("users-edit.php","users.php");
  href=href.replace(/(courses.*)/,"courses.php");
  href=href.replace(/(eval.*)/,"eval_index.php");
  href=href.replace(/(grades.*)/,"grades3-1.php");
  href=href.replace(/(housing.*)/,"housing.php");
  href=href.replace(/(\?.*)/,"");

  $("li.ui-state-default").each(function(){
    if($(this).find("a").prop("href")==href){
      $(this).addClass("ui-tabs-active");
      $(this).addClass("ui-state-active");
    }
  });

  // Positionne l'onglet "Back to list" à droite
  $(".back-to-list").each(function(){
    $(this).css("position","absolute");
    var ulLeft=$(this).closest("ul").position().left;
    var ulWidth=$(this).closest("ul").width();
    var liWidth=$(this).width();
    var liLeft=ulLeft+ulWidth-liWidth-3;
    $(this).css("left",liLeft);
    
    var ulTop=$(this).closest("ul").position().top;
    var ulHeight=$(this).closest("ul").height();
    var ulPadding=$(this).closest("ul").css("padding");
    var tmp=ulPadding.split("px");
    ulPadding=parseFloat(tmp[0]);
    var liHeight=$(this).height();
    var liTop=ulTop+ulHeight+ulPadding-liHeight-1;
    $(this).css("top",liTop);
  });

  
  // Positionne l'onglet "Next" à droite
  $(".li-next").each(function(){
    $(this).css("position","absolute");
    var BTLLeft=$(".back-to-list").position().left;
    var liWidth=$(this).width();
    var liLeft=BTLLeft-liWidth-4;
    $(this).css("left",liLeft);
    
    var ulTop=$(this).closest("ul").position().top;
    var ulHeight=$(this).closest("ul").height();
    var ulPadding=$(this).closest("ul").css("padding");
    var tmp=ulPadding.split("px");
    ulPadding=parseFloat(tmp[0]);
    var liHeight=$(this).height();
    var liTop=ulTop+ulHeight+ulPadding-liHeight-1;
    $(this).css("top",liTop);
  });

  // Positionne l'onglet "Previous" à droite
  $(".li-previous").each(function(){
    $(this).css("position","absolute");
    if($(".li-next").length){
      var NLeft=$(".li-next").position().left;
    }else{
      var NLeft=$(".back-to-list").position().left;
    }
    var liWidth=$(this).width();
    var liLeft=NLeft-liWidth-4;
    $(this).css("left",liLeft);
    
    var ulTop=$(this).closest("ul").position().top;
    var ulHeight=$(this).closest("ul").height();
    var ulPadding=$(this).closest("ul").css("padding");
    var tmp=ulPadding.split("px");
    ulPadding=parseFloat(tmp[0]);
    var liHeight=$(this).height();
    var liTop=ulTop+ulHeight+ulPadding-liHeight-1;
    $(this).css("top",liTop);
  });

  
  
  
});

$(function(){
  $("#enableEvaluation").click(function(){
    $.ajax({
      url: "enableEval.php",
      dataType: "json",
      type: "post",
      data: {semester : $(this).attr("data-semester")},
      success: function(){
	var value=$("#enableEvaluation").attr("data-enabled")==1?"Enable evaluations":"Disable evaluations";
	var enable=$("#enableEvaluation").attr("data-enabled")==1?0:1;
	$("#enableEvaluation").attr("data-enabled",enable);
	$("#enableEvaluation").attr("value",value);
      },
      error: function(){
	alert($("#enableEvaluation").attr("data-enabled"));
	var msg=$("#enableEvaluation").attr("data-enabled")==1?"disable":"enable";
	CJInfo("Cannot "+msg+" evaluations","error");
      }
    });
  });

  // Création de la liste des étudiants pour la navigation précédent suivant
  // Lors du click sur une icône "Edit" du tableau
  $(".studentsEdit").click(function(){
    var tab=new Array();
    $(".studentsCheckbox").each(function(){
      tab.push($(this).val());
    });
    $.ajax({
      url: "ajax.studentsList.php",
      dataType: "json",
      type: "post",
      data: {list: JSON.stringify(tab)},
    });
  });
  
});