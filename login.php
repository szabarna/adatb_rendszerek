<?php
require_once('db.php');


print '<body style="width: 100%; min-height: 100vh; display: grid; margin: 0;">';


print '<form action="bejelentkezes.php" method="POST" style="width: 20rem; height: 25rem; justify-self: center; top: 10rem; position: relative; display: grid; background-color: rgba(100, 100, 100, 0.1); text-align: center; border-radius: 0.5em;">';


print '<label>Felhasználónév: </label>';
print '<input required type="text" name="felhasznalo" ><br>';


print '<input type="submit" value="Elküld"><br>';
print '<a href="register.php">Regisztrálás</a>';
print '<a href="index.php">Log in as guest</a>';
print '</form>';

 /* print '<hr>'; */
print '<br>';
/*
print '<h1 style="position: absolute; justify-self: center; bottom: 22.5rem;" >Bejelentkezések</h1>';

$tabla = bejelentkezeseket_listaz();
print $tabla;
*/
print '</body>';


?>
