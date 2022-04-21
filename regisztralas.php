<?php
require_once('db.php');
$piszkos_felhasznalonev = $_POST['felhasznalo'];


if (!empty($piszkos_felhasznalonev)) {
	
	$tiszta_felhasznalonev = htmlspecialchars($piszkos_felhasznalonev);


	$sikeres = regisztrálás( $tiszta_felhasznalonev );
	
	if ( $sikeres == false) {
		print 'Username already exists!';
		print '<a href="register.php">Vissza a regisztrációhoz</a>';
	} else {
		header('Location: login.php');
	}
	
} 


?>
