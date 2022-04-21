<?php
require_once('db.php');
print '<body style="width: 100%; min-height: 100vh; display: grid; margin: 0;">';


print '<form action="regisztralas.php" method="POST" style="width: 20rem; height: 25rem; justify-self: center; top: 10rem; position: relative; display: grid; background-color: rgba(100, 100, 100, 0.1); text-align: center; border-radius: 0.5em;">';


print '<label>Felhasználónév: </label>';
print '<input required type="text" name="felhasznalo" ><br>';

print '<input type="radio" id="MV" name="radio" value="MV">';
print '<label for="MV">Munkavállaló</label><br>';

print '<input type="radio" id="MC" name="radio" value="MC">';
print '<label for="MC">Munkáltató</label><br>';

print '<input type="radio" id="KC" name="radio" value="KC">';
print '<label for="KC">Közvetitő</label>';

print '<input type="submit" value="Elküld"><br>';
print '<a href="login.php">Bejelentkezés</a>';

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
