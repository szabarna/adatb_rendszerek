<?php
session_start();
require_once('db.php');
$user = $_SESSION['username'];
$piszkos_cv = $_POST['cv'];

// 

if (!empty($user) && !empty($piszkos_cv)) {

	$tiszta_felhasznalonev = htmlspecialchars($user);
    $tiszta_cv = trim(htmlspecialchars($piszkos_cv));

    $sikeres = mv_cvUpdate($tiszta_felhasznalonev, $tiszta_cv);

	if ( $sikeres == true) {
		 header('Location: index_mv.php');
	
	} else {
		print "Valami nem sikerült.";
	
	}

	
} 


?>
