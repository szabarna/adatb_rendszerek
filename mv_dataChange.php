<?php
session_start();
require_once('db.php');
$user = $_SESSION['username'];
$piszkos_nem = $_POST['nem'];
$piszkos_nev = $_POST['nev'];
$piszkos_lakcim = $_POST['lakcim'];
$piszkos_szuldate = $_POST['szuldate'];
// 

if (!empty($piszkos_nem) && !empty($piszkos_nev) && !empty($piszkos_lakcim) && !empty($piszkos_szuldate) && !empty($user)) {

	$tiszta_felhasznalonev = htmlspecialchars($user);
	$tiszta_nem = htmlspecialchars($piszkos_nem);
	$tiszta_nev = htmlspecialchars($piszkos_nev);
    $tiszta_lakcim = htmlspecialchars($piszkos_lakcim);
	$tiszta_szuldate = htmlspecialchars($piszkos_szuldate);


	$sikeres = mv_dataUpdate( $tiszta_felhasznalonev, $tiszta_nem, $tiszta_nev, $tiszta_lakcim, $tiszta_szuldate );
	
	if ( $sikeres == true) {
		 header('Location: index_mv.php');
	
	} else {
		print "Valami nem sikerült.";
	
	}

	
} 


?>
