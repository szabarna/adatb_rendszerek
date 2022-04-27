<?php
session_start();
require_once('db.php');
$user = $_SESSION['username'];
$piszkos_adoszam = $_POST['adoszam'];
$piszkos_helyszin = $_POST['helyszin'];
$piszkos_nev = $_POST['nev'];

// 

if (!empty($user) && !empty($piszkos_adoszam) && !empty($piszkos_helyszin) && !empty($piszkos_nev))  {

	$tiszta_felhasznalonev = htmlspecialchars($user);
    $tiszta_adoszam = htmlspecialchars($piszkos_adoszam);
    $tiszta_helyszin = htmlspecialchars($piszkos_helyszin);
    $tiszta_nev = htmlspecialchars($piszkos_nev);

    $sikeres = kv_dataUpdate($tiszta_felhasznalonev, $tiszta_adoszam,  $tiszta_helyszin, $tiszta_nev );

	if ( $sikeres == true) {
		 header('Location: index_kv.php');
	
	} else {
		print "Valami nem sikerült.";
	
	}

	
} 


?>
