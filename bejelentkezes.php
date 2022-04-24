<?php
session_start();
require_once('db.php');
if(!empty($_POST['felhasznalo'])) $piszkos_felhasznalonev = $_POST['felhasznalo'];


if (!empty($piszkos_felhasznalonev)) {
	
	$tiszta_felhasznalonev = htmlspecialchars($piszkos_felhasznalonev);
	
	$_SESSION['username'] = $tiszta_felhasznalonev;
	
	$sikeres = bejelentkezes( $tiszta_felhasznalonev );
	
	if ( $sikeres == true) {
		print 'Sikeres belépés!';
		print '<br>';
		print '<a href="index.php">Tovább az oldalra</a>';

		// 1 == MV | 2 == MC | 3 == KV
		$type = checkWhichType( $tiszta_felhasznalonev );

		if($type == 1) header('Location: index_mv.php');
		if($type == 2) header('Location: index_mc.php');
		if($type == 3) header('Location: index_kv.php');
		if($type == 0) print 'Something went wrong!';

	} else {
		 print 'Előbb regisztrálj!';
		 print '<br>';
		 print '<a href="register.php">Ugrás a regisztráláshoz</a>';
	}
	
} 


?>
