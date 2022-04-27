<?php
session_start();
require_once('db.php');
$user = $_SESSION['username'];
$piszkos_nev = $_POST['nev'];
$piszkos_adoszam = $_POST['adoszam'];
$piszkos_telephely = $_POST['telephely'];
$piszkos_kategoria = $_POST['MCcategory'];
// 

if (!empty($piszkos_adoszam) && !empty($piszkos_nev) && !empty($piszkos_telephely) && !empty($user)) {

	$tiszta_felhasznalonev = htmlspecialchars($user);
	$tiszta_nev = htmlspecialchars($piszkos_nev);
	$tiszta_adoszam = htmlspecialchars($piszkos_adoszam);
    $tiszta_telephely = htmlspecialchars($piszkos_telephely);
	$tiszta_kategoria = htmlspecialchars($piszkos_kategoria);


	$sikeres = mc_dataUpdate( $tiszta_felhasznalonev, $tiszta_nev, $tiszta_adoszam, $tiszta_telephely, $tiszta_kategoria);
	
	if ( $sikeres == true) {
		 header('Location: index_mc.php');
	
	} else {
		print "Valami nem sikerült.";
	
	}

	
} 


?>