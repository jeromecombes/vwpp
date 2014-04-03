<!--

Commentaires : 
les lignes 319 � 324 permettent de s'adapter aux diff�rentes pages : � am�liorer

-->
<?php
// Affiche un petit calendrier sous forme de tableau
// 
// Copyright (c) 2005-2006 - Sylvain BAUDOIN
// Veuillez remonter toute erreur a webmaster@themanualpage.org
// 
// Le code PHP ci-dessous peut etre redistribue et/ou modifie selon les termes
// de la GNU General Public License, comme publies par la Free Software
// Foundation (version 2 et au dela)
// 
// 
// Style du calendrier :
// ---------------------
// Le style du calendrier est entierement gere par des feuilles de style.
// Les classes des feuilles de styles sont prefixees par $prefixe_css afin
// d'eviter tout conflit et permettre d'afficher 2 calendriers sur la meme
// page avec des styles differents.
// 
// 
// Utilisation :
// -------------
// Le calendrier s'integre dans une page PHP en faisant :
// 
// ...
// require_once("calendrier.php");
// ...
// calendrier(...);
// ...
// 
// Parametres :
// ------------
// $prefixe :
//          sert a prefixer tous les parametres d'URL et de session utilises par
//          le calendrier. Definissez une valeur differente pour chaque
//          calendrier doit afficher sur la meme page. Ne pas commencer le
//          prefixe par un chiffre. Par defaut, il s'agit de "calendrier_".
//          Exemple : calendrier("cal_1_").
// 
// $prefixe_css :
//         indique un prefixe a utiliser pour les classes CSS utilisees pour le
//         style du calendrier. Par defaut, il s'agit de "calendrier_". A
//         utiliser pour afficher des calendriers dans differents styles.
// 
// $date_URL :
//         si defini, ce parametre indique une URL a utiliser pour rendre les
//         jours du calendrier cliquables. L'URL passee est completee par le
//         parametre d'URL $parametre_URL. "" par defaut.
// 
// $parametre_URL :
//         si $date_URL est defini, indique le nom du parametre d'URL a utiliser
//         pour completer l'URL $date_URL est passer la date cliquee. Par
//         defaut, le parametre d'URL est appele "date". La date est passee au
//         format jjmmaaa pour les jours et mmaaaa pour le mois et l'annee (lien
//         du titre du calendrier).
// 
// $utilise_session :
//         mettre a true pour stocker les donnees d'affichage du calendrier en
//         session. Cela permet de memoriser l'affichage lorsqu'on navigue
//         entre plusieurs pages. false par defaut.
//         ATTENTION : si vous utilisez les sessions, n'oubliez pas de creer
//         la session au tout debut de votre script, le calendrier ne le fera
//         pas.
// 
// $preserve_URL :
//         indique, au moment de constuire les URL des liens "mois precedent"
//         et "mois suivant", s'il faut conserver l'URL actuelle de la page
//         (true) ou s'il faut supprimer la query string (?xx=yyy&...) et ne
//         mettre que le parametre de date. true par defaut.
// 
// $js :
//         indique si le calendrier est integre en JavaScript (true) ou non.
//         false par defaut.
// 
// $js_URL :
//         si l'integration JavaScript est utilisee, doit indiquer l'URL de la
//         page integrant le calendrier. Par defaut, vaut "".
// 

function Calendrier($prefixe = "calendrier_", $prefixe_css = "calendrier_",
					$date_URL = "", $parametre_URL = "date",
					$utilise_session = false, $preserve_URL = true, $js = false,
					$js_URL = "") {
	
	
	// 
	// FONCTIONS
	// 
	
	// Fonction d'affichage du code HTML : si $js = true, on ne met pas de
	// saut de ligne
	if (! function_exists("calendrier_affiche")) {
		function calendrier_affiche($texte, $js) {
			if ($js) {
				echo "document.writeln('".$texte."');\n";
			} else {
				echo $texte."\n";
			}
		}
	}
	
	// Sous-fonction qui ajoute le parametre $parametre_URL a la valeur $date
	// a l'URL $URL indiquee.
	// Utilise pour les fleches encadrant le titre du calendrier.
	if (! function_exists("calendrier_calcule_URL")) {
		function calendrier_calcule_URL($URL, $parametre_URL, $date, $preserve_URL,
										$utilise_session) {
			$composants_URL = parse_url($URL);
			$nouvelle_URL = $composants_URL["path"]."?";
			$ajout_SID = $utilise_session;
			// On recupere les parametres d'URL existant seulement si on le demande
			if ($preserve_URL && isset($composants_URL["query"])) {
				parse_str($composants_URL["query"], $query_string);
				// On reconstruit la query string
				foreach ($query_string as $param => $valeur) {
					if ($param != $parametre_URL) {
						$nouvelle_URL .= $param."=".urlencode($valeur)."&amp;";
					}
					// Si le SID est deja present, pas la peine de le rajouter
					if ($utilise_session && $param == session_name()) {
						$ajout_SID = false;
					}
				}
			}
			
			// On ajoute la date
			$nouvelle_URL .= $parametre_URL."=".$date;
			
			// On ajoute egalement l'identifiant de session si necessaire
			if ($ajout_SID && SID != "") {
				$nouvelle_URL .= "&amp;".SID;
			}
			
			return $nouvelle_URL;
			
		}
	}
	
	// Sous-fonction qui calcule la date du mois precedent au format mmaaaa
	if (! function_exists("calendrier_mois_precedent")) {
		function calendrier_mois_precedent($mois, $annee) {
			if ($mois == 1) {
				$nouveau_mois = "12";
				$nouvelle_annee = $annee - 1;
			} else {
				$nouveau_mois = (($mois > 10)?"":"0").($mois - 1);
				$nouvelle_annee = $annee;
			}
			
			return $nouveau_mois.$nouvelle_annee;
		}
	}
	
	// Sous-fonction qui calcule la date du mois suivant au format mmyyyy
	if (! function_exists("calendrier_mois_suivant")) {
		function calendrier_mois_suivant($mois, $annee) {
			if ($mois == 12) {
				$nouveau_mois = "01";
				$nouvelle_annee = $annee + 1;
			} else {
				$nouveau_mois = (($mois < 9)?"0":"").($mois + 1);
				$nouvelle_annee = $annee;
			}
			
			return $nouveau_mois.$nouvelle_annee;
		}
	}
	
	// 
	// VARIABLES
	// 
	// Nom des mois en francais
	$nom_mois = array("janvier", "f&eacute;vrier", "mars", "avril", "mai", "juin",
					"juillet", "ao&ucirc;t", "septembre", "octobre", "novembre",
					"d&eacute;cembre");
	
	// Variables globales
	global $_SESSION;
	global $_SERVER;
	global $_GET;
	
	
	// Si integration JavaScript avec session, on cree la session
	if ($js && $utilise_session) {
		session_start();
	}
	
	// Jour d'aujourd'hui
	$aujourdhui = date("dmY");
	
	// Recuperation du mois et de l'annee a afficher
	if (isset($_GET[$prefixe."date"])) {
		if ($_GET[$prefixe."date"] != "") {
			$mois  = (int)substr($_GET[$prefixe."date"], 0, 2);
			$annee = substr($_GET[$prefixe."date"], 2);
		}
	}
	
	// Calcul de la valeur par defaut
	if (!isset($mois)) {
		$mois = gmdate("n");
		// Recuperation de la session ou non
		if ($utilise_session && isset($_SESSION[$prefixe."mois"])) {
			$mois = $_SESSION[$prefixe."mois"];
		}
	}
	// Mise a jour en session du mois a afficher
	if ($utilise_session) {
		$_SESSION[$prefixe."mois"] = $mois;
	}
	
	// Calcul de la valeur par defaut
	if (!isset($annee)) {
		$annee = gmdate("Y");
		// Recuperation de la session ou non
		if ($utilise_session && isset($_SESSION[$prefixe."annee"])) {
			$annee = $_SESSION[$prefixe."annee"];
		}
	}
	// Mise a jour en session de l'annee a afficher
	if ($utilise_session) {
		$_SESSION[$prefixe."annee"] = $annee;
	}
	
	// Affichage du haut du calendrier
	if ($js) {
		$URL_page = $js_URL;
	} else {
		$URL_page = $_SERVER["REQUEST_URI"];
	}
	calendrier_affiche("<table class=\"".$prefixe_css."principal\">", $js);
	calendrier_affiche("	<tr class=\"".$prefixe_css."titre\">", $js);
	calendrier_affiche("		<td class=\"".$prefixe_css."titre_fleche_gauche\"><a href=\"".calendrier_calcule_URL($URL_page, $prefixe."date", calendrier_mois_precedent($mois, $annee), $preserve_URL, $utilise_session)."\" class=\"".$prefixe_css."titre_fleche_gauche_cliquable\">&lt;&lt;</a></td>", $js);
	if ($date_URL != "") {
		calendrier_affiche("		<td class=\"".$prefixe_css."titre_mois\">".$nom_mois[$mois - 1]." ".$annee."</td>", $js);
		//calendrier_affiche("		<td class=\"".$prefixe_css."titre_mois\"><a href=\"".calendrier_calcule_URL($date_URL, $parametre_URL, (($mois < 10)?"0":"").$mois.$annee, true, $utilise_session)."\" class=\"".$prefixe_css."titre_mois_cliquable\">".$nom_mois[$mois - 1]." ".$annee."</a></td>", $js);
	} else {
		calendrier_affiche("		<td class=\"".$prefixe_css."titre_mois\">".$nom_mois[$mois - 1]." ".$annee."</td>", $js);
	}
	calendrier_affiche("		<td class=\"".$prefixe_css."titre_fleche_droite\"><a href=\"".calendrier_calcule_URL($URL_page, $prefixe."date", calendrier_mois_suivant($mois, $annee), $preserve_URL, $utilise_session)."\" class=\"".$prefixe_css."titre_fleche_droite_cliquable\">&gt;&gt;</a></td>", $js);
	calendrier_affiche("	</tr>", $js);
	calendrier_affiche("	<tr>", $js);
	calendrier_affiche("		<td colspan=\"3\">", $js);
	calendrier_affiche("			<table class=\"".$prefixe_css."tableau\">", $js);
	calendrier_affiche("				<tr>", $js);
	calendrier_affiche("					<th>Mon</th>", $js);
	calendrier_affiche("					<th>Tue</th>", $js);
	calendrier_affiche("					<th>Wed</th>", $js);
	calendrier_affiche("					<th>Thu</th>", $js);
	calendrier_affiche("					<th>Fri</th>", $js);
	calendrier_affiche("					<th>Sat</th>", $js);
	calendrier_affiche("					<th>Sun</th>", $js);
	calendrier_affiche("				</tr>", $js);
	
	// On calcule le premier jour du mois
	$premier_jour_mois = gmmktime(0 ,0 ,0 , $mois, 1, $annee);
	
	// On cherche le jour de la semaine de ce premier jour pour savoir de
	// combien il faut revenir en arriere pour tomber sur un lundi
	$decalage = gmdate("w", $premier_jour_mois) - 1;
	if ($decalage == -1) {
		$decalage = 6;
	}
	
	// Premier jour du calendrier
	$jour_courant = $premier_jour_mois - 3600 * 24 * $decalage;
	
	// On affiche un tableau de 4x7, 5x7 ou 6x7 => 2 boucles imbriquees
	// Calcul du nombre de lignes du tableau
	$nb_ligne = ceil((gmdate("t", $premier_jour_mois) + $decalage) / 7);
	for ($ligne = 1; $ligne <= $nb_ligne; $ligne++) {
		// La premiere boucle sert a afficher les lignes
		calendrier_affiche("				<tr>", $js);
		
		// La seconde boucle sert a afficher les jours (les colonnes)
		for ($colonne = 1; $colonne <= 7; $colonne++) {
			// Jour du mois en train d'etre analyse
			$jour = gmdate("j", $jour_courant);
			
			// Si on est samedi ou dimanche, on affiche un fond gris
			if (gmdate("w", $jour_courant) == 6 || gmdate("w", $jour_courant) == 0) {
				$cellule = "					<td class=\"".$prefixe_css."weekend\">";
			} else {
				$cellule = "					<td>";
			}
			
			// Affichage du jour du mois
			$classe = "";
			if ($date_URL != "") {
				if (gmdate("dmY", $jour_courant) == $aujourdhui) {
					$classe = $prefixe_css."ajourdhui_cliquable";
				} else {
					// Jours hors mois avec classe "hors_mois"
					if (gmdate("n", $jour_courant) != $mois) {
						$classe = $prefixe_css."hors_mois_cliquable";
					} else {
						$classe = $prefixe_css."jour_cliquable";
					}
				}
				if($parametre_URL=="pl_poste")
					$cellule .= "<div onclick='parent.document.location.href=\"../index.php?page=planning/poste/index.php&amp;date=".gmdate("Y-m-d", $jour_courant)."\";' class='$classe'>$jour</div>";
				else
					$cellule .= "<div onclick='returnDate(\"".$parametre_URL."\",\"".gmdate("Y-m-d", $jour_courant)."\");' class='$classe'>$jour</div>";
			} else {
				// Jours hors mois avec classe "hors_mois"
				if (gmdate("n", $jour_courant) != $mois) {
					$classe = $prefixe_css."hors_mois";
				}
				// Si on est aujourd'hui, classe "aujourdhui"
				if (gmdate("dmY", $jour_courant) == $aujourdhui) {
					$classe = $prefixe_css."aujourdhui";
				}
				if ($classe == "") {
					$cellule .= $jour;
				} else {
					$cellule .= "<span class=\"".$classe."\">".$jour."</span>";
				}
			}
			
			// Fin de la cellule du jour courant
			calendrier_affiche($cellule."</td>", $js);
			
			// On passe au jour suivant
			$jour_courant += 3600 * 24 + 1;
		}
		
		// Fin des lignes
		calendrier_affiche("				</tr>", $js);
	}
	
	calendrier_affiche("			</table>", $js);
	calendrier_affiche("		</td>", $js);
	calendrier_affiche("	</tr>", $js);
	calendrier_affiche("</table>", $js);
	}
?>