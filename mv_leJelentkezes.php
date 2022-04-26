<?php
session_start();
require_once('db.php');
$user = $_SESSION['username'];
$piszkos_mc_id = $_POST['mc_id'];

// 

if (!empty($piszkos_mc_id) && !empty($user)) {

	$tiszta_felhasznalonev = htmlspecialchars($user);
	$tiszta_mc_id = htmlspecialchars($piszkos_mc_id);

    $sikeres = mv_job_leJelentkezes($tiszta_felhasznalonev, $tiszta_mc_id);

	
	 if ( $sikeres == true) {
	 	 header('Location: index_mv.php');
	
	 } else {
	 	print "Valami hiba történt.";
	
	 }

} 

?>
