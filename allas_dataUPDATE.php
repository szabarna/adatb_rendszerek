<?php
session_start();
require_once('db.php');
$user = $_SESSION['username'];
$piszkos_allas_nev = $_POST['allas_nev'];
$piszkos_helyszin = $_POST['helyszin'];
$piszkos_muszak = $_POST['muszak'];
$piszkos_tipus = $_POST['tipus'];
$piszkos_kat_id = $_POST['kat_id'];
$piszkos_leiras = $_POST['leiras'];
$mc_id = $_POST['mc_id'];
$id = $_POST['id'];
$action = $_POST['action'];

if ($_POST['action'] == 'Törlés') {

	$sikeres = ALLAS_dataDELETE($id);

    if ( $sikeres == true) {
		header('Location: index_mc.php');
   
   } else {
	   print "Valami nem sikerült.";
   
   }
}

if (!empty($piszkos_helyszin) && !empty($piszkos_muszak) && !empty($piszkos_tipus) && !empty($piszkos_leiras) && !empty($piszkos_allas_nev) && !empty($piszkos_kat_id) && !empty($mc_id) && !empty($id)) {

    $tiszta_allas_nev = htmlspecialchars($piszkos_allas_nev);
	$tiszta_helyszin = htmlspecialchars($piszkos_helyszin);
    $tiszta_muszak = htmlspecialchars($piszkos_muszak);
	$tiszta_tipus = htmlspecialchars($piszkos_tipus);
    $tiszta_kat_id = htmlspecialchars($piszkos_kat_id);
    $tiszta_leiras = htmlspecialchars($piszkos_leiras);

	$sikeres = ALLAS_dataSZERK($tiszta_helyszin, $tiszta_muszak, $tiszta_tipus, $tiszta_leiras, $tiszta_allas_nev, $tiszta_kat_id, $id);
	
	if ( $sikeres == true) {
		 header('Location: index_mc.php');
	
	} else {
		print "Valami nem sikerült.";
	
	}

	
} 


?>