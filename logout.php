<?php
//	detruit la session et affiche l'index (qui affichera le login_form)
session_start();
unset($_SESSION['vwpp']);
header("Location: index.php");
?>