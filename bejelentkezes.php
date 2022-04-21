<?php
require_once('db.php');
if(!empty($_POST['felhasznalo'])) $piszkos_felhasznalonev = $_POST['felhasznalo'];


if (!empty($piszkos_felhasznalonev)) {
	
	$tiszta_felhasznalonev = htmlspecialchars($piszkos_felhasznalonev);
	
	$sikeres = bejelentkezes( $tiszta_felhasznalonev );
	
	if ( $sikeres == true) {
		print 'Sikeres belépés!';
		print '<br>';
		print '<a href="index.php">Tovább az oldalra</a>';
	} else {
		 print 'Előbb regisztrálj!';
		 print '<br>';
		 print '<a href="register.php">Ugrás a regisztráláshoz</a>';
	}
	
} 


?>
