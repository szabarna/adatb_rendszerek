<?php
session_start();
require_once('db.php');
$user = $_SESSION['username'];
$piszkos_allasMegnevezes = $_POST['allasMegnevezes'];
$piszkos_helyszin = $_POST['helyszin'];
$piszkos_tipus = $_POST['tipusok'];
$piszkos_leiras = $_POST['leiras'];
$piszkos_ALLAScategory = $_POST['ALLAScategory'];
$mc_id = $_POST['mc_id'];
$piszkos_muszak = $_POST['muszak'];
// 

if (!empty($piszkos_allasMegnevezes) && !empty($piszkos_helyszin) && !empty($piszkos_tipus) && !empty($piszkos_leiras) && !empty($piszkos_ALLAScategory) && !empty($mc_id) && !empty($piszkos_muszak)) {

	$tiszta_allasMegnevezes = htmlspecialchars($piszkos_allasMegnevezes);
	$tiszta_helyszin = htmlspecialchars($piszkos_helyszin);
	$tiszta_tipus = htmlspecialchars($piszkos_tipus);
    $tiszta_leiras = htmlspecialchars($piszkos_leiras);
	$tiszta_ALLAScategory = htmlspecialchars($piszkos_ALLAScategory);
    $tiszta_mc_id = htmlspecialchars($mc_id);
    $tiszta_muszak = htmlspecialchars($piszkos_muszak);


	$sikeres = ALLAS_dataInsert($tiszta_helyszin, $tiszta_muszak, $tiszta_leiras, $tiszta_tipus, $tiszta_mc_id, $tiszta_allasMegnevezes, $tiszta_ALLAScategory);
	
	if ( $sikeres == true) {
		 header('Location: index_mc.php');
	
	} else {
		print "Valami nem sikerült.";
	
	}

	
} 


?>