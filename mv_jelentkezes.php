<?php
session_start();
require_once('db.php');
$user = $_SESSION['username'];
$piszkos_mc_id = $_POST['mc_id'];
$piszkos_al_id = $_POST['al_id'];

// 

if (!empty($piszkos_mc_id) && !empty($user) && !empty($piszkos_al_id)) {

	$tiszta_felhasznalonev = htmlspecialchars($user);
	$tiszta_mc_id = htmlspecialchars($piszkos_mc_id);
	$tiszta_al_id = htmlspecialchars($piszkos_al_id);

    $sikeres = mv_job_jelentkezes($tiszta_felhasznalonev, $tiszta_mc_id, $tiszta_al_id);


	
	 if ( $sikeres == true) {
	 	 header('Location: index_mv.php');
	
	 } else {
	 	print "Már van ilyen jelentkezésed!";
         print '<br>';
		print '<a href="index_mv.php">Vissza a főoldalra</a>';
	
	 }

	
} 


?>
