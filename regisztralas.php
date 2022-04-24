<?php
require_once('db.php');
$piszkos_felhasznalonev = $_POST['felhasznalo'];
$piszkos_radio = $_POST['radio'];

if (!empty($piszkos_felhasznalonev) && !empty($piszkos_radio)) {
	
	$tiszta_felhasznalonev = htmlspecialchars($piszkos_felhasznalonev);
	$tiszta_radio = htmlspecialchars($piszkos_radio);

	$sikeres = regisztrálás( $tiszta_felhasznalonev, $tiszta_radio );
	
	if ( $sikeres == false) {
		print 'Username already exists!';
		print '<br>';
		print '<a href="register.php">Vissza a regisztrációhoz</a>';
	} else {
		 header('Location: login.php');
	}

	
} 

?>
