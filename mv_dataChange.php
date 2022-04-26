<?php
session_start();
require_once('db.php');
$user = $_SESSION['username'];
$piszkos_nem = $_POST['nem'];
$piszkos_nev = $_POST['nev'];
$piszkos_lakcim = $_POST['lakcim'];
$piszkos_szuldate = $_POST['szuldate'];
$piszkos_kategoria = $_POST['MVcategory'];
$piszkos_iskolazottsag = $_POST['MViskolazottsag'];
$piszkos_szakmaiTapasztalat = $_POST['MVexperience'];

// 

if (!empty($piszkos_nem) && !empty($piszkos_nev) && !empty($piszkos_lakcim) && !empty($piszkos_szuldate) && !empty($user)
	&& !empty($piszkos_iskolazottsag) && !empty($piszkos_szakmaiTapasztalat)) {

	$tiszta_felhasznalonev = htmlspecialchars($user);
	$tiszta_nem = htmlspecialchars($piszkos_nem);
	$tiszta_nev = htmlspecialchars($piszkos_nev);
    $tiszta_lakcim = htmlspecialchars($piszkos_lakcim);
	$tiszta_szuldate = htmlspecialchars($piszkos_szuldate);
	$tiszta_kategoria = htmlspecialchars($piszkos_kategoria);
	$tiszta_iskolazottsag = htmlspecialchars($piszkos_iskolazottsag);
	$tiszta_szakmaiTapasztalat = htmlspecialchars($piszkos_szakmaiTapasztalat);


	$sikeres = mv_dataUpdate( $tiszta_felhasznalonev, $tiszta_nem, $tiszta_nev, $tiszta_lakcim, $tiszta_szuldate, $tiszta_kategoria
							, $tiszta_iskolazottsag, $tiszta_szakmaiTapasztalat);
	
	if ( $sikeres == true) {
		 header('Location: index_mv.php');
	
	} else {
		print "Valami nem sikerült.";
	
	}

	
} 


?>
